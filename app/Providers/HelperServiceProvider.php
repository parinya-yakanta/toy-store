<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

require_once app_path().'/Helpers/CommonHelper.php';
require_once app_path().'/Helpers/GoToHelper.php';

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
