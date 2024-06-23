<?php

use App\Http\Controllers\BranchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SeedController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BottleController;
use App\Http\Controllers\OtherProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PromotionsController;
use App\Http\Controllers\FirstStockController;
use App\Http\Controllers\OpnameController;
use App\Http\Controllers\PromotionBundleController;
use App\Http\Controllers\StockCardController;
use App\Http\Controllers\BundleController;
use App\Models\Customer;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/report', [HomeController::class, 'report']);
    Route::get('/detail-transactions/{id}', [HomeController::class, 'detail']);
    Route::get('/weekly-transactions', [HomeController::class, 'getWeeklyTransactions']);
    Route::get('/daily-transactions', [HomeController::class, 'getDailyTransactions']);
    Route::get('/chart', function () {
        return view('chart');
    });
    Route::get('/detail-stock/{id}', [StockController::class, 'detail']);
    Route::get('/bundles/get-products-by-branch/{branchId}', [BundleController::class, 'getProductsByBranch']);
    Route::get('/bundles/get-variants-by-product/{productId}', [BundleController::class, 'getVariantsByProduct']);
    Route::get('/bundles/get-bottle-sizes-by-variant/{variant}', [BundleController::class, 'getBottleSizesByVariant']);


    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::post('products/import', [ProductController::class, 'import'])->name('products.import');
    Route::resource('other_product', OtherProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('stock', StockController::class);
    Route::resource('stockcard', StockCardController::class);
    Route::resource('seeds', SeedController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('bottle', BottleController::class);
    Route::resource('promotions', PromotionsController::class);
    Route::resource('promotionBundle', PromotionBundleController::class);
    Route::resource('first_stock', FirstStockController::class);
    Route::resource('opname', OpnameController::class);
    Route::resource('bundles', BundleController::class);


    // Route::get('/users', function () {
    //     return view('pages.users');
    // })->name('users');

    // Route::get('/profile', function () {
    //     return view('pages.profile');
    // })->name('profile');
});
