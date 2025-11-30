<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Frontend Controllers
use App\Http\Controllers\Frontend\{
    MemberController,
    BlogMemberController,
    AccountController,
    ProductController,
    CartController,
    CheckoutController,
    SearchController,
    ForgotPasswordController
};

// Admin Controllers
use App\Http\Controllers\Admin\{
    DashboardController,
    UserController,
    CountryController,
    BlogController,
    CategoryController,
    BrandController
};

/*
|--------------------------------------------------------------------------
| FRONTEND (member)
|--------------------------------------------------------------------------
*/

// Trang chủ
Route::get('/', [MemberController::class, 'index'])->name('home');

// Guest (chưa login)
Route::middleware('guest')->group(function () {
    Route::get('/member/login',    [MemberController::class, 'showLogin'])->name('member.login');
    Route::post('/member/login',   [MemberController::class, 'login'])->name('member.login.post');

    Route::get('/member/register', [MemberController::class, 'showRegister'])->name('member.register');
    Route::post('/member/register', [MemberController::class, 'register'])->name('member.register.post');
});

// Form nhập email
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkForm'])
    ->name('password.request');

// Gửi mail reset password
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->name('password.email');

// Form nhập mật khẩu mới
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset');

// Lưu mật khẩu mới
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
    ->name('password.update');

// Logout
Route::post('/member/logout', [MemberController::class, 'logout'])
    ->middleware('auth')
    ->name('member.logout');

// Blog frontend
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogMemberController::class, 'index'])->name('index');
    Route::get('/{id}-{slug?}', [BlogMemberController::class, 'show'])
        ->whereNumber('id')
        ->name('show');

    Route::post('/rate',    [BlogMemberController::class, 'rate'])->middleware('auth')->name('rate');
    Route::post('/comment', [BlogMemberController::class, 'comment'])->name('comment');
});

// Cart
Route::get('/cart',          [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add',     [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update',  [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove',  [CartController::class, 'delete'])->name('cart.delete');

// Checkout
Route::get('/checkout',       [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/order', [CheckoutController::class, 'order'])->name('checkout.order');

// Search
Route::get('/search',             [ProductController::class, 'search'])->name('product.search');
Route::get('/search-advanced',    [SearchController::class, 'index'])->name('search.advanced');

// Price filter (AJAX)
Route::get('/products/filter-by-price', [ProductController::class, 'filterByPrice'])
    ->name('products.filter-price');

// List product (trang Products)
Route::get('/products', [SearchController::class, 'index'])->name('products.list');

// Account (chỉ member đăng nhập được)
Route::middleware(['auth', 'member'])
    ->prefix('account')
    ->name('account.')
    ->group(function () {

        // Profile
        Route::get('/update', [AccountController::class, 'edit'])->name('update');
        Route::post('/update', [AccountController::class, 'update'])->name('update.post');

        // Product của member
        Route::get('/my-product',        [ProductController::class, 'index'])->name('my-product');
        Route::get('/add-product',       [ProductController::class, 'create'])->name('add-product');
        Route::post('/add-product',      [ProductController::class, 'store'])->name('add-product.post');

        Route::get('/product/{id}/edit',    [ProductController::class, 'edit'])->name('edit-product');
        Route::post('/product/{id}/update', [ProductController::class, 'update'])->name('update-product');
        Route::delete('/product/{id}',      [ProductController::class, 'destroy'])->name('delete-product');
    });

// Chi tiết product (public)
Route::get('/product/{id}', [ProductController::class, 'show'])
    ->whereNumber('id')
    ->name('product.detail');

// Auth mặc định (nếu bạn vẫn dùng)
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [UserController::class, 'profile'])->name('profile.edit');
        Route::post('/profile', [UserController::class, 'update'])->name('profile.update');

        // Country
        Route::prefix('country')->name('country.')->group(function () {
            Route::get('/',          [CountryController::class, 'index'])->name('index');
            Route::get('/create',    [CountryController::class, 'create'])->name('create');
            Route::post('/store',    [CountryController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [CountryController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [CountryController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [CountryController::class, 'destroy'])->name('delete');
        });

        // Blog (Admin)
        Route::prefix('blog')->name('blog.')->group(function () {
            Route::get('/',          [BlogController::class, 'index'])->name('index');
            Route::get('/create',    [BlogController::class, 'create'])->name('create');
            Route::post('/store',    [BlogController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [BlogController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [BlogController::class, 'destroy'])->name('delete');
        });

        // Category
        Route::prefix('category')->name('category.')->group(function () {
            Route::get('/',           [CategoryController::class, 'index'])->name('index');
            Route::get('/create',     [CategoryController::class, 'create'])->name('create');
            Route::post('/store',     [CategoryController::class, 'store'])->name('store');
            Route::get('/edit/{id}',  [CategoryController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [CategoryController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
        });

        // Brand
        Route::prefix('brand')->name('brand.')->group(function () {
            Route::get('/',           [BrandController::class, 'index'])->name('index');
            Route::get('/create',     [BrandController::class, 'create'])->name('create');
            Route::post('/store',     [BrandController::class, 'store'])->name('store');
            Route::get('/edit/{id}',  [BrandController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [BrandController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [BrandController::class, 'destroy'])->name('delete');
        });
    });
