<?php

namespace App\Http\Controllers\Web;

use App\Enums\BusinessPartnerType;
use App\Enums\ContractStatus;
use App\Handlers\ContractOperationHandler;
use App\Http\Controllers\Controller;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Operation;
use App\Models\Core\PaymentArrangement;
use App\Models\User;
use App\Services\Core\ContractService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class OperationController extends Controller
{
    private User $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }


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

    public function execute(Request $request, ContractService $contractService)
    {
        $client = BusinessPartner::findByDocumentNumber($request->document_number)->load('users');

        $contractData = $this->buildContractData($client, $request->negotiation_type);

        $contract = $contractService->create($contractData);

        $handler = new ContractOperationHandler($contract, $client);

        $handler->dispatchOperation([
            'value' => $request->warranted_value,
            'negotiation_type' => $request->negotiation_type,
        ]);

        dd($request->all());
    }

    private function buildContractData(BusinessPartner $partner, Request $request): array
    {
        return [
            'status' => ContractStatus::ACTIVE,
            'client_id' => $partner->id,
            'supplier_id' => $this->user->supplier()?->id,
            'value' => $request->warranted_value,
            'negotiation_type' => $request->negotiation_type,
            'start_date' => $partner->pivot->opt_in_start_date,
            'end_date' => $partner->pivot->opt_in_end_date,
            'uses_registrar_management' => true,
        ];
    }
}
