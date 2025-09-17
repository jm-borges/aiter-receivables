<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ReceivableMovement extends Model
{
    /** @use HasFactory<\Database\Factories\ReceivableMovementFactory> */
    use HasFactory, HasUuids;


    protected $fillable = [/* Add your fillable attributes here */];

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
