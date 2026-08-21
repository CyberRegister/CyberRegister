<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\Contracts\OAuthenticatable;
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Expertise[] $expertises
 * @property-read list<string|null> $codes
 * @property-read string $name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PcePoint[] $pcePoints
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read \App\Models\TwoFAKey $twoFAKey
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereControllerCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCyberCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereInitials($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsController($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePlaceOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereVerificationCode($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements OAuthenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasApiTokens;
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'email',
        'password', 'cyber_code', 'date_of_birth', 'place_of_birth',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var list<string>
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
     * @return HasMany<Expertise, $this>
     */
    public function expertises(): HasMany
    {
        return $this->hasMany(Expertise::class);
    }

    /**
     * NOTE: the sort() call below re-indexes the array, discarding the
     * expertise codes used as keys, so this returns a plain list of
     * descriptions rather than a code => description map.
     *
     * @return list<string|null>
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
     * @return HasMany<PcePoint, $this>
     */
    public function pcePoints(): HasMany
    {
        return $this->hasMany(PcePoint::class);
    }

    /**
     * @param string $value
     *
     * @return void
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
     * @return HasOne<TwoFAKey, $this>
     */
    public function twoFAKey(): HasOne
    {
        return $this->hasOne(TwoFAKey::class);
    }
}
