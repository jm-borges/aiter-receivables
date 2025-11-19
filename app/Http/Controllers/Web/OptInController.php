<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Core\OptIn;
use Illuminate\Pagination\LengthAwarePaginator;

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
            $optIns = OptIn::with([
                'client',
                'contract',
                'acquirer',
                'paymentArrangement',
            ])->paginate($request->per_page ?? 20);
        } else {
            $optIns = $this->user->optIns()
                ?->with([
                    'client',
                    'contract',
                    'acquirer',
                    'paymentArrangement',
                ])
                ?->paginate($request->per_page ?? 20)
                ?? new LengthAwarePaginator(collect(), 0, 10);
        }

        return view('optins.index', compact('optIns'));
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
}
