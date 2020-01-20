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
Route::resource('categories.product', 'Category\CategoryProductController', ['only' => ['index']]);
Route::resource('categories.transaction', 'Category\CategoryTransactionController', ['only' => ['index']]);
Route::resource('categories.seller', 'Category\CategorySellerController', ['only' => ['index']]);
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
/**
 * Product
 */
Route::resource('product', 'Product\ProductController', ['only' => ['index', 'show']]);
Route::resource('product.transaction', 'Product\ProductTransactionController', ['only' => ['index']]);
/**
 * Buyer
 */
Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);
Route::resource('buyers.transaction', 'Buyer\BuyerTransactionController', ['only' => ['index']]);
Route::resource('buyers.product', 'Buyer\BuyerProductController', ['only' => ['index']]);
Route::resource('buyers.seller', 'Buyer\BuyerSellerController', ['only' => ['index']]);
Route::resource('buyers.category', 'Buyer\BuyerCategoryController', ['only' => ['index']]);
/**
 * Seller
 */
Route::resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);
Route::resource('sellers.transaction', 'Seller\SellerTransactionController', ['only' => ['index']]);
Route::resource('sellers.category', 'Seller\SellerCategoryController', ['only' => ['index']]);
Route::resource('sellers.buyer', 'Seller\SellerBuyerController', ['only' => ['index']]);
Route::resource('sellers.products', 'Seller\SellerProductController', ['except' => ['create', 'show', 'edit']]);
/**
 * Transaction
 */
Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['index', 'show']]);
Route::resource('transactions.category', 'Transaction\TransactionCategoryController', ['only' => ['index']]);
Route::resource('transactions.seller', 'Transaction\TransactionSellerController', ['only' => ['index']]);
/**
 * User
 */
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
