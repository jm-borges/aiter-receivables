<?php

namespace App\Services\Core\Files;

use App\Jobs\VerifyReceivablesToOperateJob;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Files\ARRC018Response;
use App\Models\Core\PaymentArrangement;
use App\Models\Core\Receivable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ARRC018ResponseService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = ARRC018Response::query();

        return $query;
    }

    public function create(Request $request): ARRC018Response
    {
        $aRRC018Response = ARRC018Response::create($request->all());

        return $aRRC018Response;
    }

    public function update(ARRC018Response $aRRC018Response, Request $request): ARRC018Response
    {
        $aRRC018Response->update($request->all());

        return $aRRC018Response;
    }

    // ---

    public function process(array $data): void
    {
        $this->storeResponse($data);

        foreach ($data['receivableScheduleHolders'] as $clientData) {
            $this->handleClientData($data, $clientData);
        }
    }

    private function storeResponse(array $data): void
    {
        ARRC018Response::updateOrCreate([
            'source_file_name' => $data["sourceFileName"],
        ], [
            'payment_scheme_code' => $data['paymentSchemeCode'],
            'payment_arrangement_id' => PaymentArrangement::findByCode($data['paymentSchemeCode'])?->id,
            'participant_document' => $data["participantDocument"],
            'managed_participant_id' => $data["managedParticipantId"],
            'trade_repository_document' => $data["tradeRepositoryDocument"],
            'created_at' => $data["createdAt"],
        ]);
    }

    private function handleClientData(array $data, array $clientData): void
    {
        $client = BusinessPartner::findByDocumentNumber($clientData['holderDocument']);

        if ($client) {
            foreach ($clientData['holderReceivableUnits'] as $receivableUnitData) {
                $this->handleReceivableUnitData($client, $data, $receivableUnitData);
            }

            dispatch(new VerifyReceivablesToOperateJob($client));
        }
    }

    private function handleReceivableUnitData(BusinessPartner $client, array $data, array $receivableUnitData): void
    {
        $receivable = $this->findReceivable($client, $data, $receivableUnitData);

        if ($receivable) {
            $this->updateExistingReceivable($receivable, $data);
        } else {
            $this->createNewReceivable($client, $data, $receivableUnitData);
        }
    }

    private function findReceivable(BusinessPartner $client, array $data, array $receivableUnitData): ?Receivable
    {
        return $client
            ->clientReceivables()
            ->where('cnpjCreddrSub', $data[''] ?? '') //onde conseguir??
            ->where('codInstitdrArrajPgto', $data['paymentSchemeCode'])
            ->where('dtPrevtLiquid', $receivableUnitData['expectedSettlementDate'])
            ->first();
    }

    private function createNewReceivable(BusinessPartner $client, array $data, array $receivableUnitData): void
    {
        $client->clientReceivables()->create([
            // 'acquirer_id',
            //  'cnpjCreddrSub' => ,
            'cnpjER' => $data['tradeRepositoryDocument'],
            'payment_arrangement_id' => PaymentArrangement::findByCode($data['paymentSchemeCode'])?->id,
            'codInstitdrArrajPgto' => $data['paymentSchemeCode'],
            'cnpjOuCnpjBaseOuCpfUsuFinalRecbdr' => $client->document_number,
            'dtPrevtLiquid' => $receivableUnitData['expectedSettlementDate'],
            'vlrTot' =>  $receivableUnitData['totalAmount'],
        ]);
    }

    private function updateExistingReceivable(Receivable $receivable, array $receivableUnitData): void
    {
        $receivable->update([
            'vlrTot' =>  $receivableUnitData['totalAmount'],
            //'vlrLivreUsuFinalRecbdr' => // entender melhor isso aqui
        ]);
    }
}
