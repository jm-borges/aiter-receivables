<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class OptOutResponse extends Model
{
    /** @use HasFactory<\Database\Factories\Rtm\OptOutResponseFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [
        'request_protocol',
        'opt_in_protocol',
        'opt_out_protocol',
        'processing_date',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [];
    }
}
