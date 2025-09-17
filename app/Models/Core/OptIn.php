<?php

namespace App\Models\Core;

use App\Enums\OptInStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
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
            'type' => OptInStatus::class,
        ];
    }

    public function optOut(): HasOne
    {
        return $this->hasOne(OptOut::class);
    }
}
