<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        //\App\Observers\Kernel::make()->observes();

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Modules\Site\Console\GeneratePtjCommand::class,
            ]);
        }

        if (config('app.https')) {
            $url->forceScheme('https');
        }

        Paginator::useBootstrap();
    }
}
