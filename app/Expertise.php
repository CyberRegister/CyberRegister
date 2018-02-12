<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expertise extends Model
{
    /**
     * Get the user that owns this expertise.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the actual CyberExpertise for this expertise.
     */
    public function cyberExpertise(): BelongsTo
    {
        return $this->belongsTo('App\CyberExpertise');
    }

    /**
     * The expertise code (3 chars)
     * @return string
     */
    public function getCodeAttribute(): string
    {
        return $this->cyberExpertise->expertise_code;
    }
}