@extends('user.index')

@section('title', 'Shopping Cart - NYKAA')
@push('page-styles')
<style>
/* Base Setup */
.cart-container {
    width: 92%;
    max-width: 1300px;
    margin: 60px auto;
    font-family: 'Segoe UI', Roboto, sans-serif;
    color: #2d3748;
}

.cart-title-wrapper {
    margin-bottom: 35px;
}

.cart-title {
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 5px;
    color: #1a1a1a;
    letter-spacing: -0.5px;
}

.cart-subtitle {
    font-size: 16px;
    color: #718096;
}

/* Master Layout: Sidebar Split */
.cart-wrapper {
    display: flex;
    gap: 40px;
    align-items: flex-start;
}

.cart-items-section {
    flex: 1;
}

/* Individual Item Card */
.cart-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 20px;
    border: 1px solid #f0f0f0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    display: flex;
    align-items: center;
    gap: 24px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.cart-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}

/* Image Thumbnails */
.cart-img-wrapper {
    width: 100px;
    height: 110px;
    border-radius: 12px;
    overflow: hidden;
    background: #f8f9fa;
    flex-shrink: 0;
}

.cart-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Product Info */
.cart-details {
    flex: 1;
}

.cart-details h3 {
    font-size: 18px;
    font-weight: 600;
    margin: 0 0 4px 0;
}

.cart-details h3 a {
    color: #1a1a1a;
    text-decoration: none;
    transition: color 0.2s;
}

.cart-details h3 a:hover {
    color: #e91e63;
}

.cart-sku {
    font-size: 13px;
    color: #718096;
    margin: 0 0 12px 0;
}

.cart-item-price {
    font-size: 20px;
    color: #1a1a1a;
    font-weight: 700;
}

/* Quantity Controls Stack */
.cart-actions-wrapper {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 12px;
}

/* Quantity Adjuster Widget */
.quantity-control {
    display: flex;
    align-items: center;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    overflow: hidden;
    background: #f8f9fa;
}

.qty-btn {
    background: none;
    border: none;
    padding: 8px 14px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    color: #4a5568;
    transition: background 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.qty-btn:hover {
    background: #e2e8f0;
}

.qty-btn svg {
    width: 14px;
    height: 14px;
}

.qty-val {
    padding: 0 12px;
    font-weight: 700;
    color: #1a1a1a;
    min-width: 25px;
    text-align: center;
}

/* Delete Button */
.remove-btn {
    background: #fff5f5;
    color: #e53e3e;
    border: 1px solid #fed7d7;
    padding: 8px 14px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
    font-size: 14px;
    transition: all 0.2s;
}

.remove-btn:hover {
    background: #e53e3e;
    color: #ffffff;
    border-color: #e53e3e;
}

/* Subtotal Section inside Row */
.cart-subtotal-display {
    text-align: right;
    min-width: 120px;
}

.subtotal-label {
    font-size: 13px;
    color: #718096;
    margin-bottom: 4px;
}

.subtotal-amount {
    font-size: 20px;
    font-weight: 700;
    color: #e91e63;
}

/* Continue Shopping Link */
.continue-shopping-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #e91e63;
    text-decoration: none;
    font-weight: 600;
    margin-top: 20px;
    transition: color 0.2s;
}

.continue-shopping-link:hover {
    color: #c2185b;
}

.continue-shopping-link svg {
    width: 18px;
    height: 18px;
}

/* Order Summary Sticky Sidebar */
.cart-summary {
    width: 380px;
    background: #ffffff;
    border-radius: 20px;
    padding: 30px;
    border: 1px solid #f0f0f0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    position: sticky;
    top: 30px;
}

.summary-title {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 25px;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 12px;
    color: #1a1a1a;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 16px;
    font-size: 16px;
    color: #4a5568;
}

.summary-value {
    font-weight: 600;
    color: #1a1a1a;
}

.summary-value.free-shipping {
    color: #38a169;
}

.shipping-alert {
    background: #ebf8ff;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 16px;
}

