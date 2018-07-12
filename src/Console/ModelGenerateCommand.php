<?php

namespace BitPress\LaravelGenerate\Console;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Foundation\Console\ModelMakeCommand;

class ModelGenerateCommand extends ModelMakeCommand
{
    protected $name = 'g:model';

    public function handle()
    {
    }

    public function getStub()
    {
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the class'],
            ['columns', InputArgument::IS_ARRAY, 'Columns for the database.'],
        ];
    }
}
