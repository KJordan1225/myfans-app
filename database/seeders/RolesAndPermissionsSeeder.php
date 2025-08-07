<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run()
    {
        // Reset cached roles/permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        Permission::firstOrCreate(['name' => 'view content']);
        Permission::firstOrCreate(['name' => 'create content']);
        Permission::firstOrCreate(['name' => 'edit own content']);
        Permission::firstOrCreate(['name' => 'delete own content']);
        Permission::firstOrCreate(['name' => 'manage users']);
        Permission::firstOrCreate(['name' => 'manage site']);

        // Create roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $creator = Role::firstOrCreate(['name' => 'creator']);
        $subscriber = Role::firstOrCreate(['name' => 'subscriber']);

        // Assign permissions
        $subscriber->givePermissionTo('view content');

        $creator->givePermissionTo([
            'view content',
            'create content',
            'edit own content',
            'delete own content',
        ]);

        $admin->givePermissionTo(Permission::all());
    }

}
