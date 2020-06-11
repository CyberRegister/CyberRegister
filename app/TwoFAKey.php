<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class TwoFAKey.
 *
 * @property int $id
 * @property int $user_id
 * @property bool $google2fa_enable
 * @property string $google2fa_secret
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoFAKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoFAKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoFAKey query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoFAKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoFAKey whereGoogle2faEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoFAKey whereGoogle2faSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoFAKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoFAKey whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TwoFAKey whereUserId($value)
 * @mixin \Eloquent
 */
class TwoFAKey extends Model
{
    /**
     * @var string
     */
    protected $table = '2fa_key';

    protected $fillable = ['google2fa_secret', 'google2fa_enable', 'user_id'];

    /**
     * Get the user that owns this expertise.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Encrypt the user's google_2fa secret.
     *
     * @param string $value
     * @return void
     */
    public function setGoogle2faSecretAttribute($value)
    {
        $this->attributes['google2fa_secret'] = encrypt($value);
    }

    /**
     * Decrypt the user's google_2fa secret.
     *
     * @param string $value
     *
     * @return string
     */
    public function getGoogle2faSecretAttribute($value)
    {
        return decrypt($value);
    }
}
