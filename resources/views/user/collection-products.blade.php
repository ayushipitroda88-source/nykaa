@extends('user.index')

@section('title', $collection->name . ' - NYKAA')

@section('content')

<style>
.collection-page{
    max-width:100%;
    margin:30px 0;
    padding:0 55px;
}

.back-btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
    color:#333;
    font-weight:600;
    margin-bottom:20px;
}

.back-btn:hover{
    color:#fc2779;
}

.breadcrumb-box{
    margin-bottom:25px;
    color:#777;
    font-size:14px;
}

.collection-wrapper{
    display:flex;
    gap:30px;
}

.collection-products{
    flex:1;
}

.collection-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
    padding-bottom:15px;
    border-bottom:1px solid #eaeaea;
    flex-wrap:wrap;
    gap:12px;
}

.collection-header h2{
    font-size:24px;
    font-weight:800;
    color:#fc2779;
    text-transform:uppercase;
    margin:0;
}

.collection-header .header-info{
    display:flex;
    gap:20px;
    align-items:center;
}

.products-count{
    color:#666;
    font-weight:500;
    font-size:14px;
}

.sort-dropdown{
    display:flex;
    align-items:center;
    gap:8px;
}

.sort-dropdown label{
    font-size:13px;
    font-weight:600;
    color:#666;
    white-space:nowrap;
}

.sort-dropdown select{
    padding:8px 32px 8px 12px;
    border:1.5px solid #e0e0e0;
    border-radius:8px;
    font-size:13px;
    font-weight:500;
    color:#333;
    background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23999' d='M6 8L1 3h10z'/%3E%3C/svg%3E") no-repeat right 12px center;
    appearance:none;
    cursor:pointer;
    outline:none;
    transition:border-color 0.2s;
    min-width:160px;
}

.sort-dropdown select:focus{
    border-color:#fc2779;
}

.product-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:25px;
}

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
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:16px;
    color:#aaa;
}

.wishlist-icon.wishlisted{
    color:#fc2779 !important;
    background:#fff0f5;
}

.wishlist-icon:hover{
    background:#fc2779;
    color:#fff !important;
}

.product-image{
    display:block;
    width:100%;
    height:280px;
    overflow:hidden;
}

.product-image img{
    width:100%;
    height:100%;
    object-fit:contain;
    transition:.4s;
    background:#f8f8f8;
    padding:10px;
}

.product-card:hover img{
    transform:scale(1.08);
}

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

.price{
    margin-top:10px;
    font-size:21px;
    font-weight:700;
    color:#fc2779;
}

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

.product-buttons{
    margin-top:18px;
    display:flex;
    gap:10px;
}

