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

class FactoryGenerator extends AbstractClassGenerator
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
        $stub = $this->getFactoryStub();

        /** @var \Blueprint\Models\Model $model */
        foreach ($tree->models() as $model) {
            $path = $this->outputPathFactory($model->name());
            $this->files->put($path, $this->populateFactory($stub, $model));

            $output['created'][] = $path;
        }

        return $output;
    }

    protected function outputPathFactory($name): string
    {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $this->getFactoryNamespace()) . DIRECTORY_SEPARATOR . $name . "Factory.php";
        $path = str_replace('App/', 'app/', $path);


        if (!$this->files->exists(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }
        return $path;
    }

    protected function populateFactory(string $stub, Model $model): string
    {


        $stub = $this->FactoryStrReplace($stub, $model->name(), $model->fullyQualifiedClassName());

        $stub = str_replace('ArraySlot', $this->buildArray($model), $stub);
        $stub = $this->strict_types($stub);

        return $stub;
    }

    protected function FactoryStrReplace(string $stub, $name, $className)
    {
        $stub = str_replace('{{ namespace }}', $this->getFactoryNamespace(), $stub);
        $stub = str_replace( '{{ contractnamespace }}', $this->getContractsNamespace().'\\FactoryContract', $stub);
        $stub = str_replace( '{{ dataobjectnamespace }}', $this->getDataObjectsNamespace(). '\\' . $name .'DataObject', $stub);
        $stub = str_replace('ModelsPath', $className, $stub);
        $stub = str_replace('{{ class }}', $name, $stub);
        $stub = str_replace('{{ model }}', Str::snake($name), $stub);
        return $stub;
    }

    private function buildArray(Model $model)
    {
        $array = PHP_EOL;
        foreach ($model->columns() as $column) {

            $array .= sprintf("           %s: %s(data_get(\$attributes, '%s')),", $column->name(), $this->phpValType($column->dataType()), $column->name());
            $array .= PHP_EOL;
        }

        return $array;
    }

}
