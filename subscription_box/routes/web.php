<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoxController;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/sports', function () {
    return view('sports');
})->name('sports');

Route::get('/subscriptions', function () {
    return view('subscriptions');
})->name('subscriptions');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Route::get('/boxes', function () {
    return view('boxes');
})->name('boxes');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/customize', function () {
    return view('customize');
})->name('customize');

Route::redirect('/custemize', '/customize')->name('custemize');


Route::get('/reward', function () {
    return view('reward');
})->name('reward');

//Route::get('/box/{id}', [BoxController::class , 'showBox']);
//Route::get('/customize/{id}', [BoxController::class , 'customizationOptions']);
//Route::get('/swap/{id}', [BoxController::class , 'swapItem']);
Route::post('/register', [CustomerController::class, 'register']);
//Route::post('/login', [CustomerController::class, 'login']);

