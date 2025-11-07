<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Frontend Controllers
use App\Http\Controllers\Frontend\MemberController;
use App\Http\Controllers\Frontend\BlogMemberController;
use App\Http\Controllers\Frontend\AccountController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\BlogController;

/* FRONTEND ROUTES (Member side) */

// Trang chủ
Route::get('/', [MemberController::class, 'index'])->name('home');

// Khu vực guest (chưa đăng nhập)
Route::middleware('guest')->group(function () {
    Route::get('/member/login', [MemberController::class, 'showLogin'])->name('member.login');
    Route::post('/member/login', [MemberController::class, 'login'])->name('member.login.post');

    Route::get('/member/register', [MemberController::class, 'showRegister'])->name('member.register');
    Route::post('/member/register', [MemberController::class, 'register'])->name('member.register.post');
});

// Đăng xuất (chỉ cho user đã đăng nhập)
Route::post('/member/logout', [MemberController::class, 'logout'])
    ->middleware('auth')
    ->name('member.logout');

// Blog (frontend)
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogMemberController::class, 'index'])->name('index');
    Route::get('/{id}-{slug?}', [BlogMemberController::class, 'show'])
        ->whereNumber('id')
        ->name('show');

    Route::post('/rate', [BlogMemberController::class, 'rate'])
        ->middleware('auth')
        ->name('rate');

    Route::post('/comment', [BlogMemberController::class, 'comment'])->name('comment');
});

// Account (frontend)
Route::middleware('auth')
    ->prefix('account')
    ->name('account.')
    ->group(function () {

        Route::get('/update', [AccountController::class, 'edit'])->name('update');
        Route::post('/update', [AccountController::class, 'update'])->name('update.post');

        Route::get('/my-product', [AccountController::class, 'myProducts'])->name('my-product');
        Route::get('/add-product', [AccountController::class, 'createProduct'])->name('add-product');
        Route::post('/add-product', [AccountController::class, 'storeProduct'])->name('store-product');

        Route::get('/product/{id}/edit', [AccountController::class, 'editProduct'])->name('edit-product');
        Route::post('/product/{id}/update', [AccountController::class, 'updateProduct'])->name('update-product');
        Route::get('/product/{id}/delete', [AccountController::class, 'destroyProduct'])->name('delete-product');
    });


Auth::routes();

// Sau login mặc định (Laravel)
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/* ADMIN ROUTES (Admin Panel) */

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('/profile', [UserController::class, 'profile'])->name('profile.edit');
        Route::post('/profile', [UserController::class, 'update'])->name('profile.update');

        /*
        |--------------------------------------------------------------------------
        | COUNTRY MANAGEMENT
        |--------------------------------------------------------------------------
        */
        Route::prefix('country')->name('country.')->group(function () {
            Route::get('/', [CountryController::class, 'index'])->name('index');
            Route::get('/create', [CountryController::class, 'create'])->name('create');
            Route::post('/store', [CountryController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [CountryController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [CountryController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [CountryController::class, 'destroy'])->name('delete');
        });

        /*
        |--------------------------------------------------------------------------
        | BLOG MANAGEMENT (Admin)
        |--------------------------------------------------------------------------
        */
        Route::prefix('blog')->name('blog.')->group(function () {
            Route::get('/', [BlogController::class, 'index'])->name('index');
            Route::get('/create', [BlogController::class, 'create'])->name('create');
            Route::post('/store', [BlogController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [BlogController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [BlogController::class, 'destroy'])->name('delete');
        });
    });
