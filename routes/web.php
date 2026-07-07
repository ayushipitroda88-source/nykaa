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

Route::get('/admin', function () {
    return view('layout.admin');
})->name('admin.dashboard');

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

Route::prefix('admin')->group(function () {

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