<?php

namespace App\Providers;

use App\Services\Datev\Accounting\DXSOJobsApiClient;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

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
        $use_sandbox = config('datev.dxso_jobs.use_sandbox', true);
        $api_client_id = config('datev.client_id');
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
    }
}
