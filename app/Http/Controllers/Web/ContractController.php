<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Jobs\DispatchOptInJob;
use App\Models\Core\Contract;
use App\Models\Core\BusinessPartner;
use App\Models\Core\PaymentArrangement;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = Contract::with(['client', 'supplier', 'acquirers'])->paginate(20);
        return view('contracts.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = BusinessPartner::where('type', 'client')->get();
        $suppliers = BusinessPartner::where('type', 'supplier')->get();
        $acquirers = BusinessPartner::where('type', 'acquirer')->get();
        $paymentArrangements = PaymentArrangement::all();

        return view('contracts.form', compact('clients', 'suppliers', 'acquirers', 'paymentArrangements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:business_partners,id',
            'supplier_id' => 'required|exists:business_partners,id',
            'value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'acquirers' => 'array',
            'acquirers.*' => 'exists:business_partners,id',
            'payment_arrangements' => 'array',
            'payment_arrangements.*' => 'exists:payment_arrangements,id',
        ]);

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

        return redirect()->route('contracts.index')->with('success', 'Contrato criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        $contract->load(['client', 'supplier', 'acquirers', 'paymentArrangements']);
        return view('contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        $contract->load('acquirers', 'paymentArrangements');

        $clients = BusinessPartner::where('type', 'client')->get();
        $suppliers = BusinessPartner::where('type', 'supplier')->get();
        $acquirers = BusinessPartner::where('type', 'acquirer')->get();
        $paymentArrangements = PaymentArrangement::all();

        return view('contracts.form', compact('contract', 'clients', 'suppliers', 'acquirers', 'paymentArrangements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:business_partners,id',
            'supplier_id' => 'required|exists:business_partners,id',
            'value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'acquirers' => 'array',
            'acquirers.*' => 'exists:business_partners,id',
            'payment_arrangements' => 'array',
            'payment_arrangements.*' => 'exists:payment_arrangements,id',
        ]);

        $contract->update($data);

        $contract->acquirers()->sync($data['acquirers'] ?? []);
        $contract->paymentArrangements()->sync($data['payment_arrangements'] ?? []);

        if (!empty($data['acquirers']) || !empty($data['payment_arrangements'])) {
            dispatch(new DispatchOptInJob($contract));
        }

        return redirect()->route('contracts.index')->with('success', 'Contrato atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        $contract->acquirers()->detach();
        $contract->paymentArrangements()->detach();
        $contract->delete();

        return redirect()->route('contracts.index')->with('success', 'Contrato removido com sucesso.');
    }
}
