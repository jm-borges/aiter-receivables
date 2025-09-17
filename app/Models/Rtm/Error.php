<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Error extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\ErrorFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'error_code',
        'field',
        'value',
        'receivable_unit_id',
        'merchant_id',
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

    /**
     * Relacionamento com a Unidade de Recebível
     */
    public function receivableUnit(): BelongsTo
    {
        return $this->belongsTo(ReceivableUnit::class);
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }
}
