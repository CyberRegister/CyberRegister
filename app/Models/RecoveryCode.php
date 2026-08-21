<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class RecoveryCode.
 *
 * @property int                             $id
 * @property int                             $user_id
 * @property string                          $code
 * @property \Illuminate\Support\Carbon|null $used_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User                       $user
 */
class RecoveryCode extends Model
{
    /**
     * @var string
     */
    protected $table = '2fa_recovery_codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['user_id', 'code', 'used_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'used_at' => 'datetime',
    ];

    /**
     * Get the user this code belongs to.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Limit to codes that have not been spent.
     *
     * @param Builder<RecoveryCode> $query
     *
     * @return Builder<RecoveryCode>
     */
    public function scopeUnused(Builder $query): Builder
    {
        return $query->whereNull('used_at');
    }
}
