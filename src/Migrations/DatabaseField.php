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

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function setType($type)
    {
        // @todo validate type
        $this->type = $type;

        return $this;
    }

    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }

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
