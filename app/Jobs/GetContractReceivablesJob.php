<?php

namespace App\Jobs;

use App\Actions\RRC0010Action;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Contract;
use App\Models\Core\OptIn;
use App\Models\Core\PaymentArrangement;
use App\Models\Core\Receivable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GetContractReceivablesJob implements ShouldQueue
{
    use Queueable;

    protected Contract $contract;

    /**
     * Create a new job instance.
     */
    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = app(RRC0010Action::class)->execute(cnpjOuCnpjBaseOuCpfUsuFinalRecbdr: $this->contract->client->document_number);
        if ($response['status_code'] === 200) {
            $receivables = collect($response['body']);
            $receivables->each(fn(array $receivable) => $this->storeReceivable($receivable));
        }
    }

    private function storeReceivable(array $receivable): void
    {
        $data = array_merge(
            $this->getBaseReceivableData($receivable),
            $this->getAcquirerData($receivable),
            $this->getPaymentArrangementData($receivable),
            $this->getFinancialData($receivable)
        );

        Receivable::create($data);
    }

    private function getBaseReceivableData(array $receivable): array
    {
        return [
            'client_id'   => $this->contract->client_id,
            'contract_id' => $this->contract->id,
            'opt_in_id'   => $this->getOptIn($receivable),
        ];
    }

    private function getOptIn(array $receivable): ?OptIn
    {
        return OptIn::where('contract_id', $this->contract->id)
            ->where('codInstitdrArrajPgto', $receivable['codInstitdrArrajPgto'])
            ->where('cnpjCreddrSub', $receivable['cnpjCreddrSub'])
            ->first()?->id;
    }

    private function getAcquirerData(array $receivable): array
    {
        return [
            'acquirer_id'   => BusinessPartner::findByDocumentNumber($receivable['cnpjCreddrSub'])?->id,
            'cnpjCreddrSub' => $receivable['cnpjCreddrSub'],
        ];
    }

    private function getPaymentArrangementData(array $receivable): array
    {
        return [
            'payment_arrangement_id' => PaymentArrangement::findByCode($receivable['codInstitdrArrajPgto'])?->id,
            'codInstitdrArrajPgto'   => $receivable['codInstitdrArrajPgto'],
        ];
    }

    private function getFinancialData(array $receivable): array
    {
        return [
            'tpObj'                             => $receivable['tpObj'],
            'cnpjER'                            => $receivable['cnpjER'],
            'cnpjOuCnpjBaseOuCpfUsuFinalRecbdr' => $receivable['cnpjOuCnpjBaseOuCpfUsuFinalRecbdr'],
            'vlrLivreUsuFinalRecbdr'            => $receivable['vlrLivreUsuFinalRecbdr'],
            'dtPrevtLiquid'                     => $receivable['dtPrevtLiquid'],
            'vlrTot'                            => $receivable['vlrTot'],
            'indrDomcl'                         => $receivable['indrDomcl'],
        ];
    }
}
