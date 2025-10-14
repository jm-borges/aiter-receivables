<?php

namespace App\Models\Core;

use App\Enums\ActionInvolvedPartyType;
use App\Enums\ActionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Action extends Model
{
    /** @use HasFactory<\Database\Factories\ActionFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'class_name',
        'description',
        'sender',
        'recipient',
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
            'sender' => ActionInvolvedPartyType::class,
            'recipient' => ActionInvolvedPartyType::class,
            'type' => ActionType::class,
        ];
    }

    public static function getByName(string $name): ?self
    {
        return self::where('name', $name)->first();
    }

    public function operations(): HasMany
    {
        return $this->hasMany(Operation::class);
    }
}
