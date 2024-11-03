<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Launcher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:launcher';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the app';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('key:generate');
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('app:create-database');
    }
}
