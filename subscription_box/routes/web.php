<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/reward', function () {
    return view('reward');
})->name('reward');

