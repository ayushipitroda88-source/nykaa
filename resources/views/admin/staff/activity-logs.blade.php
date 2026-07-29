@extends('layout.admin')

@section('title', 'Activity Logs')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-sm-6">
            <h1 class="h3 mb-0 text-gray-800">Activity Logs</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.staff.dashboard') }}">Staff</a></li>
                <li class="breadcrumb-item active">Activity Logs</li>
            </ol>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Staff Name</th>
                        <th>Activity</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->created_at_formatted }}</td>
                        <td>{{ $log->time }}</td>
                        <td>
                            <img src="{{ $log->admin->profile_photo_url }}" alt="" style="width:24px;height:24px;border-radius:50%;object-fit:cover;margin-right:5px;">
                            {{ $log->admin->name }}
                        </td>
                        <td>{{ $log->activity }}</td>
                        <td><code>{{ $log->ip_address ?? 'N/A' }}</code></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">No activity logs found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
        <div class="card-footer clearfix">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection