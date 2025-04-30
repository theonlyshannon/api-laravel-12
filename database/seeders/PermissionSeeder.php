<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'users-list']);
        Permission::create(['name' => 'users-create']);
        Permission::create(['name' => 'users-edit']);
        Permission::create(['name' => 'users-delete']);

        Permission::create(['name' => 'roles-list']);
        Permission::create(['name' => 'roles-create']);
        Permission::create(['name' => 'roles-edit']);
        Permission::create(['name' => 'roles-delete']);

        Permission::create(['name' => 'permissions-list']);
        Permission::create(['name' => 'permissions-create']);
        Permission::create(['name' => 'permissions-edit']);
        Permission::create(['name' => 'permissions-delete']);

        // Assign permissions to roles
        $adminRole = Role::findByName('admin');
        $userRole = Role::findByName('user');

        // Admin gets all permissions
        $adminRole->givePermissionTo([
            'users-list',
            'users-create',
            'users-edit',
            'users-delete',

            'roles-list',
            'roles-create',
            'roles-edit',
            'roles-delete',

            'permissions-list',
            'permissions-create',
            'permissions-edit',
            'permissions-delete',

        ]);

        // User only gets view permissions
        $userRole->givePermissionTo([
            'users-list',
            'roles-list',
            'permissions-list'
        ]);
    }
}