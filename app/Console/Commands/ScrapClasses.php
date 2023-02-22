<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScrapClasses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrap classes from tailwind.com docs';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $sites = config('tailwind.docs');

        foreach ($sites as $site) {
            $this->info('Visit '.$site);
            $site = 'https://tailwindcss.com/'.$site;
            $content = file_get_contents($site);

            $rows = explode('<tr>', $content);
            $first = true;
            $classes = [];
            $js = 'module.exports = [';
            foreach ($rows as $row) {
                if ($first) {
                    $first = false;
                    continue;
                }
                if (!str_contains($row, '<th')) {
                    $class = explode('>', $row)[1];
                    $class = explode('<', $class)[0];

                    $classes[] = $class;
                    $js.= "\n    '".$class."',";
                }
            }
            $js.= "\n]";

            $file = storage_path('tailwind/'.basename($site).'.json');
            file_put_contents($file, json_encode($classes, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

            $file = storage_path('tailwind/'.basename($site).'.js');
            file_put_contents($file, $js);
            //sleep(1);
        }
    }
}
