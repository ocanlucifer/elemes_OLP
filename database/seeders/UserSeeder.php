<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cahced roles and permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create']);
        Permission::create(['name' => 'update']);
        Permission::create(['name' => 'delete']);
        Permission::create(['name' => 'get_statistic']);
        Permission::create(['name' => 'get_data']);

        //create roles and assign existing permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('create');
        $adminRole->givePermissionTo('update');
        $adminRole->givePermissionTo('delete');
        $adminRole->givePermissionTo('get_statistic');

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo('get_data');

        $superadminRole = Role::create(['name' => 'super-admin']);
        // gets all permissions via Gate::before rule

        // create demo users
        $user = User::create([
            'name' => 'user',
            'fullname' => 'Test User',
            'email' => 'user@olp.com',
            'password' => bcrypt('12345678')
        ]);
        $user->assignRole($userRole);

        $user = User::create([
            'name' => 'admin',
            'fullname' => 'Test Admin',
            'email' => 'admin@olp.com',
            'password' => bcrypt('12345678')
        ]);
        $user->assignRole($adminRole);

        $user = User::create([
            'name' => 'superadmin',
            'fullname' => 'Test Superadmin',
            'email' => 'superadmin@olp.com',
            'password' => bcrypt('12345678')
        ]);
        $user->assignRole($superadminRole);
    }
}
