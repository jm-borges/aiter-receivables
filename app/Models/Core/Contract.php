<?php

namespace App\Models\Core;

use App\Models\Core\Pivots\ContractHasAcquirer;
use App\Models\Core\Pivots\ContractHasPaymentArrangement;
use App\Models\Core\Pivots\ContractHasReceivable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contract extends Model
{
    /** @use HasFactory<\Database\Factories\ContractFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'client_id',
        'supplier_id',
        'value',
        'start_date',
        'end_date',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(BusinessPartner::class, 'client_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(BusinessPartner::class, 'supplier_id');
    }

    public function acquirers(): BelongsToMany
    {
        return $this->belongsToMany(BusinessPartner::class, 'contract_has_acquirers')
            ->using(ContractHasAcquirer::class);
    }

    public function paymentArrangements(): BelongsToMany
    {
        return $this->belongsToMany(PaymentArrangement::class, 'contract_has_payment_arrangements')
            ->using(ContractHasPaymentArrangement::class);
    }

    public function receivables(): BelongsToMany
    {
        return $this->belongsToMany(Receivable::class, 'contract_has_receivables')
            ->using(ContractHasReceivable::class)
            ->withPivot(['amount']);
    }
}
