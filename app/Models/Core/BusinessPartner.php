<?php

namespace App\Models\Core;

use App\Enums\BusinessPartnerType;
use App\Models\Core\Pivots\UserHasBusinessPartner;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class BusinessPartner extends Model
{
    /** @use HasFactory<\Database\Factories\BusinessPartnerFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'fantasy_name',
        'description',
        'type',
        'document_number',
        'base_document_number',
        'state_subscription',
        'city_subscription',
        'email', //string
        'phone', //string

        'postal_code', //string
        'address', //string
        'address_number', //string
        'address_complement', //string
        'address_neighborhood', //string
        'address_city', //string
        'address_city_code',
        'address_state', //string
        'address_state_code',

    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => BusinessPartnerType::class,
        ];
    }

    public static function findByDocumentNumber(string $documentNumber): ?self
    {
        return self::where('document_number', removeSpecialCharacters($documentNumber))
            ->orWhere('base_document_number', removeSpecialCharacters($documentNumber))
            ->first();
    }

    public function clientContracts(): HasMany
    {
        return $this->hasMany(Contract::class, 'client_id');
    }

    public function clientContractPayments(): HasManyThrough
    {
        return $this->hasManyThrough(ContractPayment::class, Contract::class,  'client_id', 'contract_id');
    }

    public function supplierContracts(): HasMany
    {
        return $this->hasMany(Contract::class, 'supplier_id');
    }

    public function acquirerContracts(): BelongsToMany
    {
        return $this->belongsToMany(Contract::class, 'contract_has_acquirers');
    }

    public function clientReceivables(): HasMany
    {
        return $this->hasMany(Receivable::class, 'client_id');
    }

    public function acquirerReceivables(): HasMany
    {
        return $this->hasMany(Receivable::class, 'acquirer_id');
    }

    public function operationsAsClient(): HasMany
    {
        return $this->hasMany(Operation::class, 'client_id');
    }

    public function operationsAsSupplier(): HasMany
    {
        return $this->hasMany(Operation::class, 'supplier_id');
    }

    public function optInsAsClient(): HasMany
    {
        return $this->hasMany(OptIn::class, 'client_id');
    }

    public function optInsAsSupplier(): HasMany
    {
        return $this->hasMany(OptIn::class, 'supplier_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_has_business_partners')
            ->using(UserHasBusinessPartner::class)
            ->withPivot([
                'opt_in_start_date',
                'opt_in_end_date',
            ]);
    }
}
