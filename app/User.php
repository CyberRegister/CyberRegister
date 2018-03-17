<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lahaxearnaud\U2f\Models\U2fKey;
use Laravel\Passport\HasApiTokens;

/**
 * Class User.
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'email',
        'password', 'cyber_code', 'date_of_birth', 'place_of_birth',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'google2fa_secret',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::deleting(
            function (User $user) {
                $user->expertises()->delete();
                $user->pcePoints()->delete();
            }
        );
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'cyber_code';
    }

    /**
     * @return string
     */
    public function getNameAttribute(): string
    {
        $names = [];
        if ($this->first_name) {
            $names[] = $this->first_name;
        }
        if ($this->middle_name) {
            $names[] = $this->middle_name;
        }
        if ($this->last_name) {
            $names[] = $this->last_name;
        }

        return implode(' ', $names);
    }

    /**
     * Get the users expertises.
     *
     * @return HasMany
     */
    public function expertises(): HasMany
    {
        return $this->hasMany(Expertise::class);
    }

    /**
     * @return array
     */
    public function getCodesAttribute()
    {
        $codes = [];
        foreach ($this->expertises as $expertise) {
            $codes[$expertise->code] = $expertise->description;
        }

        sort($codes);

        return $codes;
    }

    /**
     * Get the users PCE points.
     *
     * @return HasMany
     */
    public function pcePoints(): HasMany
    {
        return $this->hasMany(PcePoint::class);
    }

    /**
     * @param $value
     */
    public function setDateOfBirthAttribute($value)
    {
        try {
            $date = Carbon::createFromFormat('Y-m-d', $value);
        } catch (\InvalidArgumentException $exception) {
            $date = Carbon::createFromFormat('d-m-Y', $value);
        }
        $this->attributes['date_of_birth'] = $date;
    }

    /**
     * @return HasOne
     */
    public function u2fKey(): HasOne
    {
        return $this->hasOne(U2fKey::class);
    }

    /**
     * @return HasOne
     */
    public function twoFAKey(): HasOne
    {
        return $this->hasOne(TwoFAKey::class);
    }
}
