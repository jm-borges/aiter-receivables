<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReceivableUnitDomicileOperation extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\ReceivableUnitDomicileOperationFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'operation_id',
        'receivable_unit_priority',
        'trade_repository_document',
        'negociated_value',
        'creditor_amount_to_constitute',
        'division_rule_indicator',
        'operation_ending_date',
        'receivable_unit_domicile_id',
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

    public function receivableUnitDomicile(): BelongsTo
    {
        return $this->belongsTo(ReceivableUnitDomicile::class);
    }
}
