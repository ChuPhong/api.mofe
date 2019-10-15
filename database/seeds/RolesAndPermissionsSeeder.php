<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'management.login', 'guard_name' => 'api']);
        Permission::create(['name' => 'management.logout', 'guard_name' => 'api']);

        Permission::create(['name' => 'management.users.all', 'guard_name' => 'api']);
        Permission::create(['name' => 'management.users.store', 'guard_name' => 'api']);
        Permission::create(['name' => 'management.users.show', 'guard_name' => 'api']);
        Permission::create(['name' => 'management.users.update', 'guard_name' => 'api']);
        Permission::create(['name' => 'management.users.update.expect.role', 'guard_name' => 'api']);
        Permission::create(['name' => 'management.users.destroy', 'guard_name' => 'api']);

        Permission::create(['name' => 'management.songs.all', 'guard_name' => 'api']);
        Permission::create(['name' => 'management.songs.store', 'guard_name' => 'api']);
        Permission::create(['name' => 'management.songs.destroy', 'guard_name' => 'api']);

        Permission::create(['name' => 'management.artists.all', 'guard_name' => 'api']);
        Permission::create(['name' => 'management.artists.store', 'guard_name' => 'api']);
        Permission::create(['name' => 'management.artists.destroy', 'guard_name' => 'api']);

        /** @var \Spatie\Permission\Contracts\Role|Role $role */

        // Create roles and assign created permissions
        Role::create(['name' => 'user', 'guard_name' => 'api']);

        $role = Role::create(['name' => 'moderator', 'guard_name' => 'api']);
        $role->syncPermissions([
            'management.login',
            'management.logout',
            'management.users.all',

            'management.songs.all',
            'management.songs.store',

            'management.artists.all',
            'management.artists.store',
        ]);

        $role = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $role->syncPermissions(Permission::all());
    }
}
