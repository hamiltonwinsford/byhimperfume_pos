<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create roles
        $role_admin = Role::updateOrCreate(
            [
                'name' => 'admin'
            ],
            [
                'name' => 'admin'
            ]
        );


        $role_staff = Role::updateOrCreate(
            [
                'name' => 'staff'
            ],
            [
                'name' => 'staff'
            ]
        );

        $role_cashier = Role::updateOrCreate(
            [
                'name' => 'cashier'
            ],
            [
                'name' => 'cashier'
            ]
            );

        //Create permissions
        $permission = Permission::updateOrCreate(
            [
                'name' => 'view_dashboard'
            ],
            [
                'name' => 'view_dashboard'
            ]
        );

        $permission_create_product = Permission::updateOrCreate(
            [
                'name' => 'create_product'
            ],
            [
                'name' => 'create_product'
            ]
        );

        $permission_update_product = Permission::updateOrCreate(
            [
                'name' => 'update_product'
            ],
            [
                'name' => 'update_product'
            ]
        );

        $permission_delete_product = Permission::updateOrCreate(
            [
                'name' => 'delete_product'
            ],
            [
                'name' => 'delete_product'
            ]
        );

        $permission_create_user = Permission::updateOrCreate(
            [
                'name' => 'create_user'
            ],
            [
                'name' => 'create_user'
            ]
        );

        $permission_update_user = Permission::updateOrCreate(
            [
                'name' => 'update_user'
            ],
            [
                'name' => 'update_user'
            ]
        );

        $permission_delete_user = Permission::updateOrCreate(
            [
                'name' => 'delete_user'
            ],
            [
                'name' => 'delete_user'
            ]
        );

        $role_admin->givePermissionTo(Permission::all());
        $role_staff->givePermissionTo([
            'view_dashboard',
            'create_product',
            'update_product',
            'delete_product',
            'create_user'
        ]);
    }
}
