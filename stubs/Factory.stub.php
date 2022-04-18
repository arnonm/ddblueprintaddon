<?php

namespace {{ namespace }};

use {{ contractnamespace }};
use {{ dataobjectnamespace }};
use \Carbon;

class {{ class }}Factory implements FactoryContract
{

    /**
     * @inheritDoc
     */
    public static function make(array $attributes): {{ class }}DataObject
    {

        return new {{ class }}DataObject(
            ArraySlot
        );
    }
}
