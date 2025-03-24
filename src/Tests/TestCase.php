<?php

namespace Eren\LaravelCommands\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Eren\LaravelCommands\Providers\LCServiceProvider;

abstract class TestCase extends BaseTestCase
{

    protected function getPackageProviders($app)
    {
        return [
            LCServiceProvider::class,
        ];
    }
}