<?php

namespace Eren\LaravelCommands\Providers;

use Illuminate\Support\ServiceProvider;
use Eren\LaravelCommands\Commands\CreateContractAndResponse;
use Eren\LaravelCommands\Commands\CustomStorageLink;
use Eren\LaravelCommands\Commands\DeleteAllFiles;

class LCServiceProvider extends ServiceProvider
{
    /**
     * Register the package's commands.
     */
    public function register()
    {
        $this->commands([
            CreateContractAndResponse::class,
            CustomStorageLink::class,
            DeleteAllFiles::class,
        ]);
    }

    /**
     * Bootstrap the package's services.
     */
    public function boot()
    {
        // Publish stubs if needed
        $this->publishes([
            __DIR__ . '/Stubs' => base_path('stubs/LC'),
        ], 'stubs');
    }
}
