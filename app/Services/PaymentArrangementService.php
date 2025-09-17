<?php

namespace App\Services;

use App\Models\PaymentArrangement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request; 
        
class PaymentArrangementService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = PaymentArrangement::query();

        return $query;
    }

    public function create(Request $request): PaymentArrangement
    {
        $paymentArrangement = PaymentArrangement::create($request->all());

        return $paymentArrangement;
    }

    public function update(PaymentArrangement $paymentArrangement, Request $request): PaymentArrangement
    {
        $paymentArrangement->update($request->all());

        return $paymentArrangement;
    }
}