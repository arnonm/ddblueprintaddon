<?php

namespace Arnonm\DDBlueprintAddon\Tests\Unit;

use Blueprint\Blueprint;
use Blueprint\Contracts\Generator;
use Blueprint\Generators\TestGenerator;
use Arnonm\DDBlueprintAddon\DDBlueprintGenerator;
use ReflectionObject;

it('swaps the default TestGenerator with our Generators', function () {
    $blueprint = app(Blueprint::class);

    $reflectionBlueprint = new ReflectionObject($blueprint);

    $generatorsProperty = $reflectionBlueprint->getProperty('generators');
    $generatorsProperty->setAccessible(true);

    $generators = collect($generatorsProperty->getValue($blueprint))
        ->map(function (Generator $generator) {
            return get_class($generator);
        })->toArray();

    expect($generators)->toContain(DDBlueprintGenerator::class);
    expect($generators)->not()->toContain(TestGenerator::class);
});
