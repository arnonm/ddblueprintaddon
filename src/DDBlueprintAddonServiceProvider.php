<?php
declare(strict_types=1);

namespace Arnonm\DDBlueprintAddon;

use Blueprint\Blueprint;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class DDBlueprintAddonServiceProvider extends ServiceProvider implements DeferrableProvider
{

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                dirname(__DIR__) . '/config/DesignDriven_Config.php' => config_path('blueprint_dd_config.php'),
            ], 'blueprint');
        }
    }

    public function register()
    {
        $this->app->singleton(DDBlueprintGenerator::class, function ($app) {
            $generator = new DDBlueprintGenerator($app['files']);
            
            return $generator;
        });

        $this->app->extend(Blueprint::class, function (Blueprint $blueprint, $app) {
            $blueprint->registerGenerator($app[DDBlueprintGenerator::class]);
            
            return $blueprint;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.blueprint.build',
            DDBlueprintGenerator::class,
            Blueprint::class,
        ];
    }
}

