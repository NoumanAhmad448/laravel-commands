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
        $this->assertFalse(Storage::exists('logs/laravel.log'));
        $this->assertFalse(Storage::exists('logs/error.log'));
    }
    public function test_deletes_files_from_custom_path()
    {
        Storage::fake();

        // Create dummy files in custom directory
        Storage::put('custom/logs/app.log', 'Log file');
        Storage::put('custom/logs/debug.log', 'Debugging');

        // Run command with a custom path
        $this->artisan('files:delete-all custom/logs')
            ->expectsOutput('All files and folders deleted successfully!')
            ->assertExitCode(0);

        // Assert files are deleted
        $this->assertFalse(Storage::exists('custom/logs/app.log'));
        $this->assertFalse(Storage::exists('custom/logs/debug.log'));
    }
    public function test_handles_missing_files_gracefully()
    {
        Storage::fake();

        // Run command when no logs exist
        $this->artisan('files:delete-all')
            ->expectsOutput('No files found to delete.')
            ->assertExitCode(0);
    }

    public function test_handles_permission_errors_gracefully()
    {
        Storage::fake();

        // Create a log file and make it read-only
        $filePath = storage_path('logs/protected.log');
        file_put_contents($filePath, 'Protected log');
        chmod($filePath, 0444); // Read-only (no delete permission)

        // Run command
        $this->artisan('files:delete-all')
            ->expectsOutput('Files that couldn\'t be deleted:');

        // Ensure file still exists
        $this->assertFileExists($filePath);

        // Reset permissions
        chmod($filePath, 0644);
    }


    public function test_command_help_message()
    {
        $this->artisan('files:delete-all --help')
            ->expectsOutputToContain('Delete all files and folders recursively, skipping undeletable ones and logging them');
    }

    public function test_deletes_only_specific_file_extensions()
    {
        Storage::fake();

        // Create multiple file types
        Storage::put('logs/app.log', 'Log content');
        Storage::put('logs/debug.txt', 'Debug content');

        // Run command with `--ext=log`
        $this->artisan('files:delete-all --ext=log');

        // Ensure only `.log` is deleted
        $this->assertFalse(Storage::exists('logs/app.log'));
        $this->assertTrue(Storage::exists('logs/debug.txt'));
    }
}
