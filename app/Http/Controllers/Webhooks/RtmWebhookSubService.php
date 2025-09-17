<?php

namespace App\Http\Controllers\Webhooks;

use App\Models\Rtm\CancelOperationResponse;
use App\Models\Rtm\CipMessage;
use App\Models\Rtm\Error;
use App\Models\Rtm\HolderReceivableUnit;
use App\Models\Rtm\Merchant;
use App\Models\Rtm\MerchantResponse;
use App\Models\Rtm\OperationCancelNotification;
use App\Models\Rtm\OperationNotification;
use App\Models\Rtm\OperationResponse;
use App\Models\Rtm\OperationSummary;
use App\Models\Rtm\OperationSummaryControl;
use App\Models\Rtm\OptInNotification;
use App\Models\Rtm\OptOutResponse;
use App\Models\Rtm\Participant;
use App\Models\Rtm\ReceivableSchedule;
use App\Models\Rtm\ReceivableScheduleHolder;
use App\Models\Rtm\ReceivableScheduleReceivingFinalUser;
use App\Models\Rtm\ReceivableUnit;
use App\Models\Rtm\ReceivableUnitCancel;
use App\Models\Rtm\ReceivableUnitDomicile;
use App\Models\Rtm\ReceivableUnitDomicileOperation;
use App\Models\Rtm\ReceivableUnitFinalUserHolder;
use App\Models\Rtm\ReceivableUnitOtherInstitution;
use App\Models\Rtm\ReceivableUnitResponse;
use App\Models\Rtm\ReceivingFinalUserReceivableUnit;
use App\Models\Rtm\Timetable;
use Carbon\Carbon;

class RtmWebhookSubService
{
    public function processCipMessages(array $cipMessages, ?OperationResponse $operationResponse = null, ?CancelOperationResponse $cancelOperationResponse = null): void
    {
        foreach ($cipMessages as $cipMessageInfo) {
            CipMessage::create([
                'code' => $cipMessageInfo['code'],
                'content' => $cipMessageInfo['content'],
                'field' => $cipMessageInfo['field'],
                'message' => $cipMessageInfo['message'],
                'operation_response_id' => $operationResponse?->id,
                'cancel_operation_response_id' => $cancelOperationResponse?->id,
            ]);
        }
    }


    public function processReceivableUnits(array $receivableUnits, ReceivableUnitResponse $response, string $status): void
    {
        foreach ($receivableUnits as $unit) {
            $this->processReceivableUnit($unit, $response, $status);
        }
    }

    protected function processReceivableUnit(array $unit, ReceivableUnitResponse $response, string $status): void
    {
        $receivableUnit = $this->createReceivableUnit($unit, $response, $status);
        $this->processErrors($unit['errors'] ?? [], $receivableUnit);
        $this->processPayments($unit['payments'] ?? [], $receivableUnit);
    }

    public function processOperationSummaryControls(array $operationSummaryControl, ?OperationSummary $operationSummary): void
    {
        foreach ($operationSummaryControl as $control) {
            $this->createOperationSummaryControl($control, $operationSummary);
        }
    }

    public function processReceivableUnitCancels(array $receivableUnitCancels, OperationCancelNotification $operationCancelNotification): void
    {
        foreach ($receivableUnitCancels as $receivableUnitInfo) {
            ReceivableUnitCancel::create([
                'sub_or_acquirer_document' => $receivableUnitInfo['subOrAcquirerDocument'] ?? null,
                'recipient_document' => $receivableUnitInfo['recipientDocument'] ?? null,
                'payment_scheme' => $receivableUnitInfo['paymentScheme'] ?? null,
                'settlement_date' => $receivableUnitInfo['settlementDate'] ?? null,
                'trader_document' => $receivableUnitInfo['traderDocument'] ?? null,
                'negociated_value_canceled' => $receivableUnitInfo['negociatedValueCanceled'] ?? null,
                'value_or_percent_to_constitute_canceled' => $receivableUnitInfo['valueOrPercentToConstituteCanceled'] ?? null,
                'operation_cancel_notification_id' => $operationCancelNotification?->id,
            ]);
        }
    }


