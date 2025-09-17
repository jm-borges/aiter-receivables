<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReceivableUnit extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\ReceivableUnitFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'receivable_unit_response_id',
        'customer_document',
        'customer_id',
        'operation_type',
        'participant_document_id',
        'payment_scheme',
        'pre_contracted_amount',
        'settlement_date',
        'total_amount',
        'status',
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
     * Relacionamento com ReceivableUnitResponse
     */
    public function response(): BelongsTo
    {
        return $this->belongsTo(ReceivableUnitResponse::class);
    }

    /**
     * Relacionamento com Payments
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Relacionamento com Errors
     */
    public function errors(): HasMany
    {
        return $this->hasMany(Error::class);
    }
}
