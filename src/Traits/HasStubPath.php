<?php
declare(strict_types=1);

namespace Arnonm\DDBlueprintAddon\Traits;

trait HasStubPath
{

    /**
     * Returns the stub path for this package.
     *
     */
    protected function stubPath(): string
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR.'stubs';
    }

    protected function getDataObjectStub(): string
    {
        $file = $this->stubPath() . DIRECTORY_SEPARATOR . 'DataObject.stub.php';
        return $this->files->get($file);
    }

    protected function getFactoryStub(): string
    {
        $file = $this->stubPath() . DIRECTORY_SEPARATOR . 'Factory.stub.php';
        return $this->files->get($file);
    }


    protected function getContractStub(string $name): string
    {
        return $this->files->get($this->stubPath() . DIRECTORY_SEPARATOR . $name.'Contract.stub.php');
    }


    protected function getTestStub(bool $pest = true): string
    {
        if ($pest) {
            return $this->files->get($this->stubPath() . DIRECTORY_SEPARATOR .'PestTest.stub.php');

        } else {
            return $this->files->get($this->stubPath() . DIRECTORY_SEPARATOR .'PhpUnitTest.stub.php');
        }
    }



}
