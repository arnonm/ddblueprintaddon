<?php

namespace Arnonm\DDBlueprintAddon\Generators;

use Arnonm\DDBlueprintAddon\Traits\HasNamespace;
use Arnonm\DDBlueprintAddon\Traits\HasPhpHelpers;
use Arnonm\DDBlueprintAddon\Traits\HasStubPath;
use Blueprint\Generators\AbstractClassGenerator;
use Blueprint\Models\Model;
use Blueprint\Tree;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Str;

class PestTestGenerator extends AbstractClassGenerator
{
    use HasStubPath;
    use HasNamespace;
    use HasPhpHelpers;

    /** @var Filesystem $files */
    protected $files;

    public function __construct($files)
    {
        $this->files = $files;
    }

    public function handle(Tree $tree, array $output): array
    {
        if (!$tree->models()) {
            return $output;
        }

        $stub = $this->getTestStub();

        /** @var \Blueprint\Models\Model $model */
        foreach ($tree->models() as $model) {
            $path = $this->outputPathTest($model->name());
            $this->files->put($path, $this->populateTest($stub, $model));

            $output['created'][] = $path;
        }

        return $output;
    }

    protected function outputPathTest($name): string
    {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $this->getTestsNamespace()) . DIRECTORY_SEPARATOR . $name . "Test.php";
        $path = str_replace('App/', 'app/', $path);


        if (!$this->files->exists(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }
        return $path;
    }

    protected function populateTest(string $stub, Model $model): string
    {


        $stub = $this->TestStrReplace($stub, $model->name(), $model->fullyQualifiedClassName());

        //$stub = str_replace('ArraySlot', $this->buildArray($model), $stub);
        $stub = $this->strict_types($stub);

        return $stub;
    }

    protected function TestStrReplace(string $stub, $name, $className)
    {
        $stub = str_replace('{{ namespace }}', $this->getTestsNamespace(), $stub);
        $stub = str_replace( '{{ contractnamespace }}', $this->getContractsNamespace().'\\FactoryContract', $stub);
        $stub = str_replace( '{{ dataobjectnamespace }}', $this->getDataObjectsNamespace(). '\\' . $name .'DataObject', $stub);
        $stub = str_replace( '{{ modelfactory }}', $this->getFactoryNamespace(). '\\' . $name .'Factory', $stub);
        $stub = str_replace('{{ modelpath }}', $className, $stub);

        $stub = str_replace('{{ class }}', $name, $stub);
        $stub = str_replace('{{ model }}', Str::snake($name), $stub);
        return $stub;
    }



}
