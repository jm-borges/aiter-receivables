<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class GeneralController extends Controller
{
    public function index()
    {
        return view('index', [
            //
        ]);
    }
}
