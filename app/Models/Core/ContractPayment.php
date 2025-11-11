<?php

namespace App\Models\Core;

use App\Enums\ContractPaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractPayment extends Model
{
    /** @use HasFactory<\Database\Factories\ContractPaymentFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'contract_id',
        'status',
        'amount',
        'payment_date',
        'due_date',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ContractPaymentStatus::class,
            'due_date' => 'date',
        ];
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function isPaid(): bool
    {
        return $this->status === ContractPaymentStatus::PAID;
    }

    public function isOverdue(): bool
    {
        return $this->isPending() && $this->due_date->isPast();
    }

    public function isPending(): bool
    {
        return $this->status === ContractPaymentStatus::PENDING;
    }
}
