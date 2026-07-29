@extends('layout.admin')

@section('title', 'Staff Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-sm-6">
            <h1 class="h3 mb-0 text-gray-800">Staff Dashboard</h1>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalStaff }}</h3>
                    <p>Total Staff</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.staff.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $activeStaff }}</h3>
                    <p>Active Staff</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <a href="{{ route('admin.staff.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $inactiveStaff }}</h3>
                    <p>Inactive Staff</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-clock"></i>
                </div>
                <a href="{{ route('admin.staff.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $roleStats->count() }}</h3>
                    <p>Total Roles</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-tag"></i>
                </div>
                <a href="{{ route('admin.settings.roles.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Role Stats Cards -->
    <div class="row">
        @foreach($roleStats as $role)
        <div class="col-lg-2 col-4 col-6">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $role->name }}</h5>
                    <p class="card-text">
                        <span class="badge bg-primary fs-6">{{ $role->admins_count }} Users</span>
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Recent Activities -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Staff Activities</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.staff.activity-logs') }}" class="btn btn-sm btn-primary">View All</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Staff</th>
                                <th>Activity</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivities as $log)
                            <tr>
                                <td>
                                    <img src="{{ $log->admin->profile_photo_url }}" alt="" class="img-circle img-size-32 mr-2" style="width:32px;height:32px;border-radius:50%;">
                                    {{ $log->admin->name }}
                                </td>
                                <td>{{ $log->activity }}</td>
                                <td>{{ $log->created_at->format('d M Y h:i A') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No activities recorded yet.</td>
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