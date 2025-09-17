<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CancelOperationResponse extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\CancelOperationResponseFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'request_result',
        'receivable_unit_identifier',
        'operation_identifier',
        'operation_cancel_protocol_identifier',
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
