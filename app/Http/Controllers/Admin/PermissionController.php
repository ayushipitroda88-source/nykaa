<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * Display the permission management page.
     */
    public function index()
    {
        $roles = Role::active()->get();
        $modules = PermissionService::getPermissionsGrouped();

        return view('admin.settings.permissions.index', compact('roles', 'modules'));
    }

    /**
     * Get permissions for a specific role (AJAX).
     */
    public function getRolePermissions($roleId)
    {
        $role = Role::with('permissions')->findOrFail($roleId);

        if ($role->isSuperAdmin()) {
            return response()->json([
                'is_super_admin' => true,
                'permissions' => PermissionService::getPermissionsGrouped(),
                'assigned_slugs' => [],
            ]);
        }

        $grouped = PermissionService::getRolePermissionsGrouped($role);
        $assignedSlugs = PermissionService::getRolePermissionSlugs($role);

        return response()->json([
            'is_super_admin' => false,
            'permissions' => $grouped,
            'assigned_slugs' => $assignedSlugs,
        ]);
    }

    /**
     * Save permissions for a role.
     */
    public function save(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,slug',
        ]);

        $role = Role::findOrFail($request->role_id);

        // Prevent modifying Super Admin permissions
        if ($role->isSuperAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Super Admin permissions cannot be modified.',
            ], 403);
        }

        $permissions = $request->input('permissions', []);

        PermissionService::assignPermissionsToRole($role, $permissions);

        return response()->json([
            'success' => true,
            'message' => 'Permissions saved successfully for role: ' . $role->name,
        ]);
    }

    /**
     * Sync permissions from the definition (Super Admin only).
     */
    public function sync()
    {
        PermissionService::syncPermissions(true);

        return redirect()->route('admin.settings.permissions.index')
            ->with('success', 'Permissions synced successfully.');
    }
}