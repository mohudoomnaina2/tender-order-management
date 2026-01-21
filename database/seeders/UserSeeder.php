<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole     = Role::where('name', 'admin')->first();
        $managerRole   = Role::where('name', 'order_manager')->first();
        $warehouseRole = Role::where('name', 'warehouse')->first();
        $customerRole  = Role::where('name', 'customer')->first();

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@tender.com',
            'password' => Hash::make('password123'),
        ]);
        $admin->roles()->attach($adminRole);

        $manager = User::create([
            'name' => 'Order Manager',
            'email' => 'manager@tender.com',
            'password' => Hash::make('password123'),
        ]);
        $manager->roles()->attach($managerRole);

        $warehouse = User::create([
            'name' => 'Warehouse',
            'email' => 'warehouse@tender.com',
            'password' => Hash::make('password123'),
        ]);
        $warehouse->roles()->attach($warehouseRole);

        $customer = User::create([
            'name' => 'Customer',
            'email' => 'customer@tender.com',
            'password' => Hash::make('password123'),
        ]);
        $customer->roles()->attach($customerRole);
    }
}
