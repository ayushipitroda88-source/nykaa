<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
 use App\Http\Controllers\CartController;   
 use App\Http\Controllers\AuthController;
 use App\Http\Controllers\WishlistController;
 use App\Http\Controllers\BrandController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ProductVariantController;

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

Route::middleware('admin.auth')->group(function () {
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

/*
|--------------------------------------------------------------------------
| TEST ROUTE
|--------------------------------------------------------------------------
*/

Route::get('/test', function () {
    $products = Product::with('category')->get();
    dd($products);
});

/*
|--------------------------------------------------------------------------
| PRODUCT ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/upload-product', [ProductController::class, 'create']);
Route::post('/upload-product', [ProductController::class, 'store']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');

Route::get('/products/{id}/edit', [ProductController::class, 'edit']);
Route::post('/products/{id}/update', [ProductController::class, 'update']);

Route::get('/products/{id}/delete', [ProductController::class, 'destroy']);

/*
|--------------------------------------------------------------------------
| CATEGORY ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('categories')->group(function () {

    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');

    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');

    Route::get('/{id}', [CategoryController::class, 'show'])->name('categories.show');

    Route::put('/{id}', [CategoryController::class, 'update'])->name('categories.update');

    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

});

/*
|--------------------------------------------------------------------------
| COLLECTION ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware('admin.auth')->group(function () {

    Route::resource('collections', CollectionController::class);

});

Route::put('/collections/{id}', [CollectionController::class, 'update'])
    ->name('collections.update');

Route::delete('/collections/{collection}', [CollectionController::class, 'destroy'])
    ->name('collections.destroy');

Route::get('/category/{id}', [CategoryController::class,'show'])
        ->name('category.show');

       

Route::get('/cart', [CartController::class,'index'])->name('cart.index');

Route::post('/cart/add/{id}', [CartController::class,'add'])->name('cart.add');

Route::post('/cart/increase/{id}', [CartController::class,'increase'])->name('cart.increase');

Route::post('/cart/decrease/{id}', [CartController::class,'decrease'])->name('cart.decrease');

Route::post('/cart/remove/{id}', [CartController::class,'remove'])->name('cart.remove');



Route::get('/search', [ProductController::class, 'search'])
    ->name('search');

    Route::get('/checkout', [CartController::class,'checkout'])->name('checkout');

    Route::get('/collections', [CollectionController::class,'userIndex'])
    ->name('collections.user');

Route::get('/collection/{id}', [CollectionController::class,'userShow'])
    ->name('collection.products');

    Route::get('/get-subcategories/{id}', [ProductController::class, 'getSubCategories']);

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/





Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

Route::get('/register', function () {
    return view('auth.register');
})->name('register.page');


Route::middleware('auth')->group(function () {

    Route::post('/wishlist/add/{id}', [WishlistController::class,'add'])->name('wishlist.add');

    Route::get('/wishlist', [WishlistController::class,'index'])->name('wishlist.index');

    Route::delete('/wishlist/remove/{id}', [WishlistController::class,'remove'])->name('wishlist.remove');

});

Route::post('/wishlist/cart/{id}', [WishlistController::class,'addToCart'])
    ->name('wishlist.cart');

    Route::post('/wishlist/add/{id}', [WishlistController::class,'add'])
    ->middleware('auth')
    ->name('wishlist.add');

// ================= BRAND =================




Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
Route::post('/brand/store', [BrandController::class, 'store'])->name('brand.store');
Route::put('/brand/update/{id}', [BrandController::class, 'update'])->name('brand.update');
Route::delete('/brand/delete/{id}', [BrandController::class, 'destroy'])->name('brand.destroy');


Route::get('/brand', [BrandController::class, 'index'])->name('brand');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// ================= COLOR =================
Route::get('/color', [ColorController::class, 'index'])->name('color.index');
Route::post('/color/store', [ColorController::class, 'store'])->name('color.store');
Route::put('/color/update/{id}', [ColorController::class, 'update'])->name('color.update');
Route::delete('/color/delete/{id}', [ColorController::class, 'destroy'])->name('color.destroy');

// ================= SIZE =================
Route::get('/size', [SizeController::class, 'index'])->name('size.index');
Route::post('/size/store', [SizeController::class, 'store'])->name('size.store');
Route::put('/size/update/{id}', [SizeController::class, 'update'])->name('size.update');
Route::delete('/size/delete/{id}', [SizeController::class, 'destroy'])->name('size.destroy');

Route::get('/products/{product}/variants', [ProductVariantController::class, 'index'])
    ->name('variants.index');

Route::get('/products/{product}/variants/create', [ProductVariantController::class, 'create'])
    ->name('variants.create');

Route::post('/products/{product}/variants', [ProductVariantController::class, 'store'])
    ->name('variants.store');

Route::get('/variants/{variant}/edit',
    [ProductVariantController::class,'edit'])
    ->name('variants.edit');

Route::put('/variants/{variant}',
    [ProductVariantController::class,'update'])
    ->name('variants.update');

Route::delete('/variants/{variant}',
    [ProductVariantController::class,'destroy'])
    ->name('variants.delete');

/*
|--------------------------------------------------------------------------
| Seller Routes
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Seller\AuthController as SellerAuthController;

Route::prefix('seller')->name('seller.')->group(function () {
    Route::get('/login', [SellerAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [SellerAuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [SellerAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [SellerAuthController::class, 'register'])->name('register.submit');
    Route::post('/logout', [SellerAuthController::class, 'logout'])->name('logout');
});

use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\ProductVariantController as SellerProductVariantController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Admin\SellerManagementController;
use App\Http\Controllers\Seller\ProfileController as SellerProfileController;
use App\Http\Controllers\Admin\ProductApprovalController;

Route::prefix('seller')->name('seller.')->middleware(['seller.auth', 'seller.approved'])->group(function () {
    Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [SellerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [SellerProfileController::class, 'update'])->name('profile.update');

    Route::resource('products', SellerProductController::class);
    
    Route::get('/products/{product}/variants', [SellerProductVariantController::class, 'index'])->name('variants.index');
    Route::post('/products/{product}/variants', [SellerProductVariantController::class, 'store'])->name('variants.store');
    Route::delete('/variants/{variant}', [SellerProductVariantController::class, 'destroy'])->name('variants.delete');

    Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [SellerOrderController::class, 'show'])->name('orders.show');

    // Seller Analytics
    Route::get('/analytics/products', [\App\Http\Controllers\Seller\AnalyticsController::class, 'products'])->name('analytics.products');
    Route::get('/analytics/products/export-pdf', [\App\Http\Controllers\Seller\AnalyticsController::class, 'exportPdf'])->name('analytics.products.export-pdf');
    Route::get('/analytics/products/export-excel', [\App\Http\Controllers\Seller\AnalyticsController::class, 'exportExcel'])->name('analytics.products.export-excel');
});

Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    // Seller Management
    Route::get('/sellers', [SellerManagementController::class, 'index'])->name('sellers.index');
    Route::get('/sellers/{id}', [SellerManagementController::class, 'show'])->name('sellers.show');
    Route::patch('/sellers/{id}/status', [SellerManagementController::class, 'updateStatus'])->name('sellers.status');

    // Product Approvals
    Route::get('/products/approvals', [ProductApprovalController::class, 'index'])->name('products.approvals');
    Route::patch('/products/approvals/{id}', [ProductApprovalController::class, 'updateStatus'])->name('products.status');

    // Admin Analytics
    Route::get('/analytics/products', [\App\Http\Controllers\Admin\AnalyticsController::class, 'products'])->name('analytics.products');
    Route::get('/analytics/products/export-pdf', [\App\Http\Controllers\Admin\AnalyticsController::class, 'exportPdf'])->name('analytics.products.export-pdf');
    Route::get('/analytics/products/export-excel', [\App\Http\Controllers\Admin\AnalyticsController::class, 'exportExcel'])->name('analytics.products.export-excel');
    Route::get('/analytics/brands', [\App\Http\Controllers\Admin\AnalyticsController::class, 'brands'])->name('analytics.brands');
    Route::get('/analytics/brands/export-pdf', [\App\Http\Controllers\Admin\AnalyticsController::class, 'exportBrandsPdf'])->name('analytics.brands.export-pdf');
    Route::get('/analytics/sellers', [\App\Http\Controllers\Admin\AnalyticsController::class, 'sellers'])->name('analytics.sellers');
    Route::get('/analytics/sellers/export-pdf', [\App\Http\Controllers\Admin\AnalyticsController::class, 'exportSellersPdf'])->name('analytics.sellers.export-pdf');
});