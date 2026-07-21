<!-- TOP BAR -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

/* =========================
   TOP BAR
========================= */

.top-bar {
    width: 100%;
    height: 36px;
    background: linear-gradient(90deg, #111 0%, #1a1a2e 100%);
    color: #ccc;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 60px;
    font-size: 12px;
    font-weight: 500;
    font-family: 'Inter', sans-serif;
}

.top-bar a {
    color: #bbb;
    text-decoration: none;
    margin-left: 20px;
    transition: color 0.25s;
    font-size: 12px;
}

.top-bar a:hover {
    color: #fc2779;
}

.top-left-msg {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #bbb;
    font-size: 12px;
}

.top-left-msg span {
    color: #fc2779;
    font-weight: 600;
}

.top-right {
    display: flex;
    align-items: center;
}

/* =========================
   NAVBAR
========================= */

.navbar {
    position: sticky;
    top: 0;
    z-index: 9999;
    width: 100%;
    height: 74px;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 50px;
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.07);
    border-bottom: 2px solid #f5f5f5;
    font-family: 'Inter', sans-serif;
    gap: 20px;
}

/* LOGO */
.logo {
    display: flex;
    align-items: center;
    gap: 3px;
    text-decoration: none;
    flex-shrink: 0;
    transition: transform 0.3s ease;
}

.logo:hover {
    transform: scale(1.03);
}

.logo-text {
    font-size: 28px;
    font-weight: 900;
    color: #fc2779;
    letter-spacing: 2px;
    font-family: 'Inter', sans-serif;
    line-height: 1;
}

.logo-sub {
    font-size: 9px;
    font-weight: 700;
    color: #555;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    line-height: 1.2;
    margin-left: 4px;
    margin-top: 2px;
}

/* NAV LINKS */
.nav-links {
    list-style: none;
    display: flex;
    align-items: center;
    gap: 6px;
    margin: 0;
    padding: 0;
    flex-shrink: 0;
}

.nav-links li {
    position: relative;
}

.nav-links > li > a {
    text-decoration: none;
    color: #2d2d2d;
    font-size: 12.5px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    padding: 6px 10px;
    border-radius: 6px;
    display: block;
    transition: all 0.25s ease;
    white-space: nowrap;
}

.nav-links > li > a:hover,
.nav-links > li > a.active-nav {
    color: #fc2779;
    background: #fff0f5;
}

/* ==========================
      MEGA MENU
========================== */

.mega-menu {
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(12px);
    width: 900px;
    max-width: 90vw;
    background: #fff;
    border-radius: 16px;
    padding: 28px 32px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12), 0 8px 20px rgba(0, 0, 0, 0.06);
    border: 1px solid #f0f0f0;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    z-index: 10000;
    pointer-events: none;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
}

.nav-links > li:hover .mega-menu {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(8px);
    pointer-events: auto;
}

/* Hover bridge to prevent gap issues */
.nav-links > li > .mega-menu::before {
    content: '';
    position: absolute;
    top: -12px;
    left: 0;
    width: 100%;
    height: 14px;
}

/* Mega menu column */
.mega-col {
    min-width: 0;
}

.mega-col-title {
    font-size: 14px;
    font-weight: 800;
    color: #fc2779;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 14px;
    padding-bottom: 8px;
    border-bottom: 2px solid #fff0f5;
    position: relative;
}

.mega-col-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -2px;
    width: 30px;
    height: 2px;
    background: #fc2779;
}

.mega-col-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.mega-col-list li {
    margin: 0;
}

.mega-col-list li a {
    display: block;
    padding: 6px 0;
    font-size: 13px;
    font-weight: 500;
    color: #555;
    text-decoration: none;
    transition: all 0.2s ease;
    border-radius: 4px;
}

.mega-col-list li a:hover {
    color: #fc2779;
    padding-left: 6px;
    background: transparent;
}

/* Sub-category heading inside mega */
.mega-sub-heading {
    font-size: 13px;
    font-weight: 700;
    color: #333;
    margin-top: 12px;
    margin-bottom: 6px;
    text-transform: capitalize;
}

.mega-sub-heading:first-child {
    margin-top: 0;
}

/* ==========================
      SEARCH
========================== */

.search-box {
    flex: 1;
    max-width: 320px;
    min-width: 160px;
    height: 42px;
    border: 1.5px solid #ebebeb;
    border-radius: 50px;
    display: flex;
    align-items: center;
    background: #fafafa;
    padding: 0 16px;
    transition: all 0.3s;
}

