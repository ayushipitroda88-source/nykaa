@extends('user.index')

@section('title', $product->title . ' - NYKAA')
@push('page-styles')
<style>
/* ===========================
   PRODUCT DETAILS
=========================== */

.product-page{
    max-width:1400px;
    margin:40px auto;
    padding:0 20px;
}

/* Color and Size Selectors */
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
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.color-swatches {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.color-swatch {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1px solid #ccc;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
}
.color-swatch:hover {
    transform: scale(1.1);
}
.color-swatch.active {
    outline: 2px solid #fc2779;
    outline-offset: 2px;
}
.size-options {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}
.size-option {
    padding: 8px 16px;
    border: 1px solid #ddd;
    border-radius: 6px;
    background: #fff;
    cursor: pointer;
    font-weight: 500;
    font-size: 14px;
    transition: all 0.2s ease;
}
.size-option:hover {
    border-color: #fc2779;
    color: #fc2779;
}
.size-option.active {
    background: #fc2779;
    color: #fff;
    border-color: #fc2779;
}

.back-btn{
    display:inline-block;
    margin-bottom:25px;
    text-decoration:none;
    color:#333;
    font-weight:600;
    transition:.3s;
}

.back-btn:hover{
    color:#fc2779;
}

/* Layout */
.product-wrapper{
    display:flex;
    gap:50px;
    align-items:flex-start;
}

/* LEFT */
.product-left{
    width:40%;
}

.product-image{
    background:#fff;
    border:1px solid #eee;
    border-radius:12px;
    padding:20px;
    text-align:center;
    box-shadow:0 5px 15px rgba(0,0,0,.06);
}

.product-image img{
    width:100%;
    max-height:600px;
    object-fit:contain;
}

/* RIGHT */
.product-right{
    width:60%;
}

.product-category{
    display:inline-block;
    background:#ffe8f2;
    color:#fc2779;
    padding:6px 14px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
    margin-bottom:15px;
}

.product-brand{
    font-size:18px;
    font-weight:700;
    color:#555;
    margin-bottom:8px;
}

.product-title{
    font-size:34px;
    font-weight:700;
    color:#222;
    margin-bottom:20px;
    line-height:1.4;
}

.product-price{
    font-size:40px;
    font-weight:700;
    color:#fc2779;
    margin-bottom:20px;
}

.product-stock{
    margin-bottom:25px;
}

.in-stock{
    background:#e7fff0;
    color:#198754;
    padding:8px 18px;
    border-radius:30px;
    font-weight:600;
}

.out-stock{
    background:#ffe8e8;
    color:#dc3545;
    padding:8px 18px;
    border-radius:30px;
    font-weight:600;
}

.product-description{
    margin-top:25px;
}

.product-description h3{
    margin-bottom:12px;
    font-size:22px;
}

.product-description p{
    color:#555;
    line-height:1.8;
    font-size:15px;
}

/* Collections */
.product-collections{
    margin-top:30px;
}

.product-collections h3{
    margin-bottom:12px;
}

.product-collections a{
    display:inline-block;
    margin:5px;
    padding:8px 16px;
    background:#fc2779;
    color:#fff;
    text-decoration:none;
    border-radius:20px;
    transition:.3s;
}

.product-collections a:hover{
    background:#222;
}

/* Buttons */
/* ==========================================
   DYNAMIC BUTTONS & SVG HEART STYLES
========================================== */

.product-buttons {
    display: flex;
    gap: 15px;
    margin-top: 35px;
}

.product-buttons form {
    flex: 1;
}

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
    gap: 10px; /* Text aur Heart ke beech ka gap */
}

/* SVG Heart Icon Setup */
.heart-icon {
    transition: transform 0.3s ease;
}

/* 1. Jiska Heart Khaali Hai (Not Wishlisted) */
.wishlist-btn {
    background: #fff !important;
    color: #fc2779 !important;
    border: 2px solid #fc2779 !important;
}

.wishlist-btn .heart-icon.outline {
    fill: transparent;      /* Andar ka color bilkul khali (blank) */
    stroke: #fc2779;        /* Border color pink */
    stroke-width: 1.5;
}

.wishlist-btn:hover {
    background: #ffe8f2 !important;
}

.wishlist-btn:hover .heart-icon {
    transform: scale(1.1);   /* Hover par halka sa pop-up effect */
}


/* 2. Jiske Andar Pink Color Fill Hai (Already Wishlisted) */
.wishlisted-btn {
    background: #fff !important; /* Background white hi rahega Nykaa look ke liye */
    color: #fc2779 !important;
    border: 2px solid #fc2779 !important;
}