    public function processReceivableScheduleHolders(array $receivableScheduleHolders, ?ReceivableSchedule $receivableSchedule): void
    {
        foreach ($receivableScheduleHolders as $receivableScheduleHolderInfo) {
            $this->processReceivableScheduleHolder($receivableScheduleHolderInfo, $receivableSchedule);
        }
    }

    protected function processReceivableScheduleHolder(array $receivableScheduleHolderInfo, ?ReceivableSchedule $receivableSchedule): void
    {
        $receivableScheduleHolder = $this->createReceivableScheduleHolder($receivableScheduleHolderInfo, $receivableSchedule);
        $this->processHolderReceivableUnits($receivableScheduleHolderInfo['holderReceivableUnits'] ?? [],  $receivableScheduleHolder);
    }

    protected function processHolderReceivableUnits(array $holderReceivableUnits, ?ReceivableScheduleHolder  $receivableScheduleHolder): void
    {
        foreach ($holderReceivableUnits as $holderReceivableUnitInfo) {
            $this->processHolderReceivableUnit($holderReceivableUnitInfo, $receivableScheduleHolder);
        }
    }

    protected function processHolderReceivableUnit(array $holderReceivableUnitInfo, ?ReceivableScheduleHolder  $receivableScheduleHolder): void
    {
        $holderReceivableUnit = $this->createHolderReceivableUnit($holderReceivableUnitInfo, $receivableScheduleHolder);
        $this->processReceivableUnitDomiciles($holderReceivableUnitInfo['domiciles'] ?? [], holderReceivableUnit: $holderReceivableUnit);
        $this->processReceivableUnitOtherInstitutions($holderReceivableUnitInfo['otherInstitutionOperations'] ?? [], holderReceivableUnit: $holderReceivableUnit);
    }

    protected function processReceivableUnitDomiciles(array $domiciles, ?HolderReceivableUnit $holderReceivableUnit = null, ?ReceivableUnitFinalUserHolder $holder = null): void
    {
        foreach ($domiciles as $domicileInfo) {
            $domicile = $this->createReceivableUnitDomicile($domicileInfo, holderReceivableUnit: $holderReceivableUnit, holder: $holder);
            $this->processOperations($domicileInfo['operations'] ?? [], $domicile);
        }
    }

    protected function processOperations(array $operations, ReceivableUnitDomicile $domicile): void
    {
        foreach ($operations as $operationInfo) {
            ReceivableUnitDomicileOperation::create([
                'operation_id' => $operationInfo['operationId'] ?? null,
                'receivable_unit_priority' => $operationInfo['receivableUnitPriority'] ?? null,
                'trade_repository_document' => $operationInfo['tradeRepositoryDocument'] ?? null,
                'negociated_value' => $operationInfo['negociatedValue'] ?? null,
                'creditor_amount_to_constitute' => $operationInfo['creditorAmountToConstitute'] ?? null,
                'division_rule_indicator' => $operationInfo['divisionRuleIndicator'] ?? null,
                'operation_ending_date' => $operationInfo['operationEndingDate'] ?? null,
                'receivable_unit_domicile_id' => $domicile?->id,
            ]);
        }
    }


    protected function processReceivableUnitOtherInstitutions(array $otherInstitutionOperations, ?HolderReceivableUnit $holderReceivableUnit = null, ?ReceivableUnitFinalUserHolder $holder = null): void
    {
        foreach ($otherInstitutionOperations as  $otherInstitutionOperationInfo) {
            $this->createReceivableUnitOtherInstitution($otherInstitutionOperationInfo, holderReceivableUnit: $holderReceivableUnit, holder: $holder);
        }
    }

    public function processReceiverFinalUsers(array $receiverFinalUsers, ?ReceivableSchedule $receivableSchedule): void
    {
        foreach ($receiverFinalUsers as $receiverFinalUserInfo) {
            $this->processReceiverFinalUser($receiverFinalUserInfo, $receivableSchedule);
        }
    }

    protected function processReceiverFinalUser(array $receiverFinalUserInfo, ?ReceivableSchedule $receivableSchedule): void
    {
        $receiverFinalUser = $this->createReceivableScheduleReceivingFinalUser($receiverFinalUserInfo, $receivableSchedule);
        $this->processReceivableUnitSchedules($receiverFinalUserInfo['receivableUnitSchedules'] ?? [], $receiverFinalUser);
    }


