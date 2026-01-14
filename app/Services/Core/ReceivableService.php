<?php

namespace App\Services\Core;

use App\Auxiliary\ReceivableData;
use App\Enums\BusinessPartnerType;
use App\Models\Core\Receivable;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Operation;
use App\Models\Core\Pivots\ContractHasReceivable;
use App\Models\Core\Pivots\OperationHasReceivable;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ReceivableService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = Receivable::query();

        return $query;
    }

    public function create(Request $request): Receivable
    {
        $receivable = Receivable::create($request->all());

        return $receivable;
    }

    public function update(Receivable $receivable, Request $request): Receivable
    {
        $receivable->update($request->all());

        return $receivable;
    }

    // ---

    public function findReceivable(BusinessPartner $client, ReceivableData $receivableData): ?Receivable
    {
        return $client
            ->clientReceivables()
            ->where('cnpjCreddrSub', $receivableData->cnpjCreddrSub)
            ->where('codInstitdrArrajPgto', $receivableData->codInstitdrArrajPgto)
            ->where('dtPrevtLiquid', $receivableData->dtPrevtLiquid)
            ->first();
    }

    public function calculateReceivablesSummaryByIdOrCnpj(string $identifier, bool $isCnpj = false): array
    {
        $businessPartner = $isCnpj
            ? $this->loadBusinessPartnerWithRelationsByCnpj($identifier)
            : $this->loadBusinessPartnerWithRelations($identifier);

        return $this->calculateReceivablesSummaryForPartner($businessPartner);
    }

    protected function calculateReceivablesSummaryForPartner(BusinessPartner $businessPartner): array
    {
        $receivables = $this->getReceivablesForPartner($businessPartner);

        $received = $receivables->filter->wasSettled()->sum('vlrTot');
        $toBeReceived = $receivables->reject->wasSettled()->sum('vlrTot');
        $locked = $receivables->sum('amount_locked_by_others');
        $free = $receivables->sum('available_value');

        $contractsIds = $businessPartner->clientContracts->pluck('id');
        $operationsIds = Operation::whereIn('contract_id', $contractsIds)
            ->get('id')
            ->pluck('id')
            ->toArray();

        $lockedByUser = OperationHasReceivable::whereIn('operation_id', $operationsIds)
            ->whereIn('receivable_id', $receivables->pluck('id'))
            ->sum('amount');

        return [
            'received' => $received,
            'to_be_received' => $toBeReceived,
            'locked' => $locked,
            'locked_by_user' =>  $lockedByUser,
            'locked_by_others' => $locked,
            'free' => $free,
        ];
    }

    public function loadBusinessPartnerWithRelations(string $id): BusinessPartner
    {
        return BusinessPartner::with('clientContracts.receivables')->findOrFail($id);
    }

    public function loadBusinessPartnerWithRelationsByCnpj(string $documentNumber): BusinessPartner
    {
        $businessPartner = BusinessPartner::findByDocumentNumber($documentNumber)?->load('clientContracts.receivables');
        if (!$businessPartner) {
            throw new Exception('Parceiro com esse CNPJ não encontrado');
        }
        return $businessPartner;
    }

    public function calculateReceivablesSummary(string $businessPartnerId): array
    {
        return $this->calculateReceivablesSummaryByIdOrCnpj($businessPartnerId);
    }

    public function calculateReceivablesSummaryByCnpj(string $documentNumber): array
    {
        return $this->calculateReceivablesSummaryByIdOrCnpj($documentNumber, true);
    }

    public function getReceivablesForPartner(BusinessPartner $partner): Collection
    {
        return match ($partner->type) {
            BusinessPartnerType::CLIENT => $partner->clientReceivables()->get(),
            BusinessPartnerType::ACQUIRER => $partner->acquirerReceivables()->get(),
            default => collect(),
        };
    }

    //------

    /*  public function handleReceivableUnitData(BusinessPartner $client, array $receivableData): void
    {
        $receivable = $this->findReceivable($client, $receivableData);

        if ($receivable) {
            $this->updateExistingReceivable($receivable, $receivableData);
        } else {
            $this->createNewReceivable($client, $receivableData);
        }
    }

    private function createNewReceivable(BusinessPartner $client, array $receivableData): void
    {
        $totalAvailableAmount = $this->getTotalAvailableAmount($receivableData);

        $client->clientReceivables()->create([
            'acquirer_id' => BusinessPartner::findByDocumentNumber($receivableData['cnpjCreddrSub'])?->id,
            'cnpjCreddrSub' => $receivableData['cnpjCreddrSub'],
            'cnpjER' => $receivableData['cnpjER'],
            'payment_arrangement_id' => PaymentArrangement::findByCode($receivableData['codInstitdrArrajPgto'])?->id,
            'codInstitdrArrajPgto' => $receivableData['codInstitdrArrajPgto'],
            'cnpjOuCnpjBaseOuCpfUsuFinalRecbdr' => $client->document_number,
            'dtPrevtLiquid' => $receivableData['dtPrevtLiquid'],
            'indrDomcl' => $receivableData['indrDomcl'],
            // ---
            'vlrTot' =>  $receivableData['vlrTot'],
            'available_value' => $totalAvailableAmount,
        ]);
    }

    private function updateExistingReceivable(Receivable $receivable, array $receivableData): void
    {
        $totalAvailableAmount = $this->getTotalAvailableAmount($receivableData);

        $receivable->update([
            'available_value' => $totalAvailableAmount,
        ]);
    }

    private function getTotalAvailableAmount(array $receivableData): float
    {
        $holders =  $receivableData['titulares'];
        $totalAvailableAmount = 0;

        foreach ($holders as $holder) {
            $totalAvailableAmount += $holder['vlrLivreTot'];
        }

        return $totalAvailableAmount;
    } */
}
