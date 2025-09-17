<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CipMessage extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\CipMessageFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'code',
        'content',
        'field',
        'message',
        'cancel_operation_response_id',
        'operation_response_id',
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

    public function cancelOperationResponse(): BelongsTo
    {
        return $this->belongsTo(CancelOperationResponse::class);
    }

    public function operationResponse(): BelongsTo
    {
        return $this->belongsTo(OperationResponse::class);
    }
}
