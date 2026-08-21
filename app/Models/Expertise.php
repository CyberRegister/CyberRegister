<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 * @property-read \App\Models\CyberExpertise $cyberExpertise
 * @property-read string $code
 * @property-read null|string $description
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expertise newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expertise newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expertise query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expertise whereCertificationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expertise whereControllerCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expertise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expertise whereCyberExpertiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expertise whereDateOfCertification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expertise whereDateOfExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expertise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expertise whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expertise whereUserId($value)
 * @mixin \Eloquent
 */
class Expertise extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'certification_code', 'date_of_certification', 'date_of_expiration', 'user_id', 'cyber_expertise_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_of_certification' => 'datetime',
        'date_of_expiration'    => 'datetime',
    ];

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
    public function getDescriptionAttribute(): ?string
    {
        return $this->cyberExpertise->description;
    }
}
