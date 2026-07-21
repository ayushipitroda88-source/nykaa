@extends('user.index')

@push('page-styles')
<style>
    /* ==========================================
       GOOGLE FONTS
    ========================================== */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    /* ==========================================
       SEARCH / BRAND PAGE
    ========================================== */
    .brand-page {
        padding: 50px 0;
        background: #f8f9fb;
        font-family: 'Poppins', sans-serif;
    }

    .brand-page .container {
        width: 92%;
        max-width: 1300px;
        margin: 0 auto;
    }

    /* ==========================================
       BRAND HEADER
    ========================================== */
    .brand-header {
        background: linear-gradient(135deg, #fc2779, #ff5ba8);
        border-radius: 24px;
        padding: 45px 50px;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 35px;
        margin-bottom: 40px;
        box-shadow: 0 15px 40px rgba(252, 39, 121, 0.25);
        position: relative;
        overflow: hidden;
    }

    .brand-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .brand-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: 10%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .brand-header-logo {
        width: 100px;
        height: 100px;
        border-radius: 20px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .brand-header-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .brand-header-logo .brand-initial {
        font-size: 36px;
        font-weight: 800;
        color: #fc2779;
    }

    .brand-header-info {
        position: relative;
        z-index: 1;
        flex: 1;
    }

    .brand-header-info h1 {
        font-size: 34px;
        font-weight: 700;
        margin: 0 0 6px 0;
        letter-spacing: -0.5px;
    }

    .brand-header-info .brand-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .brand-header-info .brand-meta span {
        font-size: 15px;
        opacity: 0.9;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .brand-header-info .brand-meta svg {
        width: 18px;
        height: 18px;
    }

    .brand-header-info .product-count-badge {
        background: rgba(255, 255, 255, 0.2);
        padding: 6px 18px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 14px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    /* ==========================================
       SEARCH HEADER (when searching)
    ========================================== */
    .search-header {
        background: #fff;
        border-radius: 20px;
        padding: 35px 40px;
        margin-bottom: 40px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.04);
        border: 1px solid #f0f0f0;
    }

    .search-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 6px 0;
    }

    .search-header p {
        color: #718096;
        font-size: 15px;
        margin: 0;
    }

    .search-header p strong {
        color: #fc2779;
    }

    /* ==========================================
       FILTER / SORT BAR
    ========================================== */
    .filter-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        background: #fff;
        padding: 16px 24px;
        border-radius: 16px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.03);
        border: 1px solid #f0f0f0;
        flex-wrap: wrap;
        gap: 15px;
    }

    .filter-bar .result-count {
        font-size: 15px;
        color: #4a5568;
        font-weight: 500;
    }

    .filter-bar .result-count strong {
        color: #1a1a1a;
        font-weight: 700;
    }

    .filter-bar .sort-select {
        padding: 10px 18px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
        color: #4a5568;
        background: #f8f9fb;
        cursor: pointer;
        outline: none;
        transition: border-color 0.2s;
    }

    .filter-bar .sort-select:focus {
        border-color: #fc2779;
    }

    .filter-bar .view-toggle {
        display: flex;
        gap: 6px;
    }

    .filter-bar .view-toggle button {
        width: 38px;
        height: 38px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #a0aec0;
        transition: all 0.2s;
    }

    .filter-bar .view-toggle button.active {
        background: #fc2779;
        color: #fff;
        border-color: #fc2779;
    }

    .filter-bar .view-toggle button:hover {
        border-color: #fc2779;
        color: #fc2779;
    }

    .filter-bar .view-toggle button.active:hover {
        color: #fff;
    }

    /* ==========================================
       PRODUCT GRID
    ========================================== */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 28px;
    }

    /* ==========================================
       PRODUCT CARD
    ========================================== */
    .product-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.06);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid #f0f0f0;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        border-color: #fc2779;
    }

    .product-card .product-image-wrapper {
        height: 280px;
        overflow: hidden;
        position: relative;
        background: #f8f8f8;
    }

    .product-card .product-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.6s ease;
        background: #f8f8f8;
        padding: 8px;
    }

    .product-card:hover .product-image-wrapper img {
        transform: scale(1.08);
    }

    /* Discount Badge */
    .discount-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: #fc2779;
        color: #fff;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(252, 39, 121, 0.4);
        z-index: 2;
    }

    /* Wishlist Button */
    .wishlist-btn {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 40px;
        height: 40px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        z-index: 2;
        color: #cbd5e0;
        font-size: 18px;
    }

    .wishlist-btn:hover {
        transform: scale(1.1);
        color: #fc2779;
    }

    .wishlist-btn.active {
        color: #fc2779;
    }

    /* Quick Add to Cart */
    .quick-cart-btn {
        position: absolute;
        bottom: 14px;
        right: 14px;
        width: 44px;
        height: 44px;
        background: #fc2779;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        z-index: 2;
        color: #fff;
        font-size: 20px;
        box-shadow: 0 4px 15px rgba(252, 39, 121, 0.35);
        opacity: 0;
        transform: translateY(10px);
    }

    .product-card:hover .quick-cart-btn {
        opacity: 1;
        transform: translateY(0);
    }

    .quick-cart-btn:hover {
        background: #1a1a1a;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
    }

    /* Product Info */
    .product-card .product-info {
        padding: 20px;
    }

    .product-card .product-category {
        font-size: 12px;
        color: #fc2779;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 6px;
    }

    .product-card .product-info h3 {
        font-size: 17px;
        font-weight: 600;
        color: #1a1a1a;
        margin: 0 0 10px 0;
        line-height: 26px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 52px;
    }

    .product-card .product-info h3 a {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s;
    }

    .product-card .product-info h3 a:hover {
        color: #fc2779;
    }

    /* Rating */
    .rating-stars {
        display: flex;
        align-items: center;
        gap: 4px;
        margin-bottom: 12px;
    }

    .rating-stars .star {
        color: #ffb400;
        font-size: 14px;
    }

    .rating-stars .star.empty {
        color: #e2e8f0;
    }

    .rating-stars .rating-count {
        font-size: 12px;
        color: #a0aec0;
        margin-left: 6px;
    }

    /* Price */
    .price-box {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
    }

    .price-current {
        font-size: 22px;
        font-weight: 700;
        color: #fc2779;
    }

    .price-old {
        font-size: 15px;
        color: #a0aec0;
        text-decoration: line-through;
    }

    .price-discount-pct {
        font-size: 12px;
        font-weight: 600;
        color: #38a169;
        background: #f0fff4;
        padding: 3px 10px;
        border-radius: 20px;
    }

    /* View Details Button */
    .view-details-btn {
        display: block;
        width: 100%;
        text-align: center;
        padding: 12px;
        background: #f8f9fb;
        color: #4a5568;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
        border: 1px solid #e2e8f0;
    }

    .view-details-btn:hover {
        background: #fc2779;
        color: #fff;
        border-color: #fc2779;
    }

    /* ==========================================
       EMPTY STATE
    ========================================== */
    .no-result {
        grid-column: 1 / -1;
        text-align: center;
        padding: 80px 20px;
        background: #fff;
        border-radius: 20px;
        border: 1px solid #f0f0f0;
    }

    .no-result .empty-icon {
        font-size: 60px;
        margin-bottom: 20px;
        display: block;
    }

    .no-result h3 {
        font-size: 24px;
        font-weight: 700;
        color: #2d3748;
        margin: 0 0 10px 0;
    }

    .no-result p {
        font-size: 15px;
        color: #718096;
        margin: 0 0 25px 0;
    }

    .no-result .shop-now-btn {
        display: inline-block;
        background: #fc2779;
        color: #fff;
        padding: 14px 35px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
    }

    .no-result .shop-now-btn:hover {
        background: #1a1a1a;
        transform: translateY(-2px);
    }

    /* ==========================================
       ALL PRODUCTS HEADER
    ========================================== */
    .all-products-header {
        background: #fff;
        border-radius: 20px;
        padding: 35px 40px;
        margin-bottom: 40px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.04);
        border: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .all-products-header .all-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #fc2779, #ff5ba8);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 28px;
        flex-shrink: 0;
    }

    .all-products-header .all-info h1 {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 4px 0;
    }

    .all-products-header .all-info p {
        font-size: 14px;
        color: #718096;
        margin: 0;
    }

    /* ==========================================
       RESPONSIVE
    ========================================== */
    @media (max-width: 768px) {
        .brand-header {
            flex-direction: column;
            text-align: center;
            padding: 30px 25px;
        }
        .brand-header-logo {
            width: 80px;
            height: 80px;
        }
        .brand-header-info h1 {
            font-size: 26px;
        }
        .brand-header-info .brand-meta {
            justify-content: center;
        }
        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 16px;
        }
        .product-card .product-image-wrapper {
            height: 200px;
        }
        .product-card .product-info h3 {
            font-size: 15px;
            min-height: auto;
        }
        .search-header {
            padding: 25px 20px;
        }
        .all-products-header {
            flex-direction: column;
            text-align: center;
            padding: 25px 20px;
        }
    }

    @media (max-width: 480px) {
        .products-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .product-card .product-image-wrapper {
            height: 170px;
        }
        .product-card .product-info {
            padding: 14px;
        }
        .price-current {
            font-size: 18px;
        }
    }
