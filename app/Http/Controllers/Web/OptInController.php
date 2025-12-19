<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Core\OptIn;
use App\Services\Core\OptOutService;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use RuntimeException;

class OptInController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Listagem de opt-ins.
     */
    public function index()
    {
        if ($this->user->isSuperAdmin()) {
            $optins = OptIn::with([
                'client',
                'acquirer',
                'paymentArrangement',
            ])->paginate($request->per_page ?? 20);
        } else {
            $optins = $this->user->optIns()
                ?->with([
                    'client',
                    'acquirer',
                    'paymentArrangement',
                ])
                ?->paginate($request->per_page ?? 20)
                ?? new LengthAwarePaginator(collect(), 0, 10);
        }

        return view('optins.index', compact('optins'));
    }

    /**
     * Detalhes de um opt-in.
     */
    public function show(OptIn $optIn)
    {
        $optIn->load([
            'client',
            'contract',
            'acquirer',
            'paymentArrangement',
            'receivables',
            'optOut',
        ]);

        return view('optins.show', compact('optIn'));
    }

    public function destroy(OptIn $optIn, OptOutService $optOutService)
    {
        try {
            $optOutService->requestOptOut($optIn);

            return redirect('/opt-ins')
                ->with('success', "Anuência cancelada com sucesso.");
        } catch (RuntimeException $e) {
            return redirect('/opt-ins')
                ->with('error', "Falha ao cancelar a anuência: " . $e->getMessage());
        } catch (Exception $e) {
            return redirect('/opt-ins')
                ->with('error', "Ocorreu um erro inesperado ao cancelar a anuência.");
        }
    }
}
