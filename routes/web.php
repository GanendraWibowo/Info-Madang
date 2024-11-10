<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;





// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk login
Route::get('/account/login', [LoginController::class, 'index'])->name('account.login');
Route::post('/account/authenticate', [LoginController::class, 'authenticate'])->name('account.authenticate');

// Rute untuk register
Route::get('/account/register', [LoginController::class, 'register'])->name('account.register');
Route::post('/account/process-register', [LoginController::class, 'processRegister'])->name('account.processRegister');

Route::middleware(['auth'])->group(function () {
    Route::get('account/dashboard/owner', [DashboardController::class, 'ownerDashboard'])->name('dashboard.owner');
    Route::get('account/dashboard/customer', [DashboardController::class, 'customerDashboard'])->name('login.dashboard');
    Route::get('/checkout', [DashboardController::class, 'checkout'])->name('checkout');
    Route::post('/place-order', [DashboardController::class, 'placeOrder'])->name('place.order');
});


Route::middleware(['auth', 'can:owner-access'])->group(function () {
    Route::get('/owner/dashboard', [OwnerController::class, 'showDashboard'])->name('owner.dashboard');
    Route::get('/owner/product', [OwnerController::class, 'products'])->name('owner.products');
    Route::get('/owner/order', [OwnerController::class, 'order'])->name('owner.orders');
    Route::get('/owner/report', [OwnerController::class, 'report'])->name('owner.reports');
    Route::get('/owner/orders-queue', [OwnerController::class, 'orderQueue'])->name('owner.orders.queue');
    Route::post('/owner/update-order-status/{orderId}', [OwnerController::class, 'updateOrderStatus'])->name('owner.updateOrderStatus');
    Route::get('/owner/profile', [OwnerController::class, 'profileOwner'])->name('owner.profile');
    Route::post('/owner/updatePassword', [OwnerController::class, 'updatePassword'])->name('owner.updatePassword');
    Route::post('/logout', [OwnerController::class, 'logout'])->name('logout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/customer/menu/{category?}', [CustomerController::class, 'menu'])->name('customer.menu');
    Route::post('/customer/add-to-cart/{productId}', [CustomerController::class, 'addToCart'])->name('customer.addToCart');
    Route::get('/customer/checkout', [CustomerController::class, 'checkout'])->name('customer.checkout');
    Route::post('/customer/process-payment', [CustomerController::class, 'processPayment'])->name('customer.processPayment');
    Route::get('/customer/order-status/{orderId}', [CustomerController::class, 'orderStatus'])->name('customer.order.status');
});

Route::put('/owner/products/{id}', [ProductController::class, 'updateProduct'])->name('owner.updateProduct');
Route::put('/owner/products/{id}/stock', [ProductController::class, 'updateStock'])->name('owner.updateStock');


