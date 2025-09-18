<?php

use App\Http\Controllers\Web\BusinessPartnerController;
use App\Http\Controllers\Web\ContractController;
use App\Http\Controllers\Web\GeneralController;
use App\Http\Controllers\Web\OptInController;
use App\Http\Controllers\Web\ReceivableController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GeneralController::class, 'index']);

// ---

Route::resource('business-partners', BusinessPartnerController::class);
Route::resource('contracts', ContractController::class);
Route::resource('opt-ins', OptInController::class);
Route::resource('receivables', ReceivableController::class);
