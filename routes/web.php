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
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\CustomerReviewController;
use App\Http\Controllers\Seller\ReviewController as SellerReviewController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;

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
    Route::post('/checkout', [CartController::class,'placeOrder'])->name('checkout.place');

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

    // Customer Order Routes
    Route::get('/my-orders', [UserOrderController::class, 'index'])->name('user.orders.index');
    Route::get('/my-orders/{id}', [UserOrderController::class, 'show'])->name('user.orders.show');
    Route::post('/my-orders/{id}/confirm-order', [UserOrderController::class, 'confirmOrder'])->name('user.orders.confirm-order');

    // Customer Review Routes
    Route::post('/reviews', [CustomerReviewController::class, 'store'])->name('user.reviews.store');
    Route::put('/reviews/{id}', [CustomerReviewController::class, 'update'])->name('user.reviews.update');
    Route::delete('/reviews/{id}', [CustomerReviewController::class, 'destroy'])->name('user.reviews.destroy');
    Route::get('/my-reviews', [CustomerReviewController::class, 'myReviews'])->name('user.reviews.index');
    Route::post('/reviews/{id}/helpful', [CustomerReviewController::class, 'voteHelpful'])->name('user.reviews.helpful');
    Route::post('/reviews/{id}/report', [CustomerReviewController::class, 'report'])->name('user.reviews.report');

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
    Route::post('/products/{id}/resubmit', [SellerProductController::class, 'resubmit'])->name('products.resubmit');
    
    Route::get('/products/{product}/variants', [SellerProductVariantController::class, 'index'])->name('variants.index');
    Route::post('/products/{product}/variants', [SellerProductVariantController::class, 'sync'])->name('variants.sync');
    Route::delete('/variants/{variant}', [SellerProductVariantController::class, 'destroy'])->name('variants.delete');

    Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [SellerOrderController::class, 'show'])->name('orders.show');

    // Seller Reviews
    Route::get('/reviews', [SellerReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{id}/reply', [SellerReviewController::class, 'reply'])->name('reviews.reply');

    // Seller Colors
    Route::get('/colors', [\App\Http\Controllers\Seller\ColorController::class, 'index'])->name('colors.index');
    Route::post('/colors', [\App\Http\Controllers\Seller\ColorController::class, 'store'])->name('colors.store');
    Route::put('/colors/{id}', [\App\Http\Controllers\Seller\ColorController::class, 'update'])->name('colors.update');
    Route::delete('/colors/{id}', [\App\Http\Controllers\Seller\ColorController::class, 'destroy'])->name('colors.destroy');

    // Seller Sizes
    Route::get('/sizes', [\App\Http\Controllers\Seller\SizeController::class, 'index'])->name('sizes.index');
    Route::post('/sizes', [\App\Http\Controllers\Seller\SizeController::class, 'store'])->name('sizes.store');
    Route::put('/sizes/{id}', [\App\Http\Controllers\Seller\SizeController::class, 'update'])->name('sizes.update');
    Route::delete('/sizes/{id}', [\App\Http\Controllers\Seller\SizeController::class, 'destroy'])->name('sizes.destroy');

    // Seller Analytics
    Route::get('/analytics/products', [\App\Http\Controllers\Seller\AnalyticsController::class, 'products'])->name('analytics.products');
    Route::get('/analytics/products/export-pdf', [\App\Http\Controllers\Seller\AnalyticsController::class, 'exportPdf'])->name('analytics.products.export-pdf');
    Route::get('/analytics/products/export-excel', [\App\Http\Controllers\Seller\AnalyticsController::class, 'exportExcel'])->name('analytics.products.export-excel');

    // Request Center - Seller
    Route::prefix('request-center')->name('request-center.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Seller\RequestCenterController::class, 'index'])->name('index');
        Route::get('/pending', [\App\Http\Controllers\Seller\RequestCenterController::class, 'pending'])->name('pending');
        Route::get('/approved', [\App\Http\Controllers\Seller\RequestCenterController::class, 'approved'])->name('approved');
        Route::get('/rejected', [\App\Http\Controllers\Seller\RequestCenterController::class, 'rejected'])->name('rejected');
        Route::get('/need-more-info', [\App\Http\Controllers\Seller\RequestCenterController::class, 'needMoreInfo'])->name('need-more-info');
        Route::get('/create', [\App\Http\Controllers\Seller\RequestCenterController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Seller\RequestCenterController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\Seller\RequestCenterController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [\App\Http\Controllers\Seller\RequestCenterController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\Seller\RequestCenterController::class, 'update'])->name('update');
        Route::post('/{id}/message', [\App\Http\Controllers\Seller\RequestCenterController::class, 'addMessage'])->name('add-message');
        Route::get('/variants/{productId}', [\App\Http\Controllers\Seller\RequestCenterController::class, 'getVariants'])->name('variants');
        Route::post('/notifications/read', [\App\Http\Controllers\Seller\RequestCenterController::class, 'markNotificationsRead'])->name('notifications.read');
    });

});