.wishlisted-btn .heart-icon.filled {
    fill: #fc2779;          /* Andar se poora PINK color fill ho jayega! */
}

.wishlisted-btn:hover {
    background: #ffe8f2 !important;
}


/* 3. Add to Cart Button Style */
.cart-btn {
    background: #fc2779 !important;
    color: #fff !important;
    border: 2px solid #fc2779 !important;
}

.cart-btn:hover {
    background: #d61c66 !important;
    border-color: #d61c66 !important;
}

/* Out of Stock Configuration */
.btn-disabled {
    background: #ccc !important;
    color: #666 !important;
    border: 2px solid #ccc !important;
    cursor: not-allowed !important;
}

.product-buttons form:first-child button{
    background:#fff;
    color:#fc2779;
    border:2px solid #fc2779;
}

.product-buttons form:first-child button:hover{
    background:#fc2779;
    color:#fff;
}

.product-buttons form:last-child button, 
.btn-disabled{
    background:#fc2779;
    color:#fff;
}

.product-buttons form:last-child button:hover{
    background:#d61c66;
}

.btn-disabled {
    background: #ccc !important;
    color: #666 !important;
    cursor: not-allowed !important;
}

/* ===========================
   RELATED PRODUCTS
=========================== */
.related-products{
    margin-top:80px;
}

.related-products h2{
    margin-bottom:30px;
    font-size:30px;
    font-weight:700;
}

.related-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:25px;
}

.related-card{
    background:#fff;
    border-radius:12px;
    overflow:hidden;
    border:1px solid #eee;
    transition:.3s;
    box-shadow:0 5px 15px rgba(0,0,0,.05);
}

.related-card:hover{
    transform:translateY(-5px);
    box-shadow:0 10px 25px rgba(0,0,0,.12);
}

.related-card img{
    width:100%;
    height:260px;
    object-fit:cover;
}

.related-card h5{
    padding:12px;
    margin:0;
    font-size:15px;
    height:55px;
    overflow:hidden;
}

.related-card h5 a{
    text-decoration:none;
    color:#222;
}

.related-card h5 a:hover{
    color:#fc2779;
}

.related-card div{
    padding:0 12px 15px;
    font-size:20px;
    font-weight:700;
    color:#fc2779;
}

/* Responsive */
@media(max-width:992px){
    .product-wrapper{
        flex-direction:column;
    }
    .product-left,
    .product-right{
        width:100%;
    }
    .related-grid{
        grid-template-columns:repeat(2,1fr);
    }
}

@media(max-width:576px){
    .product-title{
        font-size:26px;
    }
    .product-price{
        font-size:30px;
    }
    .product-buttons{
        flex-direction:column;
    }
    .related-grid{
        grid-template-columns:1fr;
    }
}
</style>
@endpush

@section('content')
<div class="product-page">

    <a href="javascript:history.back()" class="back-btn">
        &larr; Back
    </a>

    <div class="product-wrapper">
        <!-- LEFT IMAGE -->
        <div class="product-left">
            <div class="product-image">
                @if($product->image)
                    <img src="{{ asset('uploads/'.$product->image) }}" alt="{{ $product->title }}">
                @else
                    <img src="https://via.placeholder.com/500x600">
                @endif
            </div>
        </div>

        <!-- RIGHT DETAILS -->
        <div class="product-right"
     data-variants='@json($product->variants)'>
            @if($product->category)
                <div class="product-category">
                    {{ $product->category->name }}
                </div>
            @endif

            @if($product->brand)
                <div class="product-brand" style="font-size: 18px; font-weight: 700; color: #555; margin-bottom: 8px;">
                    {{ $product->brand->name }}
                </div>
            @endif

            <h1 class="product-title">
                {{ $product->title }}
            </h1>

            <div class="product-price">

@if($product->variants->count())

₹{{ number_format($product->variants->first()->price,2) }}

@else

₹{{ number_format($product->price,2) }}

@endif

</div>

            <div class="product-stock">
                @if($product->quantity > 0)
                    <span class="in-stock">
                        In Stock ({{ $product->quantity }})
                    </span>
                @else
                    <span class="out-stock">
                        Out Of Stock
                    </span>
                @endif
            </div>

            <!-- Selection Section (Colors & Sizes) -->
            <div class="product-selection-section">

    @if($product->variants->count())

        <div class="selection-title">
            Select Color
        </div>

        <div class="color-swatches">

            @foreach($product->variants->unique('color_id') as $index=>$variant)

            <div class="color-swatch {{ $index==0?'active':'' }}"
     style="background-color:{{ $variant->color->color_code }}"
     data-id="{{ $variant->color_id }}">
