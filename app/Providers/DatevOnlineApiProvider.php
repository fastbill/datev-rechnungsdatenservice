<?php

namespace App\Providers;

use App\Services\Datev\Accounting\DXSOJobsApiClient;
use App\Socialite\DatevSandboxProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory;

class DatevOnlineApiProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(DXSOJobsApiClient::class, function (Application $app) {
            return new DXSOJobsApiClient();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Extend Http

        $use_sandbox = config('datev.dxso_jobs.use_sandbox', true);
        $api_client_id = config('datev.oidc.client_id');
        $api_url = $use_sandbox
            ? config('datev.dxso_jobs.sandbox_api_url')
            : config('datev.dxso_jobs.api_url');

        Http::macro(
            'accountingDXSOJobs',
            function () use ($api_url, $api_client_id) {
                return Http::baseUrl($api_url)
                    ->acceptJson()
                    ->withHeaders([
                        'X-DATEV-Client-Id' => $api_client_id,
                    ]);
            });

        // Extend Socialite

        $socialite = $this->app->make(Factory::class);
        $socialite->extend('datev', function () use ($socialite) {

            die(config('datev.oidc.client_secret'));

            return $socialite->buildProvider(DatevSandboxProvider::class, [
                'client_id' => config('datev.oidc.client_id'),
                'client_secret' => config('datev.oidc.client_secret'),
                'redirect' => config('datev.oidc.redirect')
            ]);
        });
    }
}
