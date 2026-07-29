@extends('user.index')

@section('title', $category->name)

@section('content')

<style>
/* ============================================================
   CATEGORY PAGE LAYOUT
============================================================ */
.category-page {
    max-width: 100%;
    margin: 28px 0 40px;
    padding: 0 48px 0 0;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    text-decoration: none;
    color: #555;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 6px;
    transition: color .2s;
}
.back-btn:hover { color: #fc2779; }

.breadcrumb-box {
    color: #999;
    font-size: 13px;
    margin-bottom: 22px;
}
.breadcrumb-box a { color: #fc2779; text-decoration: none; }
.breadcrumb-box a:hover { text-decoration: underline; }

/* Two-column wrapper */
.category-wrapper {
    display: flex;
    gap: 28px;
    align-items: flex-start;
}

/* RIGHT column */
.category-products { flex: 1; min-width: 0; }

/* Sort & count bar */
.category-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
    padding: 14px 20px;
    background: #fff;
    border-radius: 14px;
    border: 1px solid #f0f0f0;
    box-shadow: 0 2px 10px rgba(0,0,0,.04);
    flex-wrap: wrap;
    gap: 12px;
}
.category-header h2 {
    font-size: 20px;
    font-weight: 800;
    color: #1a1a1a;
    margin: 0;
}
.category-header h2 span { color: #fc2779; }
.header-info {
    display: flex;
    gap: 16px;
    align-items: center;
    flex-wrap: wrap;
}
.products-count {
    color: #888;
    font-size: 13px;
    font-weight: 500;
}
.sort-dropdown { display: flex; align-items: center; gap: 8px; }
.sort-dropdown label {
    font-size: 13px;
    font-weight: 600;
    color: #666;
    white-space: nowrap;
}
.sort-dropdown select {
    padding: 8px 30px 8px 12px;
    border: 1.5px solid #e8e8e8;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 500;
    color: #333;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23999' d='M6 8L1 3h10z'/%3E%3C/svg%3E") no-repeat right 10px center;
    appearance: none;
    cursor: pointer;
    outline: none;
    transition: border-color .2s;
    min-width: 155px;
}
.sort-dropdown select:focus { border-color: #fc2779; }

/* ============================================================
   PREMIUM PRODUCT GRID
============================================================ */
.product-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

/* CARD */
.product-card {
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    position: relative;
    transition: transform .35s ease, box-shadow .35s ease;
    border: 1px solid #f0f0f0;
    box-shadow: 0 3px 14px rgba(0,0,0,.05);
    display: flex;
    flex-direction: column;
}
.product-card:hover {
    transform: translateY(-7px);
    box-shadow: 0 18px 40px rgba(0,0,0,.11);
    border-color: #ffd6e8;
}

/* Image area */
.product-image-wrapper {
    position: relative;
    height: 270px;
    overflow: hidden;
    background: #f8f8f8;
    flex-shrink: 0;
}
.product-image-wrapper a {
    display: block;
    width: 100%;
    height: 100%;
}
.product-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 12px;
    transition: transform .45s ease;
    background: #f8f8f8;
}
.product-card:hover .product-image-wrapper img { transform: scale(1.07); }

/* Discount badge */
.discount-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: linear-gradient(135deg, #fc2779, #ff5ba8);
    color: #fff;
    padding: 5px 12px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .3px;
    box-shadow: 0 4px 12px rgba(252,39,121,.35);
    z-index: 3;
}

/* Wishlist button */
.wishlist-form {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 10;
}
.wishlist-icon {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 50%;
    background: #fff;
    cursor: pointer;
    box-shadow: 0 3px 12px rgba(0,0,0,.13);
    transition: all .3s;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    color: #bbb;
}
.wishlist-icon:hover { background: #fc2779; color: #fff !important; transform: scale(1.1); }
.wishlist-icon.wishlisted { color: #fc2779 !important; background: #fff0f5; }

/* Quick cart hover button */
.quick-cart-form {
    position: absolute;
    bottom: 12px;
    right: 12px;
    z-index: 10;
    opacity: 0;
    transform: translateY(8px);
    transition: all .3s ease;
}
.product-card:hover .quick-cart-form { opacity: 1; transform: translateY(0); }
.quick-cart-btn {
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 50%;
    background: #fc2779;
    color: #fff;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(252,39,121,.4);
    transition: background .2s;
}
.quick-cart-btn:hover { background: #d91d66; }

/* Product info */
.product-info {
    padding: 14px 16px 16px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.product-brand {
    font-size: 11px;
    font-weight: 700;
    color: #fc2779;
    text-transform: uppercase;
    letter-spacing: .8px;
    margin-bottom: 4px;
}
.product-name {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 40px;
    margin-bottom: 8px;
}
.product-name a {
    text-decoration: none;
    color: #1a1a1a;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.45;
}
.product-name a:hover { color: #fc2779; }

/* Ratings */
.rating-row {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 8px;
}
.rating-stars-sm { color: #ffb300; font-size: 12px; }
.rating-count-sm { font-size: 11px; color: #aaa; }

/* Price */
.price-box {
    display: flex;
    align-items: baseline;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 10px;
}
.price-current {
    font-size: 20px;
    font-weight: 800;
    color: #fc2779;
}
.price-old {
    font-size: 13px;
    color: #bbb;
    text-decoration: line-through;
}
.price-save {
    font-size: 11px;
    font-weight: 700;
    color: #2ecc71;
    background: #eafaf1;
    padding: 2px 8px;
    border-radius: 20px;
}

/* Stock badge */
.stock-badge {
    display: inline-block;
    font-size: 11px;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
    margin-bottom: 10px;
}
.in-stock { background: #eafaf1; color: #27ae60; }
.out-stock { background: #fdecea; color: #e74c3c; }

/* Action buttons */
.product-actions {
    display: flex;
    gap: 8px;
    margin-top: auto;
}
.view-btn {
    flex: 1;
    padding: 9px 10px;
    background: #f5f5f7;
    color: #333;
    border: none;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    text-align: center;
    text-decoration: none;
    transition: all .25s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}
.view-btn:hover { background: #eee; color: #222; }
.cart-btn {
    flex: 1;
    padding: 9px 10px;
    background: linear-gradient(135deg, #fc2779, #ff5ba8);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all .25s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}
.cart-btn:hover { background: linear-gradient(135deg, #d91d66, #fc2779); transform: translateY(-1px); }
.cart-btn:disabled { opacity: .6; cursor: not-allowed; }

/* Empty */
.empty-products {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 20px;
    background: #fff;
    border-radius: 20px;
    border: 1px solid #f0f0f0;
}
.empty-products i { font-size: 64px; color: #ddd; }
.empty-products h3 { margin-top: 16px; color: #555; }

/* Pagination */
.pagination-wrapper {
    margin-top: 40px;
    display: flex;
    justify-content: center;
}
.pagination { gap: 6px; }
.pagination .page-link {
    border: none;
    border-radius: 10px;
    color: #555;
    padding: 9px 15px;
    font-weight: 600;
    transition: all .2s;
}
.pagination .active .page-link {
    background: linear-gradient(135deg, #fc2779, #ff5ba8);
    color: #fff;
    box-shadow: 0 4px 12px rgba(252,39,121,.3);
}
.pagination .page-link:hover:not(.active .page-link) {
    background: #fff0f5;
    color: #fc2779;
}

/* Responsive */
@media (max-width:1300px) { .product-grid { grid-template-columns: repeat(3,1fr); } }
@media (max-width:992px) {
    .category-page { padding: 0 16px; }
    .category-wrapper { flex-direction: column; }
    .product-grid { grid-template-columns: repeat(2,1fr); }
    .category-header { flex-direction: column; align-items: flex-start; }
}
@media (max-width:576px) {
    .product-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
    .product-image-wrapper { height: 210px; }
    .sort-dropdown select { min-width: 120px; }
}
</style>

<div class="category-page">

    <div style="margin-bottom: 20px;">
        <a href="javascript:history.back()" class="back-btn">
            <i class="bi bi-arrow-left"></i> Back
        </a>
        <div class="breadcrumb-box">
            <a href="{{ url('/') }}">Home</a> /
            @if($category->parent)
                <a href="{{ route('category.show', $category->parent->id) }}">{{ $category->parent->name }}</a> /
            @endif
            <strong>{{ $category->name }}</strong>
        </div>
    </div>

    <div class="category-wrapper">

        <!-- LEFT - Filter Sidebar -->
        @include('user.partials.filter-sidebar')

        <!-- RIGHT -->
        <div class="category-products">

            <!-- Header Bar -->
            <div class="category-header">
                <h2>{{ $category->name }} <span style="font-size:14px;font-weight:500;color:#aaa;">({{ $products->total() }} items)</span></h2>
                <div class="header-info">
                    <div class="sort-dropdown">
                        <label for="sortSelectCat"><i class="bi bi-sort-down"></i> Sort:</label>
                        <select id="sortSelectCat" onchange="applySort(this.value)">
                            <option value="newest"     {{ request('sort','newest')=='newest'     ? 'selected':'' }}>Newest</option>
                            <option value="price_asc"  {{ request('sort')=='price_asc'           ? 'selected':'' }}>Price: Low → High</option>
                            <option value="price_desc" {{ request('sort')=='price_desc'          ? 'selected':'' }}>Price: High → Low</option>
                            <option value="name_asc"   {{ request('sort')=='name_asc'            ? 'selected':'' }}>A – Z</option>
                            <option value="name_desc"  {{ request('sort')=='name_desc'           ? 'selected':'' }}>Z – A</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- PRODUCT GRID -->
            <div class="product-grid">

            @forelse($products as $product)

            @php
                $hasDiscount = $product->old_price && $product->old_price > $product->price;
                $discountPct = $hasDiscount ? round((($product->old_price - $product->price) / $product->old_price) * 100) : 0;
                $avgRating   = $product->reviews_avg_rating ? round($product->reviews_avg_rating, 1) : 0;
                $reviewCount = $product->reviews_count ?? 0;
            @endphp

            <div class="product-card">

                <!-- Discount badge -->
                @if($hasDiscount)
                    <span class="discount-badge">{{ $discountPct }}% OFF</span>
                @endif

                <!-- Wishlist -->
                <form action="{{ route('wishlist.add', $product->id) }}" method="POST" class="wishlist-form">
                    @csrf
                    <button type="submit"
                        class="wishlist-icon {{ in_array($product->id, $wishlistProductIds ?? []) ? 'wishlisted' : '' }}"
                        title="{{ in_array($product->id, $wishlistProductIds ?? []) ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                        <i class="{{ in_array($product->id, $wishlistProductIds ?? []) ? 'bi bi-heart-fill' : 'bi bi-heart' }}"></i>
                    </button>
                </form>

                <!-- Quick-add hover button -->
                @if($product->quantity > 0)
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="quick-cart-form">
                    @csrf
                    <button type="submit" class="quick-cart-btn" title="Quick Add to Cart">
                        <i class="bi bi-cart-plus"></i>
                    </button>
                </form>
                @endif

                <!-- Image -->
                <div class="product-image-wrapper">
                    <a href="{{ route('product.show', $product->id) }}">
                        @if($product->image)
                            <img src="{{ asset('uploads/'.$product->image) }}" alt="{{ $product->title }}">
                        @else
                            <img src="https://placehold.co/300x300?text=No+Image" alt="No Image">
                        @endif
                    </a>
                </div>

                <!-- Info -->
                <div class="product-info">
                    @if($product->brand)
                        <div class="product-brand">{{ $product->brand->name }}</div>
                    @endif

                    <div class="product-name">
                        <a href="{{ route('product.show', $product->id) }}">{{ Str::limit($product->title, 55) }}</a>
                    </div>

                    @if($reviewCount > 0)
                    <div class="rating-row">
                        <span class="rating-stars-sm">
                            @for($s=1;$s<=5;$s++)
                                <i class="bi {{ $s <= round($avgRating) ? 'bi-star-fill' : ($s - 0.5 <= $avgRating ? 'bi-star-half' : 'bi-star') }}"></i>
                            @endfor
                        </span>
                        <span class="rating-count-sm">({{ $reviewCount }})</span>
                    </div>
                    @endif

                    <div class="price-box">
                        <span class="price-current">₹{{ number_format($product->price, 0) }}</span>
                        @if($hasDiscount)
                            <span class="price-old">₹{{ number_format($product->old_price, 0) }}</span>
                            <span class="price-save">Save ₹{{ number_format($product->old_price - $product->price, 0) }}</span>
                        @endif
                    </div>

                    <span class="stock-badge {{ $product->quantity > 0 ? 'in-stock' : 'out-stock' }}">
                        {{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>

                    <div class="product-actions">
                        <a href="{{ route('product.show', $product->id) }}" class="view-btn">
                            <i class="bi bi-eye"></i> View
                        </a>
                        @if($product->quantity > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" style="flex:1;">
                            @csrf
                            <button class="cart-btn" style="width:100%;">
                                <i class="bi bi-bag-plus"></i> Add
                            </button>
                        </form>
                        @else
                        <button class="cart-btn" disabled style="flex:1;">Sold Out</button>
                        @endif
                    </div>
                </div>

            </div>

            @empty

            <div class="empty-products">
                <i class="bi bi-bag-x"></i>
                <h3>No Products Found</h3>
                <p style="color:#999;">Try adjusting your filters or search terms.</p>
            </div>

            @endforelse

            </div>{{-- /.product-grid --}}

            @if($products->hasPages())
            <div class="pagination-wrapper">
                {{ $products->links() }}
            </div>
            @endif

        </div>{{-- /.category-products --}}

    </div>{{-- /.category-wrapper --}}

</div>{{-- /.category-page --}}

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