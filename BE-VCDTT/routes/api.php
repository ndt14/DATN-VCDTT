<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\FAQController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PurchaseHistoryController;
use App\Models\PurchaseHistory;

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

Route::middleware(['auth:sanctum'])->group(function () {

});

    // Tour management
    Route::get('/tour', [TourController::class, 'index']);
    Route::get('/tour-add', [TourController::class,'add']);
    Route::post('/tour-store', [TourController::class, 'store']);
    Route::get('/tour-show/{id}', [TourController::class, 'show']);
    Route::put('/tour-edit/{id}', [TourController::class, 'update']);
    Route::delete('/tour-destroy/{id}', [TourController::class, 'destroy']);


    //Blog
    Route::get('/blog', [BlogController::class, 'index']);
    Route::get('/blog-add', [BlogController::class,'add']);
    Route::post('/blog-store', [BlogController::class, 'store']);
    Route::get('/blog-show/{id}', [BlogController::class, 'show']);
    Route::put('/blog-edit/{id}', [BlogController::class, 'update']);
    Route::delete('/blog-destroy/{id}', [BlogController::class, 'destroy']);

    // Category
    Route::get('/category', [CategoryController::class, 'index']);
    Route::post('/category-add', [CategoryController::class, 'add']);
    Route::post('/category-store', [CategoryController::class, 'store']);
    Route::get('/category-show/{id}', [CategoryController::class, 'show']);
    Route::put('/category-edit/{id}', [CategoryController::class, 'update']);
    Route::delete('/category-destroy/{id}', [CategoryController::class, 'destroy']);

    // Coupon
    Route::get('/coupon', [CouponController::class, 'index']);
    Route::post('/coupon-store', [CouponController::class, 'store']);
    Route::get('/coupon-show/{id}', [CouponController::class, 'show']);
    Route::get('/coupon-search', [CouponController::class, 'search_coupon']);
    Route::put('/coupon-edit/{id}', [CouponController::class, 'update']);
    Route::delete('/coupon-destroy/{id}', [CouponController::class, 'destroy']);

    //FAQ
    Route::get('/faq', [FAQController::class, 'index']);
    Route::post('/faq-store', [FAQController::class, 'store']);
    Route::get('/faq-show/{id}', [FAQController::class, 'show']);
    Route::get('/faq-search', [FAQController::class, 'search_faq']);
    Route::put('/faq-edit/{id}', [FAQController::class, 'update']);
    Route::delete('/faq-destroy/{id}', [FAQController::class, 'destroy']);

    //User
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user-store', [UserController::class, 'store']);
    Route::get('/user-show/{id}', [UserController::class, 'show']);
    Route::put('/user-edit/{id}', [UserController::class, 'update']);
    Route::delete('/user-destroy/{id}', [UserController::class, 'destroy']);

    //PurchaseHistory
    Route::post('/purchase-history-store', [PurchaseHistoryController::class, 'store']);

    //Auth
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class,  'logout'])->middleware(['auth:sanctum']);

    Route::post('/reset-password', [ResetPasswordController::class, 'sendMail']);
    Route::put('/reset-password/{token}', [ResetPasswordController::class, 'reset']);

    Route::match(['get', 'post'], '/vnpay-payment',[PaymentController::class,'vnpayPayment']); //pay route
    // Route::post('/vnpay-payment',[PaymentController::class,'vnpayPayment']);
