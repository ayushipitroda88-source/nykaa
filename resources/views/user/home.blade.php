@extends('user.index')

@section('title', 'Shop Premium Beauty Products - NYKAA')

@push('page-styles')
    <style>/*==========================
 GOOGLE FONT
==========================*/
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:#fafafa;
    color:#222;
}

img{
    max-width:100%;
    display:block;
}

a{
    text-decoration:none;
}

section{
    width:100%;
    padding:70px 8%;
}

/*==========================
 HERO
==========================*/

.hero-section{

    background:linear-gradient(135deg,#fff0f6,#ffe3ef);

    min-height:650px;

    display:flex;

    align-items:center;

}

.hero-content{

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:60px;

}

.hero-left{

    width:50%;

}

.hero-tag{

    display:inline-block;

    background:#fc2779;

    color:#fff;

    padding:8px 20px;

    border-radius:40px;

    font-size:14px;

    margin-bottom:25px;

}

.hero-left h1{

    font-size:60px;

    line-height:75px;

    font-weight:800;

    color:#111;

}

.hero-left p{

    margin:30px 0;

    color:#555;

    font-size:18px;

    line-height:30px;

}

.hero-buttons{

    display:flex;

    gap:20px;

}

.shop-btn{

    background:#fc2779;

    color:#fff;

    padding:15px 35px;

    border-radius:8px;

    font-weight:600;

    transition:.4s;

}

.shop-btn:hover{

    background:#111;

}

.explore-btn{

    border:2px solid #fc2779;

    color:#fc2779;

    padding:15px 35px;

    border-radius:8px;

    font-weight:600;

    transition:.4s;

}

.explore-btn:hover{

    background:#fc2779;

    color:#fff;

}

.hero-right{

    width:45%;

}

.hero-right img{

    width:100%;

    border-radius:30px;

    box-shadow:0 20px 60px rgba(0,0,0,.15);

}

/*==========================
 OFFER
==========================*/

.offer-section{

    padding:40px 8%;

}

.offer-box{

    background:linear-gradient(135deg,#fc2779,#ff5ba8);

    border-radius:20px;

    color:#fff;

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:45px;

}

.offer-box h2{

    font-size:42px;

}

.offer-box p{

    margin-top:10px;

    font-size:18px;

}

.offer-box a{

    background:#fff;

    color:#fc2779;

    padding:16px 35px;

    border-radius:8px;

    font-weight:700;

}

/*==========================
 FEATURES
==========================*/

.features-section{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:30px;

}

.feature-card{

    background:#fff;

    border-radius:20px;

    padding:35px;

    text-align:center;

    box-shadow:0 15px 40px rgba(0,0,0,.08);

    transition:.4s;

    font-size:40px;

}

.feature-card:hover{

    transform:translateY(-10px);

}

.feature-card h3{

    font-size:20px;

    margin:20px 0 10px;

}

.feature-card p{

    color:#666;

}

/*==================================
 SECTION TITLE
===================================*/

.section-title-box{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:40px;
}

.section-title-box h2{
    font-size:38px;
    color:#222;
    font-weight:700;
    position:relative;
}

.section-title-box h2::after{
    content:'';
    position:absolute;
    left:0;
    bottom:-12px;
    width:80px;
    height:4px;
    background:#fc2779;
    border-radius:10px;
}

.section-title-box a{
    color:#fc2779;
    font-size:17px;
    font-weight:600;
    transition:.3s;
}

.section-title-box a:hover{
    color:#111;
}

/*==================================
 COLLECTION
===================================*/

.collection-section{
    padding:80px 8%;
    background:#fff;
}

.collection-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:30px;
}

.collection-card{
    background:#fff;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 12px 35px rgba(0,0,0,.08);
    transition:.4s;
}

.collection-card:hover{
    transform:translateY(-12px);
    box-shadow:0 25px 45px rgba(0,0,0,.15);
}

.collection-image{
    height:320px;
    overflow:hidden;
    position:relative;
}

.collection-image img{
    width:100%;
    height:100%;
    object-fit:cover;
    transition:.5s;
}

.collection-card:hover img{
    transform:scale(1.08);
}

.collection-image::before{
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(to top,
    rgba(0,0,0,.35),
    transparent);
}

.collection-content{
    padding:22px;
}

.collection-content h3{
    font-size:22px;
    margin-bottom:10px;
    color:#222;
}

.collection-content p{
    color:#666;
    font-size:15px;
    line-height:26px;
}

/*==================================
 CATEGORY
===================================*/

.category-section{
    padding:80px 8%;
    background:#fafafa;
}

.category-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:25px;
}

