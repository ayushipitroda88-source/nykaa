@extends('user.index')

@section('title', $category->name)

@section('content')

<style>

.category-page{
    max-width:100%;
    margin:30px 0;
    padding:0 55px 0 0;
}

/* Back */

.back-btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
    color:#333;
    font-weight:600;
    margin-bottom:20px;
    padding-left:55px;
}

.back-btn:hover{
    color:#fc2779;
}

/* Breadcrumb */

.breadcrumb-box{
    margin-bottom:25px;
    color:#777;
    font-size:14px;
    padding-left:55px;
}

/* Layout */

.category-wrapper{
    display:flex;
    gap:30px;
}

/* LEFT */

.category-sidebar{
    width:240px;
    flex-shrink:0;
    background:#fff;
    border-radius:0 15px 15px 0;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
    padding:20px;
}

.category-sidebar h3{
    font-size:22px;
    margin-bottom:20px;
    border-bottom:2px solid #f2f2f2;
    padding-bottom:10px;
}

/* RIGHT */

.category-products{
    flex:1;
    max-width:1200px;
    
}

/* Tree */

.tree ul{
    list-style:none;
    padding-left:18px;
}

.tree li{
    margin:8px 0;
}

.tree a{
    text-decoration:none;
    color:#444;
    transition:.3s;
    font-size:15px;
}

.tree a:hover{
    color:#fc2779;
    padding-left:5px;
}

.active-category{
    color:#fc2779 !important;
    font-weight:bold;
}

/* ===========================
   PRODUCT GRID
=========================== */

.product-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:25px;
}

/* Product Card */

.product-card{
    background:#fff;
    border-radius:15px;
    overflow:hidden;
    position:relative;
    transition:.35s;
    border:1px solid #eee;
    box-shadow:0 3px 12px rgba(0,0,0,.05);
}

.product-card:hover{
    transform:translateY(-6px);
    box-shadow:0 15px 35px rgba(0,0,0,.12);
}

/* Wishlist */

.wishlist-form{
    position:absolute;
    top:12px;
    right:12px;
    z-index:20;
}

.wishlist-icon{
    width:38px;
    height:38px;
    border:none;
    border-radius:50%;
    background:#fff;
    cursor:pointer;
    box-shadow:0 3px 10px rgba(0,0,0,.15);
    transition:.3s;
}

.wishlist-icon:hover{
    background:#fc2779;
    color:#fff;
}

/* Image */

.product-image{
    display:block;
    width:100%;
    height:280px;
    overflow:hidden;
}

.product-image img{
    width:100%;
    height:100%;
    object-fit:cover;
    transition:.4s;
}

.product-card:hover img{
    transform:scale(1.08);
}

/* Info */

.product-info{
    padding:18px;
}

.product-name{
    height:48px;
    overflow:hidden;
}

.product-name a{
    text-decoration:none;
    color:#222;
    font-size:15px;
    font-weight:600;
}

.product-name a:hover{
    color:#fc2779;
}

/* Rating */

.rating{
    margin-top:8px;
    color:#ffb400;
    font-size:14px;
}

.rating span{
    color:#888;
    font-size:13px;
}

/* Price */

.price{
    margin-top:10px;
    font-size:21px;
    font-weight:700;
    color:#fc2779;
}

/* Stock */

.stock{
    display:inline-block;
    margin-top:8px;
    font-size:13px;
    padding:5px 10px;
    border-radius:30px;
}

.in-stock{
    background:#e9fff0;
    color:#169c43;
}

.out-stock{
    background:#ffeaea;
    color:#d63031;
}

/* Buttons */

.product-buttons{
    margin-top:18px;
    display:flex;
    gap:10px;
}

.view-btn,
.cart-btn{
    flex:1;
    border:none;
    text-decoration:none;
    text-align:center;
    padding:10px;
    border-radius:8px;
    font-size:14px;
    font-weight:600;
    transition:.3s;
}

.view-btn{
    background:#f5f5f5;
    color:#333;
}

.view-btn:hover{
    background:#ddd;
}

.cart-btn{
    background:#fc2779;
    color:#fff;
    cursor:pointer;
}

.cart-btn:hover{
    background:#d91d66;
}

/* Empty */

.empty-products{
    grid-column:1/-1;
    text-align:center;
    padding:80px;
}

.empty-products i{
    font-size:70px;
    color:#ccc;
}

.empty-products h3{
    margin-top:20px;
}

/* Responsive */

