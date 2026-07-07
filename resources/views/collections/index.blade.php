@extends('layout.admin')

@section('content')

<div class="container-fluid">

    <div class="row align-items-start">

        <!-- Left Side Form -->
        <div class="col-lg-4 col-md-12 mb-4">

            <div class="card">

                <div class="card-header">
                    <h4>Add Collection</h4>
                </div>

                <form action="{{ route('collections.store') }}" method="POST">
                    @csrf

                    <div class="card-body">

                        <div class="form-group">
                            <label>Collection Name</label>

                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   placeholder="Enter Collection Name"
                                   image="image"
                                   required
                        </div>

                        <div class="form-group mt-3">
    <label>Discount (%)</label>

    <input type="number"
           name="discount"
           class="form-control"
           placeholder="Enter Discount">
</div>

<div class="form-group mt-3">
    <label>Discount Start Date</label>

    <input type="date"
           name="discount_start"
           class="form-control">
</div>

<div class="form-group mt-3">
    <label>Discount End Date</label>

    <input type="date"
           name="discount_end"
           class="form-control">
</div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            Save Collection
                        </button>
                    </div>

                </form>

            </div>

        </div>
        <!-- Right Side Table -->
<div class="col-lg-8 col-md-12">

    <div class="card">

        <div class="card-header">
            <h4>Collections List</h4>
        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Collection Name</th>
                        <th>Discount</th>
                        <th>Duration</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($collections as $collection)

                    <tr>

                        <td>{{ $collection->id }}</td>

                        <td>{{ $collection->name }}</td>

                        <td>{{ $collection->discount }}%</td>

                        <td>
                            {{ $collection->discount_start }}<br>
                            {{ $collection->discount_end }}
                        </td>

                        <td>

                            <button
                                type="button"
                                class="btn btn-warning btn-sm editBtn"
                                data-id="{{ $collection->id }}"
                                data-name="{{ $collection->name }}"
                                data-discount="{{ $collection->discount }}"
                                data-start="{{ $collection->discount_start }}"
                                data-end="{{ $collection->discount_end }}">
                                Edit
                            </button>

                            <form action="{{ route('collections.destroy',$collection->id) }}"
                                  method="POST"
                                  style="display:inline-block;">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">

                                    Delete

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center">
                            No Collection Found
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
 </div> 

<!-- ================= MODAL ================= -->
<div class="modal fade" id="editModal" tabindex="-1">

    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" id="editForm">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5>Edit Collection</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

    <div class="mb-3">
        <label>Collection Name</label>
        <input type="text"
               name="name"
               id="editName"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Discount (%)</label>
        <input type="number"
               name="discount"
               id="editDiscount"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Discount Start Date</label>
        <input type="date"
               name="discount_start"
               id="editStart"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Discount End Date</label>
        <input type="date"
               name="discount_end"
               id="editEnd"
               class="form-control">
    </div>

</div>

                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

<!-- ================= PURE JS ================= -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const editButtons = document.querySelectorAll(".editBtn");
    const modal = document.getElementById("editModal");

    editButtons.forEach(button => {

        button.addEventListener("click", function () {

            document.getElementById("editName").value =
                this.dataset.name;

            document.getElementById("editDiscount").value =
                this.dataset.discount;

            document.getElementById("editStart").value =
                this.dataset.start;

            document.getElementById("editEnd").value =
                this.dataset.end;

            document.getElementById("editForm").action =
                "/collections/" + this.dataset.id;

            new bootstrap.Modal(modal).show();

        });

    });

});
</script>

@endsection