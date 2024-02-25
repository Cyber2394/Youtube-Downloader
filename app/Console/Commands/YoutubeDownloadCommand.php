<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class YoutubeDownloadCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:youtube-download-command {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download a video using yt-dlp';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Retrieve the URL argument passed to the command
        $url = $this->argument('url');

        $url = escapeshellarg($url);

        $descriptors = [
            0 => ['pipe', 'r'], // STDIN
            1 => ['pipe', 'w'], // STDOUT
            2 => ['pipe', 'w'], // STDERR
        ];

        $pipes = [];
        $directory = 'C:\temp';

        // Escape the directory path for use in the command
        $escapedDirectory = escapeshellarg($directory);

        // Use cmd /C instead of cmd /K to close the terminal window
        $process = proc_open('start cmd /C "cd /D ' . $escapedDirectory . ' && C:\ytldp\yt-dlp.exe --extract-audio --audio-format mp3 ' . escapeshellarg($url) . '"', $descriptors, $pipes, null);

        // Close the pipes
        foreach ($pipes as $pipe) {
            fclose($pipe);
        }
        // Close the process
        proc_close($process);

        $this->info("Downloaded video with URL: $url");
    }
}