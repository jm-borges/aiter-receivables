<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receivable extends Model
{
    /** @use HasFactory<\Database\Factories\ReceivableFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'client_id',
        'acquirer_id',
        'contract_id',
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
            // Add your casts here
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

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
}
