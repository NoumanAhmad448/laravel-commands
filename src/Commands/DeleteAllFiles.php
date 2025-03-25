<?php

namespace Eren\LaravelCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DeleteAllFiles extends Command
{
    protected $signature = 'files:delete-all {path? : The path to delete files from} {--ext= : optional file extension}';
    protected $description = 'Delete all files and folders recursively, skipping undeletable ones and logging them; For Every OS😍😍.
    Perhaps Sallary saver😘😘😘';
    private $extension;

    public function handle()
    {
        $path = $this->argument('path') ?? storage_path("logs");

        $this->info("Deleting files and directories from: $path");
        $this->extension = $this->option('ext'); // Get the file extension filter
        if ($path != storage_path("logs")) {
            $rootPath = base_path($path); // Change this if you want to delete from another path
        } else {
            $rootPath = $path;
        }
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
            $this->info("{$path} does not exist");
            return;
        }

        if ($this->extension) {
            $extension = $this->extension;
            // Get all files (filtered if ext is provided)
            $items = collect(File::files($path))
                ->filter(function ($file) use ($extension) {
                    return !$extension || $file->getExtension() === $extension;
                });

            if ($items->isEmpty()) {
                $this->info('No files found to delete.');
                return 0;
            }
        } else {
            $items = File::allFiles($path);
        }

        $total_files = count($items);
        $this->info("Total number of files to be deleted by the operations: {$total_files}");
        foreach ($items as $item) {
            try {
                $this->info("deleting file: {$item}");
                File::delete($item);
            } catch (\Exception $e) {
                $undeletedFiles[] = $item->getPathname();
            }
        }

        $directories = File::directories($path);
        $total_directores = count($directories);
        $this->info("deleting directories: {$total_directores}");
        foreach ($directories as $directory) {
            try {
                $this->warning("Stop here if you don\'t plan to delete directories.");
                $this->info("deleting directory: {$directory}");
                File::deleteDirectory($directory);
            } catch (\Exception $e) {
                $undeletedFiles[] = $directory;
            }
        }
    }
}
