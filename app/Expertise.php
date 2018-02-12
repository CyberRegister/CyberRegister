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
}