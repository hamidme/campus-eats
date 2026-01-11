<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorController;

// --- PUBLIC ROUTES (Everyone can see these) ---
Route::get('/', [MenuController::class, 'index'])->name('home');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen.index');
Route::post('/kitchen/update/{id}', [KitchenController::class, 'updateStatus'])->name('kitchen.update');
Route::get('/vendor/menu', [VendorController::class, 'myMenu'])->name('vendor.menu');
Route::post('/vendor/menu/{id}/toggle', [VendorController::class, 'toggle'])->name('vendor.toggle');
Route::post('/cart/add-variant', [CartController::class, 'addVariant'])->name('cart.add.variant');

// --- ADMIN ROUTES (Banker Panel) ---
// In a real app, we would check 'if(user->is_admin)' here.
Route::get('/admin/banker', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin/approve/{id}', [AdminController::class, 'approve'])->name('admin.approve');
Route::post('/admin/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');

// THIS IS THE LINE YOU WERE MISSING
Route::get('/register', function() {
    return "Registration Page Coming Soon!";
})->name('register');


// --- PROTECTED ROUTES (Must be Logged In) ---
Route::middleware(['auth'])->group(function () {
    
    // 2. ORDERS
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');

    // 3. CART SYSTEM
    Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');

    // 4. WALLET SYSTEM
    Route::get('/wallet/topup', [WalletController::class, 'showTopUp'])->name('wallet.topup');
    Route::post('/wallet/topup', [WalletController::class, 'processTopUp'])->name('wallet.process');

});