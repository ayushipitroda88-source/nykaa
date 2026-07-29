<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use App\Services\StaffService;
use App\Http\Requests\Staff\StoreStaffRequest;
use App\Http\Requests\Staff\UpdateStaffRequest;
use Illuminate\Http\Request;

class RoleManagementController extends Controller
{
    protected StaffService $staffService;

    public function __construct(StaffService $staffService)
    {
        $this->staffService = $staffService;
    }

    public function index()
    {
        $roles = Role::withCount('admins')->get();
        return view('admin.settings.roles.index', compact('roles'));
    }

    public function create()
    {
        $roles = Role::active()->get();
        return view('admin.settings.roles.create', compact('roles'));
    }

    public function store(StoreStaffRequest $request)
    {
        $this->staffService->createStaff($request->validated());

        return redirect()->route('admin.settings.roles.index')
            ->with('success', 'Staff member created successfully.');
    }

    public function edit($id)
    {
        $staff = Admin::with('role')->findOrFail($id);
        $roles = Role::active()->get();

        return view('admin.settings.roles.edit', compact('staff', 'roles'));
    }

    public function update(UpdateStaffRequest $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $this->staffService->updateStaff($admin, $request->validated());

        return redirect()->route('admin.settings.roles.index')
            ->with('success', 'Staff member updated successfully.');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin->isSuperAdmin()) {
            return redirect()->route('admin.settings.roles.index')
                ->with('error', 'Cannot delete Super Admin.');
        }

        $this->staffService->deleteStaff($admin);

        return redirect()->route('admin.settings.roles.index')
            ->with('success', 'Staff member deleted successfully.');
    }

    public function byRole($slug)
    {
        $role = Role::where('slug', $slug)->firstOrFail();
        $staff = Admin::where('role_id', $role->id)
            ->with('role')
            ->latest()
            ->paginate(15);

        return view('admin.settings.roles.role-staff', compact('staff', 'role'));
    }
}