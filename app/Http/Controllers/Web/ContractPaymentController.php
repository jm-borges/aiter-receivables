<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractPayments\GetContractPaymentsRequest;
use App\Http\Requests\ContractPayments\StoreContractPaymentRequest;
use App\Http\Requests\ContractPayments\UpdateContractPaymentRequest;
use App\Models\Core\ContractPayment;
use App\Services\Core\ContractPaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;

class ContractPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetContractPaymentsRequest $request, ContractPaymentService $contractPaymentService): View|Factory
    {
        $viewData = $contractPaymentService->getIndexViewData($request);
        return view('contract-payments.index', $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ContractPaymentService $contractPaymentService): View|Factory
    {
        $viewData = $contractPaymentService->getCreateViewData();
        return view('contract-payments.form', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractPaymentRequest $request, ContractPaymentService $contractPaymentService): RedirectResponse|Redirector
    {
        $contractPaymentService->create($request);
        return redirect()->route('contract-payments.index')->with('success', 'Pagamento criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContractPayment $contractPayment): View|Factory
    {
        return view('contract-payments.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContractPayment $contractPayment, ContractPaymentService $contractPaymentService): View|Factory
    {
        $viewData = $contractPaymentService->getEditViewData();
        return view('contract-payments.form', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractPaymentRequest $request, ContractPayment $contractPayment, ContractPaymentService $contractPaymentService): RedirectResponse|Redirector
    {
        $contractPaymentService->update($contractPayment, $request);
        return redirect()->route('contract-payments.index')->with('success', 'Pagamento atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContractPayment $contractPayment, ContractPaymentService $contractPaymentService): RedirectResponse|Redirector
    {
        $contractPaymentService->destroy($contractPayment);
        return redirect()->route('contract-payments.index')->with('success', 'Pagamento removido com sucesso.');
    }
}
