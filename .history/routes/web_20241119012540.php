<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

route::get('/', function (){
    return view('welcome');
});

Route::get('/account/login', [LoginController::class, 'index'])->name('account.login');
Route::get('/account/authenticate', [LoginController::class, 'authenticate'])->name('account.authenticate');
