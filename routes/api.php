<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\MidtransController;

// ===== PUBLIC ROUTES =====
Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

// ===== AUTH ROUTES (PUBLIC) =====
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// ===== PRODUCT ROUTES (PUBLIC) =====
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{slug}', [ProductController::class, 'show']);
});

Route::get('/categories', [CategoryController::class, 'index']);

// ===== REVIEWS (PUBLIC) =====
Route::get('/products/{productId}/reviews', [ReviewController::class, 'index']);

// ===== MIDTRANS WEBHOOK (NO AUTH REQUIRED) =====
Route::post('/midtrans/callback', [MidtransController::class, 'handleCallback']);

// ===== PROTECTED ROUTES (AUTHENTICATED) =====
Route::middleware('auth:sanctum')->group(function () {

    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);
        Route::post('/avatar', [AuthController::class, 'uploadAvatar']);
    });

    // Transaction routes
    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index']);
        Route::post('/', [TransactionController::class, 'checkout']);
        Route::get('/{id}', [TransactionController::class, 'show']);
        Route::patch('/{id}/cancel', [TransactionController::class, 'cancel']);
        Route::get('/{id}/status', [TransactionController::class, 'getStatus']);
    });

    // Chat routes
    Route::prefix('chats')->group(function () {
        Route::get('/', [ChatController::class, 'listRooms']);
        Route::post('/', [ChatController::class, 'createRoom']);
        Route::get('/{roomId}/messages', [ChatController::class, 'getMessages']);
        Route::post('/{roomId}/messages', [ChatController::class, 'sendMessage']);
        Route::patch('/{roomId}/read', [ChatController::class, 'markRead']);
        Route::post('/{roomId}/upload', [ChatController::class, 'uploadAttachment']);
    });

    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store']);
});
