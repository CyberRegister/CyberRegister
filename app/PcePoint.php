<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PcePoint.
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $location_code
 * @property int $points
 * @property string|null $controller_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PcePoint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PcePoint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PcePoint query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PcePoint whereControllerCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PcePoint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PcePoint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PcePoint whereLocationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PcePoint wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PcePoint whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PcePoint whereUserId($value)
 * @mixin \Eloquent
 */
class PcePoint extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'location_code', 'points', 'user_id',
    ];

    /**
     * Get the user that owns the points.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