.view-btn,.cart-btn{
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

.empty-products{
    grid-column:1/-1;
    text-align:center;
    padding:80px;
}

.empty-products i{
    font-size:70px;
    color:#ccc;
}

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

@media(max-width:1200px){
    .product-grid{grid-template-columns:repeat(3,1fr);}
}

@media(max-width:992px){
    .collection-page{padding:0 20px;}
    .collection-wrapper{flex-direction:column;}
    .product-grid{grid-template-columns:repeat(2,1fr);}
    .collection-header{flex-direction:column;align-items:flex-start;}
    .header-info{width:100%;justify-content:space-between;}
}

@media(max-width:600px){
    .product-grid{grid-template-columns:1fr;}
    .product-image{height:240px;}
}

.discount-badge{
    position:absolute;
    top:12px;
    left:12px;
    background:linear-gradient(135deg,#fc2779,#ff5ba8);
    color:#fff;
    padding:6px 14px;
    border-radius:30px;
    font-size:12px;
    font-weight:700;
    z-index:5;
    box-shadow:0 5px 18px rgba(252,39,121,0.35);
}
</style>

<div class="collection-page">

<div style="margin-bottom:25px;">
    <a href="javascript:history.back()" class="back-btn">
        <i class="bi bi-arrow-left"></i> Back
    </a>
    <div class="breadcrumb-box">
        Home / Collections / <strong>{{ $collection->name }}</strong>
    </div>
</div>

<div class="collection-wrapper">

    <!-- LEFT - Filters -->
    @include('user.partials.filter-sidebar')

    <!-- RIGHT -->
    <div class="collection-products">

        <div class="collection-header">
            <h2>{{ $collection->name }}</h2>
            <div class="header-info">
                <span class="products-count">
                    {{ $products->total() }} Products Found
                </span>
                <div class="sort-dropdown">
                    <label>Sort By:</label>
                    <select onchange="applySort(this.value)">
                        <option value="newest" {{ request('sort','newest')=='newest'?'selected':'' }}>Newest</option>
                        <option value="price_asc" {{ request('sort')=='price_asc'?'selected':'' }}>Price Low → High</option>
                        <option value="price_desc" {{ request('sort')=='price_desc'?'selected':'' }}>Price High → Low</option>
                        <option value="name_asc" {{ request('sort')=='name_asc'?'selected':'' }}>A-Z</option>
                        <option value="name_desc" {{ request('sort')=='name_desc'?'selected':'' }}>Z-A</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="product-grid">

            @forelse($products as $product)
            <div class="product-card">

                <form action="{{ route('wishlist.add',$product->id) }}" method="POST" class="wishlist-form">
                    @csrf
                    <button type="submit" class="wishlist-icon {{ in_array($product->id, $wishlistProductIds) ? 'wishlisted' : '' }}">
                        @if(in_array($product->id, $wishlistProductIds))
                            <i class="bi bi-heart-fill"></i>
                        @else
                            <i class="bi bi-heart"></i>
                        @endif
                    </button>
                </form>

                @php
                    $hasDiscount = false;
                    $discountPct = 0;
                    if($collection->discount > 0 && $collection->discount_start && $collection->discount_end && now()->between($collection->discount_start, $collection->discount_end)){
                        $hasDiscount = true;
                        $discountPct = $collection->discount;
                    }
                @endphp

                @if($hasDiscount)
                    <span class="discount-badge">-{{ $discountPct }}%</span>
                @endif

                <a href="{{ route('product.show', $product->id) }}?collection_id={{ $collection->id }}" class="product-image">
                    @if($product->image)
                        <img src="{{ asset('uploads/'.$product->image) }}" alt="{{ $product->title }}">
                    @else
                        <img src="https://via.placeholder.com/300x350">
                    @endif
                </a>

                <div class="product-info">
                    <div class="product-name">
                        <a href="{{ route('product.show', $product->id) }}?collection_id={{ $collection->id }}">
                            {{ Str::limit($product->title,45) }}
                        </a>
                    </div>
                    <div class="price">
                        @if($hasDiscount)
                            ₹{{ number_format($product->price - ($product->price * $discountPct / 100), 2) }}
                            <span style="font-size:14px;color:#aaa;text-decoration:line-through;font-weight:400;">₹{{ number_format($product->price,2) }}</span>
                        @else
                            ₹{{ number_format($product->price,2) }}
                        @endif
                    </div>

                    @if($product->quantity>0)
                        <span class="stock in-stock">In Stock</span>
                    @else
                        <span class="stock out-stock">Out of Stock</span>
                    @endif

                    <div class="product-buttons">
                        <a href="{{ route('product.show', $product->id) }}?collection_id={{ $collection->id }}" class="view-btn">View</a>
                        <form action="{{ route('cart.add',$product->id) }}" method="POST">
                            @csrf
                            <button class="cart-btn">Add</button>
                        </form>
                    </div>
                </div>

            </div>
            @empty
            <div class="empty-products">
                <i class="bi bi-bag-x"></i>
                <h3>No Products Found</h3>
                <p>No products available in this collection.</p>
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

@push('page-scripts')
<script>
function applySort(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('sort', value);
    window.location.href = url.toString();
}
</script>
@endpush

@endsection