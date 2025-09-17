<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OperationResponse extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\OperationResponseFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'receivable_negotiation_id',
        'operation_id',
        'status',
        'operation_href',
        'date_time',
        'managed_participant_id',
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

    public function cipMessages(): HasMany
    {
        return $this->hasMany(CipMessage::class);
    }
}
