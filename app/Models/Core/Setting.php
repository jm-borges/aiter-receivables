<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Setting extends Model
{
    /** @use HasFactory<\Database\Factories\SettingFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'auto_operate_mode_is_enabled',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'auto_operate_mode_is_enabled' => 'boolean',
        ];
    }

    public function shouldAutomaticallyOperateContracts(): bool
    {
        return $this->auto_operate_mode_is_enabled ?? false;
    }
}
