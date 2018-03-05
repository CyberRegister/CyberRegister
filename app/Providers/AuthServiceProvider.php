<?php

namespace App\Providers;

use App\CyberExpertise;
use App\Expertise;
use App\PcePoint;
use App\Policies\CyberExpertisePolicy;
use App\Policies\ExpertisePolicy;
use App\Policies\PcePointPolicy;
use App\Policies\UserPolicy;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

/**
 * Class AuthServiceProvider.
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        CyberExpertise::class => CyberExpertisePolicy::class,
        User::class           => UserPolicy::class,
        Expertise::class      => ExpertisePolicy::class,
        PcePoint::class       => PcePointPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::resource('users', 'UserPolicy');
        Passport::routes();
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
    }
}
