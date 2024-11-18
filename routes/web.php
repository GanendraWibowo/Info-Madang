<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

// Halaman utama
Route::get('/', function () {
    return view('login');
});

// Public route for accessing product images
Route::get('/products/{filename}', function ($filename) {
    $path = storage_path('app/public/products/' . $filename);
    
    if (!File::exists($path)) {
        abort(404);
    }
    
    return Response::file($path);
})->name('product.image');

// Rute untuk login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/account/authenticate', [LoginController::class, 'authenticate'])->name('account.authenticate');

// Rute untuk register
Route::get('/register', [LoginController::class, 'register'])->name('account.register');
Route::post('/account/process-register', [LoginController::class, 'processRegister'])->name('account.processRegister');

Route::middleware(['auth'])->group(function () {
    Route::get('/account/dashboard/customer', [DashboardController::class, 'customerDashboard'])->name('login.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
});

Route::middleware(['auth', 'can:admin-access'])->group(function () {
    // Changed from DashboardController to OwnerController and method to showDashboard
    Route::get('/owner/dashboard', [OwnerController::class, 'showDashboard'])->name('dashboard.owner');
    Route::get('/owner/products', [OwnerController::class, 'products'])->name('owner.products');
    Route::get('/owner/products/create', [OwnerController::class, 'products'])->name('owner.products.create');
    Route::post('/owner/products/store', [ProductController::class, 'store'])->name('owner.products.store');
    Route::get('/owner/order', [OwnerController::class, 'order'])->name('owner.orders');
    Route::get('/owner/report', [OwnerController::class, 'report'])->name('owner.reports');
    Route::get('/owner/orders-queue', [OwnerController::class, 'orderQueue'])->name('owner.orders.queue');
    Route::post('/owner/update-order-status/{orderId}', [OwnerController::class, 'updateOrderStatus'])->name('owner.updateOrderStatus');
    Route::get('/owner/profile', [OwnerController::class, 'profileOwner'])->name('owner.profile');
    Route::post('/owner/updatePassword', [OwnerController::class, 'updatePassword'])->name('owner.updatePassword');
    Route::post('/logout', [OwnerController::class, 'logout'])->name('logout');
    Route::get('/owner/products/{id}/edit', [ProductController::class, 'edit'])->name('owner.products.edit');
    Route::put('/owner/products/{id}', [ProductController::class, 'updateProduct'])->name('owner.updateProduct');
    Route::put('/owner/products/{id}/stock', [ProductController::class, 'updateStock'])->name('owner.updateStock');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/customer/menu/{category?}', [CustomerController::class, 'Products'])->name('catalog');
    Route::post('/customer/add-to-cart/{productId}', [CustomerController::class, 'cart'])->name('customer.addToCart');
    Route::get('/customer/checkout', [CustomerController::class, 'checkout'])->name('customer.checkout');
    Route::post('/customer/process-payment', [CustomerController::class, 'processPayment'])->name('customer.processPayment');
    Route::get('/customer/order-status/{orderId}', [CustomerController::class, 'orderStatus'])->name('customer.order.status');
    Route::get('/customer/profile', [CustomerController::class, 'profilee'])->name('customer.profile');
    Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');

    Route::get('/customer/cart', [CustomerController::class, 'cart'])->name('customer.cart');
    Route::get('/customer/orders', [CustomerController::class, 'orderHistory'])->name('customer.orders');
});
