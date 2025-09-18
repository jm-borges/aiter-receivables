<?php

namespace App\Models\Core\Pivots;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ContractHasAcquirer extends Pivot
{
    /** @use HasFactory<\Database\Factories\ContractHasAcquirerFactory> */
    use HasFactory, HasUuids;

    protected $table = 'contract_has_acquirers';

    protected $fillable = [
        'contract_id',
        'business_partner_id',
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
