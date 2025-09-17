<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OperationSummary extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\OperationSummaryFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'main_participant_id',
        'managed_participant_id',
        'cip_file_date',
        'cip_file_name',
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

    public function operationSummaryControls(): HasMany
    {
        return $this->hasMany(OperationSummaryControl::class);
    }
}
