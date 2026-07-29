@extends('layout.admin')

@section('title', 'Staff List')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-sm-6">
            <h1 class="h3 mb-0 text-gray-800">Staff List</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.staff.dashboard') }}">Staff</a></li>
                <li class="breadcrumb-item active">Staff List</li>
            </ol>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Profile Photo</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Assigned Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff as $member)
                    <tr>
                        <td>{{ $member->id }}</td>
                        <td>
                            <img src="{{ $member->profile_photo_url }}" alt="{{ $member->name }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                        </td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->email }}</td>
                        <td>
                            <span class="badge bg-info">{{ $member->role->name ?? 'N/A' }}</span>
                        </td>
                        <td>
                            @if($member->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $member->last_login_at ? $member->last_login_at->format('d M Y h:i A') : 'Never' }}</td>
                        <td>{{ $member->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.staff.show', $member->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">No staff members found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($staff->hasPages())
        <div class="card-footer clearfix">
            {{ $staff->links() }}
        </div>
        @endif
    </div>
</div>
@endsection