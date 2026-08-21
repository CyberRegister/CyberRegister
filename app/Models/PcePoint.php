<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PcePoint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PcePoint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PcePoint query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PcePoint whereControllerCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PcePoint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PcePoint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PcePoint whereLocationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PcePoint wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PcePoint whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PcePoint whereUserId($value)
 * @mixin \Eloquent
 */
class PcePoint extends Model
{
    use HasFactory;
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