</style>
@endpush

@section('content')

<div class="brand-page">

    <div class="container" style="display:flex; gap:30px;">

        <!-- LEFT - Filters -->
        <div style="width:260px; flex-shrink:0;">
            @include('user.partials.filter-sidebar')
        </div>

        <div style="flex:1; min-width:0;">

        @if(isset($seller))
            <!-- ========== BRAND HEADER (Seller) ========== -->
            <div class="brand-header">
                <div class="brand-header-logo">
                    @if($seller->business_logo)
                        <img src="{{ asset('storage/' . $seller->business_logo) }}" alt="{{ $seller->business_name }}">
                    @else
                        <span class="brand-initial">{{ substr($seller->business_name, 0, 1) }}</span>
                    @endif
                </div>
                <div class="brand-header-info">
                    <h1>{{ $seller->business_name }}</h1>
                    <div class="brand-meta">
                        <span>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            {{ $products->count() }} Products
                        </span>
                        <span class="product-count-badge">Premium Seller</span>
                    </div>
                </div>
            </div>

        @elseif(isset($brand))
            <!-- ========== BRAND HEADER ========== -->
            <div class="brand-header">
                <div class="brand-header-logo">
                    @if($brand->image)
                        <img src="{{ asset('uploads/' . $brand->image) }}" alt="{{ $brand->name }}">
                    @else
                        <span class="brand-initial">{{ substr($brand->name, 0, 1) }}</span>
                    @endif
                </div>
                <div class="brand-header-info">
                    <h1>{{ $brand->name }}</h1>
                    <div class="brand-meta">
                        <span>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            {{ $products->count() }} Products
                        </span>
                        <span class="product-count-badge">Top Brand</span>
                    </div>
                </div>
            </div>

        @elseif(isset($search) && $search != '')
            <!-- ========== SEARCH HEADER ========== -->
            <div class="search-header">
                <h1>Search Results</h1>
                <p>Showing results for "<strong>{{ $search }}</strong>" — <strong>{{ $products->count() }}</strong> products found</p>
            </div>

        @else
            <!-- ========== ALL PRODUCTS HEADER ========== -->
            <div class="all-products-header">
                <div class="all-icon">🛍️</div>
                <div class="all-info">
                    <h1>All Products</h1>
                    <p>Showing <strong>{{ $products->count() }}</strong> products</p>
                </div>
            </div>
        @endif

        @if(count($products) > 0)

            <!-- ========== FILTER BAR ========== -->
            <div class="filter-bar">
                <div class="result-count">
                    Showing <strong>{{ $products->total() }}</strong> product{{ $products->total() > 1 ? 's' : '' }}
                </div>
                <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                    <select class="sort-select" id="sortSelectSearch" onchange="applySortSearch(this.value)">
                        <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price Low → High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price High → Low</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Z-A</option>
                    </select>
                </div>
            </div>

            <!-- ========== PRODUCT GRID ========== -->
            <div class="products-grid" id="productGrid">

                @forelse($products as $product)

                <div class="product-card" data-price="{{ $product->price }}" data-name="{{ $product->title }}">
                    <div class="product-image-wrapper">
                        <a href="{{ route('product.show', $product->id) }}">
                            @if($product->image)
                                <img src="{{ asset('uploads/'.$product->image) }}" alt="{{ $product->title }}">
                            @else
                                <img src="https://via.placeholder.com/300x400" alt="No Image">
                            @endif
                        </a>

                        @if($product->old_price && $product->old_price > $product->price)
                            @php $discount = round((($product->old_price - $product->price) / $product->old_price) * 100); @endphp
                            <span class="discount-badge">-{{ $discount }}%</span>
                        @endif

                        <button class="wishlist-btn" onclick="toggleWishlist({{ $product->id }}, this)">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="quick-cart-btn" title="Add to Cart">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <div class="product-info">
                        <div class="product-category">{{ $product->category->name ?? 'General' }}</div>
                        <h3>
                            <a href="{{ route('product.show', $product->id) }}">
                                {{ $product->title }}
                            </a>
                        </h3>

                        
                        
                        <div class="price-box">
                            <span class="price-current">₹{{ number_format($product->price, 0) }}</span>
                            @if($product->old_price && $product->old_price > $product->price)
                                <span class="price-old">₹{{ number_format($product->old_price, 0) }}</span>
                                @php $discount = round((($product->old_price - $product->price) / $product->old_price) * 100); @endphp
                                <span class="price-discount-pct">{{ $discount }}% OFF</span>
                            @endif
                        </div>

                        <a href="{{ route('product.show', $product->id) }}" class="view-details-btn">
                            View Details
                        </a>
                    </div>
                </div>

                @empty
                    <div class="no-result">
                        <span class="empty-icon">🔍</span>
                        <h3>No Products Found</h3>
                        <p>We couldn't find any products matching your criteria.</p>
                        <a href="{{ route('home') }}" class="shop-now-btn">Browse All Products</a>
                    </div>
                @endforelse

            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div style="margin-top:40px; display:flex; justify-content:center;">
                {{ $products->links() }}
            </div>
            @endif

        @else
            <!-- ========== EMPTY STATE ========== -->
            <div class="no-result">
                <span class="empty-icon">
                    @if(isset($seller) || isset($brand))
                        📦
                    @elseif(isset($search) && $search != '')
                        🔍
                    @else
                        🛍️
                    @endif
                </span>
                <h3>
                    @if(isset($seller))
                        No products from {{ $seller->business_name }} yet
                    @elseif(isset($brand))
                        No products from {{ $brand->name }} yet
                    @elseif(isset($search) && $search != '')
                        No results found
                    @else
                        No products available
                    @endif
                </h3>
                <p>
                    @if(isset($search) && $search != '')
                        Try searching with different keywords or browse our catalog.
                    @else
                        Check back later for new arrivals!
                    @endif
                </p>
                <a href="{{ route('home') }}" class="shop-now-btn">
                    @if(isset($search) && $search != '')
                        Browse All Products
                    @else
                        Continue Shopping
                    @endif
                </a>
            </div>
        @endif

    </div>
    </div>

</div>

@endsection

@push('page-scripts')
<script>
    // ========== SORT ==========
    function applySortSearch(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', value);
        window.location.href = url.toString();
    }

    // ========== WISHLIST TOGGLE ==========
    function toggleWishlist(productId, btn) {
        fetch('/wishlist/add/' + productId, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                btn.classList.toggle('active');
            }
        })
        .catch(() => {
            window.location.href = '{{ route("login") }}';
        });
    }
</script>
@endpush
