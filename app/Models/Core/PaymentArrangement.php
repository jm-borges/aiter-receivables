<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PaymentArrangement extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentArrangementFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'name',
        'code',
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

    public static function findByCode(string $code): ?self
    {
        return self::where('code', $code)->first();
    }
}
