@extends('layout.admin')

@section('title', $role->name . ' Staff')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-sm-6">
            <h1 class="h3 mb-0 text-gray-800">{{ $role->name }} Staff</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.settings.roles.index') }}">Role Management</a></li>
                <li class="breadcrumb-item active">{{ $role->name }} Staff</li>
            </ol>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Showing staff members with role: <span class="badge bg-info">{{ $role->name }}</span>
                <span class="badge bg-primary ms-2">{{ $staff->total() }} Total</span>
            </h3>
            <div class="card-tools">
                <a href="{{ route('admin.settings.roles.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Roles
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff as $member)
                    <tr>
                        <td>{{ $member->id }}</td>
                        <td>
                            <img src="{{ $member->profile_photo_url }}" alt="" style="width:30px;height:30px;border-radius:50%;object-fit:cover;margin-right:5px;">
                            {{ $member->name }}
                        </td>
                        <td>{{ $member->email }}</td>
                        <td><span class="badge bg-info">{{ $member->role->name }}</span></td>
                        <td>
                            @if($member->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $member->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.settings.roles.edit', $member->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(!$member->isSuperAdmin())
                            <form action="{{ route('admin.settings.roles.destroy', $member->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">No staff members with this role.</td>
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