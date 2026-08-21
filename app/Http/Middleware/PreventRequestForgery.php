<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestForgery as Middleware;

/**
 * Class PreventRequestForgery.
 */
class PreventRequestForgery extends Middleware
{
    /**
     * The URIs that should be excluded from request forgery verification.
     *
     * @var list<string>
     */
    protected $except = [];
}
