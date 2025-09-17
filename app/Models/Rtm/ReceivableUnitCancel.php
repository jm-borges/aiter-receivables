<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReceivableUnitCancel extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\ReceivableUnitCancelFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'sub_or_acquirer_document',
        'recipient_document',
        'payment_scheme',
        'settlement_date',
        'trader_document',
        'negociated_value_canceled',
        'value_or_percent_to_constitute_canceled',
        'operation_cancel_notification_id',
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

    public function operationCancelNotification(): BelongsTo
    {
        return $this->belongsTo(OperationCancelNotification::class);
    }
}
