<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReceivableUnitFinalUser extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\ReceivableUnitFinalUserFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'object_type',
        'trade_repository_document',
        'participant_document_id',
        'payment_scheme',
        'bank_account_owner_document',
        'recipient_document',
        'recipient_available_amount',
        'settlement_date',
        'bank_account_owner_total_amount',
        'amount_comprimised_in_other_institutions',
        'amount_comprimised_on_institution',
        'total_avalable_amount',
        'participant_available_amount',
        'pre_contracted_amount',
        'technical_reserve_charge_amount',
        'total_amount',
        'domicile_indicator',
        'managed_participant_id',
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

    public function holders(): HasMany
    {
        return $this->hasMany(ReceivableUnitFinalUserHolder::class);
    }
}
