<?php

namespace App\Models\Core;

use App\Enums\OptInStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OptIn extends Model
{
    /** @use HasFactory<\Database\Factories\OptInFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'contract_id',
        // ARRANJO DE PAGAMENTO
        'codInstitdrArrajPgto',
        'payment_arrangement_id',
        // ADQUIRENTE
        'cnpjCreddrSub',
        'acquirer_id',
        // CLIENT
        'cnpjOuCnpjBaseOuCpfUsuFinalRecbdrOuTitlar',
        'client_id',
        //
        'status',
        'identdCtrlReqSolicte',
        'cnpj_financiadora',
        //
        'identdCtrlOptIn',
        'indrDomcl',
        'dtOptIn',
        'dtIniOptIn',
        'dtFimOptIn',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => OptInStatus::class,
            'dtOptIn' => 'date',
            'dtIniOptIn' => 'date',
            'dtFimOptIn' => 'date',
        ];
    }

    public function optOut(): HasOne
    {
        return $this->hasOne(OptOut::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(BusinessPartner::class, 'client_id');
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function acquirer(): BelongsTo
    {
        return $this->belongsTo(BusinessPartner::class, 'acquirer_id');
    }

    public function paymentArrangement(): BelongsTo
    {
        return $this->belongsTo(PaymentArrangement::class);
    }

    public function receivables(): HasMany
    {
        return $this->hasMany(Receivable::class);
    }
}
