@extends('layout.admin')

@section('title', 'Staff Details')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-sm-6">
            <h1 class="h3 mb-0 text-gray-800">Staff Details</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.staff.dashboard') }}">Staff</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.staff.index') }}">Staff List</a></li>
                <li class="breadcrumb-item active">{{ $staff->name }}</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ $staff->profile_photo_url }}" alt="{{ $staff->name }}" style="width:120px;height:120px;border-radius:50%;object-fit:cover;margin-bottom:15px;">
                    <h4>{{ $staff->name }}</h4>
                    <p class="text-muted">{{ $staff->email }}</p>
                    <p>
                        @if($staff->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Staff Information</h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width:200px;">Full Name</th>
                            <td>{{ $staff->name }}</td>
                        </tr>
                        <tr>
                            <th>Email Address</th>
                            <td>{{ $staff->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $staff->phone ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Assigned Role</th>
                            <td>
                                <span class="badge bg-info">{{ $staff->role->name ?? 'N/A' }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($staff->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Created Date</th>
                            <td>{{ $staff->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Last Login</th>
                            <td>{{ $staff->last_login_at ? $staff->last_login_at->format('d M Y, h:i A') : 'Never' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Recent Activities</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Activity</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($staff->activityLogs->sortByDesc('created_at')->take(10) as $log)
                            <tr>
                                <td>{{ $log->created_at_formatted }}</td>
                                <td>{{ $log->time }}</td>
                                <td>{{ $log->activity }}</td>
                                <td><code>{{ $log->ip_address ?? 'N/A' }}</code></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">No activities recorded.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection