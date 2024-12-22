<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Authentication Routes (login, registration, etc.)
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->middleware('guest'); // Ensure this route is only available to guests (unauthenticated users)

// Routes that require the user to be authenticated
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard Route
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart Routes
    Route::get('products/{id}/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::get('cart/{id}/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [CartController::class, 'processCheckout'])->name('processCheckout');
    Route::post('/cart/suggest-products', [CartController::class, 'suggestProducts'])->name('cart.suggestProducts');

    // Order Routes
    Route::get('/order/success', function () {
        return view('order.success', [
            'order' => session('order')
        ]);
    })->name('order.success');

    // Product Routes
    Route::resource('products', ProductController::class);

    // Home Route (only accessible if authenticated)
    Route::get('/', [HomeController::class, 'index']);
});

// Include the authentication routes (login, register, etc.)
require __DIR__.'/auth.php';
