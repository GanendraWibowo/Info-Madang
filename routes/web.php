<?php

use App\Http\Controllers\LoginController;
use illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'index'])->name('account.login');
