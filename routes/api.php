<?php

use App\Enums\BusinessPartnerType;
use App\Handlers\OperationsUpdater;
use App\Handlers\ReceivablesUpdater;
use App\Http\Controllers\Core\ContractPaymentController;
use App\Http\Controllers\Core\PaymentArrangementController;
use App\Http\Controllers\Core\ContractController;
use App\Http\Controllers\Core\BusinessPartnerController;
use App\Http\Controllers\Core\OptOutController;
use App\Http\Controllers\Core\OptInController;
use App\Http\Controllers\Core\ReceivableController;
use App\Http\Controllers\Core\ActionController;
use App\Http\Controllers\Core\OperationController;
use App\Http\Controllers\Core\Files\ARRC018ResponseController;
use App\Http\Controllers\Webhooks\RtmWebhookController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\Core\CipMessageController;
use App\Http\Controllers\Core\SettingController;
use App\Models\Core\BusinessPartner;
use Illuminate\Support\Facades\Route;

Route::get('sdgjdsjdjj', function () {
    app(OperationsUpdater::class)->updatesOperations();
    $clients = BusinessPartner::where('type', BusinessPartnerType::CLIENT)->get();
    app(ReceivablesUpdater::class)->updatesReceivables($clients);
});

Route::prefix('v1')->group(function () {

    Route::prefix('webhooks')->group(function () {
        Route::prefix('rtm')->group(function () {
            Route::prefix('v1')->group(function () {
                Route::prefix('webhook-notifications')->middleware('validate.rtm.token')->group(function () {
                    Route::post('opt-in-notification', [RtmWebhookController::class, 'handleOptInNotification']); // RRC0028
                    Route::post('opt-out-notification', [RtmWebhookController::class, 'handleOptOutNotification']); // RRC0029
                    Route::post('time-table', [RtmWebhookController::class, 'handleTimeTable']); // RRC0015
                    Route::post('operation-notification', [RtmWebhookController::class, 'handleOperationNotification']); // RRC0003
                    Route::post('operation-notification/update', [RtmWebhookController::class, 'handleOperationUpdate']); // RRC0003
                    Route::post('operation-cancel-notification', [RtmWebhookController::class, 'handleOperationCancel']); // RRC0004
                    Route::post('operation-response', [RtmWebhookController::class, 'handleOperationResponse']); // RRC0019, RRC0035
                    Route::post('cancel-operation-response', [RtmWebhookController::class, 'handleCancelOperationResponse']); // RRC0020 
                    Route::post('warranty-withdrawal-notification', [RtmWebhookController::class, 'handleWarrantyWithdrawalNotification']); // RRC0012, RRC0014
                    Route::post('refusal-surplus-output-notification', [RtmWebhookController::class, 'handleRefusalSurplusOutputNotification']); // RRC0024
                    Route::post('retornos-registro-operacao', [RtmWebhookController::class, 'handleRetornosRegistroOperacao']); // RRC0019R1

                    Route::prefix('files')->group(function () {
                        Route::post('receivable-unit-response', [RtmWebhookController::class, 'handleReceivableUnitResponse']); // ARRC001
                        Route::post('operation-summary', [RtmWebhookController::class, 'handleOperationSummary']); // ARRC007
                        Route::post('updated-participant-list', [RtmWebhookController::class, 'handleUpdatedParticipantList']); // ARRC017
                        Route::post('receivable-schedules', [RtmWebhookController::class, 'handleReceivableSchedules']); // ARRC018
                        Route::post('arrc018-response', [RtmWebhookController::class, 'handleArrc018Response']); // ARRC018
                        Route::post('arrc022-response', [RtmWebhookController::class, 'handleArrc022Response']); // ARRC022
                        Route::post('arrc023-response', [RtmWebhookController::class, 'handleArrc023Response']); // ARRC023
                        Route::post('merchant-response', [RtmWebhookController::class, 'handleMerchantResponse']); // ARRC030
                        Route::post('arrc033-response', [RtmWebhookController::class, 'handleArrc033Response']); // ARRC033
                        Route::post('arrc036-response', [RtmWebhookController::class, 'handleArrc036Response']); // ARRC036
                        Route::post('crrc034-response', [RtmWebhookController::class, 'handleCrrc034Response']); // CRRC034
                        Route::post('crrc039-response', [RtmWebhookController::class, 'handleCrrc039Response']); // CRRC039
                        Route::post('crrc040-response', [RtmWebhookController::class, 'handleCrrc040Response']); // CRRC040
                        Route::post('crrc041-response', [RtmWebhookController::class, 'handleCrrc041Response']); // CRRC041
                        Route::post('crrc042-response', [RtmWebhookController::class, 'handleCrrc042Response']); // CRRC042
                    });
                });
            });
        });
    });

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/forgot-password', [AuthController::class, 'startPasswordReset']);
    Route::post('/reset-password', [PasswordResetController::class, 'apiUpdatePassword']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/check-bearer-token', function () {
            return response()->json('User exists and Bearer token is valid');
        });

        Route::apiResources([
            'receivables' => ReceivableController::class,
            'opt-ins' => OptInController::class,
            'opt-outs' => OptOutController::class,
            'business-partners' => BusinessPartnerController::class,
            'payment-arrangements' => PaymentArrangementController::class,
            'contracts' => ContractController::class,
            'operations' => OperationController::class,
            'actions' => ActionController::class,
            'arrc018-responses' => ARRC018ResponseController::class,
            'cip-messages' => CipMessageController::class,
            'settings' => SettingController::class,
            'contract-payments' => ContractPaymentController::class,
        ]);

        Route::get('business-partners/{id}/receivables/summary', [BusinessPartnerController::class, 'receivablesSummary']);
        Route::get('business-partners/lookup/{cnpj}/receivables/summary', [BusinessPartnerController::class, 'receivablesSummaryByCnpj']);
        Route::get('business-partners/{id}/contract-payments/summary', [BusinessPartnerController::class, 'contractPaymentsSummary']);
        Route::get('business-partners/lookup/{cnpj}/credit-analysis', [BusinessPartnerController::class, 'creditAnalysisByCnpj']);
        Route::get('business-partners/{id}/receivables/schedule', [BusinessPartnerController::class, 'receivablesSchedule']);


        Route::post('attachment', [AttachmentController::class, 'addAttachment']);
        Route::delete('attachment', [AttachmentController::class, 'destroyAllAttachment']);
    });
});
