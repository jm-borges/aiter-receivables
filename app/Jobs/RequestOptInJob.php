<?php

namespace App\Jobs;

use App\Actions\RRC0011Action;
use App\Enums\OptInStatus;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Contract;
use App\Models\Core\OptIn;
use App\Models\Core\PaymentArrangement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Str;

class RequestOptInJob implements ShouldQueue
{
    use Queueable;

    protected Contract $contract;
    protected BusinessPartner $client;
    protected BusinessPartner $acquirer;
    protected PaymentArrangement $paymentArrangement;

    /**
     * Create a new job instance.
     */
    public function __construct(Contract $contract, BusinessPartner $client, BusinessPartner $acquirer, PaymentArrangement $paymentArrangement)
    {
        $this->contract = $contract;
        $this->client = $client;
        $this->acquirer = $acquirer;
        $this->paymentArrangement = $paymentArrangement;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $optIn = $this->createOptIn();
        $response = $this->executeAction($optIn);
        $this->handleResponse($optIn, $response);
    }

    private function createOptIn(): OptIn
    {
        return OptIn::create($this->prepareOptInData());
    }

    private function prepareOptInData(): array
    {
        $contractData = $this->getContractData();
        $acquirerData = $this->getAcquirerData();
        $clientData = $this->getClientData();
        $metaData = $this->getMetaData();

        return array_merge($contractData, $acquirerData, $clientData, $metaData);
    }

    private function getContractData(): array
    {
        return [
            'contract_id' => $this->contract->id,
            'payment_arrangement_id' => $this->paymentArrangement->id,
            'codInstitdrArrajPgto' => $this->paymentArrangement->code,
        ];
    }

    private function getAcquirerData(): array
    {
        return [
            'acquirer_id' => $this->acquirer->id,
            'cnpjCreddrSub' => $this->acquirer->document_number,
        ];
    }

    private function getClientData(): array
    {
        return [
            'client_id' => $this->client->id,
            'cnpjOuCnpjBaseOuCpfUsuFinalRecbdrOuTitlar' => $this->client->document_number,
        ];
    }

    private function getMetaData(): array
    {
        return [
            'status' => OptInStatus::PENDING,
            'identdCtrlReqSolicte' => $this->generateUniqueIdentifier(),
            'cnpj_financiadora' => $this->getFinanciadoraCnpj(),
            'indrDomcl' => $this->getIndrDomcl(),
            'dtOptIn' => now(),
            'dtIniOptIn' => $this->getDtIniOptIn(),
            'dtFimOptIn' => $this->getDtFimOptIn(),
        ];
    }

    private function generateUniqueIdentifier(): string
    {
        return (string) Str::uuid();
    }

    private function getFinanciadoraCnpj(): string
    {
        return '52399494000122';
    }

    private function getIndrDomcl(): string
    {
        return '';
    }

    private function getDtIniOptIn(): ?string
    {
        return $this->contract->start_date;
    }

    private function getDtFimOptIn(): ?string
    {
        return $this->contract->end_date;
    }

    private function executeAction(OptIn $optIn): array
    {
        return app(RRC0011Action::class)->execute(
            identdCtrlReqSolicte: $optIn->identdCtrlReqSolicte,
            cnpjFincdr: $optIn->cnpj_financiadora,
            cnpjOuCnpjBaseOuCpfUsuFinalRecbdrOuTitlar: $optIn->cnpjOuCnpjBaseOuCpfUsuFinalRecbdrOuTitlar,
            cnpjCreddrSub: $optIn->cnpjCreddrSub,
            codInstitdrArrajPgto: $optIn->codInstitdrArrajPgto,
            indrDomcl: $optIn->indrDomcl,
            dtOptIn: $optIn->dtOptIn,
            dtIniOptIn: $optIn->dtIniOptIn,
            dtFimOptIn: $optIn->dtFimOptIn,
        );
    }

    private function handleResponse(OptIn $optIn, array $response): void
    {
        if ($response['status_code'] === 200) {
            $optIn->update([
                'identdCtrlOptIn' => $response['body']['identdCtrlOptIn'],
                'status' => OptInStatus::ACTIVE,
            ]);
        }
    }
}
