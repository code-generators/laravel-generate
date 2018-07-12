<?php

namespace BitPress\LaravelGenerate;

use Illuminate\Support\ServiceProvider;
use BitPress\LaravelGenerate\Console\ModelGenerateCommand;

class LaravelGenerateServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app->bind('model.generate', ModelGenerateCommand::class);

        $this->commands([
            ModelGenerateCommand::class,
        ]);
    }
}
