<?php

namespace App\Services;

use App\DataTransferObjects\ContractOperationData;
use App\Enums\ContractStatus;
use App\Models\Core\Contract;
use App\Models\Core\ContractPayment;
use Carbon\Carbon;

class PaymentGenerateService
{
    public function generateInstallments(ContractOperationData $data, Contract $contract): void
    {
        $data->installmentsType === 'multiple'
            ? $this->generateMultipleInstallments($data, $contract)
            : $this->generateSingleInstallment($data, $contract);
    }

    private function generateSingleInstallment(ContractOperationData $data, Contract $contract): void
    {
        $amount = $this->calculateAmount($data->warrantedValue, $data->singleInstallmentInterest);
        $dueDate = $this->dueDateInDays($data->singleInstallmentDays);

        $this->storePayment($contract, $amount, $dueDate);
    }

    private function generateMultipleInstallments(ContractOperationData $data, Contract $contract): void
    {
        $base = $data->warrantedValue / $data->installmentsAmount;

        for ($i = 1; $i <= $data->installmentsAmount; $i++) {
            $interest = $data->installment_interest[$i] ?? 0;
            $amount = $this->calculateAmount($base, $interest);
            $dueDate = $this->dueDateInDays($i * $data->multipleInstallmentsDays);

            $this->storePayment($contract, $amount, $dueDate);
        }
    }


    private function storePayment(Contract $contract, float $amount, Carbon $dueDate): void
    {
        ContractPayment::create([
            'contract_id' => $contract->id,
            'status' => ContractStatus::ACTIVE,
            'amount' => $amount,
            'due_date' => $dueDate,
        ]);
    }

    private function calculateAmount(float $base, float $interestPercent): float
    {
        return $base * (1 + ($interestPercent / 100));
    }

    private function dueDateInDays(int $days): Carbon
    {
        return now()->addDays($days);
    }
}
