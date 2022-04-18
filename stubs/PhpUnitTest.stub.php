<?php

namespace {{ namespace }};

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertInstanceOf;
use {{ dataobjectnamespace }};
use {{ modelfactory }};
use {{ modelpath }};

class {{ class }}Test extends TestCase
{

    public function can_create_a_{{ class }}_value_object_using_a_factory_test()
    {
        assertInstanceOf({{ class }}DataObject::class, {{ class }}Factory::make({{ class }}::factory()->raw()));
    }


    public function can_create_a_{{ class }}_from_a_data_value_object_test()
    {

        /** @var {{ class }} {{ model }} */
        ${{ model }} = {{ class }}::factory()->create();

        $object = {{ class }}Factory::make({{ class }}::factory()->raw([
            '{{ model }}_id' => ${{ model }}->id,
            ])
        );

        assertInstanceOf({{ class }}::class, {{ class }}::query()->create($object->toArray()));

    }

}
