@extends('user.index')

@section('title', $product->title . ' - NYKAA')
@push('page-styles')
<style>
/* ===========================
    PRODUCT DETAILS LAYOUT
=========================== */
.product-page {
    max-width: 1400px;
    margin: 40px auto;
    padding: 0 20px;
}
.back-btn {
    display: inline-block;
    margin-bottom: 25px;
    text-decoration: none;
    color: #333;
    font-weight: 600;
    transition: .3s;
}
.back-btn:hover { color: #fc2779; }

.product-wrapper {
    display: flex;
    gap: 50px;
    align-items: flex-start;
}
.product-left { width: 40%; }
.product-image {
    background: #fff;
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0,0,0,.06);
}
.product-image img {
    width: 100%;
    max-height: 600px;
    object-fit: contain;
}

.product-right { width: 60%; }
.product-category {
    display: inline-block;
    background: #ffe8f2;
    color: #fc2779;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 15px;
}
.product-brand {
    font-size: 18px;
    font-weight: 700;
    color: #555;
    margin-bottom: 8px;
}
.product-title {
    font-size: 34px;
    font-weight: 700;
    color: #222;
    margin-bottom: 10px;
    line-height: 1.4;
}
.product-price {
    font-size: 40px;
    font-weight: 700;
    color: #fc2779;
    margin-bottom: 10px;
}
.product-stock { margin-bottom: 25px; }

.in-stock {
    background: #e7fff0;
    color: #198754;
    padding: 8px 18px;
    border-radius: 30px;
    font-weight: 600;
}
.out-stock {
    background: #ffe8e8;
    color: #dc3545;
    padding: 8px 18px;
    border-radius: 30px;
    font-weight: 600;
}

