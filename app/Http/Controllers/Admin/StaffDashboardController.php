<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use App\Models\ActivityLog;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $totalStaff = Admin::count();
        $activeStaff = Admin::active()->count();
        $inactiveStaff = Admin::inactive()->count();

        $roleStats = Role::withCount('admins')->get();

        $recentActivities = ActivityLog::with('admin')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.staff.dashboard', compact(
            'totalStaff',
            'activeStaff',
            'inactiveStaff',
            'roleStats',
            'recentActivities'
        ));
    }
}