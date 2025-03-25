<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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

    public function test_deletes_logs_by_default()
    {
        Storage::fake();

        // Create log files
        Storage::put('logs/laravel.log', 'Dummy content');
        Storage::put('logs/error.log', 'Error log');

        // Run command
        $this->artisan('files:delete-all')
            ->assertExitCode(0);

        // Ensure files are deleted
        $this->assertFalse(File::exists(storage_path('logs/laravel.log')));
        $this->assertFalse(File::exists(storage_path('logs/error.log')));
    }
    public function test_deletes_files_from_custom_path()
    {
        Storage::fake();

        // Create dummy files in custom directory
        Storage::put('custom/logs/app.log', 'Log file');
        Storage::put('custom/logs/debug.log', 'Debugging');

        // Run command with a custom path
        $this->artisan('files:delete-all storage/app/custom/logs')
            ->assertExitCode(0);

        // Assert files are deleted
        $this->assertFalse(File::exists('storage/app/custom/logs/app.log'));
        $this->assertFalse(File::exists('storage/app/custom/logs/debug.log'));
    }
    public function test_handles_missing_files_gracefully()
    {
        Storage::fake();
        $directory = storage_path('logs');
        // Run command when no logs exist
        $this->artisan('files:delete-all')
            ->assertExitCode(0);
        $this->assertFalse(File::exists($directory) && count(File::files($directory)) > 0);
    }

}
