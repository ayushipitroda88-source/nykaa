@extends('user.index')

@section('title','My Wishlist')

@push('page-styles')
<style>
/* ==========================================
   WISHLIST PAGE STYLES (NYKAA THEME)
========================================== */

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    font-family: 'Segoe UI', Roboto, sans-serif;
}

.section-title {
    font-size: 28px;
    font-weight: 700;
    color: #222;
    margin-bottom: 30px;
}

/* Grid Layout */
.wishlist-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
}

/* Wishlist Card */
.wishlist-card {
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
}

.wishlist-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

/* Product Image Box */
.wishlist-card a {
    display: block;
    background: #fff;
    padding: 15px;
    text-align: center;
    border-bottom: 1px solid #f9f9f9;
}

.wishlist-card img {
    width: 100%;
    height: 220px;
    object-fit: contain;
    transition: transform 0.3s ease;
}

.wishlist-card:hover img {
    transform: scale(1.03);
}

/* Product Info */
.wishlist-info {
    padding: 20px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.wishlist-info h4 {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin: 0 0 10px 0;
    line-height: 1.4;
    height: 44px; /* Title breaks safely into max 2 lines */
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.wishlist-info .price {
    font-size: 18px;
    font-weight: 700;
    color: #fc2779; /* Nykaa Pink */
    margin-bottom: 18px;
}

/* Action Buttons Container */
.wishlist-buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: auto; /* Forces buttons to stick to bottom */
}

.wishlist-buttons form {
    width: 100%;
    margin: 0;
}

.wishlist-buttons button {
    width: 100%;
    padding: 12px;
    font-size: 14px;
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
    border: none;
    transition: all 0.3s ease;
}

/* Add To Cart Button */
.cart-btn {
    background: #fc2779;
    color: #fff;
}

.cart-btn:hover {
    background: #e01a66;
}

/* Remove Button */
.remove-btn {
    background: #fff;
    color: #666;
    border: 1px solid #ddd !important;
}

.remove-btn:hover {
    background: #fff5f5;
    color: #dc3545;
    border-color: #dc3545 !important;
}

/* ==========================================
   EMPTY WISHLIST STATE STYLES
========================================== */
.empty-wishlist {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
    border: 1px solid #f0f0f0;
}

.empty-wishlist h3 {
    font-size: 22px;
    color: #555;
    margin-bottom: 20px;
}

.shop-btn {
    display: inline-block;
    background: #fc2779;
    color: #fff;
    padding: 14px 30px;
    text-decoration: none;
    font-weight: 600;
    border-radius: 6px;
    transition: background 0.3s ease;
}

.shop-btn:hover {
    background: #e01a66;
}

/* ==========================================
   RESPONSIVE GRID SYSTEM (MEDIA QUERIES)
========================================== */

/* For Smaller Desktops & Tablets (Landscape) */
@media (max-width: 1024px) {
    .wishlist-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    .wishlist-card img {
        height: 200px;
    }
}

/* For Tablets (Portrait) */
@media (max-width: 768px) {
    .wishlist-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    .section-title {
        font-size: 24px;
    }
}

/* For Mobile Phones */
@media (max-width: 480px) {
    .wishlist-grid {
        grid-template-columns: 1fr; /* Single column on mobile */
        gap: 20px;
    }
    .wishlist-card img {
        height: 240px; /* Bigger visual space for mobile */
    }
    .section-title {
        font-size: 22px;
        text-align: center;
    }
}
</style>
@endpush

 
@section('content')

<div class="container py-5">

    <h2 class="section-title mb-4">
        ❤️ My Wishlist
    </h2>

    @if($wishlists->count())

    <div class="wishlist-grid">

        @foreach($wishlists as $item)

        <div class="wishlist-card">

            <a href="{{ route('product.show',$item->product->id) }}">

                <img src="{{ asset('uploads/'.$item->product->image) }}"
                     alt="{{ $item->product->title }}">

            </a>

            <div class="wishlist-info">

                <h4>{{ $item->product->title }}</h4>

                <p class="price">
                    ₹{{ number_format($item->product->price,2) }}
                </p>

                <div class="wishlist-buttons">

                    <form action="{{ route('wishlist.cart',$item->product->id) }}"
                          method="POST">

                        @csrf

                        <button class="cart-btn">

                            Add To Cart

                        </button>

                    </form>

                    <form action="{{ route('wishlist.remove',$item->product->id) }}"
                          method="POST">

                        @csrf
                        @method('DELETE')

                        <button class="remove-btn">

                            Remove

                        </button>

                    </form>

                </div>

            </div>

        </div>

        @endforeach

    </div>

    @else

    <div class="empty-wishlist">

        <h3>Your Wishlist is Empty</h3>

        <a href="{{ route('home') }}" class="shop-btn">

            Continue Shopping

        </a>

    </div>

    @endif

</div>

@endsection