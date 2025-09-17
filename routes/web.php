<?php

use App\Http\Controllers\BusinessPartnerController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\Web\GeneralController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GeneralController::class, 'index']);

// ---

Route::resource('business-partners', BusinessPartnerController::class);
Route::resource('contracts', ContractController::class);



Route::post('/opt-in', [GeneralController::class, 'optIn']);
Route::delete('/opt-out/{optIn}', [GeneralController::class, 'optOut']);
