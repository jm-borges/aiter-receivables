<?php

namespace App\Models\Rtm;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RtmAccessToken extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'rtm_access_tokens';

    protected $fillable = [
        'access_token',
        'expires_at',
    ];
}
