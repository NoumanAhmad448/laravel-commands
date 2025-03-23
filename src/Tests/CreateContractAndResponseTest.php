<?php

namespace Eren\LaravelCommands\Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class CreateContractAndResponseTest extends TestCase
{
    public function test_command_creates_contract_and_response()
    {
        // Run the command
        Artisan::call('make:contract-response Auth');

        // Assert files were created
        $this->assertTrue(File::exists(app_path('Http/Contracts/AuthContract.php')));
        $this->assertTrue(File::exists(app_path('Http/Responses/AuthResponse.php')));

        // Assert binding was added to the service provider
        $providerContent = File::get(app_path('Providers/HomeController1Provider.php'));
        $this->assertStringContainsString(
            '$this->app->bind(\App\Http\Contracts\AuthContract::class, \App\Http\Responses\AuthResponse::class);',
            $providerContent
        );
    }
}
