<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CatalogController;
use Illuminate\Support\Facades\Gate;

// Halaman utama
Route::get('/', function () {
    return view('login');
});

// Rute untuk login
Route::get('/login', [LoginController::class, 'index'])->name('account.login');
Route::post('/account/authenticate', [LoginController::class, 'authenticate'])->name('account.authenticate');

// Rute untuk register
Route::get('/register', [LoginController::class, 'register'])->name('account.register');
Route::post('/account/process-register', [LoginController::class, 'processRegister'])->name('account.processRegister');

Route::middleware(['auth'])->group(function () {
    Route::get('account/dashboard/owner', [DashboardController::class, 'ownerDashboard'])->name('dashboard.owner');
    Route::get('account/dashboard/customer', [DashboardController::class, 'customerDashboard'])->name('login.dashboard');
    // Route::get('/checkout', [DashboardController::class, 'checkout'])->name('checkout');
    // Route::post('/place-order', [DashboardController::class, 'placeOrder'])->name('place.order');
});


Route::middleware(['auth'])->group(function () {
    // Owner Dashboard
    Route::get('/owner/dashboard', [OwnerController::class, 'showDashboard'])->name('owner.dashboard');

    // Product Routes
    Route::get('/owner/product', [OwnerController::class, 'products'])->name('owner.products');
    Route::post('/owner/product/store', [ProductController::class, 'store'])->name('owner.product.store');
    Route::put('/owner/products/{id}', [ProductController::class, 'updateProduct'])->name('owner.updateProduct');
    Route::put('/owner/products/{id}/stock', [ProductController::class, 'updateStock'])->name('owner.updateStock');

    // Order Routes
    Route::get('/owner/order', [OwnerController::class, 'order'])->name('owner.orders');
    Route::get('/owner/orders-queue', [OwnerController::class, 'orderQueue'])->name('owner.orders.queue');
    Route::put('/owner/update-order-status/{orderId}', [OwnerController::class, 'updateOrderStatus'])->name('orders.updateOrderStatus');

    // Reports
    Route::get('/owner/report', [OwnerController::class, 'report'])->name('owner.reports');

    // Profile Management
    Route::get('/owner/profile', [OwnerController::class, 'profileOwner'])->name('owner.profile');
    Route::post('/owner/updatePassword', [OwnerController::class, 'updatePassword'])->name('owner.updatePassword');

    // Logout Route
    Route::post('/logout', [OwnerController::class, 'logout'])->name('logout'); // assuming AuthController handles logout
});



Route::middleware(['auth'])->group(function () {
    // Customer Routes
    // Route::get('/customer/dashboard', [OwnerController::class, 'showDashboardd'])->name('customer.dashboard');
    Route::get('/customer/menu/{category?}', [CustomerController::class, 'Products'])->name('catalog');
    Route::post('/customer/add-to-cart/{productId}', [CustomerController::class, 'addToCart'])->name('customer.addToCart');
    Route::get('/customer/checkout', action: [CustomerController::class, 'checkout'])->name('customer.checkout');
    Route::post('/customer/process-payment', [CustomerController::class, 'processPayment'])->name('customer.processPayment');
    Route::get('/customer/order-status/{orderId}', [CustomerController::class, 'orderStatus'])->name('customer.order.status');
    Route::get('/customer/profile', [CustomerController::class, 'profilee'])->name('customer.profile');
    Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');
    // New routes for Cart and Order History
    Route::get('/customer/cart', [CustomerController::class, 'checkout'])->name('customer.cart');
    Route::patch('/cart/update', [CustomerController::class, 'updateCart'])->name('customer.updateCart');
    Route::get('/customer/orders', [CustomerController::class, 'orderHistory'])->name('customer.orders');

});






