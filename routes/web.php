<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;

Route::get('/', [StripeController::class, 'index'])->name('stripe.index');
Route::post('/checkout', [StripeController::class, 'checkout'])->name('stripe.checkout');
Route::get('/success', [StripeController::class, 'success'])->name('stripe.success');
Route::get('/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');

