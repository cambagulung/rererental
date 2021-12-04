<?php

namespace App\Console\Commands\Permission\Permission;

use Illuminate\Console\Command;

class CreateCombo extends Command
{
    protected $permissions = [
        'manage',
        'create',
        'read',
        'update',
        'delete',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create-combo-permission
                {name : The name of the permission}
                {guard? : The name of the guard}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a combo permissions in one command';

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
        foreach ($this->permissions as $permission)
        {
            $this->call('permission:create-permission', [
                'name' => $this->argument('name') . '.' . $permission,
                'guard' => $this->argument('guard')
            ]);
        }

        return Command::SUCCESS;
    }
}
