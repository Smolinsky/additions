<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 * @package App\Models
 *
 * @property-read int id
 * @property string uuid
 * @property string|null first_name
 * @property string|null last_name
 * @property string|null email
 * @property Carbon|null email_verified_at
 * @property string|null password
 * @property string|null remember_token
 * @property string role
 * @property-read Carbon created_at
 * @property-read Carbon updated_at
 *
 * @property-read string full_name
 *
 * @property-read Collection activations
 * @property-read Collection reminders
 * @property-read Collection accounts
 * @property-read Collection order
 * @property-read Address address
 * @property-read UserSetting|null setting
 *
 * @mixin Eloquent
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable, UuidTrait;

    public const ROLE_TRIAL = 'trial';
    public const ROLE_TRIAL_END = 'trial_end';
    public const ROLE_KITCHEN = 'kitchen';
    public const ROLE_STUDIO_90_DAYS = 'studio_90_days';
    public const ROLE_STUDIO_LIGHT = 'studio_light';
    public const ROLE_STUDIO_ENDURANCE = 'studio_endurance';
    public const ROLE_COMPLEX = 'complex';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'email_verified_at', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function (self $user) {
            $user->address()->create();
            $user->setting()->create(['unit' => Unit::TYPE_IMPERIAL]);
        });
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /* ************************ RELATIONS ************************ */

    /**
     * @return HasMany
     */
    public function activations(): HasMany
    {
        return $this->hasMany(ActivationCode::class);
    }

    /**
     * @return HasMany
     */
    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class);
    }

    /**
     * @return HasMany
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(UserAccount::class);
    }

    /**
     * @return HasOne
     */
    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    /**
     * @return HasOne
     */
    public function setting(): HasOne
    {
        return $this->hasOne(UserSetting::class);
    }

    public function confirmEmail()
    {
        $this->email_verified_at = Carbon::now();
        $this->save();
    }

    public function getFullNameAttribute(): string
    {
        return trim((string)$this->first_name . ' ' . (string)$this->last_name);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
