<?php

namespace App\Models\Core\Pivots;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ContractHasReceivable extends Pivot
{
    /** @use HasFactory<\Database\Factories\ContractHasReceivableFactory> */
    use HasFactory, HasUuids;

    protected $table = 'contract_has_receivables';

    protected $fillable = [
        'contract_id',
        'receivable_id',
        'amount',
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
