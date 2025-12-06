<?php

namespace App\Http\Controllers\Web;

use App\DataTransferObjects\ContractOperationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExecuteContractOperationRequest;
use App\Models\Core\Operation;
use App\Services\ContractOperationService;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class OperationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Listagem 
     */
    public function index()
    {
        if ($this->user->isSuperAdmin()) {
            $operations = Operation::with(['action', 'contract'])
                ->paginate($request->per_page ?? 20);
        } else {
            $operations = $this->user->operationsAsSupplier()
                ?->with(['action', 'contract'])
                ?->paginate($request->per_page ?? 20)
                ?? new LengthAwarePaginator(collect(), 0, 10);
        }

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

    public function execute(ExecuteContractOperationRequest $request, ContractOperationService $service): Redirector | RedirectResponse
    {
        $dto = ContractOperationData::fromRequest($request);
        $resultInfo = $service->execute($dto);

        if ($resultInfo->hasError) {
            return redirect('/dashboard')->with('error', 'Ocorreu um erro ao tentar enviar a operação para a registrada. A equipe técnica já foi informada');
        }

        return redirect('/dashboard')->with('success', 'Operação solicitada com sucesso. Aguarde a resposta da registradora');
    }
}
