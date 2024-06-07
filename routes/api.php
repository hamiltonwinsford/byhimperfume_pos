<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login-user', [ApiController::class, 'login'])->name('login-user');
Route::post('/update-password', [ApiController::class, 'updatePassword'])->name('update-password');
Route::get('/get-profile', [ApiController::class, 'getProfile'])->name('get-profile');
Route::post('/add-customer', [ApiController::class, 'addCustomer'])->name('add-customer');
Route::post('/search-customer', [ApiController::class, 'searchCustomer'])->name('search-customer');

/*==================== GET DATA PRODUCT ======================*/

Route::get('/get-product', [ApiController::class, 'getProduct'])->name('get-product');
Route::get('/get-category', [ApiController::class, 'getCategory'])->name('get-category');
Route::get('/get-bottle', [ApiController::class, 'getBottle'])->name('get-bottle');
Route::get('/get-other-product', [ApiController::class, 'getOtherProduct'])->name('get-other-product');
Route::post('/search-product', [ApiController::class, 'searchProduct'])->name('search-product');
Route::post('/search-bottle', [ApiController::class, 'searchBottle'])->name('search-bottle');
Route::post('/search-bottle-size', [ApiController::class, 'searchBottleSize'])->name('search-bottle-size');
Route::get('/product-by-category', [ApiController::class, 'productByCategory'])->name('product-by-category');

Route::post('/add-stock-opname', [ApiController::class, 'addStockOpname'])->name('add-stock-opname');

Route::get('/get-promotion', [ApiController::class, 'getPromotion'])->name('get-promotion');
Route::get('/get-promotion-bundle', [ApiController::class, 'getPromotionBundle'])->name('get-promotion-bundle');

/*======================== POS ==========================*/

Route::post('/check-harga', [ApiController::class, 'checkHarga'])->name('check-harga');
Route::get('/get-cart', [ApiController::class, 'getCart'])->name('get-cart');
Route::post('/add-to-cart', [ApiController::class, 'addToCart'])->name('add-to-cart');
Route::post('/update-cart', [ApiController::class, 'updateCart'])->name('update-cart');
Route::get('/delete-cart', [ApiController::class, 'deleteCart'])->name('delete-cart');
Route::post('/checkout', [ApiController::class, 'checkout'])->name('checkout');


