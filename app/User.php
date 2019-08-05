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
 *
 * @property int $id
 * @property string|null $initials
 * @property string|null $first_name
 * @property string|null $middle_name
 * @property string|null $last_name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $cyber_code
 * @property string|null $verification_code
 * @property string|null $date_of_birth
 * @property string|null $place_of_birth
 * @property mixed|null $photo
 * @property string|null $controller_code
 * @property int $is_controller
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Expertise[] $expertises
 * @property-read array $codes
 * @property-read string $name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PcePoint[] $pcePoints
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read \App\TwoFAKey $twoFAKey
 * @property-read \Lahaxearnaud\U2f\Models\U2fKey $u2fKey
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereControllerCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCyberCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereInitials($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsController($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePlaceOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereVerificationCode($value)
 * @mixin \Eloquent
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
            function (self $user) {
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
     * @param string $value
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
