<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage questions']);
        Permission::create(['name' => 'delete questions']);
        Permission::create(['name' => 'create question']);
        Permission::create(['name' => 'highlight answer']);
        Permission::create(['name' => 'create answers']);
        Permission::create(['name' => 'manage answers']);
        Permission::create(['name' => 'delete answers']);
        
        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(['manage users',
            'delete questions',
            'manage questions',
            'create question',
            'create answers',
            'highlight answer',
            'manage answers',
            'delete answers']);

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo(['delete questions',
            'create question',
            'create answers',
            'highlight answer',
            'delete answers']);
    }
}