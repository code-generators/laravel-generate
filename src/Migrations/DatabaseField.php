<?php

namespace BitPress\LaravelGenerate\Migrations;

class DatabaseField
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string|null
     */
    private $index;

    /**
     * @var string
     */
    private $tableVar = '$table';

    private $columnTypes = [
        'bigincrements' => 'bigIncrements',
        'biginteger' => 'bigInteger',
        'binary' => 'binary',
        'boolean' => 'boolean',
        'bool' => 'boolean',
        'char' => 'char',
        'date' => 'date',
        'datetime' => 'dateTime',
        'datetimetz' => 'dateTimeTz',
        'decimal' => 'decimal',
        'double' => 'double',
        'enum' => 'enum',
        'float' => 'float',
        'geometry' => 'geometry',
        'geometrycollection' => 'geometryCollection',
        'increments' => 'increments',
        'integer' => 'integer',
        'int' => 'integer',
        'ipaddress' => 'ipAddress',
        'json' => 'json',
        'jsonb' => 'jsonb',
        'linestring' => 'lineString',
        'longtext' => 'longText',
        'macaddress' => 'macAddress',
        'mediumincrements' => 'mediumIncrements',
        'mediuminteger' => 'mediumInteger',
        'mediumtext' => 'mediumText',
        'morphs' => 'morphs',
        'multilinestring' => 'multiLineString',
        'multipoint' => 'multiPoint',
        'multipolygon' => 'multiPolygon',
        'nullablemorphs' => 'nullableMorphs',
        'nullabletimestamps' => 'nullableTimestamps',
        'point' => 'point',
        'polygon' => 'polygon',
        'remembertoken' => 'rememberToken',
        'smallincrements' => 'smallIncrements',
        'softdeletes' => 'softDeletes',
        'softdeletestz' => 'softDeletesTz',
        'string' => 'string',
        'str' => 'string',
        'text' => 'text',
        'time' => 'time',
        'timetz' => 'timeTz',
        'timestamp' => 'timestamp',
        'timestamptz' => 'timestampTz',
        'timestamps' => 'timestamps',
        'timestampstz' => 'timestampsTz',
        'tinyincrements' => 'tinyIncrements',
        'tinyinteger' => 'tinyInteger',
        'unsignedbiginteger' => 'unsignedBigInteger',
        'unsigneddecimal' => 'unsignedDecimal',
        'unsignedinteger' => 'unsignedInteger',
        'unsignedmediuminteger' => 'unsignedMediumInteger',
        'unsignedsmallinteger' => 'unsignedSmallInteger',
        'unsignedtinyinteger' => 'unsignedTinyInteger',
        'uuid' => 'uuid',
        'year' => 'year',
    ];

    /**
     * @param  string $name The database column name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param  string $type The database field type
     * @return self
     */
    public function setType($type)
    {
        // @todo validate type
        $this->type = $this->parseType($type);

        return $this;
    }

    /**
     * @param  string $index The database index name for this field
     * @return self
     */
    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }

    /**
     * Override the migration table variable name
     *
     * @param  string The PHP variable representing the table in a migration
     * @return self
     */
    public function setTableVar($name)
    {
        $this->tableVar = $name;

        return $this;
    }

    public function __toString()
    {
        return vsprintf('%s->%s(\'%s\');', [
            $this->tableVar, $this->type, $this->name
        ]);
    }

    private function parseType($type)
    {
        if (! $field = $this->columnTypes[strtolower($type)] ?? null) {
            throw new \RuntimeException(sprintf('Invalid database field type "%s".', $type));
        }

        return $field;
    }
}
