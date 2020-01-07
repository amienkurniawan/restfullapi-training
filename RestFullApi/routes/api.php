<?php

use Illuminate\Http\Request;

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

/**
 * Categories
 */
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
/**
 * Product
 */
Route::resource('product', 'Product\ProductController', ['only' => ['index', 'show']]);
/**
 * Buyer
 */
Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);
/**
 * Seller
 */
Route::resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);
/**
 * Transaction
 */
Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['index', 'show']]);
/**
 * User
 */
Route::resource('user', 'User\UserController', ['except' => ['create', 'edit']]);
