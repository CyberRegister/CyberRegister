<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CyberExpertise extends Model
{
    /**
     * Get the users expertises.
     */
    public function expertises(): HasMany
    {
        return $this->hasMany(Expertise::class);
    }
}
