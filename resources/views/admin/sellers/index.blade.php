@extends('layout.admin')

@section('content')
<div class="container-fluid mt-4">
    <h3>Seller Management</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="card shadow mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Business Name</th>
                            <th>Owner</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sellers as $seller)
                        <tr>
                            <td>{{ $seller->id }}</td>
                            <td>{{ $seller->business_name }}</td>
                            <td>{{ $seller->owner_name }}</td>
                            <td>{{ $seller->email }}</td>
                            <td>
                                <span class="badge 
                                    @if($seller->status == 'pending') bg-warning 
                                    @elseif($seller->status == 'approved') bg-success 
                                    @elseif($seller->status == 'rejected') bg-danger 
                                    @else bg-secondary @endif">
                                    {{ ucfirst($seller->status) }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.sellers.status', $seller->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
                                        <option value="pending" {{ $seller->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $seller->status == 'approved' ? 'selected' : '' }}>Approve</option>
                                        <option value="rejected" {{ $seller->status == 'rejected' ? 'selected' : '' }}>Reject</option>
                                        <option value="suspended" {{ $seller->status == 'suspended' ? 'selected' : '' }}>Suspend</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
