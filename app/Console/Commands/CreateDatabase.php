<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-database';

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
        $db = [
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'host' => env('DB_HOST'),
            'database' => env('DB_DATABASE')
        ];
        $this->comment(database_path());
        $sql_file = database_path('schema/createDB.sql');
        $this->comment("create database");
        if(PHP_OS!='Linux'){
            exec("mysql --user={$db['username']} < $sql_file",$out,$val);
        }
        else {
            exec("sudo mysql --user={$db['username']} --password={$db['password']} < $sql_file",$out,$val);
        }
        if($val==0) $this->comment("Successfully created Database in {$db['database']}");
        else $this->error("Failed to create Database");

    }
}
