<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReceivableSchedule extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\ReceivableScheduleFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'source_file_name',
        'payment_scheme_code',
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

    public function receiverFinalUsers(): HasMany
    {
        return $this->hasMany(ReceivableScheduleReceivingFinalUser::class);
    }

    public function receivableScheduleHolders(): HasMany
    {
        return $this->hasMany(ReceivableScheduleHolder::class);
    }
}
