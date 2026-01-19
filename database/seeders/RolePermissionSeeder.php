<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles
        $admin        = Role::create(['name' => 'admin']);
        $manager      = Role::create(['name' => 'order_manager']);
        $warehouse    = Role::create(['name' => 'warehouse']);
        $customer     = Role::create(['name' => 'customer']);

        // Permissions
        $permissions = [
            'create_order',
            'view_all_orders',
            'view_own_orders',
            'update_order_status',
            'cancel_order',
            'ship_order',
            'override_status',
        ];

        foreach ($permissions as $perm) {
            Permission::create(['name' => $perm]);
        }

        // Permission mapping
        $admin->permissions()->sync(Permission::all());

        $manager->permissions()->sync(
            Permission::whereIn('name', [
                'create_order',
                'view_all_orders',
                'update_order_status',
                'cancel_order',
            ])->pluck('id')
        );

        $warehouse->permissions()->sync(
            Permission::where('name', 'ship_order')->pluck('id')
        );

        $customer->permissions()->sync(
            Permission::whereIn('name', [
                'create_order',
                'view_own_orders',
                'cancel_order',
            ])->pluck('id')
        );
    }
}
