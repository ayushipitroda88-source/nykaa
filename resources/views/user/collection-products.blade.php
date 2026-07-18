@extends('user.index')

    

@section('title', $collection->name)

@push('page-styles')

<style>
/* Modern & Clean Base Layout */
.container {
    width: 92%;
    max-width: 1300px;
    margin: 60px auto;
    font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
}

.section-title {
    text-align: center;
    font-size: 36px;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 8px;
    letter-spacing: -0.5px;
}

.section-desc {
    text-align: center;
    color: #6c757d;
    font-size: 16px;
    max-width: 600px;
    margin: 0 auto 45px auto;
    line-height: 1.6;
}

/* Responsive Fluid Product Grid */
.products {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
}

/* Premium Card Design */
.product-card {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
    border: 1px solid #f0f0f0;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
    border-color: transparent;
}

/* Consistent Aspect Ratio Image Wrapper */
.product-card a {
    display: block;
    overflow: hidden;
    background: #f8f9fa;
    position: relative;
    padding-top: 110%; /* Makes image blocks consistent */
}

.product-card img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.5s ease;
    background: #f8f9fa;
    padding: 10px;
}

.product-card:hover img {
    transform: scale(1.04);
}

/* Padding & Alignments */
.product-info {
    padding: 22px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.product-info h3 {
    font-size: 18px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 12px;
    line-height: 1.4;
    height: 50px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Neat Price Section */
.price {
    margin: 10px 0 20px 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
    min-height: 38px;
}

.old-price {
    color: #adb5bd;
    text-decoration: line-through;
    font-size: 15px;
    font-weight: 500;
}

.new-price {
    font-size: 24px;
    color: #e91e63; /* Dynamic energetic pink */
    font-weight: 700;
}

/* Badge Styling */
.discount-badge {
    background: #e6f4ea;
    color: #137333;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Call-to-Action Form & Button */
.product-info form {
    margin-top: auto; /* Aligns button neatly at the bottom */
}

.cart-btn {
    width: 100%;
    background: #1a1a1a; /* Professional Dark Aesthetic */
    color: #ffffff;
    border: none;
    padding: 14px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    font-size: 15px;
    transition: background 0.2s ease, transform 0.1s ease;
}

.cart-btn:hover {
    background: #e91e63; /* Turns accent color on hover */
}

.cart-btn:active {
    transform: scale(0.98);
}

/* Empty State State */
.empty {
    grid-column: 1 / -1;
    text-align: center;
    font-size: 20px;
    color: #8c8c8c;
    padding: 100px 20px;
    background: #fdfdfd;
    border-radius: 16px;

    border: 2px dashed #e0e0e0;
}

/* Wishlist Position relative on card */
.product-card {
    position: relative;
}

.wishlist-form {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 20;
}

.wishlist-icon {
    width: 38px;
    height: 38px;
    border: none;
    border-radius: 50%;
    background: #fff;
    cursor: pointer;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
    transition: .3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.wishlist-icon:hover {
    background: #e91e63;
    color: #fff;
}
</style>

@endpush

@section('content')



<div class="container">

    <h2 class="section-title">
        {{ $collection->name }}
    </h2>

    <p class="section-desc">
        {{ $collection->description }}
    </p>

    <div class="products">

@forelse($collection->products as $product)

@php



$showDiscount = false;
$discountPrice = $product->price;

if(
    $collection->discount > 0 &&
    $collection->discount_start &&
    $collection->discount_end &&
    now()->between(
        $collection->discount_start,
        $collection->discount_end
    )
){
    $showDiscount = true;

    $discountPrice =
        $product->price -
        ($product->price * $collection->discount / 100);
}



@endphp


<div class="product-card">

<!-- Wishlist -->
<form action="{{ route('wishlist.add',$product->id) }}" method="POST" class="wishlist-form">
    @csrf
    <input type="hidden" name="collection_id" value="{{ $collection->id }}">
    <button type="submit" class="wishlist-icon">
        <i class="bi bi-heart"></i>
    </button>
</form>

<a href="{{ route('product.show', ['id' => $product->id, 'collection_id' => $collection->id]) }}">

@if($product->image)

<img src="{{ asset('uploads/'.$product->image) }}">

@else

<img src="https://via.placeholder.com/300x350">

@endif

</a>

<div class="product-info">

<h3>

{{ $product->title }}

</h3>

<div class="price">

@if($showDiscount)

<div class="old-price">

₹{{ number_format($product->price,2) }}

</div>

<div class="new-price">

₹{{ number_format($discountPrice,2) }}

</div>

<div class="discount-badge">

{{ $collection->discount }}% OFF

</div>

@else

<div class="new-price">

₹{{ number_format($product->price,2) }}

</div>

@endif

</div>

<form action="{{ route('cart.add',$product->id) }}" method="POST">

@csrf

<input
type="hidden"
name="collection_id"
value="{{ $collection->id }}">

<button class="cart-btn">

Add To Cart

</button>

</form>

</div>

</div>

@empty

<div class="empty">

No Products Found

</div>

@endforelse

</div>

</div>

@endsection