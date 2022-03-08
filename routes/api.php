<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\UserCartCheckoutController;
use App\Http\Controllers\User\UserCartController;
use App\Http\Controllers\User\UserCheckoutController;
use App\Http\Controllers\User\UserProductController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('/', [Controller::class, 'routes']); // Get list of all routes

Route::controller(AuthController::class)->group(static function () {
    Route::post('/login', 'login');
    Route::post('/signup', 'signup');
});

// These were separated cause their controller only has one action
Route::get('/products', [ProductController::class, 'index']);
Route::get('/users/{user}/products', [UserProductController::class, 'index'])->middleware('auth:sanctum');
Route::get('/carts', [CartController::class, 'index'])->middleware('auth:sanctum');
Route::get('analytics', [AnalysisController::class, 'index'])->middleware('auth:sanctum');

Route::apiResources([
    'checkouts' => CheckoutController::class,
    'users.carts' => UserCartController::class,
    'users.checkouts' => UserCheckoutController::class,
    'users.carts.checkouts' => UserCartCheckoutController::class,
]);

Route::middleware('auth:sanctum')->get('/user', [Controller::class, 'user']);
