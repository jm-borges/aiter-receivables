<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HolderReceivableUnit extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\HolderReceivableUnitFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'expected_settlement_date',
        'total_amount',
        'amount_comprimised_in_other_institutions',
        'amount_comprimised_on_institution',
        'total_avalable_amount',
        'participant_anticipation_available_amount',
        'pre_contracted_amount',
        'technical_reserve_charge_amount',
        'receivable_schedule_holder_id',
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

    public function receivableScheduleHolder(): BelongsTo
    {
        return $this->belongsTo(ReceivableScheduleHolder::class);
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
