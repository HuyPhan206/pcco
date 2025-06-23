<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\BannerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Staff\StaffBannerController;
use App\Http\Controllers\Staff\StaffProductController;
use App\Http\Controllers\Staff\StaffOrderController;
use App\Http\Controllers\Staff\StaffCategoryController;
use App\Http\Controllers\Staff\StaffUserController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\CheckoutController;

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/callback', [CheckoutController::class, 'callback'])->name('checkout.callback');
Route::post('/checkout/notify', [CheckoutController::class, 'notify'])->name('checkout.notify');

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('staff', StaffController::class)->names('admin.staff');
});
Route::prefix('staff')->middleware(['auth'])->group(function () {
    // Quản lý Banner
    Route::get('/banners', [BannerController::class, 'index'])
        ->name('staff.banner.index')
        ->middleware('role:manage-banner');

    // Quản lý Sản phẩm
    Route::get('/products', [ProductController::class, 'index'])
        ->name('staff.products.index')
        ->middleware('role:manage-products');

    // Quản lý Đơn hàng
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('staff.orders.index')
        ->middleware('role:manage-orders');

    // Quản lý Danh mục
    Route::get('/categories', [CategoryController::class, 'index'])
        ->name('staff.categories.index')
        ->middleware('role:manage-categories');

    // Quản lý Người dùng
    Route::get('/users', [UserController::class, 'index'])
        ->name('staff.users.index')
        ->middleware('role:manage-users');
});


Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{slug}', [CategoryController::class, 'index'])->name('category.index');
// Public Routes
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
/* Route::post('/checkout', [OrderController::class, 'store'])->name('checkout'); */
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::get('/user/addresses', [UserController::class, 'addresses'])->name('user.addresses');
Route::post('/user/addresses', [UserController::class, 'storeAddress'])->name('user.addresses.store');
Route::get('/user/addresses/{address}/edit', [UserController::class, 'editAddress'])->name('user.addresses.edit');
Route::put('/user/addresses/{address}', [UserController::class, 'updateAddress'])->name('user.addresses.update');
Route::delete('/user/addresses/{address}', [UserController::class, 'deleteAddress'])->name('user.addresses.delete');
Route::post('/user/addresses/{address}/set-default', [UserController::class, 'setDefaultAddress'])->name('user.addresses.set-default'); 
// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
Route::post('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('products', AdminProductController::class)->names('admin.products');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::get('/orders/{id}/edit', [AdminOrderController::class, 'edit'])->name('admin.orders.edit');
    Route::put('/orders/{id}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
    Route::post('/orders/{id}/update-status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    
    // Revenue Management Routes
    Route::get('/revenue', [App\Http\Controllers\Admin\RevenueController::class, 'index'])->name('admin.revenue.index');
    
    // Product Management Routes
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
    
    // User Management Routes
        
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
        Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
        
    // Banner Routes
    Route::get('/banners', [BannerController::class, 'index'])->name('admin.banners.index');
    Route::get('/banners/create', [BannerController::class, 'create'])->name('admin.banners.create');
    Route::post('/banners', [BannerController::class, 'store'])->name('admin.banners.store');
    Route::get('/banners/{banner}/edit', [BannerController::class, 'edit'])->name('admin.banners.edit');
    Route::put('/banners/{banner}', [BannerController::class, 'update'])->name('admin.banners.update');
    Route::delete('/banners/{banner}', [BannerController::class, 'destroy'])->name('admin.banners.destroy');
    
});

// Fallback for /home
Route::get('/home', function () {
    if (auth()->check() && auth()->user()->role === 'admin') {
        return redirect()->route('admin.products.index');
    }
    return redirect('/');
})->name('home');