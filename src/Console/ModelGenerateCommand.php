<?php

namespace BitPress\LaravelGenerate\Console;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Foundation\Console\ModelMakeCommand;

class ModelGenerateCommand extends GeneratorCommand
{
    protected $name = 'g:model';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    public function handle()
    {
        if (parent::handle() === false) {
            return;
        }
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
