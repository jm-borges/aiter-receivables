<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Receivable extends Model
{
    /** @use HasFactory<\Database\Factories\ReceivableFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'opt_in_id',
        'client_id',
        'acquirer_id',
        'payment_arrangement_id',
        'tpObj',
        'cnpjER',
        'cnpjCreddrSub',
        'codInstitdrArrajPgto',
        'cnpjOuCnpjBaseOuCpfUsuFinalRecbdr',
        'vlrLivreUsuFinalRecbdr',
        'dtPrevtLiquid',
        'vlrTot',
        'indrDomcl',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'dtPrevtLiquid' => 'date',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(BusinessPartner::class, 'client_id');
    }

    public function acquirer(): BelongsTo
    {
        return $this->belongsTo(BusinessPartner::class, 'acquirer_id');
    }

    public function paymentArrangement(): BelongsTo
    {
        return $this->belongsTo(PaymentArrangement::class);
    }

    public function contracts(): BelongsToMany
    {
        return $this->belongsToMany(Contract::class, 'contract_has_receivables')
            ->withPivot(['amount']);
    }

    public function optIn(): BelongsTo
    {
        return $this->belongsTo(OptIn::class);
    }
}
