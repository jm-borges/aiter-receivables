<?php

namespace App\Services\Core;

use App\Models\Core\ContractPayment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ContractPaymentService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = ContractPayment::query();

        return $query;
    }

    public function create(Request $request): ContractPayment
    {
        $contractPayment = ContractPayment::create($request->all());

        return $contractPayment;
    }

    public function update(ContractPayment $contractPayment, Request $request): ContractPayment
    {
        $contractPayment->update($request->all());

        return $contractPayment;
    }

    public function destroy(ContractPayment $contractPayment): void
    {
        $contractPayment->delete();
    }

    // ------------------- VIEWS DATA ------------------------

    public function getIndexViewData(Request $request): array
    {
        $contractPayments = $this->filter($request)->paginate($request->per_page ?? 20);
        return compact('contractPayments');
    }

    public function getCreateViewData(): array
    {
        return [];
    }

    public function getEditViewData(): array
    {
        return [];
    }
}