</div> 

            @endforeach

        </div>



        <div class="selection-title">
            Select Size
        </div>


        <div class="size-options">

            @foreach($product->variants->unique('size_id') as $index=>$variant)

           <div class="size-option {{ $index==0?'active':'' }}"
     data-id="{{ $variant->size_id }}">

                {{ $variant->size->name }}

            </div>

            @endforeach


        </div>




    @endif


</div>

            <div class="product-description">
                <h3>Description</h3>
                <p>{{ $product->description }}</p>
            </div>

            @if($product->collections->count())
            <div class="product-collections">
                <h3>Collections</h3>
                @foreach($product->collections as $collection)
                    <a href="{{ route('collection.products',$collection->id) }}">
                        {{ $collection->name }}
                    </a>
                @endforeach
            </div>
            @endif

           <div class="product-buttons">
    
    <!-- Dynamic Wishlist Button (Empty/Filled Heart SVG) -->
    @if(auth()->check() && auth()->user()->wishlists()->where('product_id', $product->id)->exists())
        <!-- Agar Product Wishlist mein HAI (Filled Pink Heart) -->
        <form action="{{ route('wishlist.remove', $product->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="wishlisted-btn">
                <!-- Filled Heart SVG -->
                <svg class="heart-icon filled" viewBox="0 0 24 24" width="24" height="24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                Wishlisted
            </button>
        </form>
    @else
        <!-- Agar Product Wishlist mein NAHI HAI (Blank/Outline Heart) -->
        <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
            @csrf
            @if(isset($collectionId))
                <input type="hidden" name="collection_id" value="{{ $collectionId }}">
            @endif
            <input type="hidden" name="color_id" class="selectedColorInput">
            <input type="hidden" name="size_id" class="selectedSizeInput">
            <button type="submit" class="wishlist-btn">
                <!-- Outline/Blank Heart SVG -->
                <svg class="heart-icon outline" viewBox="0 0 24 24" width="24" height="24">
                    <path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/>
                </svg>
                Wishlist
            </button>
        </form>
    @endif

    <!-- Add To Cart Button System -->
    @if($product->quantity > 0)
        <form action="{{ route('cart.add',$product->id) }}" method="POST">
            @csrf
            @if(isset($collectionId))
                <input type="hidden" name="collection_id" value="{{ $collectionId }}">
            @endif
            <input type="hidden" name="color_id" class="selectedColorInput">
            <input type="hidden" name="size_id" class="selectedSizeInput">
            <button type="submit" class="cart-btn">
                Add To Cart
            </button>
        </form>
    @else
        <form onsubmit="return false;">
            <button type="button" class="btn-disabled" disabled>
                Out of Stock
            </button>
        </form>
    @endif

</div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count())
    <div class="related-products">
        <h2>Related Products</h2>
        <div class="related-grid">
            @foreach($relatedProducts as $item)
            <div class="related-card">
                <a href="{{ route('product.show',$item->id) }}">
                    @if($item->image)
                        <img src="{{ asset('uploads/'.$item->image) }}">
                    @endif
                </a>
                <h5>
                    <a href="{{ route('product.show',$item->id) }}">
                        {{ $item->title }}
                    </a>
                </h5>
                <div>
                    &#8377;{{ number_format($item->price,2) }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif



</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const swatches = document.querySelectorAll(".color-swatch");
    const sizeOptions = document.querySelectorAll(".size-option");
    const colorInputs = document.querySelectorAll(".selectedColorInput");
    const sizeInputs = document.querySelectorAll(".selectedSizeInput");

    function updateInputs() {
        const activeSwatch = document.querySelector(".color-swatch.active");
        const activeSize = document.querySelector(".size-option.active");

        const colorId = activeSwatch ? activeSwatch.dataset.id : "";
        const sizeId = activeSize ? activeSize.dataset.id : "";

        colorInputs.forEach(input => input.value = colorId);
        sizeInputs.forEach(input => input.value = sizeId);
    }

    swatches.forEach(swatch => {
        swatch.addEventListener("click", function () {
            swatches.forEach(s => s.classList.remove("active"));
            this.classList.add("active");
            updateInputs();
        });
    });

    sizeOptions.forEach(opt => {
        opt.addEventListener("click", function () {
            sizeOptions.forEach(o => o.classList.remove("active"));
            this.classList.add("active");
            updateInputs();
        });
    });

    // Run once on load to initialize first choices
    updateInputs();
});
</script>
@endsection