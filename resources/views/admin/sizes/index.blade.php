@extends('layout.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4>Seller Sizes</h4>
            <p class="text-muted mb-0">Admin can view all seller sizes. Cannot create or edit sizes.</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Seller</th>
                            <th>Size Name</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($sizes as $size)
                        <tr>
                            <td>{{ $size->id }}</td>
                            <td>
                                @if($size->seller)
                                    <strong>{{ $size->seller->business_name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $size->seller->owner_name }}</small>
                                @else
                                    <span class="text-muted">Unknown</span>
                                @endif
                            </td>
                            <td>{{ $size->name }}</td>
                            <td>
                                @if($size->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $size->created_at->format('d M Y') }}</td>
                            <td>
                                <form action="{{ route('size.destroy', $size->id) }}"
                                      method="POST"
                                      style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this size? This cannot be undone.')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No seller sizes found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection