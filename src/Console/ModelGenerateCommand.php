<?php

namespace BitPress\LaravelGenerate\Console;

use Illuminate\Support\Str;
use Illuminate\Support\Composer;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Foundation\Console\ModelMakeCommand;
use BitPress\LaravelGenerate\Migrations\MigrationCreator;

class ModelGenerateCommand extends GeneratorCommand
{
    protected $name = 'g:model';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * The migration creator instance.
     *
     * @var \Bitpress\LaravelGenerate\Migrations\MigrationCreator
     */
    protected $creator;

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  \Bitpress\LaravelGenerate\Migrations\MigrationCreator
     * @param  \Illuminate\Support\Composer  $composer
     * @return void
     */
    public function __construct(Filesystem $files, MigrationCreator $creator, Composer $composer)
    {
        parent::__construct($files);

        $this->creator = $creator;
        $this->composer = $composer;
    }

    public function handle()
    {
        if (parent::handle() === false) {
            return;
        }

        $table = Str::plural(Str::snake(class_basename($this->argument('name'))));
        $name = "create_{$table}_table";
        $create = true;

        $this->writeMigration($name, $table, $create, $this->argument('columns') ?? []);

        // @todo dump the composer autoloader
    }
    
    /**
     * Write the migration file to disk.
     *
     * @param  string  $name
     * @param  string  $table
     * @param  bool    $create
     * @return string
     */
    protected function writeMigration($name, $table, $create, array $fields = [])
    {
        $file = pathinfo($this->creator->create(
            $name,
            $this->getMigrationPath(),
            $table,
            $create,
            $fields
        ), PATHINFO_FILENAME);

        $this->line("<info>Created Migration:</info> {$file}");
    }

    /**
     * Get the path to the migration directory.
     *
     * @return string
     */
    protected function getMigrationPath()
    {
        return $this->laravel->databasePath().DIRECTORY_SEPARATOR.'migrations';
    }

    protected function getStub()
    {
        return __DIR__.'/../../resources/stubs/models/model.stub';
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the class'],
            ['columns', InputArgument::IS_ARRAY, 'Columns for the database.'],
        ];
    }
}
