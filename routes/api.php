<?php

use App\Http\Controllers\ContractHasPaymentArrangementController;
use App\Http\Controllers\PaymentArrangementController;
use App\Http\Controllers\ContractHasAcquirerController;
use App\Http\Controllers\AcquirerController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\BusinessPartnerController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\OptOutController;
use App\Http\Controllers\OptInController;
use App\Http\Controllers\ReceivableMovementController;
use App\Http\Controllers\NegotiationWindowController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\ReceivableController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\AttachmentController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('webhooks')->group(function () {
        //
    });

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/forgot-password', [AuthController::class, 'startPasswordReset']);
    Route::post('/reset-password', [PasswordResetController::class, 'apiUpdatePassword']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/check-bearer-token', function () {
            return response()->json('User exists and Bearer token is valid');
        });

        Route::post('attachment', [AttachmentController::class, 'addAttachment']);
        Route::delete('attachment', [AttachmentController::class, 'destroyAllAttachment']);

        Route::apiResources([
'receivables' => ReceivableController::class,
            'merchants' => MerchantController::class,
            'accounts' => AccountController::class,
            'participants' => ParticipantController::class,
            'negotiation-windows' => NegotiationWindowController::class,
            'receivable-movements' => ReceivableMovementController::class,
    'opt-ins' => OptInController::class,
    'opt-outs' => OptOutController::class,
    'operations' => OperationController::class,
    'clients' => ClientController::class,
    'business-partners' => BusinessPartnerController::class,
    'contracts' => ContractController::class,
    'acquirers' => AcquirerController::class,
    'contract-has-acquirers' => ContractHasAcquirerController::class,
    'payment-arrangements' => PaymentArrangementController::class,
    'contract-has-payment-arrangements' => ContractHasPaymentArrangementController::class,
]);
    });
});
