<?php

namespace {{ namespace }};

use {{ dataobjectnamespace }};
use {{ modelfactory }};
use {{ modelpath }};

it('can create a {{ class }} value object using a factory', function () {

    expect({{ class }}Factory::make({{ class }}::factory()->raw()))
        ->toBeInstanceOf({{ class }}DataObject::class);
});

it('can create a {{ class }} from a data value object', function () {

    /** @var {{ class }} {{ model }} */
    ${{ model }} = {{ class }}::factory()->create();

    $object = {{ class }}Factory::make({{ class }}::factory()->raw([
        '{{ model }}_id' => ${{ model }}->id,
    ]));

    expect({{ class }}::query()->create($object->toArray()))
        ->toBeInstanceOf({{ class }}::class);

});
