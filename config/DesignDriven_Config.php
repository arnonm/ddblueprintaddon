<?php

return [

    'app' => [
        'class_namespace' => 'App',
    ],

    'dataObjects' => [
        'class_namespace' => 'DataObjects',
    ],

    'factories' => [
        'class_namespace' => 'Factories',
    ],

    'contracts' => [
        'class_namespace' => 'Contracts',
    ],

    'test' => [
        'class_namespace' => 'Tests',
        'type'             => 'Pest',           // or PhpUnit
    ]
];