.search-box:hover {
    border-color: #fc2779;
    box-shadow: 0 0 0 3px rgba(252, 39, 121, 0.07);
}

.search-box:focus-within {
    border-color: #fc2779;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(252, 39, 121, 0.1);
}

.search-box i {
    color: #aaa;
    font-size: 15px;
    flex-shrink: 0;
}

.search-box:focus-within i {
    color: #fc2779;
}

.search-box input {
    width: 100%;
    border: none;
    outline: none;
    padding-left: 10px;
    background: transparent;
    font-size: 13.5px;
    color: #333;
    font-family: 'Inter', sans-serif;
}

.search-box input::placeholder {
    color: #bbb;
}

/* ==========================
    SELLER BUTTON
========================== */

.seller-btn {
    background: #111;
    color: #fff !important;
    padding: 9px 18px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    font-size: 12.5px;
    white-space: nowrap;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
}

.seller-btn:hover {
    background: #fc2779;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(252, 39, 121, 0.3);
}

/* ==========================
    RIGHT
========================== */

.header-right {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
    overflow: visible !important;
}

.header-icon {
    text-decoration: none;
    color: #333;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 2px;
    font-weight: 600;
    transition: all 0.25s;
    padding: 6px 10px;
    border-radius: 10px;
    cursor: pointer;
}

.header-icon:hover {
    color: #fc2779;
    background: #fff0f5;
}

.header-icon i {
    font-size: 20px;
}

.header-icon .icon-label {
    font-size: 13.5px;
    font-weight: 600;
    letter-spacing: 0.3px;
    line-height: 1;
    color: inherit;
}

/* Cart Icon */
.header-icon-bag {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #fff;
    border: 1.5px solid #ebebeb;
    position: relative;
    text-decoration: none;
    color: #222;
    transition: all 0.3s;
}

.header-icon-bag:hover {
    background: #fc2779;
    color: #fff;
    border-color: #fc2779;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(252, 39, 121, 0.3);
}

.header-icon-bag i {
    font-size: 20px;
}

.bag-count {
    position: absolute;
    top: -5px;
    right: -5px;
    width: 20px;
    height: 20px;
    background: #fc2779;
    color: #fff;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 10px;
    font-weight: 700;
    border: 2px solid #fff;
}

/* Wishlist icon */
.header-icon-wish {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #fff;
    border: 1.5px solid #ebebeb;
    position: relative;
    text-decoration: none;
    color: #222;
    transition: all 0.3s;
}

.header-icon-wish:hover {
    background: #fc2779;
    color: #fff;
    border-color: #fc2779;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(252, 39, 121, 0.3);
}

.header-icon-wish i {
    font-size: 20px;
}

.header-icon-wish .wish-count {
    position: absolute;
    top: -5px;
    right: -5px;
    width: 20px;
    height: 20px;
    background: #fc2779;
    color: #fff;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 10px;
    font-weight: 700;
    border: 2px solid #fff;
}

/* ==========================
      PROFILE DROPDOWN
========================== */

.profile-dropdown {
    position: relative;
    display: inline-block;
}

.profile-dropdown .dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    width: 180px;
    margin-top: 20px;
    border-radius: 12px;
    padding: 6px 0;
    background-color: #fff;
    border: 1px solid #f0f0f0;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    z-index: 1000;
    list-style: none;
}

.profile-dropdown::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    height: 25px;
}

.profile-dropdown:hover .dropdown-menu {
    display: block;
}

.profile-dropdown .dropdown-item {
    display: flex;
    align-items: center;
    gap: 8px;
    width: 100%;
    padding: 10px 16px;
    font-size: 13.5px;
    font-weight: 500;
    color: #444;
    text-decoration: none;
    background: none;
    border: none;
    cursor: pointer;
    transition: 0.2s;
}

.profile-dropdown .dropdown-item:hover {
    color: #fc2779;
    background-color: #fff0f5;
}

.profile-dropdown .dropdown-item i {
    font-size: 15px;
}

.profile-dropdown .dropdown-divider {
    height: 1px;
    margin: 4px 0;
    background-color: #f5f5f5;
    border: none;
}

.navbar {
    overflow: visible !important;
}

/* ==========================
      MOBILE TOGGLE
========================== */

