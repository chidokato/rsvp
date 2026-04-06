<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
    public function boot()
    {
        Blade::directive('assetv', function ($expression) {
            return "<?php \$__assetvPath = {$expression}; \$__assetvVersion = @filemtime(public_path(\$__assetvPath)); echo asset(\$__assetvPath) . '?v=' . (\$__assetvVersion ?: time()); ?>";
        });
    }
}
