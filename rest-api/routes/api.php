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
Route::resource('buyer.transactions', Controllers\Buyer\BuyerTransactionController::class, ['only' => ['index']]);
Route::resource('buyer.products', Controllers\Buyer\BuyerProductController::class, ['only' => ['index']]);
Route::resource('buyer.seller', Controllers\Buyer\BuyerSellerController::class, ['only' => ['index']]);
Route::resource('buyer.categories', Controllers\Buyer\BuyerCategoryController::class, ['only' => ['index']]);

/**
 * Sellers
 */
Route::resource('seller', Controllers\Seller\SellerController::class, ['only' => ['index', 'show']]);


/**
 * Categories
 */
Route::resource('categories', Controllers\Category\CategoryController::class, ['except' => ['create', 'edit']]);
Route::resource('categories.products', Controllers\Category\CategoryProductController::class, ['only' => ['index']]);
Route::resource('categories.seller', Controllers\Category\CategorySellerController::class, ['only' => ['index']]);
Route::resource('categories.transaction', Controllers\Category\CategoryTransactionController::class, ['only' => ['index']]);
Route::resource('categories.buyer', Controllers\Category\CategoryBuyerController::class, ['only' => ['index']]);

/**
 * Transactions
 */
Route::resource('transaction', Controllers\Transaction\TransactionController::class, ['only' => ['index', 'show']]);
Route::resource('transaction.categories', Controllers\Transaction\TransactionCategoryController::class, ['only' => ['index']]);
Route::resource('transaction.sellers', Controllers\Transaction\TransactionSellerController::class, ['only' => ['index']]);

/**
 * User
 */
Route::resource('user', Controllers\User\UserController::class, ['only' => ['index', 'show', 'store']]);