.category-card{
    position:relative;
    overflow:hidden;
    border-radius:20px;
    display:block;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.category-card img{
    width:100%;
    height:240px;
    object-fit:cover;
    transition:.5s;
}

.category-card:hover img{
    transform:scale(1.12);
}

.category-overlay{
    position:absolute;
    inset:0;
    background:linear-gradient(to top,
    rgba(0,0,0,.65),
    transparent);
    display:flex;
    align-items:flex-end;
    justify-content:center;
    padding-bottom:25px;
}

.category-overlay h3{
    color:#fff;
    font-size:22px;
    font-weight:600;
    letter-spacing:.5px;
}

.category-card:hover{
    transform:translateY(-8px);
    transition:.4s;
}

/*==================================
 SECTION SPACING
===================================*/

.collection-section,
.category-section{
    margin-top:20px;
    margin-bottom:20px;
}

/*========================================
 PRODUCT SECTION
========================================*/

.product-section{
    padding:80px 8%;
    background:#fff;
}

.product-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:30px;
}

/*========================================
 PRODUCT CARD
========================================*/

.product-card{

    background:#fff;

    border-radius:22px;

    overflow:hidden;

    position:relative;

    box-shadow:0 10px 30px rgba(0,0,0,.08);

    transition:.4s;

}

.product-card:hover{

    transform:translateY(-12px);

    box-shadow:0 25px 50px rgba(0,0,0,.15);

}

.product-image{

    height:320px;

    overflow:hidden;

    position:relative;

    background:#f8f8f8;

}

.product-image img{

    width:100%;

    height:100%;

    object-fit:cover;

    transition:.5s;

}

.product-card:hover img{

    transform:scale(1.08);

}

/*========================================
 DISCOUNT BADGE
========================================*/

.discount-badge{

    position:absolute;

    top:15px;

    left:15px;

    background:#fc2779;

    color:#fff;

    padding:8px 14px;

    border-radius:30px;

    font-size:13px;

    font-weight:600;

    box-shadow:0 5px 15px rgba(252,39,121,.35);

}

/*========================================
 PRODUCT INFO
========================================*/

.product-info{

    padding:20px;

}

.brand-name{

    color:#fc2779;

    font-size:13px;

    font-weight:600;

    text-transform:uppercase;

    letter-spacing:1px;

}

.product-info h3{

    font-size:19px;

    margin:12px 0;

    color:#222;

    min-height:55px;

    line-height:28px;

}

.rating{

    color:#ffb400;

    font-size:14px;

    margin-bottom:14px;

}

.rating span{

    color:#666;

    margin-left:8px;

}

/*========================================
 PRICE
========================================*/

.price-box{

    display:flex;

    align-items:center;

    gap:12px;

    margin-bottom:18px;

}

.new-price{

    font-size:24px;

    color:#fc2779;

    font-weight:700;

}

.old-price{

    color:#999;

    text-decoration:line-through;

    font-size:16px;

}

/*========================================
 BUTTONS
========================================*/

.product-buttons{

    display:flex;

    gap:12px;

}

.view-btn{

    width:100%;

    text-align:center;

    background:#fc2779;

    color:#fff;

    padding:14px;

    border-radius:10px;

    font-weight:600;

    transition:.4s;

}

