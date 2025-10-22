<?php

namespace App\Models\Core\Pivots;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class OperationHasReceivable extends Model
{
    /** @use HasFactory<\Database\Factories\OperationHasReceivableFactory> */
    use HasFactory, HasUuids, HasUuid;


    protected $fillable = [
        'operation_id',
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
