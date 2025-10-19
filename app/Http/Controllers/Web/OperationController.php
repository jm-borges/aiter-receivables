<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Core\Operation;


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
}