.view-btn:hover{

    background:#111;

}

.cart-btn{

    display:block;

    width:100%;

    background:#111;

    color:#fff;

    text-align:center;

    padding:14px;

    border-radius:10px;

    transition:.4s;

    font-weight:600;

}

.cart-btn:hover{

    background:#fc2779;

}

/*========================================
 BIG SALE BANNER
========================================*/

.big-sale-banner{

    padding:80px 8%;

}

.sale-content{

    background:linear-gradient(135deg,#111,#fc2779);

    color:#fff;

    border-radius:25px;

    padding:60px;

    display:flex;

    justify-content:space-between;

    align-items:center;

}

.sale-content span{

    color:#ffd4e6;

    font-size:15px;

    letter-spacing:2px;

}

.sale-content h2{

    font-size:55px;

    margin:12px 0;

}

.sale-content p{

    font-size:18px;

}

.sale-content a{

    background:#fff;

    color:#fc2779;

    padding:18px 40px;

    border-radius:12px;

    font-weight:700;

    transition:.4s;

}

.sale-content a:hover{

    background:#111;

    color:#fff;

}

/*==========================================
        PRODUCT DETAILS PAGE
==========================================*/

.product-details{
    max-width:1400px;
    margin:50px auto;
    padding:0 40px;
}

.product-wrapper{
    display:flex;
    gap:60px;
    align-items:flex-start;
}

.product-image{
    width:45%;
    position:sticky;
    top:120px;
}

.product-image img{
    width:100%;
    border-radius:18px;
    background:#fff;
    box-shadow:0 10px 40px rgba(0,0,0,.08);
    transition:.4s;
}

.product-image img:hover{
    transform:scale(1.04);
}

.product-info{
    width:55%;
}

.product-category{
    color:#fc2779;
    font-size:15px;
    font-weight:600;
    margin-bottom:10px;
}

.product-title{
    font-size:34px;
    font-weight:700;
    color:#222;
    margin-bottom:15px;
    line-height:1.4;
}

.product-rating{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:18px;
}

.product-rating i{
    color:#ffb400;
}

.product-price{
    font-size:38px;
    font-weight:700;
    color:#fc2779;
    margin-bottom:10px;
}

.product-stock{
    color:#22c55e;
    font-weight:600;
    margin-bottom:25px;
}

.product-description{
    color:#666;
    line-height:1.9;
    margin-bottom:30px;
}

.product-buttons{
    display:flex;
    gap:20px;
    margin-top:30px;
}

.add-cart-btn,
.buy-now-btn{
    flex:1;
    padding:16px;
    border:none;
    border-radius:12px;
    cursor:pointer;
    font-size:16px;
    font-weight:700;
    transition:.35s;
}

.add-cart-btn{
    background:#fc2779;
    color:#fff;
}

.add-cart-btn:hover{
    background:#e91e63;
    transform:translateY(-3px);
}

.buy-now-btn{
    background:#111;
    color:#fff;
}

.buy-now-btn:hover{
    background:#333;
    transform:translateY(-3px);
}

.product-features{
    margin-top:45px;
    background:#fafafa;
    padding:25px;
    border-radius:18px;
    border:1px solid #eee;
}

.product-features h3{
    margin-bottom:20px;
    color:#222;
}

.product-features ul{
    list-style:none;
    padding:0;
}

.product-features li{
    padding:10px 0;
    color:#555;
    display:flex;
    align-items:center;
    gap:10px;
}

.product-features li::before{
    content:"✔";
    color:#22c55e;
    font-weight:bold;
}

.related-products{
    margin-top:70px;
}

.related-products h2{
    font-size:32px;
    margin-bottom:30px;
    color:#222;
}

.product-image{
    position:relative;
}

.wishlist-icon{
    position:absolute;
    top:15px;
    right:15px;
    width:42px;
    height:42px;
    background:#fff;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 5px 15px rgba(0,0,0,.12);
    z-index:100;
}

.wishlist-icon i{
    font-size:22px;
}

.wishlist-icon .bi-heart{
    color:#999;
}

.wishlist-icon .bi-heart-fill{
    color:#fc2779 !important;
}

/* ========================================
   FEATURED PRODUCTS SLIDER
   ======================================== */

.featured-slider-wrapper {
    position: relative;
    width: 100%;
    margin-top: 20px;
}

.featured-product-slider {
    display: flex;
    gap: 25px;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding: 15px 5px;
    /* Hide scrollbar for Chrome, Safari and Opera */
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}

.featured-product-slider::-webkit-scrollbar {
    display: none; /* Hide scrollbar for Chrome, Safari and Opera */
}

.featured-product-card {
    width: 270px;
    height: 320px;
    flex-shrink: 0;
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    box-shadow: 0 8px 25px rgba(0,0,0,.06);
    transition: all .4s ease;
    border: 1px solid #f0f0f0;
}

.featured-product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,.12);
}

