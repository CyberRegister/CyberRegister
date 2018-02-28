<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TwoFAKey extends Model
{
    /**
     * @var string
     */
    protected $table = '2fa_key';

    protected $fillable = ['google2fa_secret', 'google2fa_enable', 'user_id'];

    /**
     * Get the user that owns this expertise.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Ecrypt the user's google_2fa secret.
     *
     * @param string $value
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
