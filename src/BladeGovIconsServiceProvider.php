<?php

declare(strict_types=1);

namespace Codeat3\BladeGovIcons;

use BladeUI\Icons\Factory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container;

final class BladeGovIconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('blade-govicons', []);

            $factory->add('gov-icons', array_merge(['path' => __DIR__.'/../resources/svg'], $config));
        });

    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-govicons.php', 'blade-govicons');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/svg' => public_path('vendor/blade-govicons'),
            ], 'blade-govicons');

            $this->publishes([
                __DIR__.'/../config/blade-govicons.php' => $this->app->configPath('blade-govicons.php'),
            ], 'blade-govicons-config');
        }
    }

}
