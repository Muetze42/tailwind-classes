<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use NormanHuth\Helpers\Exception\FileNotFoundException;
use NormanHuth\Helpers\Package;

class UpdateReadme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Readme';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update README.md';

    /**
     * Execute the console command.
     *
     * @throws FileNotFoundException
*/
    public function handle(): void
    {
        $files = glob(public_path('css/*.css'));
        $stylesheets = [];
        foreach ($files as $file) {
            $file = pathinfo($file, PATHINFO_FILENAME);
            $stylesheets[] = '* ['.$file.'](public/css/'.$file.'.css)';
        }

        $replace = [
            '{version}' => Package::getPackageLockJsonValue('dependencies')['tailwindcss']['version'],
            '{stylesheets}' => implode("\n", $stylesheets),
        ];

        $readme = str_replace(
            array_keys($replace),
            array_values($replace),
            file_get_contents(base_path('stubs/README.stub'))
        );

        file_put_contents(base_path('README.md'), $readme);
    }
}
