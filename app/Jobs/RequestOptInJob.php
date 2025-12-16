<?php

namespace App\Jobs;

use App\Actions\RRC0011Action;
use App\Enums\OptInStatus;
use App\Models\Core\BusinessPartner;
use App\Models\Core\OptIn;
use App\Models\Core\PaymentArrangement;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RequestOptInJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected User $user,
        protected BusinessPartner $client,
        protected BusinessPartner $acquirer,
        protected PaymentArrangement $paymentArrangement,
    ) {}

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
            // 'contract_id' => $this->contract->id,
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
            'dtOptIn' => $this->getDtIniOptIn(),
            'dtIniOptIn' => $this->getDtIniOptIn(),
            'dtFimOptIn' => $this->getDtFimOptIn(),
        ];
    }

    private function generateUniqueIdentifier(): string
    {
        return substr(hash('crc32b', Str::uuid()), 0, 20);
    }

    private function getFinanciadoraCnpj(): string
    {
        return '52399494000122';
    }

    private function getIndrDomcl(): string
    {
        return 'S';
    }

    private function getDtIniOptIn(): ?string
    {
        /** @var Collection $users */
        $users = $this->client->users;

        $user = $users->firstWhere('id', $this->user->id);

        return Carbon::parse($user?->pivot?->opt_in_start_date)->format('Y-m-d');
    }

    private function getDtFimOptIn(): ?string
    {
        /** @var Collection $users */
        $users = $this->client->users;

        $user = $users->firstWhere('id', $this->user->id);

        return Carbon::parse($user?->pivot?->opt_in_end_date)->format('Y-m-d');
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
            dtOptIn: Carbon::parse($optIn->dtOptIn)->format('Y-m-d'),
            dtIniOptIn: Carbon::parse($optIn->dtIniOptIn)->format('Y-m-d'),
            dtFimOptIn: Carbon::parse($optIn->dtFimOptIn)->format('Y-m-d'),
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
