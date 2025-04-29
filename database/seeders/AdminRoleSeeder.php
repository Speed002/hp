<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'hospital admin']);

        $role->givePermissionTo(Permission::firstOrCreate(['name' => 'create users']));
        $role->givePermissionTo(Permission::firstOrCreate(['name' => 'assign roles and permissions']));
        $role->givePermissionTo(Permission::firstOrCreate(['name' => 'update hospital']));
        $role->givePermissionTo(Permission::firstOrCreate(['name' => 'profile hospital']));
    }
}
