@extends('layout.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4>Seller Colors</h4>
            <p class="text-muted mb-0">Admin can view all seller colors. Cannot create or edit colors.</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Seller</th>
                            <th>Preview</th>
                            <th>Color Name</th>
                            <th>Hex Code</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($colors as $color)
                        <tr>
                            <td>{{ $color->id }}</td>
                            <td>
                                @if($color->seller)
                                    <strong>{{ $color->seller->business_name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $color->seller->owner_name }}</small>
                                @else
                                    <span class="text-muted">Unknown</span>
                                @endif
                            </td>
                            <td>
                                <div style="width: 30px; height: 30px; border-radius: 50%; background-color: {{ $color->color_code }}; border: 1px solid #ccc;"></div>
                            </td>
                            <td>{{ $color->name }}</td>
                            <td><code>{{ $color->color_code }}</code></td>
                            <td>
                                @if($color->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $color->created_at->format('d M Y') }}</td>
                            <td>
                                <form action="{{ route('color.destroy', $color->id) }}"
                                      method="POST"
                                      style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this color? This cannot be undone.')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No seller colors found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection