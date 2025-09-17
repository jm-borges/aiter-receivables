<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MerchantResponse extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\MerchantResponseFactory> */
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
        return [
            // Add your casts here
        ];
    }

    public function approvedMerchants(): HasMany
    {
        return $this->hasMany(Merchant::class, 'merchant_response_id')
            ->where('status', 'approved');
    }

    public function rejectedMerchants(): HasMany
    {
        return $this->hasMany(Merchant::class, 'merchant_response_id')
            ->where('status', 'rejected');
    }
}
