<?php

namespace Arnonm\DDBlueprintAddon\Generators;

use Arnonm\DDBlueprintAddon\Traits\HasNamespace;
use Arnonm\DDBlueprintAddon\Traits\HasPhpHelpers;
use Arnonm\DDBlueprintAddon\Traits\HasStubPath;
use Blueprint\Generators\AbstractClassGenerator;
use Blueprint\Tree;
use Illuminate\Contracts\Filesystem\Filesystem;

class ContractGenerator extends AbstractClassGenerator
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

    public function handle(Tree $tree, array $output, array $contracts): array
    {
        if (!$tree->models()) {
            return $output;
        }
        foreach ($contracts as $contract) {
            $stub = $this->getContractStub($contract);
            $path = $this->outputContractsObject($contract);
            $this->files->put($path, $this->ContractsStrReplace($stub));

            $output['created'][] = $path;
        }
        return $output;
    }

    protected function outputContractsObject(string $name): string
    {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $this->getContractsNamespace()) . DIRECTORY_SEPARATOR . $name . "Contract.php";
        $path = str_replace('App/', 'app/', $path);

        if ( !$this->files->exists(dirname($path))) {
            $this->files->makeDirectory(dirname($path));
        }
        return $path;
    }

    protected function ContractsStrReplace(string $stub): string
    {
        $stub = str_replace('{{ namespace }}', $this->getContractsNamespace(), $stub);
        return $stub;
    }
}
