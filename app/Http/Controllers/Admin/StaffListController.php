<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;

class StaffListController extends Controller
{
    public function index()
    {
        $staff = Admin::with('role')
            ->latest()
            ->paginate(15);

        return view('admin.staff.index', compact('staff'));
    }

    public function show($id)
    {
        $staff = Admin::with('role', 'activityLogs')
            ->findOrFail($id);

        return view('admin.staff.show', compact('staff'));
    }
}