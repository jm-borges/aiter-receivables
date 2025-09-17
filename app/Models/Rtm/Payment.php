<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\PaymentFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'receivable_unit_id',
        'operation_id',
        'settled_amount',
        'settlement_amount',
        'settlement_date',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [];
    }

    /**
     * Relacionamento com ReceivableUnit
     */
    public function receivableUnit(): BelongsTo
    {
        return $this->belongsTo(ReceivableUnit::class);
    }

    /**
     * Relacionamento com PaymentInformation
     */
    public function paymentInformation(): HasOne
    {
        return $this->hasOne(PaymentInformation::class);
    }
}
