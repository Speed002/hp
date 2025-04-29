<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'super admin']);

        $role->givePermissionTo(Permission::firstOrCreate(['name' => 'update hospital']));
        $role->givePermissionTo(Permission::firstOrCreate(['name' => 'profile hospitals']));
        $role->givePermissionTo(Permission::firstOrCreate(['name' => 'manage hospitals']));
        $role->givePermissionTo(Permission::firstOrCreate(['name' => 'manage departments']));
        $role->givePermissionTo(Permission::firstOrCreate(['name' => 'manage roles and permissions']));
    }
}
