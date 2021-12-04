<?php

namespace App\Providers;

use App\Extensions\Auth\Guards\SimpleAuthGuard;
use App\Policies\TokenPolicy;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        PersonalAccessToken::class => TokenPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->bootSimpleAuthGuard();
    }

    protected function bootSimpleAuthGuard(): void
    {
        Auth::extend('simple', function (Application $application, string $name, array $config)
        {
            $provider   = Auth::createUserProvider($config['provider'] ?? 'users');
            $request    = $application->make('request');

            return new SimpleAuthGuard($provider, $request, $config['key'] ?? 'authorization');
        });
    }
}