/* Selectors */
.product-selection-section {
    margin: 25px 0;
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
    padding: 20px 0;
}
.selection-title {
    font-size: 15px;
    font-weight: 600;
    color: #333;
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.color-swatches {
    display: flex;
    gap: 12px;
    margin-bottom: 25px;
    flex-wrap: wrap;
}
.color-swatch {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 2px solid #ddd;
    cursor: pointer;
    transition: all 0.2s ease;
}
.color-swatch:hover {
    transform: scale(1.08);
}
.color-swatch.active {
    border-color: #fff;
    outline: 2px solid #fc2779;
    outline-offset: 2px;
}
.size-options {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}
.size-option {
    padding: 8px 20px;
    border: 1px solid #ddd;
    border-radius: 6px;
    background: #fff;
    cursor: pointer;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.2s ease;
}
.size-option.active {
    background: #fc2779;
    color: #fff;
    border-color: #fc2779;
}
.size-option.disabled-option {
    background: #f5f5f5;
    color: #bbb;
    border-color: #eee;
    cursor: not-allowed;
    opacity: 0.4;
}

.product-description { margin-top: 25px; }
.product-description h3 { margin-bottom: 12px; font-size: 22px; }
.product-description p { color: #555; line-height: 1.8; font-size: 15px; }

/* Action Buttons */
.product-buttons {
    display: flex;
    gap: 15px;
    margin-top: 35px; 
}
.product-buttons form { flex: 1; }
.product-buttons button {
    width: 100%;
    padding: 15px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: all .3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}
.wishlist-btn {
    background: #fff !important;
    color: #fc2779 !important;
    border: 2px solid #fc2779 !important;
}
.wishlisted-btn {
    background: #fff !important;
    color: #fc2779 !important;
    border: 2px solid #fc2779 !important;
}
.wishlisted-btn svg { fill: #fc2779; }
.cart-btn {
    background: #fc2779 !important;
    color: #fff !important;
    border: 2px solid #fc2779 !important;
}
.cart-btn:hover { background: #d61c66 !important; }
.btn-disabled {
    background: #ccc !important;
    color: #666 !important;
    border: 2px solid #ccc !important;
    cursor: not-allowed !important;
}

@media(max-width:992px){
    .product-wrapper { flex-direction: column; }
    .product-left, .product-right { width: 100%; }
}
</style>
@endpush

@section('content')
<div class="product-page">
    <a href="javascript:history.back()" class="back-btn">&larr; Back</a>

    <div class="product-wrapper">
        <div class="product-left">
            <div class="product-image">
            @if($product->image)
    <img
        id="mainProductImage"
        src="{{ asset('uploads/'.$product->image) }}"
        alt="{{ $product->title }}">
@else
    <img
        id="mainProductImage"
        src="https://via.placeholder.com/500x600"
        alt="No Image">
@endif
            </div>
        </div>

        <div class="product-right" id="productContainer" data-variants='@json($product->variants)'>
            
            @if($product->category)
                <div class="product-category">{{ $product->category->name }}</div>
            @endif
            @if($product->brand)
                <div class="product-brand">{{ $product->brand->name }}</div>
            @endif

            <h1 class="product-title">{{ $product->title }}</h1>

            <div class="product-price" id="productPrice">
                @if($product->variants && $product->variants->count())
                    &#8377;{{ number_format($product->variants->first()->price, 2) }}
                @else
                    &#8377;{{ number_format($product->price, 2) }}
                @endif
            </div>

            <div class="product-stock" id="stockStatusWrapper">
                @if($product->variants && $product->variants->count())
                    @if($product->variants->first()->quantity > 0)
                        <span class="in-stock">In Stock</span>
                    @else
                        <span class="out-stock">Out Of Stock</span>
                    @endif
                @else
                    @if($product->quantity > 0)
                        <span class="in-stock">In Stock ({{ $product->quantity }})</span>
                    @else
                        <span class="out-stock">Out Of Stock</span>
                    @endif
                @endif
            </div>

            <div class="product-selection-section">
                @if($product->variants && $product->variants->count())
                    <div class="selection-title">Select Color</div>
                    <div class="color-swatches">
                        @foreach($product->variants->unique('color_id') as $index => $variant)
                            @if($variant->color)
                                <div class="color-swatch {{ $index == 0 ? 'active' : '' }}"
                                     style="background-color:{{ $variant->color->color_code }}"
                                     data-id="{{ $variant->color_id }}">
                                </div> 
                            @endif
                        @endforeach
                    </div>

                    <div class="selection-title">Select Size</div>
                    <div class="size-options">
                        @foreach($product->variants->unique('size_id') as $index => $variant)
                            @if($variant->size)
                                <div class="size-option {{ $index == 0 ? 'active' : '' }}"
                                     data-id="{{ $variant->size_id }}"> 
                                    {{ $variant->size->name }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="product-description">
                <h3>Description</h3>
                <p>{{ $product->description }}</p>
            </div>

            <div class="product-buttons">
                <form action="{{ route('wishlist.add', $product->id) }}" method="POST" id="wishlistForm">
                    @csrf
                    <input type="hidden" name="color_id" class="selectedColorInput">
                    <input type="hidden" name="size_id" class="selectedSizeInput">
                    <input type="hidden" name="variant_id" id="wishlistVariantId">
                    <button type="submit" class="wishlist-btn">
                        <svg viewBox="0 0 24 24" width="24" height="24" style="fill:none; stroke:#fc2779; stroke-width:1.5;"><path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/></svg>
                        Wishlist
                    </button>
                </form>
                @php 
                    $fallbackId = $product->id;
                   // $fallbackId = ($product->variants && $product->variants->count()) ? $product->variants->first()->id : $product->id; 
                @endphp
                <form action="{{ route('cart.add', ['id' => $fallbackId]) }}" method="POST" id="cartForm">
    @csrf

    <input type="hidden"
           name="variant_id"
           id="selectedVariantId">

    <button type="submit"
            id="cartActionButton"
            class="cart-btn">

        Add To Cart

    </button>

</form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("productContainer");
    if (!container) return;

    // Database variants data
    const variants = JSON.parse(container.getAttribute("data-variants") || "[]");
    const swatches = document.querySelectorAll(".color-swatch");
    const sizeOptions = document.querySelectorAll(".size-option");
    
    const colorInputs = document.querySelectorAll(".selectedColorInput");
    const sizeInputs = document.querySelectorAll(".selectedSizeInput");
    
    const priceDisplay = document.getElementById("productPrice");
    const stockWrapper = document.getElementById("stockStatusWrapper");
    const cartForm = document.getElementById("cartForm");
    const cartActionButton = document.getElementById("cartActionButton");
    const mainProductImage = document.getElementById("mainProductImage");

    const baseCartUrl = "{{ route('cart.add', ['id' => ':id']) }}";
    const assetBaseUrl = "{{ asset('uploads/variants') }}/";
    const defaultProductImage = mainProductImage ? mainProductImage.src : "";

    function updateDetails() {
        // 1. Pehle active elements dhoondho
        let activeSwatch = document.querySelector(".color-swatch.active");
        let activeSize = document.querySelector(".size-option.active");

        // Agar load par koi size active nahi hai, toh pehli available size ko active karo
        if (!activeSize && sizeOptions.length > 0) {
            sizeOptions[0].classList.add("active");
            activeSize = sizeOptions[0];
        }

        const colorId = activeSwatch ? activeSwatch.dataset.id : "";
        const sizeId = activeSize ? activeSize.dataset.id : "";

        // Hidden input fields update karo form submit ke liye
        colorInputs.forEach(i => i.value = colorId);
        sizeInputs.forEach(i => i.value = sizeId);

        if (variants.length > 0) {
            // FIXED: Loose equality (==) lagaya hai taaki string vs int ka issue solve ho jaye
            const match = variants.find(v => String(v.color_id) == String(colorId) && String(v.size_id) == String(sizeId));
            document.getElementById('selectedVariantId').value = match ? match.id : '';
            document.getElementById('wishlistVariantId').value = match ? match.id : '';
            if (match) {
                // Price Update
                if (priceDisplay) priceDisplay.innerHTML = '&#8377;' + parseFloat(match.price).toFixed(2);
                
                // Image Update
                if (mainProductImage) {
                    mainProductImage.src = match.image ? (assetBaseUrl + match.image) : defaultProductImage;
                }

                // Form Submit Action URL Update
                if (cartForm);

                // Stock Quantity Checking
                if (parseInt(match.quantity) > 0) {
                    if (stockWrapper) stockWrapper.innerHTML = '<span class="in-stock">In Stock</span>';
                    if (cartActionButton) {
                        cartActionButton.textContent = "Add To Cart";
                        cartActionButton.className = "cart-btn";
                        cartActionButton.style.background = "#fc2779";
                        cartActionButton.removeAttribute("disabled");
                    }
                } else {
                    if (stockWrapper) stockWrapper.innerHTML = '<span class="out-stock">Out Of Stock</span>';
                    if (cartActionButton) {
                        cartActionButton.textContent = "Out Of Stock";
                        cartActionButton.className = "btn-disabled";
                        cartActionButton.setAttribute("disabled", "disabled");
                    }
                }
            } else {
                // Agar is combo ka record nahi hai
                if (priceDisplay) priceDisplay.textContent = "Unavailable";
                if (stockWrapper) stockWrapper.innerHTML = '<span class="out-stock">Out Of Stock</span>';
                if (cartActionButton) {
                    cartActionButton.textContent = "Out Of Stock";
                    cartActionButton.className = "btn-disabled";
                    cartActionButton.setAttribute("disabled", "disabled");
                }
            }
        }
    }

    // Color click events
    swatches.forEach(s => {
        s.addEventListener("click", function() {
            swatches.forEach(x => x.classList.remove("active"));
            this.classList.add("active");
            updateDetails();
        });
    });

    // Size click events
    sizeOptions.forEach(o => {
        o.addEventListener("click", function() {
            sizeOptions.forEach(x => x.classList.remove("active"));
            this.classList.add("active");
            updateDetails();
        });
    });

    // Pehli baar details call karo load hote hi
    updateDetails();
});
</script>
@endsection