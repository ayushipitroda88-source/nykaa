<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Super Admin', 'slug' => 'super-admin', 'description' => 'Full system access', 'status' => true],
            ['name' => 'Admin', 'slug' => 'admin', 'description' => 'Administrative access', 'status' => true],
            ['name' => 'Manager', 'slug' => 'manager', 'description' => 'Manager level access', 'status' => true],
            ['name' => 'Support', 'slug' => 'support', 'description' => 'Customer support access', 'status' => true],
            ['name' => 'Warehouse', 'slug' => 'warehouse', 'description' => 'Warehouse management access', 'status' => true],
            ['name' => 'Finance', 'slug' => 'finance', 'description' => 'Finance department access', 'status' => true],
            ['name' => 'Marketing', 'slug' => 'marketing', 'description' => 'Marketing team access', 'status' => true],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}