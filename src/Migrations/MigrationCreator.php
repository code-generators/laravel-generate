<?php

namespace BitPress\LaravelGenerate\Migrations;

use RuntimeException;
use Illuminate\Database\Migrations\MigrationCreator as LaravelMigrationCreator;

class MigrationCreator extends LaravelMigrationCreator
{
    /**
     * Create a new migration at the given path.
     *
     * @param  string  $name
     * @param  string  $path
     * @param  string  $table
     * @param  bool    $create
     * @param  array   $fields
     * @return string
     * @throws \Exception
     */
    public function create($name, $path, $table = null, $create = false, array $fields = [])
    {
        $this->ensureMigrationDoesntAlreadyExist($name);

        // First we will get the stub file for the migration, which serves as a type
        // of template for the migration. Once we have those we will populate the
        // various place-holders, save the file, and run the post create event.
        $stub = $this->getStub($table, $create);

        $this->files->put(
            $path = $this->getPath($name, $path),
            $this->populateStub($name, $stub, $table, $fields)
        );

        // Next, we will fire any hooks that are supposed to fire after a migration is
        // created. Once that is done we'll be ready to return the full path to the
        // migration file so it can be used however it's needed by the developer.
        $this->firePostCreateHooks($table);

        return $path;
    }

    public function stubPath()
    {
        return __DIR__.'/../../resources/stubs/migrations';
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
    protected function populateStub($name, $stub, $table, array $fields = [])
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

        $stub = str_replace('%fields%', implode("\n".str_repeat(' ', 12), $fieldStr), $stub);

        // @todo add indexes
        $stub = str_replace('%indexes%', '', $stub);
        
        return $stub;
    }

    /**
     * Convert the database field
     *
     * @throws RuntimeException
     * @return \BitPress\LaravelGenerate\Migrations\DatabaseField
     */
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
            default:
                throw new RuntimeException(sprintf('Unknown field type "%s".', $fieldArg));
        }

        return $field;
    }
}
