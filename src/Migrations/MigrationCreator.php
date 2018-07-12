<?php

namespace BitPress\LaravelGenerate\Migrations;

use Illuminate\Database\Migrations\MigrationCreator as LaravelMigrationCreator;

class MigrationCreator extends LaravelMigrationCreator
{
    public function stubPath()
    {
        return __DIR__.'/../../resources/stubs';
    }

    /**
     * Get the migration stub file.
     *
     * @param  string  $table
     * @param  bool    $create
     * @return string
     */
    protected function getStub($table, $create)
    {
        $stub = $create ? 'create.stub' : 'update.stub';

        return $this->files->get($this->stubPath()."/{$stub}");
    }

    /**
     * Populate the place-holders in the migration stub.
     *
     * @param  string  $name
     * @param  string  $stub
     * @param  string  $table
     * @return string
     */
    protected function populateStub($name, $stub, $table, ...$fields)
    {
        $stub = parent::populateStub($name, $stub, $table);

        return $this->addFields($stub, $fields);
    }

    protected function addFields($stub, $fieldArgs)
    {
        $fields = [];
        $fieldStr = [];

        foreach ($fieldArgs as $field) {
            $f = $this->parseField($field);
            $fields[] = $f;
            $fieldStr[] = (string) $f;
        }

        $stub = str_replace('%fields%', implode("\n", $fieldStr), $stub);

        // @todo add indexes
        $stub = str_replace('%indexes%', '', $stub);
        
        return $stub;
    }

    protected function parseField($fieldArg)
    {
        $parts = explode(':', $fieldArg);
        $field = new DatabaseField();
        switch (count($field)) {
            // eg: title
            case 1:
                $field->setName($parts[0])
                      ->setType('string');
                break;
            // eg: created_at:datetime
            case 2:
                $field->setName($parts[0])
                      ->setType($parts[1]);
                break;
            
            // eg: created_at:datetime:index
            case 3:
                $field->setName($parts[0])
                      ->setType($parts[1])
                      ->setIndex($parts[2]);
                break;
        }
    }
}
