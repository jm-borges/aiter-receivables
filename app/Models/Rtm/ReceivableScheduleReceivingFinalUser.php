<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReceivableScheduleReceivingFinalUser extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\ReceivableScheduleReceivingFinalUserFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'final_user_document',
        'final_user_free_value',
        'receivable_schedule_id',
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

    public function receivableSchedule(): BelongsTo
    {
        return $this->belongsTo(ReceivableSchedule::class);
    }

    public function receivingFinalUserReceivableUnits(): HasMany
    {
        return $this->hasMany(ReceivingFinalUserReceivableUnit::class);
    }
}
