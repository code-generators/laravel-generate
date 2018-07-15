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
        $this->type = $type;

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
}
