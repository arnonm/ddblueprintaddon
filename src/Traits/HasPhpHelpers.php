<?php
declare(strict_types=1);

namespace Arnonm\DDBlueprintAddon\Traits;

trait HasPhpHelpers
{


    protected function phpDataType(string $dataType)
    {
        static $php_data_types = [
            'id' => 'int',
            'uuid' => 'string',
            'bigincrements' => 'int',
            'biginteger' => 'int',
            'boolean' => 'bool',
            'date' => '\Carbon\Carbon',
            'datetime' => '\Carbon\Carbon',
            'datetimetz' => '\Carbon\Carbon',
            'decimal' => 'float',
            'double' => 'double',
            'float' => 'float',
            'increments' => 'int',
            'integer' => 'int',
            'mediumincrements' => 'int',
            'mediuminteger' => 'int',
            'nullabletimestamps' => '\Carbon\Carbon',
            'smallincrements' => 'int',
            'smallinteger' => 'int',
            'softdeletes' => '\Carbon\Carbon',
            'softdeletestz' => '\Carbon\Carbon',
            'time' => '\Carbon\Carbon',
            'timetz' => '\Carbon\Carbon',
            'timestamp' => '\Carbon\Carbon',
            'timestamptz' => '\Carbon\Carbon',
            'timestamps' => '\Carbon\Carbon',
            'timestampstz' => '\Carbon\Carbon',
            'tinyincrements' => 'integer',
            'tinyinteger' => 'int',
            'unsignedbiginteger' => 'int',
            'unsigneddecimal' => 'float',
            'unsignedinteger' => 'int',
            'unsignedmediuminteger' => 'int',
            'unsignedsmallinteger' => 'int',
            'unsignedtinyinteger' => 'int',
            'year' => 'int',
        ];

        return $php_data_types[strtolower($dataType)] ?? 'string';
    }

    private function fillableColumns(array $columns)
    {
        return array_diff(
            array_keys($columns),
            [
                'id',
                'deleted_at',
                'created_at',
                'updated_at',
                'remember_token',
                'softdeletes',
                'softdeletestz',
            ]
        );
    }

    private function phpValType(string $dataType)
    {
        static $php_data_types = [
            'id' => 'intval',
            'uuid' => 'strval',
            'bigincrements' => 'intval',
            'biginteger' => 'intval',
            'boolean' => 'boolval',
            'date' => '',
            'datetime' => '',
            'datetimetz' => '',
            'decimal' => 'floatval',
            'increments' => 'intval',
            'integer' => 'intval',
            'mediumincrements' => 'intval',
            'mediuminteger' => 'intval',
            'mediumText' => 'strval',
            'nullabletimestamps' => '',
            'smallincrements' => 'intval',
            'smallinteger' => 'intval',
            'string'    => 'strval',
            'time' => '',
            'timetz' => '',
            'timestamp' => '',
            'timestamptz' => '',
            'timestamps' => '',
            'timestampstz' => '',
            'tinyincrements' => 'intval',
            'tinyinteger' => 'intval',
            'unsignedbiginteger' => 'intval',
            'unsigneddecimal' => 'floatval',
            'unsignedinteger' => 'intval',
            'unsignedmediuminteger' => 'intval',
            'unsignedsmallinteger' => 'intval',
            'unsignedtinyinteger' => 'intval',
            'year' => 'intval',
        ];
        return $php_data_types[strtolower($dataType)] ?? 'strval';
    }

    protected function supportsReadOnly(): bool
    {
       return (PHP_VERSION_ID > 80100);
    }
}
