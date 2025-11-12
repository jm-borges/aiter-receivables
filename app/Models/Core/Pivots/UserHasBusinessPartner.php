<?php

namespace App\Models\Core\Pivots;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserHasBusinessPartner extends Pivot
{
    /** @use HasFactory<\Database\Factories\UserHasBusinessPartnerFactory> */
    use HasFactory, HasUuids;

    protected $table = 'user_has_business_partners';

    protected $fillable = [
        'user_id',
        'business_partner_id',
        'opt_in_start_date',
        'opt_in_end_date',
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