@media(max-width:1200px){

.product-grid{
grid-template-columns:repeat(3,1fr);
}

}

@media(max-width:992px){

.category-page{
    padding:0 20px;
}

.back-btn{
    padding-left:0;
}

.breadcrumb-box{
    padding-left:0;
}

.category-wrapper{
flex-direction:column;
}

.category-sidebar{
width:100%;
border-radius:15px;
}

.product-grid{
grid-template-columns:repeat(2,1fr);
}

}

@media(max-width:600px){

.product-grid{
grid-template-columns:1fr;
}

.product-image{
height:240px;
}

}

/* ===========================
   PAGINATION
=========================== */

.pagination-wrapper{

    margin-top:40px;

    display:flex;

    justify-content:center;

}

.pagination svg{

    width:18px;

}

.pagination{

    gap:8px;

}

.pagination .page-link{

    border:none;

    border-radius:8px;

    color:#444;

    padding:10px 16px;

}

.pagination .active .page-link{

    background:#fc2779;

    color:#fff;

}

</style>

<div class="category-page">

<a href="javascript:history.back()" class="back-btn">

<i class="bi bi-arrow-left"></i>

Back

</a>

<div class="breadcrumb-box">

Home /

@if($category->parent)

{{ $category->parent->name }} /

@endif

<strong>{{ $category->name }}</strong>

</div>

<div class="category-wrapper">

<!-- LEFT -->

<div class="category-sidebar">

<h3>Categories</h3>



<div class="tree">

<ul>

<li>

<a href="{{ route('category.show',$category->id) }}"
class="active-category">

{{ $category->name }}

</a>

@if($category->children->count())

<ul>

@foreach($category->children as $child)

<li>

<a href="{{ route('category.show',$child->id) }}"
class="{{ $category->id == $child->id ? 'active-category' : '' }}">

{{ $child->name }}

</a>

@if($child->children->count())

<ul>

@foreach($child->children as $sub)

<li>

<a href="{{ route('category.show',$sub->id) }}"
class="{{ $category->id == $sub->id ? 'active-category' : '' }}">

{{ $sub->name }}

</a>

</li>

@endforeach

</ul>

@endif

</li>

@endforeach

</ul>

@endif

</li>

</ul>

</div> <!-- tree close -->
</div> <!-- category-sidebar close -->
<!-- RIGHT -->

<div class="category-products">

<h2 style="font-size:30px;font-weight:700;">

{{ $category->name }}

</h2>

<p style="color:#888;margin-bottom:25px;">

{{ $products->count() }} Products Found

</p>

<h3>Total Products: {{ $products->count() }}</h3>
<br>

<!-- PRODUCT GRID -->
<div class="product-grid">


@forelse($products as $product)

<div class="product-card">

    <!-- Wishlist -->
    <form action="{{ route('wishlist.add',$product->id) }}" method="POST" class="wishlist-form">
        @csrf
        <button type="submit" class="wishlist-icon">
            <i class="bi bi-heart"></i>
        </button>
    </form>

    <!-- Product Image -->
    <a href="{{ route('product.show',$product->id) }}" class="product-image">

        @if($product->image)

            <img src="{{ asset('uploads/'.$product->image) }}" alt="{{ $product->title }}">

        @else

            <img src="https://via.placeholder.com/300x350">

        @endif

    </a>

    <!-- Product Info -->

    <div class="product-info">

        <div class="product-name">

            <a href="{{ route('product.show',$product->id) }}">

                {{ Str::limit($product->title,45) }}

            </a>

        </div>

        <div class="price">

            ₹{{ number_format($product->price,2) }}

        </div>

        @if($product->quantity>0)

            <span class="stock in-stock">

                In Stock

            </span>

        @else

            <span class="stock out-stock">

                Out of Stock

            </span>

        @endif

        <div class="product-buttons">

            <a href="{{ route('product.show',$product->id) }}" class="view-btn">

                View

            </a>

            <form action="{{ route('cart.add',$product->id) }}" method="POST">

                @csrf

                <button class="cart-btn">

                    Add

                </button>

            </form>

        </div>

    </div>

</div>

@empty

<div class="empty-products">

    <i class="bi bi-bag-x"></i>

    <h3>No Products Found</h3>

    <p>No products available in this category.</p>

</div>

@endforelse

@if($products->hasPages())

<div class="pagination-wrapper">

    {{ $products->links() }}

</div>

@endif

</div>

</div>

</div>

@endsection