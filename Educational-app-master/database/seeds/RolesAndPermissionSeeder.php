<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // // create permissions
        // Permission::create(['name' => 'edit articles']);
        // Permission::create(['name' => 'delete articles']);
        // Permission::create(['name' => 'publish articles']);
        // Permission::create(['name' => 'unpublish articles']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'super_admin']);
        $role = Role::create(['name' => 'sub_admin']);
        $role = Role::create(['name' => 'students']);
        $role = Role::create(['name' => 'general']);
        

        // or may be done by chaining
            // ->givePermissionTo(['publish articles', 'unpublish articles']);

        $role = Role::create(['name' => 'super_admin']);
        $role->givePermissionTo(Permission::all());
    }
}
