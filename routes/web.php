<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShippingAddressController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));

// Guest-only auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login',     [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',    [LoginController::class, 'login']);
    Route::get('/register',  [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::patch('/profile',          [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::post('/addresses',             [ShippingAddressController::class, 'store'])->name('addresses.store');
    Route::patch('/addresses/{address}',  [ShippingAddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [ShippingAddressController::class, 'destroy'])->name('addresses.destroy');
});

// Public product routes
Route::get('/products',           [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Public category routes
Route::get('/categories',            [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Super admin routes
Route::middleware(['auth', 'role:super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users',             [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}',    [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}',   [AdminUserController::class, 'destroy'])->name('users.destroy');
});

// Admin product + category routes (super_admin + product_admin)
Route::middleware(['auth', 'role:super_admin,product_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/products',                [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create',         [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products',               [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{product}',    [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}',   [AdminProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/categories',                  [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create',           [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories',                 [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit',  [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::patch('/categories/{category}',     [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}',    [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
});
