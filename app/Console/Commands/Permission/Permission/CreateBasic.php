<?php

namespace App\Console\Commands\Permission\Permission;

use Illuminate\Console\Command;

class CreateBasic extends Command
{
    protected $permissions = [
        'article',
        'driver',
        'invoice',
        'owner',
        'permission',
        'product',
        'role',
        'user',
        'coupon',
        'admin'
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create-basic-permission
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
            $this->call('permission:create-combo-permission', [
                'name' => $permission,
                'guard' => $this->argument('guard')
            ]);
        }

        return Command::SUCCESS;
    }
}
