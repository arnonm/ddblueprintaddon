<?php
declare(strict_types=1);

namespace Arnonm\DDBlueprintAddon\Tests\Feature;


use Blueprint\Models\Model;
use Blueprint\Tree;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;

class DDBluePrintTest extends FeatureTestCase
{

    public function test_it_should_return_expected_types()
    {
        assertEquals($this->subject->types(), ['tests', 'dataobjects', 'factories', 'contracts']);
    }


    public function test_expects_nothing_to_be_generated_when_no_models_are_given()
    {

        /** @var FeatureTestCase $this */

        $this->files->expects('exists')->never();
        $this->files->expects('get')->never();
        $this->files->expects('put')->never();

        $files = $this->subject->output(new Tree(['models' => []]));

        self::assertEmpty($files);
    }

    public function test_that_contracts_are_generated_when_a_model_is_given()
    {
        /** @var FeatureTestCase $this */
        $this->files->expects('exists')->never();
        $this->files->shouldReceive('get')->withAnyArgs()->andReturn('string')->times(5);
        $this->files->shouldReceive('makeDirectory');
        $this->files->shouldReceive('exists')->times(5);
        $this->files->shouldReceive('put')->times(5);

        $files = $this->subject->output(new Tree(['models' => [new Model('Dummy')]]));

        assertEquals(5, count($files['created']));
    }

//        $this->files->shouldReceive('get')->with($this->stubPath . 'DataValueObjectContract.stub.php')->andReturn('Dummy');
//        $this->files->shouldReceive('get')->with($this->stubPath .'FactoryContract.stub.php',)->andReturn('Dummy');
//        $this->files->shouldReceive('get')->with($this->stubPath .'DataObject.stub.php',)->andReturn('Dummy');
//        $this->files->shouldReceive('get')->with($this->stubPath .'Factory.stub.php',)->andReturn('Dummy');
//        $this->files->shouldReceive('get')->with($this->stubPath .'PhpUnitTest.stub.php',)->andReturn('Dummy');
//        $this->files->shouldReceive('get')->with($this->stubPath.'PestTest.stub.php',)->andReturn('Dummy');
}