    protected function processReceivableUnitSchedules(array $receivableUnitSchedules, ?ReceivableScheduleReceivingFinalUser $receiverFinalUser): void
    {
        foreach ($receivableUnitSchedules as $receivableUnitScheduleInfo) {
            $this->processReceivableUnitSchedule($receivableUnitScheduleInfo, $receiverFinalUser);
        }
    }

    protected function processReceivableUnitSchedule(array $receivableUnitScheduleInfo, ?ReceivableScheduleReceivingFinalUser $receiverFinalUser)
    {
        $receivableUnitSchedule = $this->createReceivingFinalUserReceivableUnit($receivableUnitScheduleInfo, $receiverFinalUser);
        $this->processHolders($receivableUnitScheduleInfo['holders'] ?? [], $receivableUnitSchedule);
    }

    protected function processHolders(array $holders, ?ReceivingFinalUserReceivableUnit $receivableUnitSchedule)
    {
        foreach ($holders as $holderInfo) {
            $this->processHolder($holderInfo, $receivableUnitSchedule);
        }
    }

    protected function processHolder(array $holderInfo, ?ReceivingFinalUserReceivableUnit $receivableUnitSchedule)
    {
        $holder = $this->createReceivableUnitFinalUserHolder($holderInfo, $receivableUnitSchedule);
        $this->processReceivableUnitDomiciles($holderInfo['domiciles'], holder: $holder);
        $this->processReceivableUnitOtherInstitutions($holderInfo['otherInstitutionOperations'], holder: $holder);
    }

    protected function processErrors(array $errors, ReceivableUnit $receivableUnit)
    {
        foreach ($errors as $error) {
            $this->createError($error, $receivableUnit);
        }
    }

    protected function processPayments(array $payments, ReceivableUnit $receivableUnit)
    {
        foreach ($payments as $payment) {
            $this->processPayment($payment, $receivableUnit);
        }
    }

    protected function processPayment(array $payment, ReceivableUnit $receivableUnit): void
    {
        $paymentEntry = $this->createPayment($payment, $receivableUnit);
        if (isset($payment['paymentsInformation'])) {
            $this->createPaymentInformation($payment['paymentsInformation'], $paymentEntry);
        }
    }

    public function processMerchants(array $merchants, ?MerchantResponse $merchantResponse, string $status): void
    {
        foreach ($merchants as $merchant) {
            $this->createMerchant($merchant, $merchantResponse, $status);
        }
    }

    public function createOperationSummary(array $operationData): OperationSummary
    {
        return OperationSummary::create([
            'main_participant_id' => $operationData['mainParticipantId'],
            'managed_participant_id' => $operationData['managedParticipantId'] ?? null, // Campo opcional
            'cip_file_date' => $operationData['cipFileDate'],
            'cip_file_name' => $operationData['cipFileName'],
        ]);
    }

    protected function createOperationSummaryControl(array $control, ?OperationSummary $operationSummary): OperationSummaryControl
    {
        return OperationSummaryControl::create([
            'operation_summary_id' => $operationSummary?->id,
            'file_date' => $control['fileDate'],
            'file_name_received' => $control['fileNameReceived'],
            'file_name_sent' => $control['fileNameSent'],
            'participant_negociation_protocol' => $control['participantNegociationProtocol'] ?? null,
            'request_protocol' => $control['requestProtocol'] ?? null,
            'trade_repository_deconstruction_protocol' => $control['tradeRepositoryDeconstructionProtocol'] ?? null,
            'trade_repository_negociation_cancell_protocol' => $control['tradeRepositoryNegociationCancellProtocol'] ?? null,
            'trade_repository_operation_protocol' => $control['tradeRepositoryOperationProtocol'] ?? null,
            'trade_repository_opt_in_protocol' => $control['tradeRepositoryOptInProtocol'] ?? null,
            'trade_repository_opt_out_protocol' => $control['tradeRepositoryOptOutProtocol'] ?? null,
            'trade_repository_original_operation_protocol' => $control['tradeRepositoryOriginalOperationProtocol'] ?? null,
            'trade_repository_plea_protocol' => $control['tradeRepositoryPleaProtocol'] ?? null,
        ]);
    }


