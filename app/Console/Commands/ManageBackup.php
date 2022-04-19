<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Artisan;

class ManageBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:manage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a backup of the database and clean up the old ones';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('backup:run', [
            '--only-db' => true,
        ]); 

        Artisan::call('backup:clean'); 

        return Command::SUCCESS;
    }
}
