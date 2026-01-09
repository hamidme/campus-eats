<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\Cart;
use App\Models\MenuItem;

Route::get('/', function () {
    // 2. Fetch the actual food from your database
    $menuItems = MenuItem::all();
    
    // 3. Send it to your specific layout file
    return view('home', ['menuItems' => $menuItems]);
});


Route::get('/cart', Cart::class)->name('cart');
Route::get('/my-orders', App\Livewire\MyOrders::class)->name('my-orders');

// Auth Routes
Route::get('/login', App\Livewire\Auth\Login::class)->name('login');
Route::get('/register', App\Livewire\Auth\Register::class)->name('register');

// Protect the Orders Page (Only logged in users can see it)
Route::get('/my-orders', App\Livewire\MyOrders::class)
    ->middleware('auth')
    ->name('my-orders');

Route::get('/profile', App\Livewire\Profile::class)
    ->middleware('auth') // <--- Important! Guests get kicked to login
    ->name('profile');
