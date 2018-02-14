<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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
        'password', 'remember_token',
    ];
    
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            $user->expertises()->delete();
            $user->pcePoints()->delete();
        });
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
        if ($this->first_name) $names[] = $this->first_name;
        if ($this->middle_name) $names[] = $this->middle_name;
        if ($this->last_name) $names[] = $this->last_name;
        return join(' ', $names);
    }

    /**
     * Get the users expertises.
     */
    public function expertises(): HasMany
    {
        return $this->hasMany(Expertise::class);
    }

    /**
     * @return array
     */
    public function getCodesAttribute() {
        $codes = [];
        foreach ($this->expertises as $expertise) {
            $codes[$expertise->code] = $expertise->description;
        }
        return $codes;
    }

    /**
     * Get the users PCE points.
     */
    public function pcePoints(): HasMany
    {
        return $this->hasMany(PcePoint::class);
    }
}
