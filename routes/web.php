<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/payment/success', [\App\Http\Controllers\OrderController::class, 'createNewOrderOnPaymentSuccess'])->name('stripe.success');
Route::get('/test/order', [\App\Http\Controllers\OrderController::class, 'testOrder']);

Route::get('/clear/laravel/cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
});

Route::get('/', [\App\Http\Controllers\CustomerDashboardController::class, 'index'])->name('customer.index');
Route::get('/{any}', [\App\Http\Controllers\CustomerDashboardController::class, 'index']);
Route::get('/{any}/{any1}', [\App\Http\Controllers\CustomerDashboardController::class, 'index']);
Route::get('/{any}/{any1}/{any2}', [\App\Http\Controllers\CustomerDashboardController::class, 'index']);

