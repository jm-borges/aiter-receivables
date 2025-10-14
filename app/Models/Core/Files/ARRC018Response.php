<?php

namespace App\Models\Core\Files;

use App\Models\Core\PaymentArrangement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ARRC018Response extends Model
{
    /** @use HasFactory<\Database\Factories\ARRC018ResponseFactory> */
    use HasFactory, HasUuids;

    protected $table = 'arrc018_responses';

    protected $fillable = [
        'payment_arrangement_id', //string
        'source_file_name', //string
        'participant_document', //string
        'managed_participant_id', //string
        'trade_repository_document', //string
        'payment_scheme_code', //string
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

    public function paymentArrangement(): BelongsTo
    {
        return $this->belongsTo(PaymentArrangement::class);
    }
}
