<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

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
    return view('dashboard', ['dashboardMode' => 'customer']);
})->name('dashboard');

Route::get('/dashboard', function () {

    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return view('dashboard', ['dashboardMode' => 'customer']);
})->name('dashboard');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::post('/register/submit', [RegisterController::class, 'register'])->name('register.submit.legacy');



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
    return view('reward', ['rewardMode' => 'customer']);
})->name('reward');

Route::get('/customize/{id}', [CustomerController::class, 'customize'])
    ->name('customize.box');

Route::get('/boxes', [CustomerController::class, 'boxes'])
 ->name('boxes');  
   
Route::post('/add-to-cart/{id}', [CustomerController::class, 'addToCart'])
 ->name('add.to.cart');

Route::get('/cart', [CustomerController::class, 'cart'])
  ->name('cart'); 

Route::get('/admin/reward', [AdminController::class, 'getAllRewardAccounts'])->name('admin.reward');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');


Route::prefix('admin/api')->group(function () {
    // 1. Plan Management
    Route::get('/admin/plans', [AdminController::class, 'getAllPlans'])->name('admin.plans');
    Route::post('/admin/plans/create', [AdminController::class, 'createPlan'])->name('admin.plans.create');
    Route::delete('/admin/plans/{planId}', [AdminController::class, 'deletePlan'])->name('admin.plans.delete');

    // 2. Inventory Management
   Route::post('/admin/items/add', [AdminController::class, 'addItem']) ->name('admin.items.add');
   Route::delete('/admin/items/{itemId}', [AdminController::class, 'deleteItem']) ->name('admin.items.delete');
   Route::get('/admin/items', [AdminController::class, 'getAllItems'])->name('admin.items');
    Route::patch('/admin/items/{itemId}/stock', [AdminController::class, 'updateStock'])->name('admin.items.updateStock');
   Route::get('/admin/items/low-stock', [AdminController::class, 'getLowStockItems'])->name('admin.items.low-stock');

    // 3. Theme Management
    Route::post('/admin/themes', [AdminController::class, 'createTheme'])->name('admin.themes.create');
    Route::delete('/admin/themes/{themeId}', [AdminController::class, 'deleteTheme'])->name('admin.themes.delete');
    Route::post('/admin/themes/assign-item', [AdminController::class, 'assignItemToTheme'])->name('admin.themes.assign-item');
    Route::delete('/admin/themes/{themeId}/items/{itemId}', [AdminController::class, 'removeItemFromTheme'])->name('admin.themes.remove-item');

    // 4. Orders & Fulfillment
    Route::get('/orders', [AdminController::class, 'getAllOrders']);
    Route::get('/orders/{orderId}', [AdminController::class, 'getOrder']);
    Route::patch('/orders/{orderId}/status', [AdminController::class, 'updateOrderStatus']);
    Route::get('/orders/batching/{status}/{country_id}', [AdminController::class, 'getOrdersForBatching']);

    // 5. User Management
    Route::get('/users', [AdminController::class, 'getAllUsers']);
    Route::get('/users/{userId}', [AdminController::class, 'getUserById']);

    // 6. Rewards
    Route::post('/orders/{orderId}/add-reward', [AdminController::class, 'addRewardPointsForOrder'])->name('admin.rewards.add');
    Route::post('/rewards/users/{userId}/redeem', [AdminController::class, 'redeemRewardPoints'])->name('admin.rewards.redeem');

    // 7. Returns
    Route::get('/returns', [AdminController::class, 'getAllreturns']);
    Route::get('/returns/{returnsId}', [AdminController::class, 'getReturnById']);
    Route::patch('/returns/{returnsId}/approve', [AdminController::class, 'approveReturn']);
    Route::patch('/returns/{returnsId}/reject', [AdminController::class, 'rejectReturn']);
});
