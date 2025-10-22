<?php

namespace App\Services\Core;

use App\Models\Core\Receivable;
use App\Models\Core\BusinessPartner;
use App\Models\Core\PaymentArrangement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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

    public function findReceivable(BusinessPartner $client, array $receivableData): ?Receivable
    {
        return $client
            ->clientReceivables()
            ->where('cnpjCreddrSub', $receivableData['cnpjCreddrSub'])
            ->where('codInstitdrArrajPgto', $receivableData['codInstitdrArrajPgto'])
            ->where('dtPrevtLiquid', $receivableData['dtPrevtLiquid'])
            ->first();
    }

    //------

    public function handleReceivableUnitData(BusinessPartner $client, array $receivableData): void
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
    }
}
