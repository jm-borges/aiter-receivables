<?php

namespace App\Models\Core\Pivots;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ContractHasPaymentArrangement extends Model
{
    /** @use HasFactory<\Database\Factories\ContractHasPaymentArrangementFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'contract_id',
        'payment_arrangement_id',
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