    protected function createMerchant(array $merchant, ?MerchantResponse $merchantResponse, string $status): Merchant
    {
        return Merchant::create([
            'operation_type' => $merchant['operationType'] ?? null,
            'customer_document_type' => $merchant['customerDocumentType'] ?? null,
            'customer_document' => $merchant['customerDocument'] ?? null,
            'legal_name' => $merchant['legalName'] ?? null,
            'social_name' => $merchant['socialName'] ?? null,
            'address' => $merchant['address'] ?? null,
            'zip_code' => $merchant['zipCode'] ?? null,
            'city' => $merchant['city'] ?? null,
            'state' => $merchant['state'] ?? null,
            'status' => $status,
            'merchant_response_id' => $merchantResponse?->id,
        ]);
    }

    public function createParticipant(array $participantData): Participant
    {
        return Participant::create([
            'document' => $participantData['document'] ?? null,
            'document_type' => $participantData['documentType'] ?? null,
            'domicile_indicator' => $participantData['domicileIndicator'] ?? null,
            'email' => $participantData['email'] ?? null,
            'homologation_entry_date' => $participantData['homologationEntryDate'] ?? null,
            'is_active' => $participantData['isActive'] ?? $participantData['IsActive'] ?? null,
            'name' => $participantData['name'] ?? null,
            'participant_type' => $participantData['participantType'] ?? null,
            'production_entry_date' => $participantData['productionEntryDate'] ?? null,
            'telephone' => $participantData['telephone'] ?? null,
            'managed_participant_id' => $participantData['managedParticipantId'] ?? null,
        ]);
    }

    public function createReceivableSchedule(array $data): ReceivableSchedule
    {
        return ReceivableSchedule::create([
            'source_file_name' => $data['sourceFileName'] ?? null,
            'payment_scheme_code' => $data['paymentSchemeCode'] ?? null,
            'managed_participant_id' => $data['managedParticipantId'] ?? null,
            'created_at' => $data['createdAt'] ?? null,
        ]);
    }

    protected function createReceivableUnitFinalUserHolder(
        array $holderInfo,
        ?ReceivingFinalUserReceivableUnit $receivableUnitSchedule
    ): ReceivableUnitFinalUserHolder {
        return ReceivableUnitFinalUserHolder::create([
            'bank_account_owner_document' => $holderInfo['bankAccountOwnerDocument'] ?? null,
            'bank_account_owner_total_amount' => $holderInfo['bankAccountOwnerTotalAmount'] ?? null,
            'amount_comprimised_in_other_institutions' => $holderInfo['amountComprimisedInOtherInstitutions'] ?? null,
            'amount_comprimised_on_institution' => $holderInfo['amountComprimisedOnInstitution'] ?? null,
            'total_avalable_amount' => $holderInfo['totalAvalableAmount'] ?? null,
            'participant_available_amount' => $holderInfo['participantAvailableAmount'] ?? null,
            'pre_contracted_amount' => $holderInfo['preContractedAmount'] ?? null,
            'technical_reserve_charge_amount' => $holderInfo['technicalReserveChargeAmount'] ?? null,
            'receiving_final_user_receivable_unit_id' => $receivableUnitSchedule?->id,
        ]);
    }


    protected function createReceivingFinalUserReceivableUnit(array $receivableUnitScheduleInfo, ?ReceivableScheduleReceivingFinalUser $receiverFinalUser): ReceivingFinalUserReceivableUnit
    {
        return ReceivingFinalUserReceivableUnit::create([
            'expected_settlement_date' => isset($receivableUnitScheduleInfo['expectedSettlementDate'])
                ? Carbon::parse($receivableUnitScheduleInfo['expectedSettlementDate'])->format('Y-m-d H:i:s')
                : null,
            'total_value' => $receivableUnitScheduleInfo['totalValue'] ?? null,
            'domicile_indicator' => $receivableUnitScheduleInfo['domicileIndicator'] ?? null,
            'receivable_schedule_receiving_final_user_id' => $receiverFinalUser?->id,
        ]);
    }

