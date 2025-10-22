<?php

namespace App\Handlers;

use App\Actions\RRC0010Action;
use App\Models\Core\BusinessPartner;
use App\Models\Core\PaymentArrangement;
use App\Models\Core\Receivable;
use App\Services\Core\ReceivableService;

class ReceivablesUpdater
{
    public function syncReceivablesFromRegistrar(BusinessPartner $client): void
    {
        $response = app(RRC0010Action::class)->execute(
            cnpjOuCnpjBaseOuCpfUsuFinalRecbdr: $client->document_number,
        );

        if ($response['status_code'] === 200) {
            $this->handleSuccessfulRRC0010($client, $response);
        }
    }

    private function handleSuccessfulRRC0010(BusinessPartner $client, array $response): void
    {
        $receivablesData = $response['body'];

        foreach ($receivablesData as $receivableData) {
            $this->handleReceivableData($client, $receivableData);
        }
    }

    private function handleReceivableData(BusinessPartner $client, array $receivableData): Receivable
    {
        $receivable = app(ReceivableService::class)->findReceivable($client, $receivableData);

        if ($receivable) {
            return $this->updateReceivable($receivable, $receivableData);
        }

        return $this->createReceivable($client, $receivableData);
    }

    private function createReceivable(BusinessPartner $client, array $receivableData): Receivable
    {
        $totalAvailableAmount = $this->getTotalAvailableAmount($receivableData);

        return $client->clientReceivables()->create([
            'acquirer_id' => BusinessPartner::findByDocumentNumber($receivableData['cnpjCreddrSub'])?->id,
            'cnpjCreddrSub' => $receivableData['cnpjCreddrSub'],
            'cnpjER' => $receivableData['cnpjER'],
            'payment_arrangement_id' => PaymentArrangement::findByCode($receivableData['codInstitdrArrajPgto'])?->id,
            'codInstitdrArrajPgto' => $receivableData['codInstitdrArrajPgto'],
            'cnpjOuCnpjBaseOuCpfUsuFinalRecbdr' => $client->document_number,
            'dtPrevtLiquid' => $receivableData['dtPrevtLiquid'],
            'indrDomcl' => $receivableData['indrDomcl'],
            'vlrTot' =>  $receivableData['vlrTot'],
            'available_value' => $totalAvailableAmount,
        ]);
    }

    private function updateReceivable(Receivable $receivable, array $receivableData): Receivable
    {
        $totalAvailableAmount = $this->getTotalAvailableAmount($receivableData);

        $receivable->update([
            'available_value' => $totalAvailableAmount,
        ]);

        return $receivable;
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
