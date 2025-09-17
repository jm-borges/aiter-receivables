<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class OperationNotification extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\OperationNotificationFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'operation_id',
        'operation_href',
        'created_date',
        'update_date',
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
}
