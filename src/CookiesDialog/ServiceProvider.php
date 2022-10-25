<?php

namespace SSD\CookiesDialog;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use SSD\CookiesDialog\Utilities\Share;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @param  \SSD\CookiesDialog\Utilities\Share  $share
     * @return void
     */
    public function boot(Share $share): void
    {
        View::composer('*', fn($view) => $view->with($share->all()));

        $this->publishes([
            __DIR__.'/config/cookies-dialog.php' => config_path('cookies-dialog.php'),
        ], 'laravel-cookies-dialog');

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
    }
}