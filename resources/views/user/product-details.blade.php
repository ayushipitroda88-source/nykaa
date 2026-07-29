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
@media(min-width:768px){
    .border-end-md {
        border-right: 1px solid #ddd !important;
    }
}
</style>
@endpush

@section('content')
<div class="product-page">
    @if(session('success'))
        <div class="alert alert-alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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

        @php
            $variantData = $product->variants->flatMap(function($v) {
                return $v->sizes->map(function($s) use ($v) {
                    return [
                        "id" => $s->id,
                        "color_id" => $v->color_id,
                        "size_id" => $s->size_id,
                        "price" => $s->price,
                        "quantity" => $s->quantity,
                        "image" => $v->image
                    ];
                });
            })->values();
        @endphp
        <div class="product-right" id="productContainer" data-variants="{{ json_encode($variantData) }}">
            
            @if($product->category)
                <div class="product-category">{{ $product->category->name }}</div>
            @endif
            @if($product->brand)
                <div class="product-brand">{{ $product->brand->name }}</div>
            @endif

            <h1 class="product-title">{{ $product->title }}</h1>

            <div class="product-price" id="productPrice">
                @if($product->variants && $product->variants->count() && $product->variants->first()->sizes->count())
                    &#8377;{{ number_format($product->variants->first()->sizes->first()->price, 2) }}
                @else
                    &#8377;{{ number_format($product->price, 2) }}
                @endif
            </div>

            <div class="product-stock" id="stockStatusWrapper">
                @if($product->variants && $product->variants->count() && $product->variants->first()->sizes->count())
                    @if($product->variants->first()->sizes->first()->quantity > 0)
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
                        @foreach($product->variants->sortBy('priority') as $index => $variant)
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
                        @php
                            $allSizes = collect();
                            foreach($product->variants as $variant) {
                                foreach($variant->sizes as $vs) {
                                    $allSizes->push($vs->size);
                                }
                            }
                            $uniqueSizes = $allSizes->unique('id');
                        @endphp
                        @foreach($uniqueSizes as $index => $size)
                            @if($size)
                                <div class="size-option {{ $index == 0 ? 'active' : '' }}"
                                     data-id="{{ $size->id }}"> 
                                    {{ $size->name }}
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

    @php
        $canReview = false;
        $userReview = null;
        if (auth()->check()) {
            $confirmedOrderItem = \App\Models\OrderItem::whereHas('order', function ($q) {
                $q->where('user_id', auth()->id())->where('status', 'confirmed');
            })->where('product_id', $product->id)->first();

            if ($confirmedOrderItem) {
                $canReview = true;
                $userReview = \App\Models\Review::where('user_id', auth()->id())
                    ->where('product_id', $product->id)
                    ->first();
            }
        }
    @endphp

    <!-- ==============================================
         ENTERPRISE REVIEW & RATING SECTION
         =============================================== -->
    <div class="reviews-section mt-5 pt-4 border-top">
        <h2 class="section-title mb-4 font-weight-bold" style="font-size: 26px; color:#111;">
            Customer Ratings & Reviews
        </h2>

        <!-- Rating Summary & Breakdown Grid -->
        <div class="row g-4 mb-5 align-items-center bg-light p-4 rounded-4 shadow-sm mx-0">
            <!-- Left: Overall Rating -->
            <div class="col-md-4 text-center border-end-md pb-3 pb-md-0">
                <div class="display-3 font-weight-bold text-dark mb-1" style="font-weight: 800;">
                    {{ number_format($product->average_rating, 1) }}
                </div>
                <div class="stars-display fs-4 mb-2" style="color: #ffb400;">
                    @php $avgRating = round($product->average_rating); @endphp
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $avgRating) ★ @else <span style="color:#ddd;">★</span> @endif
                    @endfor
                </div>
                <div class="text-muted font-weight-medium mb-3">
                    Based on <strong>{{ $product->total_reviews }}</strong> {{ Str::plural('Review', $product->total_reviews) }}
                </div>

                <!-- ✍️ Write / Edit Review Button -->
                <div>
                    @if(auth()->check())
                        @if($canReview)
                            <button type="button" 
                                    class="btn text-white fw-bold px-4 py-2 rounded-pill shadow-sm" 
                                    style="background:#fc2779; transition: all 0.2s;" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#reviewModal-{{ $product->id }}">
                                <i class="bi bi-pencil-square me-1"></i> {{ $userReview ? 'Edit Your Review' : 'Rate Product' }}
                            </button>
                            <!-- Include Review Modal -->
                            @include('user.partials.review-modal', ['product' => $product, 'review' => $userReview])
                        @else
                            <button type="button" 
                                    class="btn btn-outline-secondary fw-bold px-4 py-2 rounded-pill shadow-sm" 
                                    onclick="alert('You can only rate and review products you have purchased and received. If you purchased it, please confirm order on your Orders page first.')">
                                ⭐ Rate Product
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary fw-bold px-4 py-2 rounded-pill shadow-sm">
                            ⭐ Login to Rate
                        </a>
                    @endif
                </div>
            </div>

            <!-- Right: Rating Breakdown Progress Bars -->
            <div class="col-md-8">
                <div class="pe-md-3">
                    @foreach($ratingData['breakdown'] as $star => $data)
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="text-nowrap fw-bold text-dark" style="width: 55px; font-size: 13px;">
                                {{ $star }} Star
                            </div>
                            <div class="progress flex-grow-1" style="height: 10px; background: #e9ecef; border-radius: 10px;">
                                <div class="progress-bar" 
                                     role="progressbar" 
                                     style="width: {{ $data['percentage'] }}%; background: {{ $star >= 4 ? '#28a745' : ($star == 3 ? '#ffc107' : '#dc3545') }}; border-radius: 10px;" 
                                     aria-valuenow="{{ $data['percentage'] }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100"></div>
                            </div>
                            <div class="text-muted small text-end" style="width: 50px;">
                                {{ $data['count'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Filter & Sorting Toolbar -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 pb-3 border-bottom">
            <!-- Filter Options -->
            <div class="d-flex gap-2 flex-wrap align-items-center">
                <span class="fw-bold text-dark me-2 small text-uppercase">Filter:</span>
                <a href="{{ request()->fullUrlWithQuery(['review_filter' => 'all']) }}" 
                   class="btn btn-sm rounded-pill {{ $ratingFilter === 'all' ? 'btn-dark' : 'btn-outline-secondary' }}">
                    All Reviews
                </a>
                @for($s = 5; $s >= 1; $s--)
                    <a href="{{ request()->fullUrlWithQuery(['review_filter' => $s]) }}" 
                       class="btn btn-sm rounded-pill {{ $ratingFilter == (string)$s ? 'btn-warning text-dark fw-bold' : 'btn-outline-secondary' }}">
                        {{ $s }} ★
                    </a>
                @endfor
                <a href="{{ request()->fullUrlWithQuery(['review_filter' => 'with_images']) }}" 
                   class="btn btn-sm rounded-pill {{ $ratingFilter === 'with_images' ? 'btn-danger' : 'btn-outline-secondary' }}">
                    <i class="bi bi-camera-fill me-1"></i> With Images
                </a>
            </div>

            <!-- Sorting Options -->
            <div class="d-flex align-items-center gap-2">
                <span class="fw-bold text-dark small text-uppercase">Sort By:</span>
                <form action="{{ request()->url() }}" method="GET" class="d-inline">
                    @foreach(request()->except(['review_sort', 'page']) as $k => $v)
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endforeach
                    <select name="review_sort" class="form-select form-select-sm border-2 rounded-pill pe-4" onchange="this.form.submit()">
                        <option value="newest" {{ $ratingSort === 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ $ratingSort === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="highest" {{ $ratingSort === 'highest' ? 'selected' : '' }}>Highest Rating</option>
                        <option value="lowest" {{ $ratingSort === 'lowest' ? 'selected' : '' }}>Lowest Rating</option>
                        <option value="most_helpful" {{ $ratingSort === 'most_helpful' ? 'selected' : '' }}>Most Helpful</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Customer Reviews List -->
        <div class="reviews-list">
            @forelse($reviews as $rev)
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-3 position-relative">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="d-flex align-items-center gap-3">
                            <!-- Avatar / Initial -->
                            <div class="avatar-circle d-flex align-items-center justify-content-center text-white fw-bold" 
                                 style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #fc2779, #ff5ba8); font-size: 18px;">
                                {{ strtoupper(substr($rev->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <!-- Customer Name & Verified Badge -->
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <h6 class="fw-bold text-dark mb-0">{{ $rev->user->name ?? 'Verified Buyer' }}</h6>
                                    @if($rev->is_verified_purchase)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1 small" style="font-size: 11px;">
                                            <i class="bi bi-check-circle-fill me-1"></i> Verified Purchase
                                        </span>
                                    @endif
                                </div>
                                <div class="text-muted small mt-1">
                                    Reviewed on {{ $rev->created_at->format('d F Y') }}
                                </div>
                            </div>
                        </div>

                        <!-- Star Rating -->
                        <div class="fs-5" style="color: #ffb400;">
                            @for($st = 1; $st <= 5; $st++)
                                @if($st <= $rev->rating) ★ @else <span style="color:#ddd;">★</span> @endif
                            @endfor
                        </div>
                    </div>

                    <!-- Review Title & Description -->
                    @if($rev->title)
                        <h5 class="fw-bold text-dark mt-2 mb-2">{{ $rev->title }}</h5>
                    @endif
                    <p class="text-secondary mb-3" style="line-height: 1.6; font-size: 14.5px;">{{ $rev->description }}</p>

                    <!-- Review Images Gallery -->
                    @if($rev->images->count() > 0)
                        <div class="d-flex gap-2 flex-wrap mb-3">
                            @foreach($rev->images as $rImg)
                                <a href="{{ asset('uploads/' . $rImg->image_path) }}" target="_blank">
                                    <img src="{{ asset('uploads/' . $rImg->image_path) }}" class="rounded border shadow-sm" width="80" height="80" style="object-fit:cover;">
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <!-- Seller Reply Block -->
                    @if($rev->reply)
                        <div class="p-3 bg-light border-start border-3 border-danger rounded-3 mb-3">
                            <div class="fw-bold text-dark small mb-1">
                                <i class="bi bi-reply-fill me-1" style="color:#fc2779;"></i> Response from Seller ({{ $rev->reply->seller->business_name ?? 'Seller' }})
                            </div>
                            <p class="mb-0 text-muted small">{{ $rev->reply->reply }}</p>
                        </div>
                    @endif

                    <!-- Footer Actions (Helpful Button & Report Button) -->
                    <div class="d-flex align-items-center gap-3 pt-2 border-top">
                        <button type="button" 
                                class="btn btn-sm btn-outline-secondary rounded-pill helpful-vote-btn" 
                                data-review-id="{{ $rev->id }}">
                            👍 Helpful (<span class="helpful-count">{{ $rev->helpful_count }}</span>)
                        </button>

                        <button type="button" 
                                class="btn btn-sm btn-link text-muted text-decoration-none ms-auto" 
                                data-bs-toggle="modal" 
                                data-bs-target="#reportModal-{{ $rev->id }}">
                            <i class="bi bi-flag"></i> Report
                        </button>

                        @if(auth()->check() && auth()->id() === $rev->user_id)
                            <form action="{{ route('user.reviews.destroy', $rev->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete your review?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                    <i class="bi bi-trash3 me-1"></i> Delete
                                </button>
                            </form>
                        @endif

                        @include('user.partials.report-modal', ['reviewId' => $rev->id])
                    </div>
                </div>
            @empty
                <div class="text-center py-5 bg-light rounded-4 border">
                    <div class="display-4 text-muted mb-2"><i class="bi bi-chat-left-text"></i></div>
                    <h5 class="fw-bold text-dark">No Reviews Matching Criteria</h5>
                    <p class="text-muted small mb-0">Be the first to review this product after purchasing!</p>
                </div>
            @endforelse

            <div class="d-flex justify-content-center mt-4">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Helpful Vote AJAX Handler
    document.querySelectorAll('.helpful-vote-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const reviewId = this.getAttribute('data-review-id');
            const countSpan = this.querySelector('.helpful-count');

            fetch(`/reviews/${reviewId}/helpful`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    countSpan.textContent = data.helpful_count;
                    if (data.voted) {
                        this.classList.remove('btn-outline-secondary');
                        this.classList.add('btn-primary');
                    } else {
                        this.classList.remove('btn-primary');
                        this.classList.add('btn-outline-secondary');
                    }
                } else if (data.message) {
                    alert(data.message);
                }
            })
            .catch(err => console.error(err));
        });
    });
});
</script>

<script>
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