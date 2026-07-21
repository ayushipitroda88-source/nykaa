@extends('layout.admin')

<style>
.multi-select {
    position: relative;
    width: 100%;
}

.select-box {
    border: 1px solid #ccc;
    padding: 10px;
    cursor: pointer;
    background: #fff;
}

.checkboxes {
    display: none;
    border: 1px solid #ccc;
    max-height: 200px;
    overflow-y: auto;
    background: white;
    position: absolute;
    width: 100%;
    z-index: 999;
}

.checkboxes label {
    display: block;
    padding: 8px;
}
</style>

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        Upload Makeup Product
                    </h3>
                </div>

                <div class="card-body">

                    <form action="/upload-product"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        

                        <div class="mb-3">
                            <label class="form-label">
                                Product Title
                            </label>

                            <input type="text"
                                   name="title"
                                   class="form-control"
                                   placeholder="Enter product title"
                                   value="{{ old('title') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Product Price
                            </label>

                            <input type="text"
                                   name="price"
                                   class="form-control"
                                   placeholder="Enter product price"
                                   value="{{ old('price') }}">
                        </div>
                            <div class="mb-3">
    <label class="form-label">
        Product Quantity
    </label>

    <input type="number"
           name="quantity"
           class="form-control"
           placeholder="Enter available quantity"
           value="{{ old('quantity',0) }}"
           min="0"
           required>
</div>
                        <div class="mb-3">
                            <label class="form-label">
                                Product Image
                            </label>

                            <input type="file"
                                   name="image"
                                   class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Description
                            </label>

                            <textarea name="description"
                                      rows="5"
                                      class="form-control"
                                      placeholder="Enter product description"></textarea>
                        </div>
<div class="mb-3">
    <label>Brand</label>
    <select name="brand_id" class="form-control">
        <option value="">Select Brand</option>
        @foreach($brands as $brand)
            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                {{ $brand->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Main Category</label>

    <select id="main_category" class="form-control"
        <option value="">Select Main Category</option>

        @foreach($mainCategories as $category)
            <option value="{{ $category->id }}">
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Sub Category</label>

    <select id="sub_category" class="form-control">
        <option value="">Select Sub Category</option>
    </select>
</div>

<div class="mb-3">
    <label>Child Category</label>

    <select name="category_id" id="child_category" class="form-control" required>
        <option value="">Select Child Category</option>
    </select>
</div>

<div class="mb-3">
    <label>Collections</label>

    <div class="multi-select">
        <div class="select-box" onclick="toggleDropdown()">
            Select Collections ▼
        </div>

        <div class="checkboxes" id="checkboxes">
            @foreach($collections as $collection)
                <label>
                    <input type="checkbox"
                           name="collections[]"
                           value="{{ $collection->id }}"
                           {{ isset($product) && $product->collections->contains($collection->id) ? 'checked' : '' }}>
                    {{ $collection->name }}
                </label>
            @endforeach
        </div>
    </div>
</div>

<div class="mb-3">
    <label>Colors</label>

    <div class="multi-select">
        <div class="select-box" onclick="toggleColorsDropdown()">
            Select Colors ▼
        </div>

        <div class="checkboxes" id="colorCheckboxes" style="display: none;">
            @foreach($colors as $color)
                <label class="d-flex align-items-center gap-2">
                    <input type="checkbox"
                           name="colors[]"
                           value="{{ $color->id }}"
                           {{ is_array(old('colors')) && in_array($color->id, old('colors')) ? 'checked' : '' }}>
                    <span style="width: 15px; height: 15px; border-radius: 50%; display: inline-block; background-color: {{ $color->color_code }}; border: 1px solid #ccc;"></span>
                    {{ $color->name }}
                </label>
            @endforeach
        </div>
    </div>
</div>

<div class="mb-3">
    <label>Sizes</label>

    <div class="multi-select">
        <div class="select-box" onclick="toggleSizesDropdown()">
            Select Sizes ▼
        </div>

        <div class="checkboxes" id="sizeCheckboxes" style="display: none;">
            @foreach($sizes as $size)
                <label>
                    <input type="checkbox"
                           name="sizes[]"
                           value="{{ $size->id }}"
                           {{ is_array(old('sizes')) && in_array($size->id, old('sizes')) ? 'checked' : '' }}>
                    {{ $size->name }}
                </label>
            @endforeach
        </div>
    </div>
</div>

<br>
                        
                        <button type="submit"
                                class="btn btn-primary">
                            Upload Product
                        </button>

                        <a href="{{ url('/products') }}"
                           class="btn btn-secondary">
                            Back
                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>

function resetSubCategory() {
    $('#sub_category').html('<option value="">Select Sub Category</option>');
}

function resetChildCategory() {
    $('#child_category').html('<option value="">Select Child Category</option>');
}

function loadSubCategories(mainCategoryId, selectedSubId = null, selectedChildId = null) {
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

        if (selectedSubId) {
            $('#sub_category').val(selectedSubId);
            loadChildCategories(selectedSubId, selectedChildId);
        }
    }).fail(function() {
        resetSubCategory();
        resetChildCategory();
    });
}

function loadChildCategories(subCategoryId, selectedChildId = null) {
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

        if (selectedChildId) {
            $('#child_category').val(selectedChildId);
        }
    }).fail(function() {
        resetChildCategory();
    });
}

function toggleDropdown() {
    let checkboxes = document.getElementById("checkboxes");
    checkboxes.style.display = checkboxes.style.display === "block" ? "none" : "block";
}

function toggleColorsDropdown() {
    let checkboxes = document.getElementById("colorCheckboxes");
    checkboxes.style.display = checkboxes.style.display === "block" ? "none" : "block";
}

function toggleSizesDropdown() {
    let checkboxes = document.getElementById("sizeCheckboxes");
    checkboxes.style.display = checkboxes.style.display === "block" ? "none" : "block";
}

$(document).ready(function() {
    // Close dropdowns when clicked outside
    $(document).on("click", function(event) {
        if (!$(event.target).closest(".multi-select").length) {
            $("#checkboxes").hide();
            $("#colorCheckboxes").hide();
            $("#sizeCheckboxes").hide();
        }
    });

    $('#main_category').on('change', function() {
        let id = $(this).val();
        loadSubCategories(id);
    });

    $('#sub_category').on('change', function() {
        let id = $(this).val();
        loadChildCategories(id);
    });
});

</script>

@endsection