<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CyberExpertise extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'required_points', 'expertise_code',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($cyberExpertise) {
            $cyberExpertise->expertises()->delete();
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'expertise_code';
    }

    /**
     * Get the actual user expertises for this.
     *
     * @return HasMany
     */
    public function expertises(): HasMany
    {
        return $this->hasMany(Expertise::class);
    }
}
