@extends('user.index')

@section('title', 'Shop Premium Beauty Products - NYKAA')

@push('page-styles')
    <style>
/*=============================================
  GOOGLE FONTS & BASE
=============================================*/
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@600;700;800&display=swap');

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter',sans-serif;
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
    color:inherit;
}

section{
    width:100%;
    padding:80px 8%;
}

/*=============================================
  HERO SECTION - REDESIGNED
=============================================*/

.hero-section{
    background:linear-gradient(135deg,#fff5f7 0%,#ffe8ef 40%,#fce4ec 100%);
    min-height:620px;
    display:flex;
    align-items:center;
    position:relative;
    overflow:hidden;
    padding:60px 8%;
}

/* Decorative circles */
.hero-section::before{
    content:'';
    position:absolute;
    top:-120px;
    right:-80px;
    width:500px;
    height:500px;
    border-radius:50%;
    background:radial-gradient(circle,rgba(252,39,121,0.08) 0%,transparent 70%);
    pointer-events:none;
}

.hero-section::after{
    content:'';
    position:absolute;
    bottom:-100px;
    left:-60px;
    width:400px;
    height:400px;
    border-radius:50%;
    background:radial-gradient(circle,rgba(252,39,121,0.05) 0%,transparent 70%);
    pointer-events:none;
}

.hero-content{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:60px;
    position:relative;
    z-index:2;
    width:100%;
}

.hero-left{
    width:50%;
}

.hero-tag{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background:linear-gradient(135deg,#fc2779,#ff5ba8);
    color:#fff;
    padding:10px 24px;
    border-radius:50px;
    font-size:14px;
    font-weight:600;
    margin-bottom:28px;
    box-shadow:0 8px 25px rgba(252,39,121,0.3);
    animation:fadeInUp 0.6s ease;
}

.hero-left h1{
    font-size:58px;
    line-height:1.15;
    font-weight:900;
    color:#1a1a1a;
    font-family:'Inter',sans-serif;
    animation:fadeInUp 0.8s ease;
}

.hero-left h1 .highlight{
    background:linear-gradient(135deg,#fc2779,#ff8eb5);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    background-clip:text;
}

.hero-left p{
    margin:24px 0 32px;
    color:#666;
    font-size:17px;
    line-height:1.8;
    max-width:500px;
    animation:fadeInUp 1s ease;
}

.hero-buttons{
    display:flex;
    gap:16px;
    animation:fadeInUp 1.2s ease;
}

.shop-btn{
    background:linear-gradient(135deg,#fc2779,#ff5ba8);
    color:#fff;
    padding:16px 38px;
    border-radius:12px;
    font-weight:700;
    font-size:15px;
    transition:all .4s cubic-bezier(0.25,0.46,0.45,0.94);
    display:inline-flex;
    align-items:center;
    gap:8px;
    box-shadow:0 10px 30px rgba(252,39,121,0.3);
}

.shop-btn:hover{
    transform:translateY(-3px);
    box-shadow:0 18px 40px rgba(252,39,121,0.4);
}

.explore-btn{
    border:2px solid #fc2779;
    color:#fc2779;
    padding:16px 38px;
    border-radius:12px;
    font-weight:700;
    font-size:15px;
    transition:all .4s cubic-bezier(0.25,0.46,0.45,0.94);
    display:inline-flex;
    align-items:center;
    gap:8px;
}

.explore-btn:hover{
    background:#fc2779;
    color:#fff;
    transform:translateY(-3px);
    box-shadow:0 10px 30px rgba(252,39,121,0.25);
}

.hero-right{
    width:45%;
    animation:fadeInRight 1s ease;
}

.hero-right img{
    width:100%;
    border-radius:30px;
    box-shadow:0 30px 80px rgba(252,39,121,0.15);
    transition:transform .8s ease;
}

.hero-right img:hover{
    transform:scale(1.02) rotate(1deg);
}

/* Floating badges on hero */
.hero-stats{
    display:flex;
    gap:40px;
    margin-top:40px;
    animation:fadeInUp 1.4s ease;
}

.hero-stat-item{
    display:flex;
    flex-direction:column;
}

.hero-stat-item .stat-number{
    font-size:28px;
    font-weight:900;
    color:#1a1a1a;
    line-height:1.2;
}

.hero-stat-item .stat-label{
    font-size:13px;
    color:#888;
    font-weight:500;
}

/*=============================================
  ANIMATIONS
=============================================*/

@keyframes fadeInUp{
    from{
        opacity:0;
        transform:translateY(30px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

@keyframes fadeInRight{
    from{
        opacity:0;
        transform:translateX(50px);
    }
    to{
        opacity:1;
        transform:translateX(0);
    }
}

/*=============================================
  FEATURES SECTION - REDESIGNED
=============================================*/

.features-section{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:24px;
    padding:50px 8%;
    background:#fff;
    position:relative;
    z-index:2;
    margin-top:-40px;
    border-radius:0;
}

.feature-card{
    background:#fff;
    border-radius:18px;
    padding:30px 24px;
    text-align:center;
    box-shadow:0 8px 35px rgba(0,0,0,0.05);
    transition:all .4s cubic-bezier(0.25,0.46,0.45,0.94);
    border:1px solid #f5f5f5;
    position:relative;
    overflow:hidden;
}

.feature-card::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    right:0;
    height:3px;
    background:linear-gradient(90deg,#fc2779,#ff8eb5);
    transform:scaleX(0);
    transform-origin:left;
    transition:transform .4s ease;
}

.feature-card:hover{
    transform:translateY(-8px);
    box-shadow:0 20px 50px rgba(252,39,121,0.1);
    border-color:rgba(252,39,121,0.15);
}

.feature-card:hover::before{
    transform:scaleX(1);
}

.feature-icon-wrap{
    width:60px;
    height:60px;
    border-radius:16px;
    background:linear-gradient(135deg,#fff0f5,#fce4ec);
    display:flex;
    align-items:center;
    justify-content:center;
    margin:0 auto 16px;
    font-size:28px;
    transition:all .4s ease;
}

.feature-card:hover .feature-icon-wrap{
    background:linear-gradient(135deg,#fc2779,#ff5ba8);
    transform:scale(1.1) rotate(-5deg);
}

.feature-card:hover .feature-icon-wrap .feat-icon{
    filter:brightness(10);
}

.feature-card h3{
    font-size:17px;
    font-weight:700;
    margin:0 0 6px;
    color:#222;
}

.feature-card p{
    color:#888;
    font-size:14px;
    margin:0;
}

/*=============================================
  SECTION TITLE
=============================================*/

.section-title-box{
    display:flex;
    justify-content:space-between;
    align-items:flex-end;
    margin-bottom:40px;
}

.section-title-box h2{
    font-size:34px;
    color:#1a1a1a;
    font-weight:800;
    position:relative;
    letter-spacing:-0.5px;
}

.section-title-box h2::after{
    content:'';
    position:absolute;
    left:0;
    bottom:-12px;
    width:70px;
    height:4px;
    background:linear-gradient(90deg,#fc2779,#ff8eb5);
    border-radius:10px;
}

.section-title-box a{
    color:#fc2779;
    font-size:15px;
    font-weight:600;
    transition:all .3s;
    display:inline-flex;
    align-items:center;
    gap:6px;
}

.section-title-box a:hover{
    color:#1a1a1a;
    gap:10px;
}

/*=============================================
  FEATURED PRODUCTS SLIDER - ENHANCED
=============================================*/

.product-section{
    padding:80px 8%;
    background:#fff;
}

.featured-slider-wrapper{
    position:relative;
    width:100%;
    margin-top:10px;
}

.featured-product-slider{
    display:flex;
    gap:24px;
    overflow-x:auto;
    scroll-behavior:smooth;
    padding:20px 5px;
    -ms-overflow-style:none;
    scrollbar-width:none;
}

.featured-product-slider::-webkit-scrollbar{
    display:none;
}

.featured-product-card{
    min-width:270px;
    max-width:270px;
    flex-shrink:0;
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    position:relative;
    box-shadow:0 8px 30px rgba(0,0,0,0.05);
    transition:all .4s cubic-bezier(0.25,0.46,0.45,0.94);
    border:1px solid #f0f0f0;
    display:flex;
    flex-direction:column;
}

.featured-product-card:hover{
    transform:translateY(-10px);
    box-shadow:0 20px 50px rgba(0,0,0,0.1);
    border-color:rgba(252,39,121,0.15);
}

.featured-product-card .product-image{
    width:100%;
    height:270px;
    background:#fafafa;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
    position:relative;
}

.featured-product-card .product-image img{
    width:100%;
    height:100%;
    object-fit:cover;
    transition:transform .6s ease;
    background:#fafafa;
    display:block;
}

.featured-product-card:hover .product-image img{
    transform:scale(1.1);
}

.featured-product-card .product-info{
    padding:16px 18px 20px;
    border-top:1px solid #f0f0f0;
    flex:1;
    display:flex;
    flex-direction:column;
}

.featured-product-card .product-info .brand-tag{
    font-size:11px;
    font-weight:600;
    color:#fc2779;
    text-transform:uppercase;
    letter-spacing:1px;
    margin-bottom:6px;
}

.featured-product-card .product-info h3{
    font-size:15px;
    font-weight:600;
    color:#222;
    margin-bottom:8px;
    line-height:1.4;
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
    min-height:42px;
}

.featured-product-card .product-info .price-row{
    display:flex;
    align-items:center;
    gap:10px;
    margin-top:auto;
    padding-top:10px;
}

.featured-product-card .product-info .new-price{
    font-size:20px;
    font-weight:800;
    color:#fc2779;
}

.featured-product-card .product-info .old-price{
    font-size:14px;
    color:#aaa;
    text-decoration:line-through;
}

.featured-product-card .product-info .variant-info{
    font-size:12px;
    color:#999;
    margin-bottom:6px;
    line-height:1.5;
}

.featured-product-card .discount-badge{
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

.featured-wishlist-icon{
    position:absolute;
    top:12px;
    right:12px;
    width:38px;
    height:38px;
    background:#fff;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
    z-index:5;
    cursor:pointer;
    transition:all .3s ease;
    border:none;
    opacity:0;
    transform:translateY(10px);
}

.featured-product-card:hover .featured-wishlist-icon{
    opacity:1;
    transform:translateY(0);
}

.featured-wishlist-icon i{
    font-size:18px;
    color:#999;
    transition:all .3s ease;
}

.featured-wishlist-icon:hover{
    background:#fc2779;
}

.featured-wishlist-icon:hover i{
    color:#fff;
}

/* Quick add to cart overlay */
.product-quick-add{
    position:absolute;
    bottom:0;
    left:0;
    right:0;
    background:linear-gradient(to top,rgba(0,0,0,0.7),transparent);
    padding:40px 16px 16px;
    transform:translateY(100%);
    transition:transform .4s ease;
    display:flex;
    justify-content:center;
}

.featured-product-card:hover .product-quick-add{
    transform:translateY(0);
}

.quick-add-btn{
    background:#fff;
    color:#fc2779;
    border:none;
    padding:10px 24px;
    border-radius:30px;
    font-weight:700;
    font-size:13px;
    cursor:pointer;
    transition:all .3s ease;
    width:90%;
}

.quick-add-btn:hover{
    background:#fc2779;
    color:#fff;
}

/* Slider arrows */
.slider-arrow{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    width:48px;
    height:48px;
    border-radius:50%;
    background:#fff;
    border:1px solid #eee;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
    color:#111;
    font-size:20px;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    z-index:10;
    transition:all .3s ease;
}

.slider-arrow:hover{
    background:#fc2779;
    color:#fff;
    border-color:#fc2779;
    box-shadow:0 8px 25px rgba(252,39,121,0.3);
    transform:translateY(-50%) scale(1.08);
}

.slider-arrow.prev-btn{
    left:-20px;
}

.slider-arrow.next-btn{
    right:-20px;
}

.slider-progress-container{
    width:160px;
    height:4px;
    background:#e8e8e8;
    margin:28px auto 0;
    border-radius:10px;
    overflow:hidden;
    position:relative;
}

.slider-progress-bar{
    height:100%;
    width:30%;
    background:linear-gradient(90deg,#fc2779,#ff8eb5);
    border-radius:10px;
    position:absolute;
    left:0;
    transition:left 0.1s ease;
}

/*=============================================
  BRAND SECTION - ENHANCED
=============================================*/

.brand-section{
    padding:80px 8%;
    background:linear-gradient(135deg,#f8f8f8 0%,#fff5f7 100%);
    position:relative;
    overflow:hidden;
}

.brand-section::before{
    content:'';
    position:absolute;
    top:-30%;
    right:-10%;
    width:600px;
    height:600px;
    background:radial-gradient(circle,rgba(252,39,121,0.05) 0%,transparent 70%);
    border-radius:50%;
    pointer-events:none;
}

.brand-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:24px;
    align-items:stretch;
    position:relative;
    z-index:1;
}

.brand-card{
    background:#fff;
    border-radius:18px;
    min-height:170px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    padding:28px 20px 22px;
    box-shadow:0 6px 25px rgba(0,0,0,0.04);
    transition:all .4s cubic-bezier(0.25,0.46,0.45,0.94);
    border:1px solid #f0f0f0;
    position:relative;
    overflow:hidden;
    cursor:pointer;
    text-decoration:none;
}

.brand-card::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    right:0;
    height:4px;
    background:linear-gradient(90deg,#fc2779,#ff8eb5);
    transform:scaleX(0);
    transform-origin:left;
    transition:transform .4s ease;
}

.brand-card:hover{
    transform:translateY(-8px);
    box-shadow:0 20px 50px rgba(252,39,121,0.1);
    border-color:rgba(252,39,121,0.15);
}

.brand-card:hover::before{
    transform:scaleX(1);
}

.brand-card .brand-logo-wrapper{
    width:100%;
    min-height:110px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:10px;
    border-radius:14px;
    background:#fafafa;
    padding:15px 12px;
    transition:all .4s ease;
    border:1px solid #f0f0f0;
}

.brand-card:hover .brand-logo-wrapper{
    background:#fff5f7;
    border-color:rgba(252,39,121,0.2);
    transform:scale(1.03);
}

.brand-card .brand-logo-wrapper img{
    max-width:70%;
    max-height:50px;
    object-fit:contain;
    border-radius:6px;
    transition:transform .4s ease;
}

.brand-card:hover .brand-logo-wrapper img{
    transform:scale(1.1);
}

.brand-card .brand-logo-wrapper .brand-name-inside{
    font-size:12px;
    font-weight:600;
    color:#666;
    text-align:center;
    transition:color .3s ease;
    letter-spacing:0.3px;
    display:-webkit-box;
    -webkit-line-clamp:1;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

.brand-card:hover .brand-logo-wrapper .brand-name-inside{
    color:#fc2779;
}

.brand-card .brand-product-count{
    font-size:12px;
    color:#aaa;
    margin-top:6px;
    font-weight:400;
}

/* Placeholder style */
.brand-card .brand-card-placeholder{
    width:100%;
    min-height:110px;
    border-radius:14px;
    background:linear-gradient(135deg,#fce4ec,#fff0f3);
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:8px;
    margin-bottom:8px;
    border:1px solid #f8d7e0;
    transition:all .4s ease;
}

.brand-card:hover .brand-card-placeholder{
    background:linear-gradient(135deg,#fc2779,#ff5ba8);
    border-color:#fc2779;
    transform:scale(1.03);
}

.brand-card .brand-card-placeholder .placeholder-initials{
    font-size:28px;
    font-weight:800;
    color:#fc2779;
    text-transform:uppercase;
    letter-spacing:1px;
    transition:color .3s ease;
}

.brand-card:hover .brand-card-placeholder .placeholder-initials{
    color:#fff;
}

.brand-card .brand-card-placeholder .brand-name-inside{
    font-size:12px;
    font-weight:600;
    color:#888;
    text-align:center;
    transition:color .3s ease;
}

.brand-card:hover .brand-card-placeholder .brand-name-inside{
    color:#fff;
}

/*=============================================
  APP DOWNLOAD SECTION - REDESIGNED
=============================================*/

.app-section{
    padding:0 8% 80px;
    background:#fff;
}

.app-download-wrapper{
    background:linear-gradient(135deg,#1a1a1a 0%,#2d2d2d 50%,#1a1a1a 100%);
    border-radius:28px;
    padding:60px 70px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:50px;
    position:relative;
    overflow:hidden;
}

.app-download-wrapper::before{
    content:'';
    position:absolute;
    top:-50%;
    right:-20%;
    width:500px;
    height:500px;
    border-radius:50%;
    background:radial-gradient(circle,rgba(252,39,121,0.12) 0%,transparent 70%);
    pointer-events:none;
}

.app-download-wrapper::after{
    content:'';
    position:absolute;
    bottom:-40%;
    left:-10%;
    width:400px;
    height:400px;
    border-radius:50%;
    background:radial-gradient(circle,rgba(252,39,121,0.08) 0%,transparent 70%);
    pointer-events:none;
}

.app-download-left{
    flex:1;
    position:relative;
    z-index:2;
}

.app-download-left .app-tag{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background:rgba(252,39,121,0.15);
    color:#ff8eb5;
    padding:6px 16px;
    border-radius:30px;
    font-size:12px;
    font-weight:600;
    margin-bottom:16px;
}

.app-download-left h2{
    font-size:36px;
    font-weight:800;
    color:#fff;
    line-height:1.2;
    margin-bottom:12px;
    letter-spacing:-0.5px;
}

.app-download-left p{
    font-size:16px;
    color:rgba(255,255,255,0.7);
    margin-bottom:28px;
    line-height:1.7;
    max-width:440px;
}

.app-buttons{
    display:flex;
    gap:16px;
    flex-wrap:wrap;
}

.app-btn{
    display:inline-flex;
    align-items:center;
    gap:12px;
    padding:14px 28px;
    border-radius:14px;
    font-weight:600;
    font-size:14px;
    transition:all .3s ease;
    text-decoration:none;
}

.app-btn.app-store{
    background:#fff;
    color:#1a1a1a;
}

.app-btn.google-play{
    background:rgba(255,255,255,0.1);
    color:#fff;
    border:1px solid rgba(255,255,255,0.2);
}

.app-btn:hover{
    transform:translateY(-3px);
    box-shadow:0 12px 30px rgba(0,0,0,0.3);
}

.app-btn.app-store:hover{
    box-shadow:0 12px 30px rgba(255,255,255,0.15);
}

.app-btn.google-play:hover{
    background:#fff;
    color:#1a1a1a;
}

.app-btn i{
    font-size:24px;
}

.app-btn .btn-text{
    display:flex;
    flex-direction:column;
    text-align:left;
    line-height:1.2;
}

.app-btn .btn-text .btn-label{
    font-size:9px;
    font-weight:500;
    opacity:0.7;
    text-transform:uppercase;
    letter-spacing:0.5px;
}

.app-btn .btn-text .btn-store{
    font-size:16px;
    font-weight:700;
}

.app-download-right{
    flex-shrink:0;
    position:relative;
    z-index:2;
}

.app-phone-mockup{
    width:220px;
    height:auto;
    filter:drop-shadow(0 30px 60px rgba(0,0,0,0.4));
    animation:float 3s ease-in-out infinite;
}

@keyframes float{
    0%,100%{transform:translateY(0);}
    50%{transform:translateY(-15px);}
}

/*=============================================
  RESPONSIVE
=============================================*/

@media(max-width:1200px){
    .hero-left h1{font-size:46px;}
    .app-download-wrapper{padding:50px 40px;}
}

@media(max-width:992px){
    section{padding:60px 5%;}
    .hero-content{flex-direction:column-reverse;gap:40px;}
    .hero-left,.hero-right{width:100%;}
    .hero-left h1{font-size:40px;}
    .hero-right{max-width:450px;margin:0 auto;}
    .hero-stats{justify-content:center;}
    .features-section{grid-template-columns:repeat(2,1fr);gap:16px;padding:30px 5%;margin-top:-30px;}
    .featured-product-card{min-width:240px;max-width:240px;}
    .app-download-wrapper{flex-direction:column;text-align:center;padding:50px 30px;}
    .app-download-left p{margin:0 auto 28px;}
    .app-buttons{justify-content:center;}
    .app-phone-mockup{width:180px;}
    .slider-arrow{width:40px;height:40px;font-size:16px;}
    .slider-arrow.prev-btn{left:-12px;}
    .slider-arrow.next-btn{right:-12px;}
}

@media(max-width:768px){
    section{padding:50px 4%;}
    .hero-section{padding:40px 4%;min-height:auto;}
    .hero-left h1{font-size:32px;}
    .hero-left p{font-size:15px;}
    .hero-tag{font-size:12px;padding:8px 18px;}
    .shop-btn,.explore-btn{padding:14px 28px;font-size:14px;}
    .hero-buttons{flex-direction:column;}
    .hero-stats{gap:24px;flex-wrap:wrap;}
    .hero-stat-item .stat-number{font-size:22px;}
    .features-section{padding:20px 4%;margin-top:-20px;gap:12px;}
    .feature-card{padding:20px 16px;}
    .feature-card h3{font-size:15px;}
    .section-title-box h2{font-size:26px;}
    .section-title-box{flex-direction:column;align-items:flex-start;gap:10px;}
    .featured-product-card{min-width:200px;max-width:200px;}
    .featured-product-card .product-image{height:200px;}
    .brand-grid{grid-template-columns:repeat(2,1fr);gap:16px;}
    .app-download-wrapper{padding:40px 24px;border-radius:20px;}
    .app-download-left h2{font-size:28px;}
    .app-btn{padding:12px 20px;font-size:13px;}
    .app-phone-mockup{width:150px;}
    .product-section{padding:50px 4%;}
    .brand-section{padding:50px 4%;}
    .slider-arrow{display:none;}
}

@media(max-width:480px){
    .features-section{grid-template-columns:repeat(2,1fr);}
    .hero-left h1{font-size:28px;}
    .featured-product-card{min-width:170px;max-width:170px;}
    .featured-product-card .product-image{height:170px;}
    .featured-product-card .product-info{padding:12px 14px 16px;}
    .featured-product-card .product-info h3{font-size:13px;min-height:36px;}
    .featured-product-card .product-info .new-price{font-size:17px;}
    .app-download-left h2{font-size:24px;}
    .app-buttons{flex-direction:column;align-items:center;}
}
    </style>
@endpush

@section('content')

<!-- ==================== HERO SECTION ==================== -->
<section class="hero-section">

    <div class="hero-content">

        <div class="hero-left">

            <span class="hero-tag">
                ✨ India's No.1 Beauty Store
            </span>

            <h1>
                Discover Beauty <br>
                <span class="highlight">That Inspires You</span>
            </h1>

            <p>
                Shop premium beauty, skincare, makeup and fashion
                products from the world's most loved brands.
            </p>

            <div class="hero-buttons">

                <a href="{{ route('search') }}" class="shop-btn">
                    Shop Now <i class="bi bi-arrow-right"></i>
                </a>

                <a href="{{ route('collections.user') }}" class="explore-btn">
                    Explore Collection <i class="bi bi-grid-3x3-gap-fill"></i>
                </a>

            </div>

           
            </div>

        </div>

        <div class="hero-right">

            <img src="{{ asset('images/banner.png') }}"
                 onerror="this.src='https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=700';"
                 alt="Beauty Products">

        </div>

    </div>

</section>

<!-- ==================== FEATURES ==================== -->
<section class="features-section">

    <div class="feature-card">
        <div class="feature-icon-wrap">
            <span class="feat-icon">🚚</span>
        </div>
        <h3>Free Delivery</h3>
        <p>On orders above ₹499</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon-wrap">
            <span class="feat-icon">💯</span>
        </div>
        <h3>100% Authentic</h3>
        <p>Guaranteed Products</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon-wrap">
            <span class="feat-icon">💳</span>
        </div>
        <h3>Secure Payment</h3>
        <p>100% Safe & Fast</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon-wrap">
            <span class="feat-icon">⭐</span>
        </div>
        <h3>Top Brands</h3>
        <p>1900+ Trusted Brands</p>
    </div>

</section>

<!-- ==================== FEATURED PRODUCTS ==================== -->
<section class="product-section">

    <div class="section-title-box">

        <h2>Featured Products</h2>

        <a href="{{ route('search') }}">
            View All <i class="bi bi-arrow-right"></i>
        </a>

    </div>

    <div class="featured-slider-wrapper">
        <button class="slider-arrow prev-btn" id="sliderPrev">
            <i class="bi bi-chevron-left"></i>
        </button>

        <div class="featured-product-slider" id="featuredSlider">

            @forelse($products->take(12) as $product)

            <div class="featured-product-card">

                <!-- Discount Badge -->
                @if($product->discount_percentage)
               
                @endif

                <!-- Wishlist Button -->
                <button class="featured-wishlist-icon" data-product-id="{{ $product->id }}">
                    <i class="bi bi-heart"></i>
                </button>

                <!-- Quick Add to Cart Overlay -->
                <div class="product-quick-add">
                    
                </div>

                <a href="{{ route('product.show',$product->id) }}">

                    <div class="product-image">

                        @if($product->image)

                            <img src="{{ asset('uploads/'.$product->image) }}" 
                                 alt="{{ $product->title }}">

                        @else

                            <img src="https://via.placeholder.com/350x420">

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

<!-- ==================== SHOP BY BRAND ==================== -->
<section class="brand-section">

    <div class="section-title-box">

        <h2>Shop By Top Brands</h2>

    </div>

    <div class="brand-grid">

    @foreach($sellers as $seller)
        <a href="{{ route('search', ['seller_id' => $seller->id]) }}" class="brand-card">
            @if($seller->business_logo)
                <div class="brand-logo-wrapper">
                    <img src="{{ asset('storage/' . $seller->business_logo) }}" alt="{{ $seller->business_name }}">
                  
                </div>
            @else
                <div class="brand-card-placeholder">
                    <span class="placeholder-initials">{{ substr($seller->business_name, 0, 2) }}</span>
                    <span class="brand-name-inside">{{ $seller->business_name }}</span>
                </div>
            @endif
            
        </a>
    @endforeach

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