<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PcePoint extends Model
{
    /**
     * Get the user that owns the points.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
