<?php

namespace App\Services\Core;

use App\Jobs\DispatchOptInJob;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Contract;
use App\Models\Core\PaymentArrangement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ContractService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = Contract::with(['client', 'supplier', 'acquirers']);

        //

        return $query;
    }

    public function create(array $data): Contract
    {
        $contract = Contract::create($data);

        if (!empty($data['acquirers'])) {
            $contract->acquirers()->sync($data['acquirers']);
        }

        if (!empty($data['payment_arrangements'])) {
            $contract->paymentArrangements()->sync($data['payment_arrangements']);
        }

        if (!empty($data['acquirers']) || !empty($data['payment_arrangements'])) {
            dispatch(new DispatchOptInJob($contract));
        }

        return $contract;
    }

    public function update(Contract $contract, array $data): Contract
    {
        $contract->update($data);

        $contract->acquirers()->sync($data['acquirers'] ?? []);
        $contract->paymentArrangements()->sync($data['payment_arrangements'] ?? []);

        if (!empty($data['acquirers']) || !empty($data['payment_arrangements'])) {
            //TODO: Aqui teria que verificar se é necessário atualizar ou cancelar e criar novos opt ins
            dispatch(new DispatchOptInJob($contract));
        }

        return $contract;
    }

    public function destroy(Contract $contract): void
    {
        $contract->acquirers()->detach();
        $contract->paymentArrangements()->detach();
        $contract->operations()->detach();
        $contract->delete();
    }

    // ------------------- VIEWS DATA ------------------------

    public function getIndexViewData(Request $request): array
    {
        $contracts = $this->filter($request)->paginate($request->per_page ?? 20);
        return compact('contracts');
    }

    public function getCreateViewData(): array
    {
        $clients = BusinessPartner::where('type', 'client')->get();
        $suppliers = BusinessPartner::where('type', 'supplier')->get();
        $acquirers = BusinessPartner::where('type', 'acquirer')->get();
        $paymentArrangements = PaymentArrangement::orderBy('code', 'asc')->get();

        return compact('clients', 'suppliers', 'acquirers', 'paymentArrangements');
    }

    public function getEditViewData(): array
    {
        $clients = BusinessPartner::where('type', 'client')->get();
        $suppliers = BusinessPartner::where('type', 'supplier')->get();
        $acquirers = BusinessPartner::where('type', 'acquirer')->get();
        $paymentArrangements = PaymentArrangement::all();

        return compact('contract', 'clients', 'suppliers', 'acquirers', 'paymentArrangements');
    }

    // ---

    public function calculatePaymentsSummary(string $businessPartnerId): array
    {
        $businessPartner = $this->loadBusinessPartnerWithPayments($businessPartnerId);
        $payments = $this->collectAllPayments($businessPartner);

        return $this->summarizePayments($payments);
    }

    private function loadBusinessPartnerWithPayments(string $id): ?BusinessPartner
    {
        return BusinessPartner::with('clientContracts.payments')->find($id);
    }

    private function collectAllPayments(BusinessPartner $partner): Collection
    {
        return $partner->clientContracts
            ->pluck('payments')
            ->flatten(1);
    }

    private function summarizePayments(Collection $payments): array
    {
        return [
            'amount_due' => $this->sumByCondition($payments, fn($p) => $p->isOverdue()),
            'amount_to_be_recovered' => $this->sumByCondition($payments, fn($p) => $p->isPending() && !$p->isOverdue()),
            'amount_recovered' => $this->sumByCondition($payments, fn($p) => $p->isPaid()),
        ];
    }

    private function sumByCondition(Collection $payments, callable $condition): float
    {
        return $payments
            ->filter($condition)
            ->sum('amount');
    }
}
