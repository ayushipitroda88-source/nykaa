@extends('layout.admin')

@section('title', 'Role Management')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-sm-6">
            <h1 class="h3 mb-0 text-gray-800">Role Management</h1>
        </div>
        <div class="col-sm-6 text-end">
            <a href="{{ route('admin.settings.roles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Staff
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Role Name</th>
                        <th>Total Users</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>
                            <strong>{{ $role->name }}</strong>
                            @if($role->slug === 'super-admin')
                                <span class="badge bg-warning ms-1">Super Admin</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.settings.roles.by-role', $role->slug) }}" class="badge bg-primary text-decoration-none fs-6">
                                {{ $role->admins_count }} Users
                            </a>
                        </td>
                        <td>
                            @if($role->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.settings.roles.by-role', $role->slug) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-users"></i> View Users
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection