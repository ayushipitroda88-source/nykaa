<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Services\PermissionService;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Sync all permissions from the definition
        PermissionService::syncPermissions(true);

        // Assign all permissions to Super Admin role
        $superAdmin = Role::where('slug', 'super-admin')->first();
        if ($superAdmin) {
            $allPermissions = \App\Models\Permission::pluck('slug')->toArray();
            PermissionService::assignPermissionsToRole($superAdmin, $allPermissions);
            $this->command->info('All permissions assigned to Super Admin role.');
        }

        // Assign default permissions to Admin role
        $admin = Role::where('slug', 'admin')->first();
        if ($admin) {
            $adminPermissions = [
                'dashboard_view',
                'products_view', 'products_create', 'products_edit', 'products_delete', 'products_approve', 'products_reject', 'products_export',
                'variants_view', 'variants_create', 'variants_edit', 'variants_delete',
                'categories_view', 'categories_create', 'categories_edit', 'categories_delete',
                'collections_view', 'collections_create', 'collections_edit', 'collections_delete',
                'brands_view', 'brands_create', 'brands_edit', 'brands_delete',
                'seller_management_view', 'seller_management_create', 'seller_management_edit', 'seller_management_delete', 'seller_management_approve', 'seller_management_reject',
                'customer_management_view', 'customer_management_create', 'customer_management_edit', 'customer_management_delete', 'customer_management_export',
                'orders_view', 'orders_approve', 'orders_reject', 'orders_export',
                'request_center_view', 'request_center_create', 'request_center_edit', 'request_center_delete', 'request_center_approve', 'request_center_reject',
                'analytics_view', 'analytics_export',
                'staff_view', 'staff_create', 'staff_edit', 'staff_delete', 'staff_manage',
                'settings_view', 'settings_manage',
            ];
            PermissionService::assignPermissionsToRole($admin, $adminPermissions);
            $this->command->info('Default permissions assigned to Admin role.');
        }

        // Assign permissions to Manager role
        $manager = Role::where('slug', 'manager')->first();
        if ($manager) {
            $managerPermissions = [
                'dashboard_view',
                'products_view', 'products_create', 'products_edit', 'products_approve', 'products_reject', 'products_export',
                'variants_view', 'variants_create', 'variants_edit',
                'categories_view', 'categories_create', 'categories_edit',
                'collections_view', 'collections_create', 'collections_edit',
                'brands_view', 'brands_create', 'brands_edit',
                'seller_management_view', 'seller_management_approve', 'seller_management_reject',
                'customer_management_view', 'customer_management_export',
                'orders_view', 'orders_approve', 'orders_reject', 'orders_export',
                'request_center_view', 'request_center_create', 'request_center_approve', 'request_center_reject',
                'analytics_view', 'analytics_export',
                'staff_view',
                'settings_view',
            ];
            PermissionService::assignPermissionsToRole($manager, $managerPermissions);
            $this->command->info('Default permissions assigned to Manager role.');
        }

        // Assign permissions to Support role
        $support = Role::where('slug', 'support')->first();
        if ($support) {
            $supportPermissions = [
                'dashboard_view',
                'products_view',
                'categories_view',
                'customer_management_view', 'customer_management_edit',
                'orders_view', 'orders_approve', 'orders_reject',
                'request_center_view', 'request_center_create',
            ];
            PermissionService::assignPermissionsToRole($support, $supportPermissions);
            $this->command->info('Default permissions assigned to Support role.');
        }

        // Assign permissions to Warehouse role
        $warehouse = Role::where('slug', 'warehouse')->first();
        if ($warehouse) {
            $warehousePermissions = [
                'dashboard_view',
                'products_view', 'products_edit',
                'variants_view', 'variants_create', 'variants_edit',
                'orders_view', 'orders_export',
            ];
            PermissionService::assignPermissionsToRole($warehouse, $warehousePermissions);
            $this->command->info('Default permissions assigned to Warehouse role.');
        }

        // Assign permissions to Finance role
        $finance = Role::where('slug', 'finance')->first();
        if ($finance) {
            $financePermissions = [
                'dashboard_view',
                'products_view',
                'orders_view', 'orders_approve', 'orders_reject', 'orders_export',
                'analytics_view', 'analytics_export',
                'customer_management_view',
            ];
            PermissionService::assignPermissionsToRole($finance, $financePermissions);
            $this->command->info('Default permissions assigned to Finance role.');
        }

        // Assign permissions to Marketing role
        $marketing = Role::where('slug', 'marketing')->first();
        if ($marketing) {
            $marketingPermissions = [
                'dashboard_view',
                'products_view',
                'categories_view',
                'collections_view', 'collections_create', 'collections_edit',
                'brands_view',
                'analytics_view', 'analytics_export',
                'customer_management_view', 'customer_management_export',
            ];
            PermissionService::assignPermissionsToRole($marketing, $marketingPermissions);
            $this->command->info('Default permissions assigned to Marketing role.');
        }

        $this->command->info('Permission seeding completed successfully!');
    }
}