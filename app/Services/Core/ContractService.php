<?php

namespace App\Services\Core;

use App\Jobs\DispatchOptInJob;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Contract;
use App\Models\Core\PaymentArrangement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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
}
