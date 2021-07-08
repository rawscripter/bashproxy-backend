<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/discord/callback', [\App\Http\Controllers\DiscordController::class, 'createOrRegisterUser']);
Route::post('/payment/session/create', [\App\Http\Controllers\StripeController::class, 'createStripeSession']);
Route::post('/coupon/check', [\App\Http\Controllers\StripeController::class, 'checkCouponCode']);

//api for admin
Route::post('/admin/customers', [\App\Http\Controllers\AdminDashboardController::class, 'customers']);
Route::post('/admin/orders', [\App\Http\Controllers\AdminDashboardController::class, 'orders']);
Route::post('/dashboard/summery', [\App\Http\Controllers\AdminDashboardController::class, 'dashboardSummery']);
