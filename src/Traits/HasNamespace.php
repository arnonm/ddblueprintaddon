<?php
declare(strict_types=1);

namespace Arnonm\DDBlueprintAddon\Traits;

use function config;

trait HasNamespace
{

    protected function getDataObjectsNamespace(): string
    {
        return
            config('blueprint.app.class_namespace','App')
            . '\\' .
            config('blueprint.dataObjects.class_namespace', 'DataObjects');
    }

    protected function getFactoryNamespace(): string
    {
        return
            config('blueprint.app.class_namespace','App')
            . '\\' .
            config('blueprint.Factories.class_namespace', 'Factories');
    }

    protected function getContractsNamespace(): string
    {
        return
            config('blueprint.app.class_namespace','App')
            . '\\' .
            config('blueprint.contracts.class_namespace', 'Contracts');
    }

    protected function getTestsNamespace(): string
    {
        return
            config('blueprint.test.class_namespace','Tests')
            . '\\Unit';
    }
}
