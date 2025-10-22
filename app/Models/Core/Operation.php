<?php

namespace App\Models\Core;

use App\Enums\OperationStatus;
use App\Models\Core\Pivots\OperationHasReceivable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operation extends Model
{
    /** @use HasFactory<\Database\Factories\OperationFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'action_id',
        'contract_id',
        'client_id',
        'status',
        'identdOp',
        'sitRet',
        'operation_href',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => OperationStatus::class,
        ];
    }

    public function action(): BelongsTo
    {
        return $this->belongsTo(Action::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(BusinessPartner::class, 'client_id');
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function receivables(): BelongsToMany
    {
        return $this->belongsToMany(Receivable::class, 'operation_has_receivables')
            ->using(OperationHasReceivable::class)
            ->withPivot(['amount']);
    }

    public function cipMessages(): HasMany
    {
        return $this->hasMany(CipMessage::class);
    }
}