.featured-product-card .product-image {
    width: 100%;
    height: 100%;
    background: #fff;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
}

.featured-product-card .product-image img {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
    transition: transform .5s ease;
}

.featured-product-card:hover .product-image img {
    transform: scale(1.06);
}

.slider-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #fff;
    border: 1px solid #eee;
    box-shadow: 0 4px 15px rgba(0,0,0,.1);
    color: #111;
    font-size: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    transition: all .3s ease;
}

.slider-arrow:hover {
    background: #fc2779;
    color: #fff;
    border-color: #fc2779;
    box-shadow: 0 6px 20px rgba(252,39,121,.3);
}

.slider-arrow.prev-btn {
    left: -24px;
}

.slider-arrow.next-btn {
    right: -24px;
}

/* Scroll progress indicator */
.slider-progress-container {
    width: 150px;
    height: 4px;
    background: #e0e0e0;
    margin: 25px auto 0 auto;
    border-radius: 10px;
    overflow: hidden;
    position: relative;
}

.slider-progress-bar {
    height: 100%;
    width: 30%;
    background: #fc2779;
    border-radius: 10px;
    position: absolute;
    left: 0;
    transition: left 0.1s ease;
}

/*========================================
 BRAND SECTION
========================================*/

.brand-section {
    padding: 80px 8%;
    background: #fafafa;
}

.brand-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 30px;
    align-items: center;
}

.brand-card {
    background: #fff;
    border-radius: 15px;
    height: 130px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 25px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    border: 1px solid #eee;
}

.brand-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    border-color: #fc2779;
}

.brand-card img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: transform 0.4s ease;
}

.brand-card:hover img {
    transform: scale(1.05);
}

</style>
@endpush

@section('content')
<!-- ================= HERO SECTION ================= -->



<section class="hero-section">

    <div class="hero-content">

        <div class="hero-left">

            <span class="hero-tag">
                ✨ India's No.1 Beauty Store
            </span>

            <h1>
                Discover Beauty <br>
                That Inspires You
            </h1>

            <p>
                Shop premium beauty, skincare, makeup and fashion
                products from the world's most loved brands.
            </p>

            <div class="hero-buttons">

                <a href="{{ route('search') }}" class="shop-btn">
                    Shop Now
                </a>

                <a href="{{ route('collections.user') }}" class="explore-btn">
                    Explore Collection
                </a>

            </div>

        </div>

        <div class="hero-right">

            <img src="{{ asset('images/banner.png') }}"
                 onerror="this.src='https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=700';">

        </div>

    </div>

</section>


<!-- ================= FEATURES ================= -->

<section class="features-section">

    <div class="feature-card">

        🚚

        <h3>Free Delivery</h3>

        <p>Above ₹499</p>

    </div>

    <div class="feature-card">

        💯

        <h3>100% Original</h3>

        <p>Guaranteed Products</p>

    </div>

    <div class="feature-card">

        💳

        <h3>Secure Payment</h3>

        <p>Fast & Safe</p>

    </div>

    <div class="feature-card">

        ⭐

        <h3>Top Brands</h3>

        <p> Brands</p>

    </div>

