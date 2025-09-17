<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentInformation extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\PaymentInformationFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'payment_id',
        'account_number',
        'account_type',
        'bank_branch',
        'code_compe',
        'code_ispb',
        'customer_document',
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

    /**
     * Relacionamento com o modelo Payment
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
}