.shipping-alert p {
    margin: 0;
    font-size: 13px;
    color: #2b6cb0;
}

.summary-row.total {
    border-top: 2px dashed #e2e8f0;
    padding-top: 20px;
    margin-top: 20px;
    font-size: 22px;
    font-weight: 800;
    color: #1a1a1a;
}

.total-amount {
    color: #e91e63;
}

.tax-note {
    font-size: 12px;
    color: #a0aec0;
    margin-top: 4px;
    text-align: right;
}

.checkout-btn {
    display: block;
    width: 100%;
    text-align: center;
    text-decoration: none;
    background: #1a1a1a;
    color: #ffffff;
    padding: 16px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 16px;
    margin-top: 25px;
    transition: background 0.2s ease, transform 0.1s ease;
    border: none;
    cursor: pointer;
}

.checkout-btn:hover {
    background: #e91e63;
}

.checkout-btn:active {
    transform: scale(0.98);
}

.secondary-shop-btn {
    display: block;
    width: 100%;
    text-align: center;
    text-decoration: none;
    background: transparent;
    color: #4a5568;
    border: 1px solid #e2e8f0;
    padding: 14px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 15px;
    margin-top: 12px;
    transition: all 0.2s;
}

.secondary-shop-btn:hover {
    background: #f7fafc;
    color: #1a1a1a;
}

/* Trust Badges Box */
.trust-badges-box {
    margin-top: 20px;
    background: #ffffff;
    border-radius: 16px;
    padding: 20px;
    border: 1px solid #f0f0f0;
}

.badge-item {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
    font-size: 14px;
    color: #4a5568;
}

.badge-item:last-child {
    margin-bottom: 0;
}

.badge-item svg {
    width: 18px;
    height: 18px;
    color: #38a169;
    flex-shrink: 0;
}

/* Empty Cart State Styling */
.cart-empty {
    text-align: center;
    padding: 80px 20px;
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #f0f0f0;
    max-width: 600px;
    margin: 40px auto;
}

.cart-empty svg {
    width: 80px;
    height: 80px;
    color: #cbd5e0;
    margin-bottom: 20px;
}

.cart-empty h3 {
    font-size: 26px;
    font-weight: 700;
    color: #2d3748;
    margin: 0 0 10px 0;
}

.cart-empty p {
    font-size: 16px;
    color: #718096;
    margin: 0 0 30px 0;
}

.shop-now-btn {
    display: inline-block;
    background: #e91e63;
    color: white;
    padding: 14px 35px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: background 0.2s;
}

.shop-now-btn:hover {
    background: #c2185b;
}

/* Responsive Breakpoint for Mobile/Tablets */
@media (max-width: 992px) {
    .cart-wrapper {
        flex-direction: column;
    }
    .cart-summary {
        width: 100%;
        position: static;
    }
}

@media (max-width: 640px) {
    .cart-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
    .cart-actions-wrapper {
        flex-direction: row;
        width: 100%;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #f0f0f0;
        padding-top: 15px;
    }
    .cart-subtotal-display {
        text-align: left;
    }
}
</style>
@endpush

@section('content')

<div class="cart-container">
    
    @if(count($cart) > 0)
        <!-- Page Title -->
        <div class="cart-title-wrapper">
            <h1 class="cart-title">Shopping Cart</h1>
            <div class="cart-subtitle">Review your items before checkout</div>
        </div>

        <div class="cart-wrapper">
            
            <!-- Cart Items Section -->
            <div class="cart-items-section">
                @php $total = 0; @endphp
                
                @foreach($cart as $item)
                    @php 
                        $subtotal = $item['price'] * $item['quantity']; 
                        $total += $subtotal; 
                    @endphp
                    
                    <div class="cart-card">
                        <!-- Product Image -->
                        <div class="cart-img-wrapper">
                           
    @if($item['variant_image'])
    <img src="{{ asset('uploads/variants/'.$item['variant_image']) }}" alt="{{ $item['title'] }}">
@else
    <img src="{{ asset('uploads/'.$item['product_image']) }}" alt="{{ $item['title'] }}">
