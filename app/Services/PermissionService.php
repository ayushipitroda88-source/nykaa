<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PermissionService
{
    /**
     * Define all modules and their available actions.
     * This is the single source of truth for permission definitions.
     * New modules can be added here without modifying existing logic.
     */
    public static function getModuleActions(): array
    {
        return [
            'Dashboard' => ['view'],
            'Products' => ['view', 'create', 'edit', 'delete', 'approve', 'reject', 'export', 'import'],
            'Variants' => ['view', 'create', 'edit', 'delete'],
            'Categories' => ['view', 'create', 'edit', 'delete'],
            'Collections' => ['view', 'create', 'edit', 'delete'],
            'Brands' => ['view', 'create', 'edit', 'delete'],
            'Seller Management' => ['view', 'create', 'edit', 'delete', 'approve', 'reject'],
            'Customer Management' => ['view', 'create', 'edit', 'delete', 'export'],
            'Orders' => ['view', 'approve', 'reject', 'export'],
            'Request Center' => ['view', 'create', 'edit', 'delete', 'approve', 'reject'],
            'Analytics' => ['view', 'export'],
            'Staff' => ['view', 'create', 'edit', 'delete', 'manage'],
            'Settings' => ['view', 'manage'],
        ];
    }

    /**
     * Get module slug for permission naming.
     */
    public static function getModuleSlug(string $module): string
    {
        return Str::slug($module, '_');
    }

    /**
     * Get permission slug for a module action.
     */
    public static function getPermissionSlug(string $module, string $action): string
    {
        return self::getModuleSlug($module) . '_' . Str::slug($action, '_');
    }

    /**
     * Get permission name for display.
     */
    public static function getPermissionName(string $module, string $action): string
    {
        return $module . ' - ' . ucfirst($action);
    }

    /**
     * Sync all permissions from the definition into the database.
     * This is safe to run multiple times - it will create missing permissions
     * and optionally remove permissions that no longer exist in the definition.
     */
    public static function syncPermissions(bool $removeOrphans = false): void
    {
        $moduleActions = self::getModuleActions();
        $existingSlugs = [];

        DB::transaction(function () use ($moduleActions, $removeOrphans, &$existingSlugs) {
            foreach ($moduleActions as $module => $actions) {
                foreach ($actions as $action) {
                    $slug = self::getPermissionSlug($module, $action);
                    $existingSlugs[] = $slug;

                    Permission::updateOrCreate(
                        ['slug' => $slug],
                        [
                            'name' => self::getPermissionName($module, $action),
                            'module' => $module,
                            'action' => $action,
                        ]
                    );
                }
            }

            // Remove permissions that no longer exist in the definition
            if ($removeOrphans) {
                Permission::whereNotIn('slug', $existingSlugs)->delete();
            }
        });
    }

    /**
     * Get all permissions grouped by module.
     */
    public static function getPermissionsGrouped(): array
    {
        $permissions = Permission::all()->groupBy('module');
        $moduleActions = self::getModuleActions();
        $grouped = [];

        foreach ($moduleActions as $module => $actions) {
            $modulePermissions = $permissions->get($module, collect());
            $grouped[$module] = [
                'module' => $module,
                'slug' => self::getModuleSlug($module),
                'permissions' => $modulePermissions,
                'actions' => $actions,
            ];
        }

        return $grouped;
    }

    /**
     * Get permissions for a specific role, grouped by module.
     */
    public static function getRolePermissionsGrouped(Role $role): array
    {
        $grouped = self::getPermissionsGrouped();
        $rolePermissionSlugs = $role->permissions()->pluck('slug')->toArray();

        foreach ($grouped as $module => &$data) {
            foreach ($data['permissions'] as $permission) {
                $permission->assigned = in_array($permission->slug, $rolePermissionSlugs);
            }
        }

        return $grouped;
    }

    /**
     * Assign permissions to a role.
     */
    public static function assignPermissionsToRole(Role $role, array $permissionSlugs): void
    {
        DB::transaction(function () use ($role, $permissionSlugs) {
            $permissionIds = Permission::whereIn('slug', $permissionSlugs)->pluck('id')->toArray();
            $role->permissions()->sync($permissionIds);
        });
    }

    /**
     * Get all permission slugs for a role.
     */
    public static function getRolePermissionSlugs(Role $role): array
    {
        return $role->permissions()->pluck('slug')->toArray();
    }

    /**
     * Check if a role has a specific permission.
     */
    public static function roleHasPermission(Role $role, string $permissionSlug): bool
    {
        return $role->hasPermission($permissionSlug);
    }

    /**
     * Get module icon mapping for UI.
     */
    public static function getModuleIcon(string $module): string
    {
        $icons = [
            'Dashboard' => 'bi bi-speedometer',
            'Products' => 'bi bi-box-seam',
            'Variants' => 'bi bi-collection',
            'Categories' => 'bi bi-folder',
            'Collections' => 'bi bi-grid',
            'Brands' => 'bi bi-tag',
            'Seller Management' => 'bi bi-people',
            'Customer Management' => 'bi bi-person-badge',
            'Orders' => 'bi bi-cart',
            'Request Center' => 'bi bi-clipboard-check',
            'Analytics' => 'bi bi-bar-chart',
            'Staff' => 'bi bi-person-gear',
            'Settings' => 'bi bi-gear',
        ];

        return $icons[$module] ?? 'bi bi-circle';
    }
}