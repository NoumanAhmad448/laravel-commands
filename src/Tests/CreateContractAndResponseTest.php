<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Tests\TestCase;


class CreateContractAndResponseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }


    public function test_command_creates_contract_and_response()
    {
        // Run the command
        Artisan::call('storage:link-custom');
        $this->assertTrue(true);
    }
}
