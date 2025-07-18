<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupToDriveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:drive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Log::info('BackupToDriveCommand: handle() called');
        $this->info('BackupToDriveCommand executed.');
    }
}
