<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RenameFilesCommand extends Command
{
    protected $signature = 'rename:files';

    protected $description = 'Remove a specific substring from the names of files in the public/songs folder';

    public function handle()
    {
        $folderPath = public_path('songs'); // Path to the public/songs folder
        $substringToRemove = 'spotifydown.com - ';

        $files = File::files($folderPath);

        foreach ($files as $file) {
            $filename = $file->getFilename();

            if (strpos($filename, $substringToRemove) !== false) {
                $newFilename = str_replace($substringToRemove, '', $filename);
                $newPath = $file->getPath() . DIRECTORY_SEPARATOR . $newFilename;

                File::move($file->getPathname(), $newPath);

                $this->info("Renamed: {$filename} -> {$newFilename}");
            }
        }

        $this->info('Files renamed successfully!');
    }
}
