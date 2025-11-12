<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\BusinessPartnerType;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Pivots\UserHasBusinessPartner;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, HasUuids, Notifiable, HasApiTokens, InteractsWithMedia;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',

        'phone',
        'birth_date',
        'gender',

        'is_super_admin',

        'preferred_currency',
        'preferred_language',
        'timezone',
        'date_format',
        'country_code',
        'thousands_separator',
        'decimal_separator',

        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_super_admin' => 'boolean'
    ];

    //===================== UTILITIES ==============================

    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin;
    }

    //=================  MEDIA ==================================

    public function profileImageData(): ?Media
    {
        $images = $this->getMedia('profile_image');

        if ($images != null && count($images) > 0) {
            return $images[0];
        }

        return null;
    }

    //=================  RELATIONSHIPS ==================================

    // 

    public function businessPartners(): BelongsToMany
    {
        return $this->belongsToMany(BusinessPartner::class, 'user_has_business_partners')
            ->using(UserHasBusinessPartner::class)
            ->withPivot([
                'opt_in_start_date',
                'opt_in_end_date',
            ]);
    }

    public function supplier(): ?BusinessPartner
    {
        return $this
            ->businessPartners()
            ->where('type', BusinessPartnerType::SUPPLIER)
            ->first();
    }
}
