<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class CreateStylesheets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stylesheets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build stylesheets';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $config = file_get_contents(base_path('stubs/vite.config.stub'));
        $files = glob(storage_path('tailwind/*.js'));
        foreach ($files as $file) {
            $utility = pathinfo($file, PATHINFO_FILENAME);
            $this->alert('Build '.$utility);
            $safelist = file_get_contents($file);

            file_put_contents(base_path('tailwind.safelist.js'), $safelist);
            file_put_contents(base_path('vite.config.js'), str_replace('{utility}', $utility, $config));

            $result = Process::run('npm run build');
            $this->line($result->output());
            Storage::disk('htdocs')->copy('build/'.$utility.'.css', 'css/'.$utility.'.css');
        }
    }
}
