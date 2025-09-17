<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OperationCancelNotification extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\OperationCancelNotificationFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'trade_repository_document',
        'negotiating_participant_document',
        'receivable_negotiation_id',
        'operation_id',
        'receivable_owner_document',
        'total_value_cancel_operation_indicator',
        'operation_cancel_id',
        'lien_to_constitute_cancel_indicator',
        'created_date',
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

    public function receivableUnits(): HasMany
    {
        return $this->hasMany(ReceivableUnitCancel::class);
    }
}
