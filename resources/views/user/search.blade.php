@extends('user.index')

@push('page-styles')
<style>
    /* =========================
   SEARCH PAGE
========================= */

.search-page{
    padding:40px 0;
    background:#f8f9fb;
}

.search-page .container{
    width:90%;
    max-width:1200px;
    margin:auto;
}

.section-title{
    font-size:28px;
    font-weight:bold;
    margin-bottom:20px;
    color:#222;
}

/* Grid */
.products-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}

/* Product Card */
.product-card{
    background:#fff;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 3px 12px rgba(0,0,0,0.08);
    transition:0.3s;
    text-align:center;
}

.product-card:hover{
    transform:translateY(-5px);
}

.product-card img{
    width:100%;
    height:220px;
    object-fit:cover;
}

/* Info */
.product-info{
    padding:15px;
}

.product-info h3{
    font-size:16px;
    margin-bottom:5px;
    color:#222;
}

.category{
    font-size:13px;
    color:#777;
    margin-bottom:5px;
}

.price{
    font-size:16px;
    font-weight:bold;
    color:#ff3f6c;
    margin-bottom:10px;
}

/* Button */
.view-btn{
    display:inline-block;
    padding:8px 12px;
    background:#ff3f6c;
    color:#fff;
    border-radius:6px;
    text-decoration:none;
    font-size:14px;
}

.view-btn:hover{
    background:#e12f5c;
}

/* Empty state */
.no-result{
    grid-column:1/-1;
    text-align:center;
    font-size:18px;
    color:#888;
    padding:40px;
}
</style>
@endpush

@section('content')

<div class="search-page">

<div class="container">

<h2 class="section-title">Search Result</h2>

<div class="products-grid">

@forelse($products as $product)

<div class="product-card">

<a href="{{ route('product.show',$product->id) }}">

<img src="{{ asset('uploads/'.$product->image) }}" alt="{{ $product->title }}">

</a>

<div class="product-info">

<h3>{{ $product->title }}</h3>

<p class="category">
{{ $product->category->name ?? 'No Category' }}
</p>

<p class="price">
₹{{ number_format($product->price,2) }}
</p>

<a href="{{ route('product.show',$product->id) }}" class="view-btn">
View Details
</a>

</div>

</div>

@empty

<div class="no-result">
No Product Found
</div>

@endforelse

</div>

</div>

</div>

@endsection