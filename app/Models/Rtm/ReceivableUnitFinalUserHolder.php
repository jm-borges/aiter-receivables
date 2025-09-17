<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReceivableUnitFinalUserHolder extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\ReceivableUnitFinalUserHolderFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'bank_account_owner_document',
        'bank_account_owner_total_amount',
        'amount_comprimised_in_other_institutions',
        'amount_comprimised_on_institution',
        'total_avalable_amount',
        'participant_available_amount',
        'pre_contracted_amount',
        'technical_reserve_charge_amount',
        'receivable_unit_final_user_id',
        'receiving_final_user_receivable_unit_id',
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

    public function receivableUnitFinalUser(): BelongsTo
    {
        return $this->belongsTo(ReceivableUnitFinalUser::class);
    }

    public function receivingFinalUserReceivableUnit(): BelongsTo
    {
        return $this->belongsTo(ReceivingFinalUserReceivableUnit::class);
    }

    public function domiciles(): HasMany
    {
        return $this->hasMany(ReceivableUnitDomicile::class);
    }

    public function otherInstitutionOperations(): HasMany
    {
        return $this->hasMany(ReceivableUnitOtherInstitution::class);
    }
}
