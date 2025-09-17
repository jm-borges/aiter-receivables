<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReceivableUnitOtherInstitution extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\ReceivableUnitOtherInstitutionFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'division_rule_indicator',
        'negociated_amount',
        'creditor_amount_to_constitute',
        'operation_ending_date',
        'receivable_unit_priority',
        'receivable_unit_final_user_holder_id',
        'holder_receivable_unit_id',
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

    public function receivableUnitFinalUserHolder(): BelongsTo
    {
        return $this->belongsTo(ReceivableUnitFinalUserHolder::class);
    }

    public function holderReceivableUnit(): BelongsTo
    {
        return $this->belongsTo(HolderReceivableUnit::class);
    }
}
