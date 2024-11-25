<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

// Public Routes
Route::get('/', function () {
    return view('login');
});

// Product Image Route
Route::get('/products/{filename}', function ($filename) {
    $path = storage_path('app/public/products/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    return Response::file($path);
})->name('product.image');

// Authentication Routes
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/account/authenticate', [LoginController::class, 'authenticate'])->name('account.authenticate');
Route::get('/register', [LoginController::class, 'register'])->name('account.register');
Route::post('/account/process-register', [LoginController::class, 'processRegister'])->name('account.processRegister');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Common Dashboard Routes
    Route::get('/account/dashboard/customer', [DashboardController::class, 'customerDashboard'])->name('login.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Owner Routes
    Route::middleware(['can:admin-access'])->prefix('owner')->name('owner.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [OwnerController::class, 'showDashboard'])->name('dashboard.owner');
        
        // Products Management
        Route::get('/products', [OwnerController::class, 'products'])->name('products');
        Route::get('/products/create', [OwnerController::class, 'products'])->name('products.create');
        Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [ProductController::class, 'updateProduct'])->name('updateProduct');
        Route::put('/products/{id}/stock', [ProductController::class, 'updateStock'])->name('updateStock');
        
        // Orders Management
        Route::get('/order', [OwnerController::class, 'order'])->name('orders');
        Route::get('/orders-queue', [OwnerController::class, 'orderQueue'])->name('orders.queue');
        Route::post('/update-order-status/{orderId}', [OwnerController::class, 'updateOrderStatus'])->name('updateOrderStatus');
    });

    // Reports Route (Outside of group)
    Route::get('/owner/report', [OwnerController::class, 'reports'])->name('owner.reports');
        
    // Owner Routes (continued)
    Route::middleware(['can:admin-access'])->prefix('owner')->name('owner.')->group(function () {
        // Expenses
        Route::resource('expenses', ExpenseController::class);
        
        // Profile Management
        Route::get('/profile', [OwnerController::class, 'profileOwner'])->name('profile');
        Route::post('/updatePassword', [OwnerController::class, 'updatePassword'])->name('updatePassword');
    });

    // Customer Routes
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/menu/{category?}', [CustomerController::class, 'Products'])->name('menu');
        Route::post('/add-to-cart/{productId}', [CustomerController::class, 'addToCart'])->name('addToCart');
        Route::get('/checkout', [CustomerController::class, 'checkout'])->name('checkout');
        Route::post('/process-payment', [CustomerController::class, 'processPayment'])->name('processPayment');
        Route::get('/order-status/{orderId}', [CustomerController::class, 'orderStatus'])->name('order.status');
        Route::get('/profile', [CustomerController::class, 'profilee'])->name('profile');
        Route::get('/cart', [CustomerController::class, 'cart'])->name('cart');
        Route::patch('/cart/update', [CustomerController::class, 'updateCart'])->name('updateCart');
        Route::get('/orders', [CustomerController::class, 'orderHistory'])->name('orders');
    });

    // Logout Route
    Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');
});

// Fallback Route
Route::fallback(function () {
    return view('errors.404');
});