    public function createReceivableUnitResponse(array $data): ReceivableUnitResponse
    {
        return ReceivableUnitResponse::create([
            'main_participant_id' => $data['mainParticipantId'] ?? null,
            'managed_participant_id' => $data['managedParticipantId'] ?? null,
            'response_situation' => $data['responseSituation'] ?? null,
            'error_code' => $data['errorCode'] ?? null,
            'file_date' => isset($data['fileDate']) ? Carbon::parse($data['fileDate']) : null,
            'file_name' => $data['fileName'] ?? null,
            'reference_date' => isset($data['referenceDate']) ? Carbon::parse($data['referenceDate']) : null,
        ]);
    }

    protected function createReceivableUnit(array $unit, ReceivableUnitResponse $response, string $status): ReceivableUnit
    {
        return ReceivableUnit::create([
            'receivable_unit_response_id' => $response->id,
            'customer_document' => $unit['customerDocument'] ?? null,
            'customer_id' => $unit['customerId'] ?? null,
            'operation_type' => $unit['operationType'] ?? null,
            'participant_document_id' => $unit['participantDocumentId'] ?? null,
            'payment_scheme' => $unit['paymentScheme'] ?? null,
            'pre_contracted_amount' => $unit['preContractedAmount'] ?? null,
            'settlement_date' => Carbon::parse($unit['settlementDate']),
            'total_amount' => $unit['totalAmount'] ?? null,
            'status' => $status
        ]);
    }

    protected function createReceivableScheduleReceivingFinalUser(array $receiverFinalUserInfo, ?ReceivableSchedule $receivableSchedule): ReceivableScheduleReceivingFinalUser
    {
        return ReceivableScheduleReceivingFinalUser::create([
            'final_user_document' => $receiverFinalUserInfo['finalUserDocument'] ?? null,
            'final_user_free_value' => $receiverFinalUserInfo['finalUserFreeValue'] ?? null,
            'receivable_schedule_id' => $receivableSchedule?->id,
        ]);
    }

    protected function createReceivableScheduleHolder(array $receivableScheduleHolderInfo, ?ReceivableSchedule $receivableSchedule): ReceivableScheduleHolder
    {
        return ReceivableScheduleHolder::create([
            'holder_document' => $receivableScheduleHolderInfo['holderDocument'],
            'receivable_schedule_id' => $receivableSchedule?->id,
        ]);
    }

    protected function createHolderReceivableUnit(
        array $holderReceivableUnitInfo,
        ?ReceivableScheduleHolder $receivableScheduleHolder
    ): HolderReceivableUnit {
        return HolderReceivableUnit::create([
            'expected_settlement_date' => isset($holderReceivableUnitInfo['expectedSettlementDate'])
                ? Carbon::parse($holderReceivableUnitInfo['expectedSettlementDate'])->format('Y-m-d H:i:s')
                : null,
            'total_amount' => $holderReceivableUnitInfo['totalAmount'] ?? null,
            'amount_comprimised_in_other_institutions' => $holderReceivableUnitInfo['amountComprimisedInOtherInstitutions'] ?? null,
            'amount_comprimised_on_institution' => $holderReceivableUnitInfo['amountComprimisedOnInstitution'] ?? null,
            'total_avalable_amount' => $holderReceivableUnitInfo['totalAvalableAmount'] ?? null,
            'participant_anticipation_available_amount' => $holderReceivableUnitInfo['participantAnticipationAvailableAmount'] ?? null,
            'pre_contracted_amount' => $holderReceivableUnitInfo['preContractedAmount'] ?? null,
            'technical_reserve_charge_amount' => $holderReceivableUnitInfo['technicalReserveChargeAmount'] ?? null,
            'receivable_schedule_holder_id' => $receivableScheduleHolder?->id,
        ]);
    }

    protected function createReceivableUnitDomicile(
        array $domicileInfo,
        ?HolderReceivableUnit $holderReceivableUnit = null,
        ?ReceivableUnitFinalUserHolder $holder = null
    ): ReceivableUnitDomicile {
        return ReceivableUnitDomicile::create([
            'bank_account_owner_document' => $domicileInfo['bankAccountOwnerDocument'],
            'account_type' => $domicileInfo['accountType'],
            'bank_branch' => $domicileInfo['bankBranch'],
            'account_number' => $domicileInfo['accountNumber'],
            'payment_account_number' => $domicileInfo['paymentAccountNumber'] ?? null,
            'effective_liquidation_date' => $domicileInfo['effectiveLiquidationDate'] ?? null,
            'effective_liquidation_amount' => $domicileInfo['effectiveLiquidationAmount'] ?? null,
            'available_amount' => $domicileInfo['availableAmount'] ?? null,
            'holder_receivable_unit_id' => $holderReceivableUnit?->id,
            'receivable_unit_final_user_holder_id' => $holder?->id,
        ]);
    }

