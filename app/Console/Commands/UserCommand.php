<?php

namespace App\Console\Commands;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class UserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:set';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        Permission::find(1)->where('name','scoring-list')->delete();
        Permission::create(['name' =>'scoring-list']);

        Permission::find(1)->where(['name' =>'scoring-create'])->delete();
        Permission::create(['name' =>'scoring-create']);

        Permission::find(1)->where(['name' =>'scoring-edit'])->delete();
        Permission::create(['name' =>'scoring-edit']);

        Permission::find(1)->where(['name' =>'scoring-delete'])->delete();
        Permission::create(['name' =>'scoring-delete']);

        // $role->revokePermissionTo($permission);
        // $permission->removeRole($role);

        $users = User::role('user')->get(); // Returns only users with the role 'writer'
       // $users->revokePermissionTo('scoring-list');
        $users->givePermissionTo('scoring-list');
        $users->givePermissionTo('scoring-create');
        $users->givePermissionTo('scoring-edit');
        $users->givePermissionTo('scoring-delete');





    }
}
