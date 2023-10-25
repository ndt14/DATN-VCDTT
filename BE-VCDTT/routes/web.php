<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\FAQController;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\PurchaseHistoryController;
use App\Http\Controllers\Api\UserController;



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

Route::get('/', function () {
    // return ['Laravel' => app()->version()];
    return view('admin.common.layout');
});

Route::get('/test', function(){
    return view('admin.common.layout');
});

Route::get('/tour', [TourController::class, 'tourManagementList'])->name('tour.list');
Route::match(['GET','POST'],'/tour/add', [TourController::class, 'tourManagementAdd'])->name('tour.add');
Route::match(['GET','POST'],'/tour/edit/{id}', [TourController::class, 'tourManagementEdit'])->name('tour.edit');
Route::get('/tour/detail/{id}', [TourController::class, 'tourManagementDetail'])->name('tour.detail');

Route::get('/blog', [BlogController::class, 'blogManagementList'])->name('blog.list');
Route::match(['GET','POST'],'/blog/add', [BlogController::class, 'blogManagementAdd'])->name('blog.add');
Route::match(['GET','POST'],'/blog/edit/{id}', [BlogController::class, 'blogManagementEdit'])->name('blog.edit');
Route::get('/blog/detail/{id}', [BlogController::class, 'blogManagementDetail'])->name('blog.detail');

Route::get('/faq', [FAQController::class, 'faqManagementList'])->name('faq.list');
Route::match(['GET','POST'],'/faq/add', [FAQController::class,'faqManagementAdd'])->name('faq.add');
Route::match(['GET','POST'],'/faq/edit/{id}', [FAQController::class,'faqManagementEdit'])->name('faq.edit');
Route::get('/faq/detail/{id}', [FaqController::class, 'faqManagementDetail'])->name('faq.detail');

Route::get('/coupon', [CouponController::class, 'couponManagementList'])->name('coupon.list');
Route::match(['GET','POST'],'/coupon/add', [CouponController::class,'couponManagementAdd'])->name('coupon.add');
Route::match(['GET','POST'],'/coupon/edit/{id}', [CouponController::class,'couponManagementEdit'])->name('coupon.edit');
Route::get('/coupon/detail/{id}', [CouponController::class, 'couponManagementDetail'])->name('coupon.detail');

Route::get('/user', [UserController::class, 'userManagementList'])->name('user.list');
Route::get('/user/detail/{id}', [UserController::class, 'userManagementDetail'])->name('user.detail');
Route::match(['GET','POST'],'/user/add', [UserController::class, 'userManagementAdd'])->name('user.add');
Route::match(['GET','POST'],'/user/edit/{id}', [UserController::class,'userManagementEdit'])->name('user.edit');

Route::get('/category', [CategoryController::class,'cateManagementList'])->name('category.list');
Route::get('/category/add', [CategoryController::class,'cateManagementAdd'])->name('category.add');
Route::post('/category/store', [CategoryController::class,'cateManagementStore'])->name('category.store');
Route::match(['GET','POST'],'/category/edit/{id}', [CategoryController::class,'cateManagementEdit'])->name('category.edit');


Route::post('/file-upload', [FileController::class, 'store'])->name('file.store');

Route::get('/purchase-history', [PurchaseHistoryController::class, 'purchaseHistoryManagementList'])->name('purchase_histories.list');
Route::get('/purchase-history/edit/{id}', [PurchaseHistoryController::class, 'purchaseHistoryManagementEdit'])->name('purchase_histories.edit');
Route::get('/purchase-history/detail/{id}', [PurchaseHistoryController::class, 'purchaseHistoryManagementDetail'])->name('purchase_histories.detail');
Route::get('/purchase-history/mark-as-read', [PurchaseHistoryController::class, 'purchaseHistoryMarkAsRead'])->name('purchase_histories.mark_as_read');

// Route::get('/mark-as-read', [App\Http\Controllers\Api\PurchaseHistoryController::class,'markAsRead'])->name('mark-as-read');

require __DIR__.'/auth.php';
