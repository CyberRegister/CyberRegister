<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Expertise.
 *
 * @property int $id
 * @property int $user_id
 * @property int $cyber_expertise_id
 * @property \Illuminate\Support\Carbon|null $date_of_certification
 * @property \Illuminate\Support\Carbon|null $date_of_expiration
 * @property string|null $certification_code
 * @property string|null $controller_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\CyberExpertise $cyberExpertise
 * @property-read string $code
 * @property-read null|string $description
 * @property-read \App\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expertise newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expertise newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expertise query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expertise whereCertificationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expertise whereControllerCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expertise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expertise whereCyberExpertiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expertise whereDateOfCertification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expertise whereDateOfExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expertise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expertise whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expertise whereUserId($value)
 * @mixin \Eloquent
 */
class Expertise extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'certification_code', 'date_of_certification', 'date_of_expiration', 'user_id', 'cyber_expertise_id',
    ];

    /**
     * @var array
     */
    protected $dates = ['date_of_certification', 'date_of_expiration'];

    /**
     * Get the user that owns this expertise.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the actual CyberExpertise for this expertise.
     */
    public function cyberExpertise(): BelongsTo
    {
        return $this->belongsTo(CyberExpertise::class);
    }

    /**
     * The expertise code (3 chars).
     *
     * @return string
     */
    public function getCodeAttribute(): string
    {
        return $this->cyberExpertise->expertise_code;
    }

    /**
     * The expertise description.
     *
     * @return null|string
     */
    public function getDescriptionAttribute():? string
    {
        return $this->cyberExpertise->description;
    }
}