.mobile-toggle {
    display: none;
    width: 40px;
    height: 40px;
    border: none;
    background: none;
    cursor: pointer;
    font-size: 24px;
    color: #333;
    padding: 0;
    align-items: center;
    justify-content: center;
}

/* ==========================
      MOBILE SIDEBAR (Accordion)
========================== */

.mobile-sidebar-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 99999;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.mobile-sidebar-overlay.active {
    display: block;
    opacity: 1;
}

.mobile-sidebar {
    position: fixed;
    top: 0;
    left: -320px;
    width: 300px;
    height: 100%;
    background: #fff;
    z-index: 100000;
    transition: left 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    box-shadow: 4px 0 30px rgba(0, 0, 0, 0.15);
    overflow-y: auto;
    padding-bottom: 40px;
}

.mobile-sidebar.open {
    left: 0;
}

.mobile-sidebar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #f0f0f0;
    background: linear-gradient(135deg, #fc2779, #ff5ba8);
    color: #fff;
}

.mobile-sidebar-header h5 {
    margin: 0;
    font-weight: 700;
    font-size: 18px;
}

.mobile-sidebar-close {
    border: none;
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 18px;
    transition: all 0.3s;
}

.mobile-sidebar-close:hover {
    background: rgba(255, 255, 255, 0.4);
}

/* Mobile accordion categories */
.mobile-cat-item {
    border-bottom: 1px solid #f5f5f5;
}

.mobile-cat-link {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 20px;
    text-decoration: none;
    color: #333;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.2s;
    cursor: pointer;
}

.mobile-cat-link:hover {
    background: #fff0f5;
    color: #fc2779;
}

.mobile-cat-link .toggle-icon {
    transition: transform 0.3s ease;
    font-size: 12px;
}

.mobile-cat-link .toggle-icon.open {
    transform: rotate(90deg);
}

.mobile-sub-list {
    display: none;
    background: #fafafa;
    padding: 4px 0;
}

.mobile-sub-list.open {
    display: block;
}

.mobile-sub-link {
    display: block;
    padding: 10px 20px 10px 36px;
    text-decoration: none;
    color: #555;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.2s;
    cursor: pointer;
}

.mobile-sub-link:hover {
    color: #fc2779;
    background: #fff0f5;
}

.mobile-child-link {
    display: block;
    padding: 8px 20px 8px 52px;
    text-decoration: none;
    color: #777;
    font-size: 12.5px;
    font-weight: 400;
    transition: all 0.2s;
}

.mobile-child-link:hover {
    color: #fc2779;
    background: #fff0f5;
}

/* ==========================
      RESPONSIVE
========================== */

@media (max-width: 1200px) {
    .search-box { max-width: 200px; }
}

@media (max-width: 992px) {
    .nav-links { display: none; }
    .mega-menu { display: none !important; }
    .search-box { display: none; }
    .navbar { padding: 0 20px; }
    .top-bar { padding: 0 20px; }
    .mobile-toggle { display: flex; }
}

@media (max-width: 768px) {
    .top-bar { display: none; }
    .logo-text { font-size: 24px; }
    .header-icon .icon-label { display: none; }
    .seller-btn span { display: none; }
}
</style>

<!-- TOP BAR -->
<div class="top-bar">
    <div class="top-left-msg">
        🚚 Free delivery on orders above <span>₹499</span>&nbsp;&nbsp;|&nbsp;&nbsp;✨ 100% Authentic Products
    </div>
    <div class="top-right">
        <a href="#">Store & Events</a>
        <a href="#">Gift Card</a>
        <a href="#">Help</a>
    </div>
</div>

