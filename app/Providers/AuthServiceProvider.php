<?php

namespace App\Providers;

use App\Models\CyberExpertise;
use App\Models\Expertise;
use App\Models\PcePoint;
use App\Models\User;
use App\Policies\CyberExpertisePolicy;
use App\Policies\ExpertisePolicy;
use App\Policies\PcePointPolicy;
use App\Policies\UserPolicy;
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
     * @var array<class-string, class-string>
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
    public function boot(): void
    {
        Gate::resource('users', UserPolicy::class);

        // This application's oauth_clients table predates Passport 13, which
        // switched the default client identifier to a UUID. Keep integer ids
        // so existing clients continue to authenticate.
        Passport::$clientUuids = false;

        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
    }
}
