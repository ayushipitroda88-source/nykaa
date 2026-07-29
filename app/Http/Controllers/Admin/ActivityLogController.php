<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('admin')
            ->latest()
            ->paginate(25);

        return view('admin.staff.activity-logs', compact('logs'));
    }
}