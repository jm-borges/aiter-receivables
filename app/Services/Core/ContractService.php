<?php

namespace App\Services\Core;

use App\Models\Core\Contract;
use App\Models\Core\Receivable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ContractService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = Contract::query();

        return $query;
    }

    public function create(Request $request): Contract
    {
        $contract = Contract::create($request->all());

        return $contract;
    }

    public function update(Contract $contract, Request $request): Contract
    {
        $contract->update($request->all());

        return $contract;
    }

    // ---

    /**
     * Update the receivables attached to a given contract.
     *
     * @param Contract $contract
     * @return void
     */
    public function updateReceivablesInContract(Contract $contract): void
    {
        $goal = $contract->value;
        $amount = $this->processExistingReceivables($contract, $goal);

        if (!$this->contractHasAchievedGoal($amount, $goal)) {
            $this->processNewReceivables($contract, $goal, $amount);
        }
    }

    /**
     * Process already attached receivables and adjust their values if needed.
     *
     * @param Contract $contract
     * @param float $goal
     * @return float
     */
    private function processExistingReceivables(Contract $contract, float $goal): float
    {
        return $contract->receivables->reduce(
            fn(float $amount, Receivable $receivable): float =>
            $this->updateReceivable($contract, $receivable, $goal, $amount),
            0.0
        );
    }

    /**
     * Attach new receivables to the contract until the goal is achieved.
     *
     * @param Contract $contract
     * @param float $goal
     * @param float $amount
     * @return float
     */
    private function processNewReceivables(Contract $contract, float $goal, float $amount): float
    {
        foreach ($this->getNewReceivables($contract) as $receivable) {
            if ($this->contractHasAchievedGoal($amount, $goal)) {
                break;
            }
            $amount = $this->attachNewReceivable($contract, $receivable, $goal, $amount);
        }

        return $amount;
    }

    /**
     * Get receivables not yet attached to the given contract.
     *
     * @param Contract $contract
     * @return Collection<int, Receivable>
     */
    private function getNewReceivables(Contract $contract): Collection
    {
        return Receivable::whereDoesntHave(
            'contracts',
            fn($q) => $q->where('contracts.id', $contract->id)
        )->get();
    }

    /**
     * Update a receivable already attached to the contract if its value changed.
     *
     * @param Contract $contract
     * @param Receivable $receivable
     * @param float $goal
     * @param float $current
     * @return float
     */
    private function updateReceivable(
        Contract $contract,
        Receivable $receivable,
        float $goal,
        float $current
    ): float {
        if ($this->contractHasAchievedGoal($current, $goal)) {
            return $current;
        }

        $receivable->refresh();
        $pivot = $receivable->pivot->amount ?? 0;
        $latest = $receivable->vlrTot;

        if ($pivot === $latest) {
            return $current;
        }

        $newValue = $this->calculateNewReceivableValue($pivot, $latest, $goal, $current);

        if ($newValue !== null) {
            $this->syncReceivable($contract, $receivable, $newValue);
            $current += $newValue;
        }

        return $current;
    }

    /**
     * Attach a new receivable to the contract.
     *
     * @param Contract $contract
     * @param Receivable $receivable
     * @param float $goal
     * @param float $current
     * @return float
     */
    private function attachNewReceivable(
        Contract $contract,
        Receivable $receivable,
        float $goal,
        float $current
    ): float {
        $value = min($receivable->vlrTot, $goal - $current);

        $contract->receivables()->attach($receivable, [
            'id'     => (string) Str::uuid(),
            'amount' => $value,
        ]);

        return $current + $value;
    }

    /**
     * Determine the new receivable value when its amount changed.
     *
     * @param float $pivot
     * @param float $latest
     * @param float $goal
     * @param float $current
     * @return float|null
     */
    private function calculateNewReceivableValue(
        float $pivot,
        float $latest,
        float $goal,
        float $current
    ): ?float {
        return match (true) {
            $pivot > $latest  => $latest, // decreased
            $pivot < $latest  => min($latest, $goal - $current), // increased
            default           => null,
        };
    }

    /**
     * Update the pivot table for a given receivable in the contract.
     *
     * @param Contract $contract
     * @param Receivable $receivable
     * @param float $amount
     * @return void
     */
    private function syncReceivable(Contract $contract, Receivable $receivable, float $amount): void
    {
        $contract->receivables()->updateExistingPivot($receivable->id, [
            'id'     => (string) Str::uuid(),
            'amount' => $amount,
        ], true);
    }

    /**
     * Check if the current amount has reached or exceeded the goal.
     *
     * @param float $current
     * @param float $goal
     * @return bool
     */
    private function contractHasAchievedGoal(float $current, float $goal): bool
    {
        return $current >= $goal;
    }
}
