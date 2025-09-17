<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReceivableUnitDomicile extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\ReceivableUnitDomicileFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'bank_account_owner_document',
        'account_type',
        'bank_branch',
        'account_number',
        'payment_account_number',
        'effective_liquidation_date',
        'effective_liquidation_amount',
        'available_amount',
        'holder_receivable_unit_id',
        'receivable_unit_final_user_id',
        'receivable_unit_final_user_holder_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // Add your casts here
        ];
    }

    public function holderReceivableUnit(): BelongsTo
    {
        return $this->belongsTo(HolderReceivableUnit::class);
    }

    public function receivableUnitFinalUser(): BelongsTo
    {
        return $this->belongsTo(ReceivableUnitFinalUser::class);
    }

    public function receivableUnitFinalUserHolder(): BelongsTo
    {
        return $this->belongsTo(ReceivableUnitFinalUserHolder::class);
    }

    public function operations(): HasMany
    {
        return $this->hasMany(ReceivableUnitDomicileOperation::class);
    }
}
