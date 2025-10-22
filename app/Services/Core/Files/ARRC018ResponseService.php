<?php

namespace App\Services\Core\Files;

use App\Jobs\AutoOperateClientContractsJob;
use App\Jobs\VerifyReceivablesToOperateJob;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Files\ARRC018Response;
use App\Models\Core\PaymentArrangement;
use App\Models\Core\Setting;
use App\Services\Core\ReceivableService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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
                /// ENQUANTO A RTM NÃO ADICIONAR UM CAMPO EM QUE SEJA POSSIVEL OBTER O CNPJ DA CREDENCIADORA, É MELHOR UTILIZARMOS A RRC0010 PARA OBTER OS RECEBIVEIS DIRETO DA NUCLEA 
                /// ATÉ LÁ, MANTER COMENTADO ESSE TRECHO PARA EVITAR INSERÇÃO DE RECEBIVEIS REPETIDOS MAS SEM CREDENCIADORA
                /* $receivableData = $this->buildStandardizedReceivableData($client, $data, $receivableUnitData);
                app(ReceivableService::class)->handleReceivableUnitData($client, $receivableData); */
            }

            if (Setting::first()->shouldAutomaticallyOperateContracts()) {
                dispatch(new AutoOperateClientContractsJob($client));
            }
        }
    }

    private function buildStandardizedReceivableData(BusinessPartner $client, array $data, array $receivableUnitData): array
    {
        $holders = $this->getHolders($receivableUnitData);

        return [
            'cnpjER' => $data['tradeRepositoryDocument'],
            'cnpjCreddrSub' => '',
            'codInstitdrArrajPgto' => $data['paymentSchemeCode'],
            'cnpjOuCnpjBaseOuCpfUsuFinalRecbdr' => $client->document_number,
            'vlrTot' =>  $receivableUnitData['totalAmount'],
            'indrDomcl' => $receivableUnitData['domicileIndicator'],
            'dtPrevtLiquid' => $receivableUnitData['expectedSettlementDate'],
            'titulares' => $holders,
        ];
    }

    private function getHolders(array $receivableUnitData): array
    {
        $holdersData = $receivableUnitData['holders'];
        $holders = [];

        foreach ($holdersData as $holder) {
            $holders[] = [
                'vlrLivreTot' => $holder['totalAvalableAmount'],
            ];
        }

        return $holders;
    }
}