@endif

                        </div>

                        <!-- Product Info -->
                       <div class="cart-details">

    <h3>
        <a href="{{ route('product.show', $item['id']) }}">
            {{ $item['title'] }}
        </a>
    </h3>

    <p class="cart-sku">
        SKU: #{{ str_pad($item['id'],6,'0',STR_PAD_LEFT) }}
    </p>

    <p style="margin:6px 0;color:#666;">
        <strong>Color:</strong> {{ $item['color'] ?? '-' }}
    </p>

    <p style="margin:6px 0;color:#666;">
        <strong>Size:</strong> {{ $item['size'] ?? '-' }}
    </p>

    <p class="cart-item-price">
        ₹{{ number_format($item['price'],2) }}
    </p>

</div>

                    
                        <div class="cart-actions-wrapper">
    <div class="quantity-control">
        <form action="{{ route('cart.decrease', $item['variant_id'] ?? $item['id']) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="qty-btn">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                </svg>
            </button>
        </form>
        
        <span class="qty-val">{{ $item['quantity'] }}</span>
        
        <form action="{{ route('cart.increase', $item['variant_id'] ?? $item['id']) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="qty-btn">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </button>
        </form>
    </div>

    <form action="{{ route('cart.remove', $item['variant_id'] ?? $item['id']) }}" method="POST">
        @csrf
        <button type="submit" class="remove-btn">Remove</button>
    </form>
</div>
                        <!-- Subtotal Display per Row -->
                        <div class="cart-subtotal-display">
                            <div class="subtotal-label">Subtotal</div>
                            <div class="subtotal-amount">₹{{ number_format($subtotal, 2) }}</div>
                        </div>
                    </div>
                @endforeach

                <!-- Continue Shopping Button Link -->
                <div>
                    <a href="{{ route('home') }}" class="continue-shopping-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Continue Shopping
                    </a>
                </div>
            </div>

            <!-- Sticky Order Summary Sidebar -->
            <div class="cart-sidebar-container">
                <div class="cart-summary">
                    <h2 class="summary-title">Order Summary</h2>

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span class="summary-value">₹{{ number_format($total, 2) }}</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Shipping</span>
                        @if($total >= 499)
                            <span class="summary-value free-shipping">Free</span>
                        @else
                            <span class="summary-value">₹{{ number_format(50, 2) }}</span>
                        @endif
                    </div>

                    @if($total < 499)
                        <div class="shipping-alert">
                            <p><strong>Free shipping</strong> on orders above ₹499</p>
                        </div>
                    @endif
                    
                    <div class="summary-row">
                        <span>Tax (estimated 5%)</span>
                        <span class="summary-value">₹{{ number_format($total * 0.05, 2) }}</span>
                    </div>

                    <div class="summary-row total">
                        <span>Total</span>
                        <div>
                            <div class="total-amount">
                                ₹{{ number_format($total + ($total * 0.05) + ($total >= 499 ? 0 : 50), 2) }}
                            </div>
                            <div class="tax-note">Tax included</div>
                        </div>
                    </div>

                    <a href="{{ route('checkout') }}" class="checkout-btn">Proceed to Checkout</a>
                    <a href="{{ route('home') }}" class="secondary-shop-btn">Continue Shopping</a>
                </div>

                <!-- Trust Badges Section -->
                <div class="trust-badges-box">
                    <div class="badge-item">
                        <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                        <span>100% Secure Checkout</span>
                    </div>
                    <div class="badge-item">
                        <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                        <span>Easy Returns</span>
                    </div>
                    <div class="badge-item">
                        <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                        <span>Order Tracking</span>
                    </div>
                </div>
            </div>

        </div>

    @else
        <!-- Empty Cart State -->
        <div class="cart-empty">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <h3>Your Cart is Empty</h3>
            <p>Add some products to get started!</p>
            <a href="{{ route('home') }}" class="shop-now-btn">Start Shopping</a>
        </div>
    @endif

</div>

@endsection