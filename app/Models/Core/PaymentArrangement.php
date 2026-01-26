<?php

namespace App\Models\Core;

use App\Enums\PaymentArrangementType;
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
        'type',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => PaymentArrangementType::class,
        ];
    }

    public static function findByCode(string $code): ?self
    {
        return self::where('code', $code)->first();
    }
}
