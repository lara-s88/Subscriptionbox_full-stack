<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoxController;

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


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
//Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register/submit', [RegisterController::class, 'register'])->name('register.submit');



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

Route::get('/box/{id}', [BoxController::class , 'showBox']);
Route::get('/customize/{id}', [BoxController::class , 'customizationOptions']);
Route::get('/swap/{id}', [BoxController::class , 'swapItem']);

