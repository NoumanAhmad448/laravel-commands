<?php

namespace Eren\LaravelCommands\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    // use RefreshDatabase;  // This will ensure fresh database for each test

    protected function setUp(): void
    {
        parent::setUp();
    }
    public function createApplication()
    {
        return app();
    }
}
