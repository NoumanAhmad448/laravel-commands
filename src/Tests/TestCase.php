<?php

namespace Eren\LaravelCommands\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Eren\LaravelCommands\Providers\LCServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LCServiceProvider::class,
        ];
    }
}