<?php

namespace App\Http\Controllers\Web;

use App\Enums\ContractStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contracts\GetContractsRequest;
use App\Http\Requests\Contracts\StoreContractRequest;
use App\Http\Requests\Contracts\UpdateContractRequest;
use App\Models\Core\Contract;
use App\Services\Core\ContractService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;

class ContractController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetContractsRequest $request, ContractService $contractService): View|Factory
    {
        $viewData = $contractService->getIndexViewData($request, $this->user);

        return view('contracts.index', $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ContractService $contractService): View|Factory
    {
        $viewData = $contractService->getCreateViewData();
        return view('contracts.form', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractRequest $request, ContractService $contractService): RedirectResponse|Redirector
    {
        $data = [...$request->all(), 'status' => ContractStatus::ACTIVE];
        $contractService->create($data);
        return redirect()->route('contracts.index')->with('success', 'Contrato criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract): View|Factory
    {
        $contract->load(['client', 'supplier', 'acquirers', 'paymentArrangements']);
        return view('contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract, ContractService $contractService): View|Factory
    {
        $contract->load('acquirers', 'paymentArrangements');
        $viewData = $contractService->getEditViewData();
        return view('contracts.form', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractRequest $request, Contract $contract, ContractService $contractService): RedirectResponse|Redirector
    {
        $data = $request->all();
        $contractService->update($contract, $data);
        return redirect()->route('contracts.index')->with('success', 'Contrato atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract, ContractService $contractService): RedirectResponse|Redirector
    {
        $contractService->destroy($contract);
        return redirect()->route('contracts.index')->with('success', 'Contrato removido com sucesso.');
    }
}
