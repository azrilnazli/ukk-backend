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
        // create User
         $user = User::create([
            'name' => 'JSPD',
            'email' => 'jspd@local',
            'password' => bcrypt('password')
        ]);

        // create role
        $role = Role::create(['name' => 'JSPD']); // create Role

        // assign role to user
        $user->assignRole('JSPD'); // assign
        //$user->removeRole('JSPD'); // remove

        // create Permission
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions(); // clear cache
        $permissions = [
            'scoring-list',
            'scoring-create',
            'scoring-edit',
            'scoring-delete',
         ];

         // create permission and assign to role
         foreach ($permissions as $permission) {
            Permission::find(1)->where('name',$permission)->delete(); // delete existing
            Permission::create(['name' =>$permission]); // create new
            //$user->givePermissionTo($permission); // assign user to each permission
            $role->givePermissionTo($permission); // assign each permission to role
         }
        // $users = User::role('JSPD')->get(); // Returns only users with the role 'JSPD'
        // $roles = Role::pluck('name', 'id')->toArray(); // list all registered roles

        // $role = Role::findOrFail($request->id); $role->delete()
        // $role = Role::findByName('JSPD');
        // $role->delete();
        // $perm = Permission::findByName("write post");
        // $perm->delete();
    }
}
