<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CyberExpertise extends Model
{
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'expertise_code';
    }

    /**
     * Get the actual user expertises for this.
     */
    public function expertises(): HasMany
    {
        return $this->hasMany(Expertise::class);
    }
}
