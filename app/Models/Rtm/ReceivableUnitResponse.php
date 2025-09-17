<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ReceivableUnitResponse extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\ReceivableUnitResponseFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'main_participant_id',
        'managed_participant_id',
        'response_situation',
        'error_code',
        'file_date',
        'file_name',
        'issuer_control_number',
        'issuer_ispb',
        'recipient_control_number',
        'recipient_ispb',
        'reference_date',
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


    public function receivableUnitsApproved()
    {
        return $this->hasMany(ReceivableUnit::class)->where('status', 'approved');
    }

    public function receivableUnitsRefused()
    {
        return $this->hasMany(ReceivableUnit::class)->where('status', 'refused');
    }
}