    protected function createReceivableUnitOtherInstitution(
        array $otherInstitutionOperationInfo,
        ?HolderReceivableUnit $holderReceivableUnit = null,
        ?ReceivableUnitFinalUserHolder $holder = null
    ): ReceivableUnitOtherInstitution {
        return ReceivableUnitOtherInstitution::create([
            'division_rule_indicator' => $otherInstitutionOperationInfo['divisionRuleIndicator'] ?? null,
            'negociated_amount' => $otherInstitutionOperationInfo['negociatedAmount'] ?? null,
            'creditor_amount_to_constitute' => $otherInstitutionOperationInfo['creditorAmountToConstitute'] ?? null,
            'operation_ending_date' => $otherInstitutionOperationInfo['operationEndingDate'] ?? null,
            'receivable_unit_priority' => $otherInstitutionOperationInfo['receivableUnitPriority'] ?? null,
            'receivable_unit_final_user_holder_id' => $holder?->id,
            'holder_receivable_unit_id' => $holderReceivableUnit?->id,
        ]);
    }

    protected function createPayment(array $payment, ReceivableUnit $receivableUnit)
    {
        return $receivableUnit->payments()->create([
            'operation_id' => $payment['operationId'] ?? null,
            'settled_amount' => $payment['settledAmount'] ?? null,
            'settlement_amount' => $payment['settlementAmount'] ?? null,
            'settlement_date' => isset($payment['settlementDate']) ? Carbon::parse($payment['settlementDate']) : null,
        ]);
    }

    protected function createPaymentInformation(array $paymentInformation, $paymentEntry)
    {
        $paymentEntry->paymentInformation()->create([
            'account_number' => $paymentInformation['accountNumber'] ?? null,
            'account_type' => $paymentInformation['accountType'] ?? null,
            'bank_branch' => $paymentInformation['bankBranch'] ?? null,
            'code_compe' => $paymentInformation['codeCompe'] ?? null,
            'code_ispb' => $paymentInformation['codeIspb'] ?? null,
            'customer_document' => $paymentInformation['customerDocument'] ?? null,
        ]);
    }

    protected function createError(array $error, ReceivableUnit $receivableUnit): Error
    {
        return  Error::create([
            'receivable_unit_id' => $receivableUnit->id,
            'error_code' => $error['code'],
            'field' => $error['field'],
            'value' => $error['value'],
        ]);
    }

    public function createOptInNotification(array $data): OptInNotification
    {
        return OptInNotification::create([
            'opt_in_protocol' => $data['optInProtocol'] ?? null,
            'recipient_document' => $data['recipientDocument'] ?? null,
            'participant_document_id' => $data['participantDocumentId'] ?? null,
            'financier_document' => $data['financierDocument'] ?? null,
            'payment_scheme' => $data['paymentScheme'] ?? null,
            'opt_in_signature_date' => $data['optInSignatureDate'] ?? null,
            'opt_in_starting_date' => $data['optInStartingDate'] ?? null,
            'opt_in_ending_date' => $data['optInEndingDate'] ?? null,
            'domicile_indicator' => $data['domicileIndicator'] ?? null,
            'trade_repository_document' => $data['tradeRepositoryDocument'] ?? null,
            'opt_in_receiver_document' => $data['optInReceiverDocument'] ?? null,
            'created_date' => isset($data['createdDate']) ? Carbon::parse($data['createdDate']) : null,
            'managed_participant_id' => $data['managedParticipantId'] ?? null,
        ]);
    }

    public function createOptOutResponse(array $data): OptOutResponse
    {
        return  OptOutResponse::create([
            'request_protocol' => $data['requestProtocol'] ?? null,
            'opt_out_protocol' => $data['optOutProtocol'] ?? null,
            'processing_date' => isset($data['processingDate']) ? Carbon::parse($data['processingDate']) : null,
            'opt_in_protocol' => $data['optInProtocol'] ?? null,
        ]);
    }

