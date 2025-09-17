<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Operation extends Model
{
    /** @use HasFactory<\Database\Factories\OperationFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'status',
        'cnpjER',
        'identdNegcRecbvl',
        'identdOp',
        'indrTpNegc',
        'dtVencOp',
        'vlrTotLimOuSldDevdr',
        'vlrGar',
        'indrGestER',
        'indrRegrDivs',
        'indrAlcancContrtoCreddrSub',
        'indrActeIncondlOp',
        'identdCIPOpOrRenegcDiv',
        'indrActeUniddRecbvlReserv',
        'indrPeriodRecalc',
        'diaExeccRecalc',
        'dtHrIncl',
        'indrSitOp',
        'indrAutcCess',
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
}
