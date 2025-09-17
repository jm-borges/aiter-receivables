<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class OptInNotification extends Model
{
    /** @use HasFactory<\Database\Factories\OptInNotificationFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'opt_in_protocol',
        'recipient_document',
        'participant_document_id',
        'financier_document',
        'payment_scheme',
        'opt_in_signature_date',
        'opt_in_starting_date',
        'opt_in_ending_date',
        'domicile_indicator',
        'trade_repository_document',
        'opt_in_receiver_document',
        'created_date',
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
