<?php

namespace App\Http\Controllers\Web;

use App\Handlers\ContractOperationHandler;
use App\Http\Controllers\Controller;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Operation;
use Illuminate\Http\Request;

class OperationController extends Controller
{
    /**
     * Listagem 
     */
    public function index()
    {
        $operations = Operation::with([
            'action',
        ])->paginate(20);

        return view('operations.index', compact('operations'));
    }

    /**
     * Detalhes
     */
    public function show(Operation $operation)
    {
        $operation->load([
            'action',
        ]);

        return view('operations.show', compact('operation'));
    }

    public function executeIndex()
    {
        return view('operations.execute-index', []);
    }

    public function execute(Request $request)
    {
        $client = BusinessPartner::findByDocumentNumber($request->document_number)->load('clientContracts');

        $contract = $client->contracts->first();

        if (!$contract) {
            return redirect('/operations/execute')->with('error', 'Ainda não foi cadastrado um contrato com esse cliente');
        }

        if ($contract->isAutomatic()) {
            return redirect('/operations/execute')->with('error', 'O contrato desse cliente está definido como operação automática pelo sistema');
        }

        $handler = new ContractOperationHandler($contract, $client);

        $handler->dispatchOperation([
            'value' => $request->warranted_value,
            'negotiation_type' => $request->negotiation_type
        ]);

        dd($request->all());
    }
}
