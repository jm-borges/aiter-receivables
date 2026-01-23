<?php

namespace App\Models\Core;

use App\Enums\ReceivableStatus;
use App\Models\Core\Pivots\OperationHasReceivable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Receivable extends Model
{
    /** @use HasFactory<\Database\Factories\ReceivableFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'status',
        //
        'client_id',
        'acquirer_id',
        'payment_arrangement_id',
        'tpObj',
        'cnpjER',
        'cnpjCreddrSub',
        'codInstitdrArrajPgto',
        'cnpjOuCnpjBaseOuCpfUsuFinalRecbdr',
        'dtPrevtLiquid',
        'indrDomcl',
        //
        'vlrLivreUsuFinalRecbdr',
        'vlrTot',
        //---
        'available_value',
        'amount_locked_by_others',

        'is_to_be_constituted',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ReceivableStatus::class,
            'dtPrevtLiquid' => 'date',
            'is_to_be_constituted' => 'boolean',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(BusinessPartner::class, 'client_id');
    }

    public function acquirer(): BelongsTo
    {
        return $this->belongsTo(BusinessPartner::class, 'acquirer_id');
    }

    public function paymentArrangement(): BelongsTo
    {
        return $this->belongsTo(PaymentArrangement::class);
    }

    public function operations(): BelongsToMany
    {
        return $this->belongsToMany(Operation::class, 'operation_has_receivables')
            ->using(OperationHasReceivable::class)
            ->withPivot(['amount']);
    }

    public function wasSettled(): bool
    {
        return $this->status === ReceivableStatus::SETTLED;
    }
}
