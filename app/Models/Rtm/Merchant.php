<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Merchant extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\MerchantFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'operation_type',
        'customer_document_type',
        'customer_document',
        'legal_name',
        'social_name',
        'address',
        'zip_code',
        'city',
        'state',
        'status',
        'merchant_response_id',
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

    public function errors(): HasMany
    {
        return $this->hasMany(Error::class);
    }
}
