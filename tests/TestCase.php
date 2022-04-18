<?php
declare(strict_types=1);

namespace Arnonm\DDBlueprintAddon\Tests;

use Blueprint\BlueprintServiceProvider;
use Arnonm\DDBlueprintAddon\DDBlueprintAddonServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getEnvironmentSetUp($app): void
    {
        // blueprint config
        $app['config']->set('blueprint.namespace', 'App');
        $app['config']->set('blueprint.models_namespace', '');
        $app['config']->set('blueprint.app_path', 'app');
    }

    protected function getPackageProviders($app): array
    {
        return [
            BlueprintServiceProvider::class,
            DDBlueprintAddonServiceProvider::class,
        ];
    }
}
