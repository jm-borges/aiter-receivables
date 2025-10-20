<?php

namespace App\Http\Controllers\Webhooks;

use App\Enums\OperationStatus;
use App\Http\Controllers\Controller;
use App\Jobs\VerifyReceivablesToOperateJob;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Files\ARRC018Response;
use App\Models\Core\Operation;
use App\Models\Core\PaymentArrangement;
use App\Models\Core\Receivable;
use App\Services\Core\Files\ARRC018ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class RtmWebhookController extends Controller
{
    private RtmWebhookSubService $rtmWebhookSubService;

    public function __construct(RtmWebhookSubService $rtmWebhookSubService)
    {
        $this->rtmWebhookSubService = $rtmWebhookSubService;
    }

    public function handleOptInNotification(Request $request): JsonResponse
    {
        return $this->processEvent('Opt-In Notification', $request, function (array $data) {
            //$this->rtmWebhookSubService->createOptInNotification($data);
            Log::info("Processando Opt-In...", $data);
        });
    }

    public function handleOptOutNotification(Request $request): JsonResponse
    {
        return $this->processEvent('Opt-Out Notification', $request, function (array $data) {
            //$this->rtmWebhookSubService->createOptOutResponse($data);
            Log::info("Processando Opt-Out...", $data);
        });
    }

    public function handleTimeTable(Request $request): JsonResponse
    {
        return $this->processEvent('Time Table Notification', $request, function (array $data) {
            //$this->rtmWebhookSubService->createTimetable($data);
            Log::info("Atualizando Time Table...", $data);
        });
    }

    public function handleOperationNotification(Request $request): JsonResponse
    {
        return $this->processEvent('Operation Notification', $request, function ($data) {
            //$this->rtmWebhookSubService->createOperationNotification($data);
            Log::info("Notificação de operação recebida.", $data);
        });
    }

    public function handleOperationUpdate(Request $request): JsonResponse
    {
        return $this->processEvent('Operation Update', $request, function ($data) {
            //$this->rtmWebhookSubService->createOperationNotification($data);
            Log::info("Atualizando operação...", $data);
        });
    }

    public function handleOperationCancel(Request $request): JsonResponse
    {
        return $this->processEvent('Operation Cancel', $request, function ($data) {
            // $operationCancelNotification = $this->rtmWebhookSubService->createOperationCancelNotification($data);
            // $this->rtmWebhookSubService->processReceivableUnitCancels($data['receivableUnits'] ?? [], $operationCancelNotification);
            Log::info("Operação cancelada.", $data);
        });
    }

    public function handleOperationResponse(Request $request): JsonResponse
    {
        return $this->processEvent('Operation Response', $request, function ($data) {
            Log::info("Recebendo resposta da operação...", $data);

            $identifier = $data['receivableNegociationId'];
            $operation = Operation::find($identifier);

            if ($operation) {
                $operation->update([
                    'identdOp' => $data['operationId'] ?? null,
                    'sitRet' => strtolower($data['status']),
                    'operation_href' => $data['operationHref'] ?? null,
                    'status' => strtolower($data['status']) === 'recusado' ?
                        OperationStatus::REFUSED : (strtolower($data['status']) === 'aceito' ?
                            OperationStatus::ACCEPTED : OperationStatus::ERROR),
                ]);

                if (isset($data['cipMessages'])) {
                    foreach ($data['cipMessages'] as $cipMessage) {
                        $operation->cipMessages()->create([
                            'code' => $cipMessage['code'],
                            'content' => $cipMessage['content'],
                            'field' => $cipMessage['field'],
                            'message' => $cipMessage['message'],
                        ]);
                    }
                }
            }
        });
    }

    public function handleCancelOperationResponse(Request $request): JsonResponse
    {
        return $this->processEvent('Cancel Operation Response', $request, function ($data) {
            /*  $cancelOperationResponse = $this->rtmWebhookSubService->createCancelOperationResponse($data);
            $this->rtmWebhookSubService->processCipMessages($data['messages'] ?? [], cancelOperationResponse: $cancelOperationResponse); */
            Log::info("Recebendo resposta de cancelamento...", $data);
        });
    }

    public function handleReceivableUnitResponse(Request $request): JsonResponse
    {
        return $this->processEvent('Receivable Unit Response', $request, function ($data) {
            /*  $response = $this->rtmWebhookSubService->createReceivableUnitResponse($data);

            $this->rtmWebhookSubService->processReceivableUnits($data['receivableUnitsApproved'] ?? [], $response, 'approved');
            $this->rtmWebhookSubService->processReceivableUnits($data['receivableUnitsRefused'] ?? [], $response, 'refused'); */

            Log::info("Processando unidade recebível...", $data);
        });
    }

    public function handleOperationSummary(Request $request): JsonResponse
    {
        return $this->processEvent('Operation Summary', $request, function ($data) {
            // $operationSummary = $this->rtmWebhookSubService->createOperationSummary($data);
            // $this->rtmWebhookSubService->processOperationSummaryControls($data['operationSummaryControl'] ?? [], $operationSummary);

            Log::info("Resumo da operação recebido.", $data);
        });
    }

    public function handleUpdatedParticipantList(Request $request): JsonResponse
    {
        return $this->processEvent('Updated Participant List', $request, function ($data) {
            /* foreach ($data as $participantData) {
                $this->rtmWebhookSubService->createParticipant($participantData);
            } */

            Log::info("Lista de participantes atualizada.", $data);
        });
    }

    public function handleMerchantResponse(Request $request): JsonResponse
    {
        return $this->processEvent('Merchant Response', $request, function ($data) {
            /*  $merchantResponse = $this->rtmWebhookSubService->createMerchantResponse($data);

            $this->rtmWebhookSubService->processMerchants($data['approvedMerchants'] ?? [], $merchantResponse, 'approved');
            $this->rtmWebhookSubService->processMerchants($data['rejectedMerchants'] ?? [], $merchantResponse, 'rejected');
 */
            Log::info("Resposta do comerciante recebida.", $data);
        });
    }

    public function handleReceivableSchedules(Request $request): JsonResponse
    {
        return $this->processEvent('Receivable Schedules', $request, function ($data) {
            /*  $receivableSchedule = $this->rtmWebhookSubService->createReceivableSchedule($data);

            $this->rtmWebhookSubService->processReceiverFinalUsers($data['receiverFinalUsers'] ?? [], $receivableSchedule);
            $this->rtmWebhookSubService->processReceivableScheduleHolders($data['receivableScheduleHolders'] ?? [], $receivableSchedule);
 */
            Log::info("Recebendo cronograma de recebíveis...", $data);
        });
    }

    public function handleWarrantyWithdrawalNotification(Request $request): JsonResponse
    {
        return $this->processEvent('WarrantyWithdrawalNotification', $request, function ($data) {
            Log::info("WarrantyWithdrawalNotification", $data);
        });
    }

    public function handleRefusalSurplusOutputNotification(Request $request): JsonResponse
    {
        return $this->processEvent('RefusalSurplusOutputNotification', $request, function ($data) {
            Log::info("RefusalSurplusOutputNotification", $data);
        });
    }

    public function handleRetornosRegistroOperacao(Request $request): JsonResponse
    {
        return $this->processEvent('RetornosRegistroOperacao', $request, function ($data) {
            $identifier = $data['receivableNegociationId'];
            $operation = Operation::find($identifier);

            if ($operation) {
                $operation->update([
                    'identdOp' => $data['operationId'],
                    'sitRet' => strtolower($data['status']),
                    'operation_href' => $data['operationHref'] ?? null,
                    'status' => strtolower($data['status']) === 'recusado' ?
                        OperationStatus::REFUSED : (strtolower($data['status']) === 'aceito' ?
                            OperationStatus::ACCEPTED : OperationStatus::ERROR),
                ]);
            }
        });
    }

    public function handleArrc018Response(Request $request): JsonResponse
    {
        return $this->processEvent('Arrc018Response', $request, function (array $data) {
            app(ARRC018ResponseService::class)->process($data);
        });
    }

    public function handleArrc022Response(Request $request): JsonResponse
    {
        return $this->processEvent('Arrc022Response', $request, function ($data) {
            Log::info("Arrc022Response", $data);
        });
    }

    public function handleArrc023Response(Request $request): JsonResponse
    {
        return $this->processEvent('Arrc023Response', $request, function ($data) {
            Log::info("Arrc023Response", $data);
        });
    }

    public function handleArrc033Response(Request $request): JsonResponse
    {
        return $this->processEvent('Arrc033Response', $request, function ($data) {
            Log::info("Arrc033Response", $data);
        });
    }

    public function handleArrc036Response(Request $request): JsonResponse
    {
        return $this->processEvent('Arrc036Response', $request, function ($data) {
            Log::info("Arrc036Response", $data);
        });
    }

    public function handleCrrc034Response(Request $request): JsonResponse
    {
        return $this->processEvent('Crrc034Response', $request, function ($data) {
            Log::info("Crrc034Response", $data);
        });
    }

    public function handleCrrc039Response(Request $request): JsonResponse
    {
        return $this->processEvent('Crrc039Response', $request, function ($data) {
            Log::info("Crrc039Response", $data);
        });
    }

    public function handleCrrc040Response(Request $request): JsonResponse
    {
        return $this->processEvent('Crrc040Response', $request, function ($data) {
            Log::info("Crrc040Response", $data);
        });
    }

    public function handleCrrc041Response(Request $request): JsonResponse
    {
        return $this->processEvent('Crrc041Response', $request, function ($data) {
            Log::info("Crrc041Response", $data);
        });
    }

    public function handleCrrc042Response(Request $request): JsonResponse
    {
        return $this->processEvent('Crrc042Response', $request, function ($data) {
            Log::info("Crrc042Response", $data);
        });
    }

    private function processEvent(string $eventName, Request $request, callable $callback): JsonResponse
    {
        try {
            $data = $request->json()->all();

            Log::info("Evento salvo no banco de dados: {$eventName}", $data);

            $callback($data);

            return response()->json(['message' => "{$eventName} processado com sucesso."], 200);
        } catch (Exception $e) {
            Log::error("Erro ao processar webhook: " . $e->getMessage() . ' | ' . $e->getFile() . ' | ' .  $e->getLine());
            return response()->json(['error' => 'Erro interno ao processar o evento.'], 500);
        }
    }
}
