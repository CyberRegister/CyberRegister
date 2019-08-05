<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class CyberExpertise.
 *
 * @property int $id
 * @property string|null $expertise_code
 * @property string|null $description
 * @property int $required_points
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Expertise[] $expertises
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CyberExpertise newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CyberExpertise newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CyberExpertise query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CyberExpertise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CyberExpertise whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CyberExpertise whereExpertiseCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CyberExpertise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CyberExpertise whereRequiredPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CyberExpertise whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
        static::deleting(
            function (self $cyberExpertise) {
                $cyberExpertise->expertises()->delete();
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