</section>

<!-- ================= FEATURED PRODUCTS ================= -->

<section class="product-section">

    <div class="section-title-box">

        <h2>Featured Products</h2>

        <a href="{{ route('search') }}">
            View All →
        </a>

    </div>

    <div class="featured-slider-wrapper">
        <button class="slider-arrow prev-btn" id="sliderPrev">
            <i class="bi bi-chevron-left"></i>
        </button>

        <div class="featured-product-slider" id="featuredSlider">

            @forelse($products->take(12) as $product)

            <div class="featured-product-card">

                 <a href="{{ route('product.show',$product->id) }}">

        <div class="product-image">

            @if($product->image)

                <img src="{{ asset('uploads/'.$product->image) }}" 
                     alt="{{ $product->title }}">

            @else

                <img src="https://via.placeholder.com/350x420">

            @endif

        </div>


        <div class="product-info">

            <h3>
                {{ $product->title }}
            </h3>


            {{-- Product Variants --}}

            @if($product->variants->count())

                @foreach($product->variants->take(1) as $variant)

                    <p>
                        Color:
                        {{ $variant->color->name ?? '' }}
                    </p>


                    <p>
                        Size:
                        {{ $variant->size->name ?? '' }}
                    </p>


                    <p class="new-price">
                        ₹{{ $variant->price }}
                    </p>

                @endforeach

            @else

                <p class="new-price">
                    ₹{{ $product->price }}
                </p>

            @endif


        </div>

    </a> 

            </div>

            @empty

            <h3>No Products Found</h3>

            @endforelse

        </div>

        <button class="slider-arrow next-btn" id="sliderNext">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>

    <!-- Scroll progress indicator -->
    <div class="slider-progress-container">
        <div class="slider-progress-bar" id="sliderProgress"></div>
    </div>

</section>

<!-- ================= SHOP BY BRAND ================= -->

<section class="brand-section">

    <div class="section-title-box">

        <h2>Shop By Top Brands</h2>

    </div>

    <div class="brand-grid">

    @foreach($brands as $brand)
        <a href="{{ route('search', ['brand_id' => $brand->id]) }}" class="brand-card">
            <img src="{{ asset('uploads/brands/' . $brand->logo) }}" alt="{{ $brand->name }}">
        </a>
    @endforeach

</div>

</section>

<!-- ================= APP DOWNLOAD ================= -->

<section class="app-section">

    <div>

        <h2>

            Download Our App

        </h2>

        <p>

            Shop Anytime Anywhere

        </p>

    </div>

    <div class="app-buttons">

        <a href="#">

            Google Play

        </a>

        <a href="#">

            App Store

        </a>

    </div>

</section>

@push('page-scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('featuredSlider');
    const prevBtn = document.getElementById('sliderPrev');
    const nextBtn = document.getElementById('sliderNext');
    const progress = document.getElementById('sliderProgress');

    if (slider) {
        // Scroll amount on arrow click
        const scrollAmount = 300;

        prevBtn.addEventListener('click', () => {
            slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        });

        nextBtn.addEventListener('click', () => {
            slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });

        // Update progress bar
        const updateProgressBar = () => {
            const maxScroll = slider.scrollWidth - slider.clientWidth;
            if (maxScroll > 0) {
                const scrollPercent = (slider.scrollLeft / maxScroll) * 100;
                // Since progress bar width is 30% of wrapper, we calculate left position as percentage of remaining space (70%)
                progress.style.left = (scrollPercent * 0.7) + '%';
            }
        };

        slider.addEventListener('scroll', updateProgressBar);
        window.addEventListener('resize', updateProgressBar);
        // Initial call
        setTimeout(updateProgressBar, 100);
    }
});
</script>
@endpush

@endsection