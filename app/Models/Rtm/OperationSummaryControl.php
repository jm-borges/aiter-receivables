<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OperationSummaryControl extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\OperationSummaryControlFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'operation_summary_id',
        'file_date',
        'file_name_received',
        'file_name_sent',
        'participant_negociation_protocol',
        'request_protocol',
        'trade_repository_deconstruction_protocol',
        'trade_repository_negociation_cancell_protocol',
        'trade_repository_operation_protocol',
        'trade_repository_opt_in_protocol',
        'trade_repository_opt_out_protocol',
        'trade_repository_original_operation_protocol',
        'trade_repository_plea_protocol',
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

    public function operationSummary(): BelongsTo
    {
        return $this->belongsTo(OperationSummary::class);
    }
}
