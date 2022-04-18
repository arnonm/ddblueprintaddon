<?php

namespace Arnonm\DDBlueprintAddon\Generators;

use Arnonm\DDBlueprintAddon\Traits\HasNamespace;
use Arnonm\DDBlueprintAddon\Traits\HasPhpHelpers;
use Arnonm\DDBlueprintAddon\Traits\HasStubPath;
use Blueprint\Generators\AbstractClassGenerator;
use Blueprint\Models\Column;
use Blueprint\Models\Model;
use Blueprint\Tree;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Str;

class DataObjectGenerator extends AbstractClassGenerator
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
        $stub = $this->getDataObjectStub();

        /** @var \Blueprint\Models\Model $model */
        foreach ($tree->models() as $model) {
            $path = $this->outputPathDataObject($model->name());
            $this->files->put($path, $this->populateDataObject($stub, $model));

            $output['created'][] = $path;
        }

        return $output;
    }

    protected function DataObjectStrReplace(string $stub, $name, $className)
    {
        $stub = str_replace('{{ namespace }}', $this->getDataObjectsNamespace(), $stub);
        $stub = str_replace( '{{ contractnamespace }}', $this->getContractsNamespace().'\DataValueObjectContract', $stub);
        $stub = str_replace('ModelsPath', $className, $stub);
        $stub = str_replace('{{ class }}', $name, $stub);
        $stub = str_replace('{{ model }}', Str::snake($name), $stub);
        return $stub;
    }



    protected function buildConstructor(Model $model)
    {

        $constructor = 'public function __construct('.PHP_EOL;
        $nullable ='';
        foreach ($model->columns() as $column) {

            if ($this->nullable($column)) {

                $nullable .= sprintf('        public %s %s|null $%s = null,',
                    $this->supportsReadOnly() ? 'readonly' : '',
                    $this->phpDataType($column->dataType()),
                    $column->name()
                );
                $nullable .= PHP_EOL;

            } else {

                $constructor .= sprintf('        public %s %s $%s,',
                    $this->supportsReadOnly() ? 'readonly' : '',
                    $this->phpDataType($column->dataType()),
                    $column->name()
                );
                $constructor .= PHP_EOL;
            }

        }
        $constructor .= $nullable;
        $constructor .= '    )'.PHP_EOL;
        $constructor .= '{'.PHP_EOL;
        $constructor .= '}'.PHP_EOL;

        return $constructor;
    }

    protected function outputPathDataObject($name): string
    {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $this->getDataObjectsNamespace()) . DIRECTORY_SEPARATOR . $name . "DataObject.php";
        $path = str_replace('App/', 'app/', $path);


        if (!$this->files->exists(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }
        return $path;
    }


    private function buildArray(Model $model)
    {
        $array = PHP_EOL;
        $array .= 'public function toArray(): array'. PHP_EOL;
        $array .= '{'.PHP_EOL;
        $array .= '     return ['.PHP_EOL;
        foreach ($model->columns() as $column) {

            $array .= sprintf("         '%s'    => \$this->%s,", $column->name(), $column->name());
            $array .= PHP_EOL;
        }
        $array .= '];'.PHP_EOL;
        $array .= '}'.PHP_EOL;

        return $array;
    }



    protected function populateDataObject(string $stub, Model $model): string
    {


        $stub = $this->DataObjectStrReplace($stub, $model->name(), $model->fullyQualifiedClassName());

        $stub = str_replace('ConstructorSlot', $this->buildConstructor($model), $stub);
        $stub = str_replace('ArraySlot', $this->buildArray($model), $stub);
        $stub = $this->strict_types($stub);

        return $stub;
    }

    private function nullable(Column $column): bool
    {
        return $column->isNullable();
    }

}
