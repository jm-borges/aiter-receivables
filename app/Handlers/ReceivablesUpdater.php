<?php

namespace App\Handlers;

use App\Actions\RRC0010Action;
use App\Auxiliary\ReceivableData;
use App\Enums\ReceivableStatus;
use App\Models\Core\BusinessPartner;
use App\Models\Core\PaymentArrangement;
use App\Models\Core\Receivable;
use App\Services\Core\ReceivableService;
use Illuminate\Support\Collection;

class ReceivablesUpdater
{
    /**
     * @param Collection<int,BusinessPartner> $clients
     */
    public function updatesReceivables(Collection $clients): void
    {
        foreach ($clients as $client) {
            $this->syncReceivablesFromRegistrar($client);
        }
    }

    private function syncReceivablesFromRegistrar(BusinessPartner $client): void
    {
        $response = app(RRC0010Action::class)->execute(
            cnpjOuCnpjBaseOuCpfUsuFinalRecbdr: $client->document_number,
            dtIniPrevtLiquid: date('Y-m-d'),
            dtFimPrevtLiquid: now()->addMonths(2)->format('Y-m-d'),
        );

        if ($response['status_code'] === 200) {
            $this->handleSuccessfulRRC0010($client, $response);
        }
    }

    private function handleSuccessfulRRC0010(BusinessPartner $client, array $response): void
    {
        $receivablesData = $response['body'];

        $openLocalReceivables = $this->getOpenLocalReceivables($client);

        $receivedIds = $this->syncAndCollectReceivedIds($client, $receivablesData);

        $missingReceivables = $this->findMissingReceivables($openLocalReceivables, $receivedIds);

        $this->markAsSettled($missingReceivables);
    }

    private function getOpenLocalReceivables(BusinessPartner $client)
    {
        return $client->clientReceivables()
            ->where('status', '!=', ReceivableStatus::SETTLED)
            ->get();
    }

    private function syncAndCollectReceivedIds(BusinessPartner $client, array $receivablesDataArr): array
    {
        $receivedIds = [];

        foreach ($receivablesDataArr as $item) {
            $receivableData = ReceivableData::fromArray($item);
            $receivable = $this->handleReceivableData($client, $receivableData);

            $receivedIds[] = $receivable->id;
        }

        return $receivedIds;
    }

    private function findMissingReceivables($openLocalReceivables, array $receivedIds)
    {
        return $openLocalReceivables->whereNotIn('id', $receivedIds);
    }

    private function markAsSettled($missingReceivables): void
    {
        foreach ($missingReceivables as $receivable) {
            $receivable->update([
                'status' => ReceivableStatus::SETTLED,
            ]);
        }
    }

    private function handleReceivableData(BusinessPartner $client, ReceivableData $receivableData): Receivable
    {
        $receivable = app(ReceivableService::class)->findReceivable($client, $receivableData);

        if ($receivable) {
            return $this->updateReceivable($receivable, $receivableData);
        }

        return $this->createReceivable($client, $receivableData);
    }

    private function createReceivable(BusinessPartner $client, ReceivableData $receivableData): Receivable
    {
        $totalAvailableAmount = $this->getTotalAvailableAmount($receivableData);

        return $client->clientReceivables()->create([
            'acquirer_id' => BusinessPartner::findByDocumentNumber($receivableData->cnpjCreddrSub)?->id,
            'cnpjCreddrSub' => $receivableData->cnpjCreddrSub,
            'cnpjER' => $receivableData->cnpjER,
            'payment_arrangement_id' => PaymentArrangement::findByCode($receivableData->codInstitdrArrajPgto)?->id,
            'codInstitdrArrajPgto' => $receivableData->codInstitdrArrajPgto,
            'cnpjOuCnpjBaseOuCpfUsuFinalRecbdr' => $client->document_number,
            'dtPrevtLiquid' => $receivableData->dtPrevtLiquid,
            'indrDomcl' => $receivableData->indrDomcl,
            'vlrTot' =>  $receivableData->vlrTot,
            'available_value' => $totalAvailableAmount,
            'amount_locked_by_others' => $receivableData->vlrTot - $totalAvailableAmount,
        ]);
    }

    private function updateReceivable(Receivable $receivable, ReceivableData $receivableData): Receivable
    {
        $totalAvailableAmount = $this->getTotalAvailableAmount($receivableData);

        $receivable->update([
            'vlrTot' =>  $receivableData->vlrTot,
            'available_value' => $totalAvailableAmount,
            'amount_locked_by_others' => $receivableData->vlrTot - $totalAvailableAmount,
        ]);

        return $receivable;
    }

    private function getTotalAvailableAmount(ReceivableData $receivableData): float
    {
        $holders =  $receivableData->titulares;
        $totalAvailableAmount = 0;

        foreach ($holders as $holder) {
            $totalAvailableAmount += $holder['vlrLivreTot'];
        }

        return $totalAvailableAmount;
    }
}
