@extends('layout.seller')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white pb-0 pt-4">
                <h4 class="mb-0">Add New Product</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Product Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Image</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Main Category</label>
                            <select id="main_category" class="form-select">
                                <option value="">Select Main Category</option>
                                @foreach($mainCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sub Category</label>
                            <select id="sub_category" class="form-select">
                                <option value="">Select Sub Category</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Child Category</label>
                            <select name="category_id" id="child_category" class="form-select" required>
                                <option value="">Select Child Category</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Brand</label>
                            <select name="brand_id" class="form-select">
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Price (₹)</label>
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stock Quantity</label>
                            <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}" required min="0">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Description</label>
                        <textarea name="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('seller.products.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
function resetSubCategory() {
    $('#sub_category').html('<option value="">Select Sub Category</option>');
}
function resetChildCategory() {
    $('#child_category').html('<option value="">Select Child Category</option>');
}
function loadSubCategories(mainCategoryId) {
    if (!mainCategoryId) {
        resetSubCategory();
        resetChildCategory();
        return;
    }
    $('#sub_category').html('<option>Loading...</option>');
    resetChildCategory();
    $.get('/get-subcategories/' + mainCategoryId, function(data) {
        let html = '<option value="">Select Sub Category</option>';
        data.forEach(function(item) {
            html += '<option value="' + item.id + '">' + item.name + '</option>';
        });
        $('#sub_category').html(html);
    }).fail(function() {
        resetSubCategory();
        resetChildCategory();
    });
}
function loadChildCategories(subCategoryId) {
    if (!subCategoryId) {
        resetChildCategory();
        return;
    }
    $('#child_category').html('<option>Loading...</option>');
    $.get('/get-subcategories/' + subCategoryId, function(data) {
        let html = '<option value="">Select Child Category</option>';
        data.forEach(function(item) {
            html += '<option value="' + item.id + '">' + item.name + '</option>';
        });
        $('#child_category').html(html);
    }).fail(function() {
        resetChildCategory();
    });
}
$(document).ready(function() {
    $('#main_category').on('change', function() {
        loadSubCategories($(this).val());
    });
    $('#sub_category').on('change', function() {
        loadChildCategories($(this).val());
    });
});
</script>
