<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

/**
 * Buyers
 */
Route::resource('buyer', Controllers\Buyer\BuyerController::class, ['only' => ['index', 'show']]);


/**
 * Sellers
 */
Route::resource('seller', Controllers\Seller\SellerController::class, ['only' => ['index', 'show']]);


/**
 * Categories
 */
Route::resource('categories', Controllers\Category\CategoryController::class, ['except' => ['create', 'edit']]);


/**
 * Transactions
 */
Route::resource('transaction', Controllers\Transaction\TransactionController::class, ['only' => ['index', 'show']]);


/**
 * User
 */
Route::resource('user', Controllers\User\UserController::class, ['only' => ['index', 'show', 'store']]);
