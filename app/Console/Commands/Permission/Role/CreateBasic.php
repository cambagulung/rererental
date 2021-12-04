<?php

namespace App\Console\Commands\Permission\Role;

use Illuminate\Console\Command;

class CreateBasic extends Command
{
    protected $roles = [
        'admin',
        'driver',
        'owner',
        'admin',
        'security',
        'service',
        'super'
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create-basic-role
                {guard? : The name of the guard}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a basic role in one command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach ($this->roles as $role)
        {
            $this->call('permission:create-role', [
                'name' => $role,
                'guard' => $this->argument('guard')
            ]);
        }

        return Command::SUCCESS;
    }
}
