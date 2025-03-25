<?php

namespace Eren\LaravelCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DeleteAllFiles extends Command
{
    protected $signature = 'files:delete-all {path? : The path to delete files from} {--ext= : optional file extension}';
    protected $description = 'Delete all files and folders recursively, skipping undeletable ones and logging them; only for linux and mac';
    private $extension;

    public function handle()
    {
        $path = $this->argument('path') ?? storage_path("logs");

        $this->info("Deleting files and directories from: $path");
        $this->extension = $this->option('ext'); // Get the file extension filter

        $rootPath = base_path($path); // Change this if you want to delete from another path
        $undeletedFiles = [];

        // OS Detection
        $os = PHP_OS_FAMILY;
        $this->info("Operating System: $os");

        // Deletion Process
        $this->deleteFilesRecursively($rootPath, $undeletedFiles);

        // Display Results
        if (!empty($undeletedFiles)) {
            $this->warn("\nFiles that couldn't be deleted:");
            foreach ($undeletedFiles as $file) {
                $this->line("- " . $file);
            }
            $this->warn("\nTotal undeleted files: " . count($undeletedFiles));
        } else {
            $this->info("\nAll files and folders deleted successfully!");
        }
    }

    private function deleteFilesRecursively($path, &$undeletedFiles)
    {
        if (!File::exists($path)) {
            return;
        }

        if ($this->extension) {
            $extension = $this->extension;
            // Get all files (filtered if ext is provided)
            $items = collect(File::files(base_path($path)))
                ->filter(function ($file) use ($extension) {
                    return !$extension || $file->getExtension() === $extension;
                });

            if ($items->isEmpty()) {
                $this->info('No files found to delete.');
                return 0;
            }
        }else{
            $items = File::allFiles($path);
        }
        foreach ($items as $item) {
            try {
                File::delete($item);
            } catch (\Exception $e) {
                $undeletedFiles[] = $item->getPathname();
            }
        }

        $directories = File::directories($path);
        foreach ($directories as $directory) {
            try {
                File::deleteDirectory($directory);
            } catch (\Exception $e) {
                $undeletedFiles[] = $directory;
            }
        }
    }
}
