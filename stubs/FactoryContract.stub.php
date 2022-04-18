<?php

namespace {{ namespace }};


interface FactoryContract
{
    /**
     * @param array $attributes
     * @return \{{ namespace }}\DataValueObjectContract
     */
    public static function make(array $attributes):DataValueObjectContract;
}
