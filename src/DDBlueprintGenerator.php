<?php

namespace Arnonm\DDBlueprintAddon;

use Arnonm\DDBlueprintAddon\Generators\ContractGenerator;
use Arnonm\DDBlueprintAddon\Generators\DataObjectGenerator;
use Arnonm\DDBlueprintAddon\Generators\FactoryGenerator;
use Arnonm\DDBlueprintAddon\Generators\PestTestGenerator;
use Arnonm\DDBlueprintAddon\Generators\PhpUnitTestGenerator;
use Arnonm\DDBlueprintAddon\Traits\HasNamespace;
use Arnonm\DDBlueprintAddon\Traits\HasPhpHelpers;
use Arnonm\DDBlueprintAddon\Traits\HasStubPath;
use Blueprint\Contracts\Generator;
use Blueprint\Generators\AbstractClassGenerator;
use Blueprint\Tree;
use Illuminate\Contracts\Filesystem\Filesystem;
use function config;


class DDBlueprintGenerator extends AbstractClassGenerator implements Generator
{
    use HasStubPath;
    use HasNamespace;
    use HasPhpHelpers;

    /** @var Filesystem $files */
    protected $files;

    /** @var array */
    private $imports = [];


    public function __construct($files)
    {
        $this->files = $files;
    }

    public function output(Tree $tree): array
    {
        $output = [];

        $contractGenerator = new ContractGenerator($this->files);
        $output = $contractGenerator->handle($tree, $output, ['DataValueObject', 'Factory']);

        $dataObjectGenerator = new DataObjectGenerator($this->files);
        $output = $dataObjectGenerator->handle($tree, $output);

        $factoryGenerator = new FactoryGenerator($this->files);
        $output = $factoryGenerator->handle($tree, $output);

        if (config('blueprint.test.type') == "Pest") {
            $testGenerator = new PestTestGenerator($this->files);
            $output = $testGenerator->handle($tree, $output);

        } else {
            $testGenerator = new PhpUnitTestGenerator($this->files);
            $output = $testGenerator->handle($tree, $output);

        }


        return $output;
    }


    public function types(): array
    {
        return ['tests', 'dataobjects', 'factories', 'contracts'];
    }

}
