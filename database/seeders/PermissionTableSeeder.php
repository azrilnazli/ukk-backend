<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $controllers = ['user','video','dashboard','category','company']; // add controller name
         $actions = ['list','create','edit','delete'];

         // create permissions
         foreach ($controllers as $controller) 
         {
            foreach($actions as $action)
            {
                $$controller[] =  $controller.'-'.$action; // create $user[] , $video[]
                Permission::create(['name' => $controller.'-'.$action]);
            }
         }

        // role assignment
        $role = Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());
        $role = Role::create(['name' => 'user'])->givePermissionTo([$video,$dashboard,$category]);
        $role = Role::create(['name' => 'super-admin'])->givePermissionTo(Permission::all());
        $role = Role::create(['name' => 'subscriber'])->givePermissionTo($dashboard);

        // assign role to user
        User::find(1)->assignRole('super-admin');
        User::find(2)->assignRole('admin');
        User::find(3)->assignRole('user');
        User::find(4)->assignRole('subscriber');
    }
}
