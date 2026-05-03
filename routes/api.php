<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth');

// ===== CHECKOUT ROUTES =====
Route::prefix('checkout')->group(function () {
    Route::post('/', [CheckoutController::class, 'checkout'])
        ->name('checkout.create');
    Route::get('/{order_id}', [CheckoutController::class, 'getOrder'])
        ->name('checkout.get');
});

// ===== PAYMENT ROUTES =====
Route::prefix('payment')->group(function () {
    Route::get('/{order_id}', [PaymentController::class, 'getPaymentInfo'])
        ->name('payment.info');
    Route::post('/upload', [PaymentController::class, 'uploadPaymentProof'])
        ->name('payment.upload');
    Route::post('/verify', [PaymentController::class, 'verifyPayment'])
        ->name('payment.verify');
    Route::get('/pending-verifications', [PaymentController::class, 'getPendingVerifications'])
        ->name('payment.pending');
});
