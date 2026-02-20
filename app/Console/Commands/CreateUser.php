<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user {name} {email} {password}';

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
        $name =$this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);
        $this->info("email: {$email} | password: {$password}");
    }
}
