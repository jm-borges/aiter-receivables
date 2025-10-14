<?php

namespace App\Models\Core\Pivots;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;

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

    protected static function booted()
    {
        static::creating(function ($pivot) {
            if (!$pivot->id) {
                $pivot->id = Str::uuid()->toString();
            }
        });
    }
}
