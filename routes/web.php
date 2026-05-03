<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\OrderController;

// ─── AUTH ───────────────────────────────────────────
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── LANDING ────────────────────────────────────────
Route::view('/', 'welcome')->name('welcome');

// ─── BUYER (auth required) ──────────────────────────
Route::middleware('auth')->group(function () {
    // Catalog
    Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog');
    Route::get('/produk/{product}', [ProductController::class, 'show'])->name('product.show');

    // Cart
    Route::get('/keranjang',         [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/keranjang/{id}',  [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/keranjang/voucher',[CartController::class, 'applyVoucher'])->name('cart.voucher');

    // Checkout
    Route::get('/checkout',          [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout',         [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/sukses/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Chat (buyer)
    Route::get('/chat',              [ChatController::class, 'buyerIndex'])->name('chat.buyer');
    Route::get('/chat/{user}',       [ChatController::class, 'conversation'])->name('chat.conversation');
    Route::post('/chat/{user}',      [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/{user}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');

    // Contact chat page
    Route::get('/kontak-chat',       [ChatController::class, 'contactPage'])->name('chat.contact');
    
});

// ─── SELLER ─────────────────────────────────────────
Route::middleware(['auth', 'seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard',         [SellerController::class, 'dashboard'])->name('dashboard');
    Route::get('/produk',            [SellerController::class, 'products'])->name('products');
    Route::post('/produk',           [SellerController::class, 'storeProduct'])->name('products.store');
    Route::put('/produk/{product}',  [SellerController::class, 'updateProduct'])->name('products.update');
    Route::delete('/produk/{product}',[SellerController::class, 'destroyProduct'])->name('products.destroy');

    Route::get('/pesanan',           [OrderController::class, 'sellerIndex'])->name('orders');
    Route::patch('/pesanan/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');

    Route::get('/chat',              [ChatController::class, 'sellerIndex'])->name('chat');
    Route::get('/profil',            [SellerController::class, 'profile'])->name('profile');
    Route::put('/profil',            [SellerController::class, 'updateProfile'])->name('profile.update');
});

// ─── API (AJAX) ──────────────────────────────────────
Route::middleware('auth')->prefix('api')->group(function () {
    Route::get('/produk',            [CatalogController::class, 'apiProducts']);
    Route::get('/keranjang/count',   [CartController::class, 'count']);
});
