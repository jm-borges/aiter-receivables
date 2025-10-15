<?php

namespace App\Models\Core;

use App\Enums\BusinessPartnerType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function contracts(): HasMany|BelongsToMany
    {
        return match ($this->type) {
            BusinessPartnerType::CLIENT   => $this->hasMany(Contract::class, 'client_id'),
            BusinessPartnerType::SUPPLIER => $this->hasMany(Contract::class, 'supplier_id'),
            BusinessPartnerType::ACQUIRER => $this->belongsToMany(Contract::class, 'contract_has_acquirers'),
        };
    }

    public function receivables(): HasMany
    {
        return match ($this->type) {
            BusinessPartnerType::CLIENT   => $this->hasMany(Receivable::class, 'client_id'),
            BusinessPartnerType::ACQUIRER => $this->hasMany(Receivable::class, 'acquirer_id'),
        };
    }
}
