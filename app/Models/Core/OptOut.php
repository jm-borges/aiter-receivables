<?php

namespace App\Models\Core;

use App\Enums\OptOutStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OptOut extends Model
{
    /** @use HasFactory<\Database\Factories\OptOutFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'opt_in_id',
        'status',
        'identd_ctrl_opt_in',
        'identdCtrlReqSolicte',
        'identdCtrlOptOut',

    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => OptOutStatus::class,
        ];
    }

    public function optIn(): BelongsTo
    {
        return $this->belongsTo(OptIn::class);
    }
}
