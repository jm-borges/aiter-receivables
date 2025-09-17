<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Timetable extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\TimetableFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'date',                          // Data de referência
        'opening_date',                   // Data de abertura da janela
        'closing_date',                   // Data de fechamento da janela
        'trade_repository_opening_date',  // Data de abertura da janela - Registradora
        'trade_repository_closing_date',
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
