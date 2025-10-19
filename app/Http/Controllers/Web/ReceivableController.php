<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Core\Receivable;

class ReceivableController extends Controller
{
    public function index()
    {
        $receivables = Receivable::with(['client', 'acquirer', 'paymentArrangement', 'contracts', 'optIn'])
            ->latest()
            ->paginate(15);

        return view('receivables.index', compact('receivables'));
    }

    public function show(string $id)
    {
        $receivable = Receivable::with(['client', 'acquirer', 'paymentArrangement', 'contracts', 'optIn'])
            ->findOrFail($id);

        return view('receivables.show', compact('receivable'));
    }

    public function queryIndex()
    {
        return view('receivables.query-index', []);
    }
}