use App\Http\Controllers\Admin\StaffDashboardController;
use App\Http\Controllers\Admin\StaffListController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\RoleManagementController;

Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    // Seller Management
    Route::get('/sellers', [SellerManagementController::class, 'index'])->name('sellers.index');
    Route::get('/sellers/{id}', [SellerManagementController::class, 'show'])->name('sellers.show');
    Route::patch('/sellers/{id}/status', [SellerManagementController::class, 'updateStatus'])->name('sellers.status');
    Route::get('/sellers/{id}/products', [SellerManagementController::class, 'products'])->name('sellers.products');
    Route::get('/sellers/{id}/colors', [SellerManagementController::class, 'colors'])->name('sellers.colors');
    Route::delete('/sellers/{id}/colors/{color_id}', [SellerManagementController::class, 'destroyColor'])->name('sellers.colors.destroy');
    Route::get('/sellers/{id}/sizes', [SellerManagementController::class, 'sizes'])->name('sellers.sizes');
    Route::delete('/sellers/{id}/sizes/{size_id}', [SellerManagementController::class, 'destroySize'])->name('sellers.sizes.destroy');

    // Product Approvals - Full Workflow
    Route::get('/products/approvals', [ProductApprovalController::class, 'index'])->name('products.approvals');
    Route::get('/products/approvals/{id}/review', [ProductApprovalController::class, 'review'])->name('products.review');
    Route::post('/products/approvals/{id}/approve', [ProductApprovalController::class, 'approve'])->name('products.approve');
    Route::post('/products/approvals/{id}/reject', [ProductApprovalController::class, 'reject'])->name('products.reject');
    Route::post('/products/approvals/{id}/resubmit', [ProductApprovalController::class, 'resubmit'])->name('products.resubmit');

    // Review Management
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/pending', [AdminReviewController::class, 'pending'])->name('pending');
        Route::get('/approved', [AdminReviewController::class, 'approved'])->name('approved');
        Route::get('/rejected', [AdminReviewController::class, 'rejected'])->name('rejected');
        Route::get('/reported', [AdminReviewController::class, 'reported'])->name('reported');
        Route::post('/{id}/approve', [AdminReviewController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [AdminReviewController::class, 'reject'])->name('reject');
        Route::delete('/{id}', [AdminReviewController::class, 'destroy'])->name('destroy');
        Route::post('/reports/{id}/dismiss', [AdminReviewController::class, 'dismissReport'])->name('dismiss-report');
    });

    // Admin Analytics
    Route::get('/analytics/products', [\App\Http\Controllers\Admin\AnalyticsController::class, 'products'])->name('analytics.products');
    Route::get('/analytics/products/export-pdf', [\App\Http\Controllers\Admin\AnalyticsController::class, 'exportPdf'])->name('analytics.products.export-pdf');
    Route::get('/analytics/products/export-excel', [\App\Http\Controllers\Admin\AnalyticsController::class, 'exportExcel'])->name('analytics.products.export-excel');
    Route::get('/analytics/brands', [\App\Http\Controllers\Admin\AnalyticsController::class, 'brands'])->name('analytics.brands');
    Route::get('/analytics/brands/export-pdf', [\App\Http\Controllers\Admin\AnalyticsController::class, 'exportBrandsPdf'])->name('analytics.brands.export-pdf');
    Route::get('/analytics/sellers', [\App\Http\Controllers\Admin\AnalyticsController::class, 'sellers'])->name('analytics.sellers');
    Route::get('/analytics/sellers/export-pdf', [\App\Http\Controllers\Admin\AnalyticsController::class, 'exportSellersPdf'])->name('analytics.sellers.export-pdf');

    // Staff Module (View-Only - All Admin Users)
    Route::prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
        Route::get('/', [StaffListController::class, 'index'])->name('index');
        Route::get('/{id}', [StaffListController::class, 'show'])->name('show');
        Route::get('/activity/logs', [ActivityLogController::class, 'index'])->name('activity-logs');
    });

    // Request Center - Admin
    Route::prefix('request-center')->name('request-center.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\RequestCenterController::class, 'index'])->name('index');
        Route::get('/pending', [\App\Http\Controllers\Admin\RequestCenterController::class, 'pending'])->name('pending');
        Route::get('/approved', [\App\Http\Controllers\Admin\RequestCenterController::class, 'approved'])->name('approved');
        Route::get('/rejected', [\App\Http\Controllers\Admin\RequestCenterController::class, 'rejected'])->name('rejected');
        Route::get('/need-more-info', [\App\Http\Controllers\Admin\RequestCenterController::class, 'needMoreInfo'])->name('need-more-info');
        Route::get('/history', [\App\Http\Controllers\Admin\RequestCenterController::class, 'history'])->name('history');
        Route::get('/{id}', [\App\Http\Controllers\Admin\RequestCenterController::class, 'show'])->name('show');
        Route::post('/{id}/approve', [\App\Http\Controllers\Admin\RequestCenterController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [\App\Http\Controllers\Admin\RequestCenterController::class, 'reject'])->name('reject');
        Route::post('/{id}/request-more-info', [\App\Http\Controllers\Admin\RequestCenterController::class, 'requestMoreInfo'])->name('request-more-info');
        Route::post('/{id}/message', [\App\Http\Controllers\Admin\RequestCenterController::class, 'addMessage'])->name('add-message');
    });

    // Settings - Role Management & Permission Management (Super Admin Only)
    Route::prefix('settings')->name('settings.')->middleware('super.admin')->group(function () {
        Route::get('/roles', [RoleManagementController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [RoleManagementController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RoleManagementController::class, 'store'])->name('roles.store');
        Route::get('/roles/{id}/edit', [RoleManagementController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{id}', [RoleManagementController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{id}', [RoleManagementController::class, 'destroy'])->name('roles.destroy');
        Route::get('/roles/by-role/{slug}', [RoleManagementController::class, 'byRole'])->name('roles.by-role');

        // Permission Management
        Route::get('/permissions', [\App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/permissions/role/{roleId}', [\App\Http\Controllers\Admin\PermissionController::class, 'getRolePermissions'])->name('permissions.role');
        Route::post('/permissions/save', [\App\Http\Controllers\Admin\PermissionController::class, 'save'])->name('permissions.save');
        Route::get('/permissions/sync', [\App\Http\Controllers\Admin\PermissionController::class, 'sync'])->name('permissions.sync');
    });
});
