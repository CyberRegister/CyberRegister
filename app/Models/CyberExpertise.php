<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Expertise[] $expertises
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CyberExpertise newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CyberExpertise newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CyberExpertise query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CyberExpertise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CyberExpertise whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CyberExpertise whereExpertiseCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CyberExpertise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CyberExpertise whereRequiredPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CyberExpertise whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CyberExpertise extends Model
{
    /** @use HasFactory<\Database\Factories\CyberExpertiseFactory> */
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
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
     * @return HasMany<Expertise, $this>
     */
    public function expertises(): HasMany
    {
        return $this->hasMany(Expertise::class);
    }
}