    public function createTimetable(array $data): Timetable
    {
        return   Timetable::create([
            'date' => isset($data['date']) ? Carbon::parse($data['date'])->format('Y-m-d') : null,
            'opening_date' => isset($data['openingDate']) ? Carbon::parse($data['openingDate']) : null,
            'closing_date' => isset($data['closingDate']) ? Carbon::parse($data['closingDate']) : null,
            'trade_repository_opening_date' => isset($data['tradeRepositoryOpeningDate']) ? Carbon::parse($data['tradeRepositoryOpeningDate']) : null,
            'trade_repository_closing_date' => isset($data['tradeRepositoryClosingDate']) ? Carbon::parse($data['tradeRepositoryClosingDate']) : null,
        ]);
    }

    public function createOperationNotification(array $data): OperationNotification
    {
        return  OperationNotification::create([
            'operation_id' => $data['operationId'] ?? null,
            'operation_href' => $data['operationHref'] ?? null,
            'created_date' => isset($data['createdDate']) ? Carbon::parse($data['createdDate']) : null,
            'update_date' => isset($data['updateDate']) ? Carbon::parse($data['updateDate']) : null,
            'managed_participant_id' => $data['managedParticipantId'] ?? null,
        ]);
    }

    public function createOperationCancelNotification(array $data): OperationCancelNotification
    {
        return  OperationCancelNotification::create([
            'trade_repository_document' => $data['tradeRepositoryDocument'] ?? null,
            'negotiating_participant_document' => $data['negociatingParticipantDocument'] ?? null,
            'receivable_negotiation_id' => $data['receivableNegociationId'] ?? null,
            'operation_id' => $data['operationId'] ?? null,
            'receivable_owner_document' => $data['receivableOwnerDocument'] ?? null,
            'total_value_cancel_operation_indicator' => $data['totalValueCancelOperationIndicator'] ?? null,
            'operation_cancel_id' => $data['operationCancelId'] ?? null,
            'lien_to_constitute_cancel_indicator' => $data['lienToConstituteCancelIndicator'] ?? null,
            'created_date' => isset($data['createdDate']) ? Carbon::parse($data['createdDate']) : null,
        ]);
    }

    protected function createOperationResponse(array $data): OperationResponse
    {
        return  OperationResponse::create([
            'receivable_negotiation_id' => $data['receivableNegociationId'] ?? null,
            'operation_id' => $data['operationId'] ?? null,
            'status' => $data['status'] ?? null,
            'operation_href' => $data['operationHref'] ?? null,
            'date_time' => isset($data['dateTime']) ? Carbon::parse($data['dateTime']) : null,
            'managed_participant_id' => $data['managedParticipantId'] ?? null,
        ]);
    }

    public function createCancelOperationResponse(array $data): CancelOperationResponse
    {
        return  CancelOperationResponse::create([
            'request_result' => $data['requestResult'] ?? null,
            'receivable_unit_identifier' => $data['receivableUnitIdentifier'] ?? null,
            'operation_identifier' => $data['operationIdentifier'] ?? null,
            'operation_cancel_protocol_identifier' => $data['operationCancelProtocolIdentifier'] ?? null,
            'date_time' => isset($data['dateTime']) ? Carbon::parse($data['dateTime']) : null,
            'managed_participant_id' => $data['managedParticipantId'] ?? null,
        ]);
    }

    public function createMerchantResponse(array $data): MerchantResponse
    {
        return MerchantResponse::create([
            'main_participant_id' => $data['mainParticipantId'] ?? null,
            'managed_participant_id' => $data['managedParticipantId'] ?? null,
            'response_situation' => $data['responseSituation'] ?? null,
            'error_code' => $data['errorCode'] ?? null,
            'file_date' => $data['fileDate'] ?? null,
            'file_name' => $data['fileName'] ?? null,
            'issuer_control_number' => $data['issuerControlNumber'] ?? null,
            'issuer_ispb' => $data['issuerIspb'] ?? null,
            'recipient_control_number' => $data['recipientControlNumber'] ?? null,
            'recipient_ispb' => $data['recipientIspb'] ?? null,
            'reference_date' => $data['referenceDate'] ?? null,
        ]);
    }
}
