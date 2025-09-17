<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Participant extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\ParticipantFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'document',
        'document_type',
        'domicile_indicator',
        'email',
        'homologation_entry_date',
        'is_active',
        'name',
        'participant_type',
        'production_entry_date',
        'telephone',
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
}
