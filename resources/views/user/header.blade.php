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

.nav-links li a {
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

.nav-links li a:hover {
    color: #fc2779;
    background: #fff0f5;
}

.nav-links li.active > a {
    color: #fc2779;
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
    font-size: 10px;
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

/* Wishlist icon count badge */
.wishlist-count {
    font-size: 11px;
    font-weight: 700;
    color: #333;
    line-height: 1;
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
      RESPONSIVE
========================== */

@media (max-width: 1200px) {
    .search-box { max-width: 200px; }
}

@media (max-width: 992px) {
    .nav-links { display: none; }
    .search-box { display: none; }
    .navbar { padding: 0 20px; }
    .top-bar { padding: 0 20px; }
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

    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo">
        <span class="logo-text">NYKAA</span>

    </a>

    <!-- Categories -->
    <ul class="nav-links">
        @foreach($categories as $category)
            <li>
                <a href="{{ route('category.show', $category->id) }}">
                    {{ $category->name }}
                </a>
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
        Register as Seller
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
        <a href="{{ route('wishlist.index') }}" class="header-icon">
            <i class="bi bi-heart"></i>
            <span class="icon-label">{{ Auth::check() ? App\Models\Wishlist::where('user_id', Auth::id())->count() : 0 }}</span>
        </a>

        <!-- Cart -->
        <a href="{{ route('cart.index') }}" class="header-icon-bag">
            <i class="bi bi-cart3"></i>
            <span class="bag-count">
                {{ Auth::check() ? App\Models\CartItem::where('user_id', Auth::id())->sum('quantity') : count(session('cart', [])) }}
            </span>
        </a>

    </div>

</div>