<!-- MAIN NAVBAR -->
<div class="navbar">

    <!-- Mobile Toggle -->
    <button class="mobile-toggle" onclick="toggleMobileSidebar()" aria-label="Menu">
        <i class="bi bi-list"></i>
    </button>

    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo">
        <span class="logo-text">NYKAA</span>
    </a>

    <!-- Categories with Mega Menu -->
    <ul class="nav-links">
        @foreach($categories as $category)
            <li>
                <a href="{{ route('category.show', $category->id) }}" class="{{ request()->segment(1) == 'category' && request()->segment(2) == $category->id ? 'active-nav' : '' }}">
                    {{ $category->name }}
                </a>

                @if($category->children->count() > 0)
                    <div class="mega-menu">
                        @foreach($category->children as $subCategory)
                            <div class="mega-col">
                                <div class="mega-col-title">
                                    <a href="{{ route('category.show', $subCategory->id) }}" style="color: #fc2779; text-decoration: none;">
                                        {{ $subCategory->name }}
                                    </a>
                                </div>
                                @if($subCategory->children->count() > 0)
                                    <ul class="mega-col-list">
                                        @foreach($subCategory->children as $childCategory)
                                            <li>
                                                <a href="{{ route('category.show', $childCategory->id) }}">
                                                    {{ $childCategory->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </li>
        @endforeach
    </ul>

    <!-- Search -->
    <form action="{{ route('search') }}" method="GET" class="search-box">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input
            type="text"
            name="search"
            placeholder="Search Products..."
            value="{{ request('search') }}">
    </form>

    <!-- Register as Seller -->
    <a href="{{ route('seller.register') }}" class="seller-btn">
        <i class="fa-solid fa-store"></i>
        <span>Register as Seller</span>
    </a>

    <!-- Right -->
    <div class="header-right">

        @auth
            <div class="dropdown profile-dropdown">
                <a class="header-icon dropdown-toggle" href="#" role="button" aria-expanded="false">
                    <i class="fa-regular fa-user"></i>
                    <span class="icon-label">{{ Auth::user()->name }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('home') }}">
                            <i class="bi bi-person-circle"></i> My Account
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ route('login') }}" class="header-icon">
                <i class="fa-regular fa-user"></i>
                <span class="icon-label">Sign In</span>
            </a>
        @endauth

        <!-- Wishlist -->
        <a href="{{ route('wishlist.index') }}" class="header-icon-wish">
            @if($wishlistProductIds && count($wishlistProductIds) > 0)
                <i class="bi bi-heart-fill" style="color:#fc2779;"></i>
            @else
                <i class="bi bi-heart"></i>
            @endif
            <span class="wish-count" style="{{ !$wishlistProductIds || count($wishlistProductIds) == 0 ? 'display:none;' : '' }}">{{ $wishlistProductIds ? count($wishlistProductIds) : 0 }}</span>
        </a>

        <!-- Cart -->
        <a href="{{ route('cart.index') }}" class="header-icon-bag">
            <i class="bi bi-cart3"></i>
            <span class="bag-count">
                {{ $cartCount ?? 0 }}
            </span>
        </a>

    </div>

</div>

<!-- ==========================
     MOBILE SIDEBAR (Overlay + Accordion)
========================== -->

<div class="mobile-sidebar-overlay" id="mobileOverlay" onclick="toggleMobileSidebar()"></div>

<div class="mobile-sidebar" id="mobileSidebar">

    <div class="mobile-sidebar-header">
        <h5><i class="bi bi-grid"></i> Categories</h5>
        <button class="mobile-sidebar-close" onclick="toggleMobileSidebar()">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="mobile-sidebar-body">
        @foreach($categories as $category)
            <div class="mobile-cat-item">
                <div class="mobile-cat-link" onclick="toggleMobileSub(this)">
                    <span>{{ $category->name }}</span>
                    @if($category->children->count() > 0)
                        <i class="bi bi-chevron-right toggle-icon"></i>
                    @endif
                </div>

                @if($category->children->count() > 0)
                    <div class="mobile-sub-list">
                        @foreach($category->children as $subCategory)
                            <a href="{{ route('category.show', $subCategory->id) }}" class="mobile-sub-link">
                                {{ $subCategory->name }}
                            </a>
                            @if($subCategory->children->count() > 0)
                                @foreach($subCategory->children as $childCategory)
                                    <a href="{{ route('category.show', $childCategory->id) }}" class="mobile-child-link">
                                        — {{ $childCategory->name }}
                                    </a>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>

<!-- ==========================
     JAVASCRIPT
========================== -->

<script>
function toggleMobileSidebar() {
    const sidebar = document.getElementById('mobileSidebar');
    const overlay = document.getElementById('mobileOverlay');
    sidebar.classList.toggle('open');
    overlay.classList.toggle('active');
    document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
}

function toggleMobileSub(el) {
    const subList = el.nextElementSibling;
    if (!subList || !subList.classList.contains('mobile-sub-list')) return;
    const icon = el.querySelector('.toggle-icon');
    if (icon) icon.classList.toggle('open');
    subList.classList.toggle('open');
}

// Close mobile sidebar on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const sidebar = document.getElementById('mobileSidebar');
        if (sidebar.classList.contains('open')) {
            toggleMobileSidebar();
        }
    }
});
</script>