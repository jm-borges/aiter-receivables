<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Core\OptIn;

class OptInController extends Controller
{
    /**
     * Listagem de opt-ins.
     */
    public function index()
    {
        $optIns = OptIn::with([
            'client',
            'contract',
            'acquirer',
            'paymentArrangement',
        ])->paginate(20);

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
