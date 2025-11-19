<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;


class CreditAnalysisController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('credit-analysis.index', []);
    }
}
