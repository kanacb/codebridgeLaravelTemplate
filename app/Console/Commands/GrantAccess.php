<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GrantAccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:grant-access';

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
        $sql_file = database_path('schema/grantUser.sql');
        $this->comment("grant User");
        if(PHP_OS!='Linux'){
            $exec = "mysql --user={$db['username']} --password={$db['password']} --database={$db['database']} < $sql_file";
            $this->comment($exec);
            exec($exec,$out,$val);
        }
        else {
            $exec = "sudo mysql --user={$db['username']} --password={$db['password']} --database={$db['database']} < $sql_file";
            $this->comment($exec);
            exec($exec,$out,$val);
        }
        if($val==0) $this->comment("Successfully Granted User to {$db['database']}");
        else $this->error("Failed to Grant User");
    }
}
