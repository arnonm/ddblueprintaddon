<?php
declare(strict_types=1);

namespace Arnonm\DDBlueprintAddon\Tests\Feature;

use Arnonm\DDBlueprintAddon\Tests\Feature\FeatureTestCase;

class DDBluePrintTest extends FeatureTestCase
{

    public function it_should_return_expected_types()
    {
        assertEquals($this->subject->types(), ['tests']);
    }

}

