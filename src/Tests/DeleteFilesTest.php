<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DeleteFilesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
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
        $this->artisan('files:delete-all storage/app/logs --ext=log');

        // Ensure only `.log` is deleted
        $this->assertFalse(File::exists(storage_path('app.logs/app.log')));
        $this->assertTrue(Storage::exists('logs/debug.txt'));
        Storage::delete('logs/debug.txt');
    }
    public function test_deletes_directories()
    {
        Storage::fake();

        // Create multiple file types
        Storage::put('custom/logs/app.log', 'Log content');
        Storage::put('custom/app.log', 'Log content');

        // Run command with `--ext=log`
        $this->artisan('files:delete-all storage/app/custom/app.log --ext=log');

        // Ensure only `.log` is deleted
        $this->assertFalse(File::exists(storage_path('app/custom/logs/app.log')));
        $this->assertFalse(File::exists(storage_path('app/custom/app.log')));
        $this->assertFalse(File::exists(storage_path('app/custom')) && count(File::files(storage_path('app/custom'))) > 0);
    }
}
