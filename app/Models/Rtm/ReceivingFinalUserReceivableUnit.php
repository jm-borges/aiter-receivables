<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReceivingFinalUserReceivableUnit extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\ReceivingFinalUserReceivableUnitFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'expected_settlement_date',
        'total_value',
        'domicile_indicator',
        'receivable_schedule_receiving_final_user_id',
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

    public function receivableScheduleReceivingFinalUser(): BelongsTo
    {
        return $this->belongsTo(ReceivableScheduleReceivingFinalUser::class);
    }

    public function holders(): HasMany
    {
        return $this->hasMany(ReceivableUnitFinalUserHolder::class);
    }
}
