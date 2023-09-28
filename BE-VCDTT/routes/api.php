<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CategoryController;


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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('admin')->group(function () {
    // Tour management
    Route::get('/tour', [TourController::class, 'index']);
    Route::get('/tour-add', [TourController::class, 'add']);
    Route::post('/tour-store', [TourController::class, 'store']);
    Route::get('/tour-show/{id}', [TourController::class, 'show']);
    Route::put('/tour-edit/{id}', [TourController::class, 'update']);
    Route::delete('/tour-destroy/{id}', [TourController::class, 'destroy']);


    //Blog
    Route::get('/blog', [BlogController::class, 'index']);
    Route::post('/blog-store', [BlogController::class, 'store']);
    Route::get('/blog-show/{id}', [BlogController::class, 'show']);
    Route::put('/blog-edit/{id}', [BlogController::class, 'update']);
    Route::delete('/blog-destroy/{id}', [BlogController::class, 'destroy']);

    // Category
    Route::get('/category', [CategoryController::class, 'index']);
    Route::post('/category-store', [CategoryController::class, 'store']);
    Route::get('/category-show/{id}', [CategoryController::class, 'show']);
    Route::put('/category-edit/{id}', [CategoryController::class, 'update']);
    Route::delete('/category-destroy/{id}', [CategoryController::class, 'destroy']);

    // Coupon
    Route::get('/coupon', [CouponController::class, 'index']);
    Route::post('/coupon-store', [CouponController::class, 'store']);
    Route::get('/coupon-show/{id}', [CouponController::class, 'show']);
    Route::put('/coupon-edit/{id}', [CouponController::class, 'update']);
    Route::delete('/coupon-destroy/{id}', [CouponController::class, 'destroy']);

    //FAQ
    Route::get('/faq', [FAQController::class, 'index']);
    Route::post('/faq-store', [FAQController::class, 'store']);
    Route::get('/faq-show/{id}', [FAQController::class, 'show']);
    Route::put('/faq-edit/{id}', [FAQController::class, 'update']);
    Route::delete('/faq-destroy/{id}', [FAQController::class, 'destroy']);

    //User
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user-store', [UserController::class, 'store']);
    Route::get('/user-show/{id}', [UserController::class, 'show']);
    Route::put('/user-edit/{id}', [UserController::class, 'update']);
    Route::delete('/user-destroy/{id}', [UserController::class, 'destroy']);
});
