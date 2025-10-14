<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\BusinessPartnerController;
use App\Http\Controllers\Web\ContractController;
use App\Http\Controllers\Web\OperationController;
use App\Http\Controllers\Web\OptInController;
use App\Http\Controllers\Web\ReceivableController;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('business-partners', BusinessPartnerController::class);
    Route::resource('contracts', ContractController::class);
    Route::resource('opt-ins', OptInController::class);
    Route::resource('receivables', ReceivableController::class);
    Route::resource('operations', OperationController::class);
});

require __DIR__ . '/auth.php';
