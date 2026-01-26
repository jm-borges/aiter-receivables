<?php

namespace App\DataTransferObjects;

class ContractOperationData
{
    public function __construct(
        public readonly string $documentNumber,
        public readonly float  $warrantedValue,
        public readonly string $negotiationType,
        public readonly string $type,
        public readonly string $installmentsType,
        public readonly ?int   $singleInstallmentDays,
        public readonly ?float $singleInstallmentInterest,
        public readonly ?int   $multipleInstallmentsDays,
        public readonly ?int   $installmentsAmount,
        public readonly ?array $installmentInterest,
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            documentNumber: $request->document_number,
            warrantedValue: (float) $request->warranted_value,
            type: $request->type,
            negotiationType: $request->negotiation_type,
            installmentsType: $request->installments_type,
            singleInstallmentDays: $request->single_installment_days,
            singleInstallmentInterest: $request->single_installment_interest,
            multipleInstallmentsDays: $request->multiple_installments_days,
            installmentsAmount: $request->installments_amount,
            installmentInterest: $request->installment_interest,
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            documentNumber: $data['documentNumber'],
            warrantedValue: (float) $data['warrantedValue'],
            type: $data['type'],
            negotiationType: $data['negotiationType'],
            installmentsType: $data['installmentsType'],
            singleInstallmentDays: $data['singleInstallmentDays'] ?? null,
            singleInstallmentInterest: $data['singleInstallmentInterest'] ?? null,
            multipleInstallmentsDays: $data['multipleInstallmentsDays'] ?? null,
            installmentsAmount: $data['installmentsAmount'] ?? null,
            installmentInterest: $data['installmentInterest'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'documentNumber'             => $this->documentNumber,
            'warrantedValue'             => $this->warrantedValue,
            'type'                       => $this->type,
            'negotiationType'            => $this->negotiationType,
            'installmentsType'           => $this->installmentsType,
            'singleInstallmentDays'      => $this->singleInstallmentDays,
            'singleInstallmentInterest'  => $this->singleInstallmentInterest,
            'multipleInstallmentsDays'   => $this->multipleInstallmentsDays,
            'installmentsAmount'         => $this->installmentsAmount,
            'installmentInterest'        => $this->installmentInterest,
        ];
    }
}
