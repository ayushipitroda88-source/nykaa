<!-- TOP BAR -->
<style>/* =========================
   TOP BAR
========================= */

.top-bar{
    width:100%;
    height:38px;
    background:#111;
    color:#fff;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:0 60px;
    font-size:13px;
    font-weight:500;
}

.top-bar a{
    color:#fff;
    text-decoration:none;
    margin-left:22px;
    transition:.3s;
}

.top-bar a:hover{
    color:#fc2779;
}

.top-right{
    display:flex;
    align-items:center;
}


/* =========================
   NAVBAR
========================= */

.navbar{
    position:sticky;
    top:0;
    z-index:9999;

    width:100%;
    height:82px;

    background:#fff;

    display:flex;
    align-items:center;
    justify-content:space-between;

    padding:0 55px;

    box-shadow:0 8px 30px rgba(0,0,0,.08);

    border-bottom:1px solid #eee;
}


/* LOGO */

.logo{
    font-size:34px;
    font-weight:800;
    color:#fc2779;
    letter-spacing:2px;
    cursor:pointer;
    user-select:none;
}


/* NAV LINKS */

.nav-links{

    list-style:none;

    display:flex;

    align-items:center;

    gap:28px;

    margin:0;

    padding:0;

}

.nav-links li{

    position:relative;

}

.nav-links li a{

    text-decoration:none;

    color:#222;

    font-size:15px;

    font-weight:600;

    transition:.35s;

    padding:28px 0;

    display:block;

}

.nav-links li a:hover{

    color:#fc2779;

}

.nav-links li::after{

    content:"";

    position:absolute;

    left:0;

    bottom:18px;

    width:0;

    height:2px;

    background:#fc2779;

    transition:.35s;

}

.nav-links li:hover::after{

    width:100%;

}


/* ==========================
      SEARCH
========================== */

.search-box{

    width:360px;

    height:46px;

    border:1px solid #e6e6e6;

    border-radius:50px;

    display:flex;

    align-items:center;

    background:#fafafa;

    padding:0 18px;

    transition:.3s;

}

.search-box:hover{

    box-shadow:0 10px 30px rgba(0,0,0,.06);

}

.search-box:focus-within{

    border-color:#fc2779;

    background:#fff;

}

.search-box i{

    color:#999;

    font-size:18px;

}

.search-box input{

    width:100%;

    border:none;

    outline:none;

    padding-left:12px;

    background:transparent;

    font-size:14px;

}


/* ==========================
    RIGHT
========================== */

.header-right{

    display:flex;

    align-items:center;

    gap:18px;

}

.header-icon{

    text-decoration:none;

    color:#222;

    display:flex;

    align-items:center;

    gap:8px;

    font-weight:600;

    transition:.3s;

}

.header-icon:hover{

    color:#fc2779;

}

.header-icon i{

    font-size:22px;

}

.header-icon-bag{

    width:48px;

    height:48px;

    border-radius:50%;

    display:flex;

    justify-content:center;

    align-items:center;

    background:#fff;

    border:1px solid #ececec;

    position:relative;

    text-decoration:none;

    color:#222;

    transition:.3s;

}

.header-icon-bag:hover{

    background:#fc2779;

    color:#fff;

    transform:translateY(-2px);

}

.header-icon-bag i{

    font-size:22px;

}

.bag-count{

    position:absolute;

    top:-5px;

    right:-5px;

    width:22px;

    height:22px;

    background:#fc2779;

    color:#fff;

    border-radius:50%;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:11px;

    font-weight:bold;

}






/* ==========================
      RESPONSIVE
========================== */

@media(max-width:1200px){

.search-box{

width:250px;

}

}

@media(max-width:992px){

.nav-links{

display:none;

}

.search-box{

display:none;

}

.navbar{

padding:0 20px;

}

.top-bar{

padding:0 20px;

}

}

@media(max-width:768px){

.top-bar{

display:none;

}

.logo{

font-size:28px;

}

.header-icon span{

display:none;

}

.nav-links {
    display: flex;
    gap: 20px;
    list-style: none;
}


.dropdown-column h4{
    font-size:15px;
    color:#fc2779;
    font-weight:700;
    margin-bottom:10px;
}

/* Profile Dropdown Fix */

.profile-dropdown{
    position: relative;
}

.profile-dropdown .dropdown-menu{
    width: 170px;
    min-width: 170px;
    margin-top: 10px !important;
    border-radius: 10px;
    padding: 6px 0;
    border: none;
    box-shadow: 0 8px 20px rgba(0,0,0,.15);
}

.profile-dropdown .dropdown-item{
    padding: 8px 15px;
    font-size: 14px;
}

.profile-dropdown .dropdown-divider{
    margin: 4px 0;
}

.header-right{
    overflow: visible !important;
}

.navbar{
    overflow: visible !important;
}

.header-icon span{
    max-width:120px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}


}</style>


<div class="top-bar">

    <div>📱 Get App</div>

    <div class="top-right">
        <a href="#">Store & Events</a>
        <a href="#">Gift Card</a>
        <a href="#">Help</a>
    </div>

</div>

<!-- MAIN NAVBAR -->

<div class="navbar">

    <!-- Logo -->

    <div class="logo">
        NYKAA
    </div>

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

    

    <!-- Right -->
<!-- Right Section -->
    <div class="header-right">

        @auth
            <div class="dropdown profile-dropdown">
                <a class="header-icon dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-regular fa-user"></i>
                    <span>{{ Auth::user()->name }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-person-circle me-2"></i>My Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ route('login') }}" class="header-icon">
                <i class="fa-regular fa-user"></i>
                <span>Sign In</span>
            </a>
        @endauth
            <a href="{{ route('wishlist.index') }}" class="header-icon">
    <i class="bi bi-heart"></i>
    <span>{{ Auth::check() ? App\Models\Wishlist::where('user_id',Auth::id())->count() : 0 }}</span>
</a>



        <!-- Shopping Bag (As per image: No extra text underneath) -->
        <!-- Shopping Bag (Exact Outline Style) -->
        <a href="{{ route('cart.index') }}" class="header-icon-bag">
            <i class="bi bi-cart3"></i>
            <span class="bag-count">
                {{ Auth::check() ? App\Models\CartItem::where('user_id', Auth::id())->sum('quantity') : count(session('cart', [])) }}
            </span>
        </a>

    </div>

</div>

<!-- Mega Menu -->

