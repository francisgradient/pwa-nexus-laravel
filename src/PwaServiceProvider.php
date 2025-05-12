<?php

namespace FrancisLarvelPwa;

use FrancisLarvelPwa\Commands\PWACommand;
use FrancisLarvelPwa\Commands\PWAPublishCommand;
use FrancisLarvelPwa\Services\PWAService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class PwaServiceProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->singleton(PWAService::class, function ($app) {
            return new PWAService;
        });

        $this->commands([
            PWAPublishCommand::class,
            PWACommand::class,
        ]);

        $this->publishes([
            __DIR__.'/Stubs/pwa.stub' => config_path('pwa.php'),
        ], 'nexus:publish-pwa-config');

        $this->publishes([
            __DIR__.'/Stubs/manifest.stub' => public_path('manifest.json'),
        ], 'nexus:publish-manifest');

        $this->publishes([
            __DIR__.'/Stubs/offline.stub' => public_path('offline.html'),
        ], 'nexus:publish-offline');

        $this->publishes([
            __DIR__.'/Stubs/sw.stub' => public_path('sw.js'),
        ], 'nexus:publish-sw');

        $this->publishes([
            __DIR__.'/Stubs/logo.png' => public_path('logo.png'),
        ], 'nexus:publish-logo');

    }

    public function boot(): void
    {

        Blade::directive('PwaHead', function () {
            return '<?php echo app(\\FrancisLarvelPwa\\Services\\PWAService::class)->headTag(); ?>';
        });

        Blade::directive('RegisterServiceWorkerScript', function () {
            return '<?php echo app(\\FrancisLarvelPwa\\Services\\PWAService::class)->registerServiceWorkerScript(); ?>';
        });

        if (class_exists('Illuminate\Foundation\AliasLoader')) {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('PWA', \FrancisLarvelPwa\Facades\PWA::class);
        }
    }
}