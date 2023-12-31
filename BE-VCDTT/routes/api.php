<?php

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FAQController;

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\AllocationController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\KeyValueController;
use App\Http\Controllers\Api\WishListController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\TermAndPrivacyController;
use App\Http\Controllers\Api\TourToCategoryController;
use App\Http\Controllers\Api\PurchaseHistoryController;
use App\Http\Controllers\Api\Auth\GoogleLoginController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;

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
Route::get('/tour-add', [TourController::class, 'add']);
Route::post('/tour-store', [TourController::class, 'store']);
Route::get('/tour-show/{id}', [TourController::class, 'show']);
Route::put('/tour-edit/{id}', [TourController::class, 'update'])->name('api.tour.edit');
Route::delete('/tour-destroy/{id}', [TourController::class, 'destroy']);
Route::delete('/tour-destroy-forever/{id}', [TourController::class, 'destroyForever']);

//Blog
Route::get('/blog', [BlogController::class, 'index']);
Route::get('/blog-add', [BlogController::class, 'add']);
Route::post('/blog-store', [BlogController::class, 'store']);
Route::get('/blog-show/{id}', [BlogController::class, 'show']);
Route::put('/blog-edit/{id}', [BlogController::class, 'update'])->name('api.blog.edit');
Route::delete('/blog-destroy/{id}', [BlogController::class, 'destroy']);
Route::delete('/blog-destroy-forever/{id}', [BlogController::class, 'destroyForever']);

// Category
Route::get('/category', [CategoryController::class, 'index']);
Route::post('/category-add', [CategoryController::class, 'add']);
Route::post('/category-store', [CategoryController::class, 'store'])->name('api.category.store');
Route::get('/category-show/{id}', [CategoryController::class, 'show']);
Route::put('/category-edit/{id}', [CategoryController::class, 'update'])->name('api.category.edit');
Route::delete('/category-destroy/{id}', [CategoryController::class, 'destroy']);
Route::delete('/category-destroy-forever/{id}', [CategoryController::class, 'destroyForever']);

// Coupon
Route::get('/coupon', [CouponController::class, 'index']);
Route::post('/coupon-store', [CouponController::class, 'store']);
Route::get('/coupon-show/{id}', [CouponController::class, 'show']);
Route::put('/coupon-edit/{id}', [CouponController::class, 'update'])->name('api.coupon.edit');
Route::delete('/coupon-destroy/{id}', [CouponController::class, 'destroy']);
Route::delete('/coupon-destroy-forever/{id}', [CouponController::class, 'destroyForever']);
// Rating
Route::get('/rating/{id}', [RatingController::class, 'index']);
Route::get('/rating', [RatingController::class, 'indexAll']);
Route::post('/rating-store', [RatingController::class, 'store']);
Route::get('/rating-show/{id}', [RatingController::class, 'show']);
Route::put('/rating-edit/{id}', [RatingController::class, 'update'])->name('api.rating.edit');
Route::delete('/rating-destroy/{id}', [RatingController::class, 'destroy']);
Route::delete('/rating-destroy-forever/{id}', [RatingController::class, 'destroyForever']);

//FAQ
Route::get('/faq', [FAQController::class, 'index']);
Route::post('/faq-store', [FAQController::class, 'store']);
Route::get('/faq-show/{id}', [FAQController::class, 'show']);
Route::get('/faq-search', [FAQController::class, 'search_faq']);
Route::put('/faq-edit/{id}', [FAQController::class, 'update'])->name('api.faq.edit');
Route::delete('/faq-destroy/{id}', [FAQController::class, 'destroy']);
Route::delete('/faq-destroy-forever/{id}', [FAQController::class, 'destroyForever']);

//User
Route::get('/user', [UserController::class, 'index']);
Route::post('/user-store', [UserController::class, 'store']);
Route::get('/user-show/{id}', [UserController::class, 'show']);
Route::get('/user-search', [UserController::class, 'search_user']);
Route::put('/user-edit/{id}', [UserController::class, 'update'])->name('api.user.edit');
Route::delete('/user-destroy/{id}', [UserController::class, 'destroy']);
Route::put('/change-password/{id}', [UserController::class, 'changePassword']);
Route::delete('/user-destroy-forever/{id}', [UserController::class, 'destroyForever']);

//PurchaseHistory
Route::get('/purchase-history', [PurchaseHistoryController::class, 'index']);
Route::post('/purchase-history-store', [PurchaseHistoryController::class, 'store']);
Route::get('/purchase-history-show/{id}', [PurchaseHistoryController::class, 'showById']);
Route::get('/purchase-history-show-by-user/{user_id}', [PurchaseHistoryController::class, 'showByUser']); //show tất cả hóa đơn của người dùng
Route::put('/purchase-history-edit/{id}', [PurchaseHistoryController::class, 'update'])->name('api.purchase_histories.edit');
Route::delete('/purchase-history-destroy/{id}', [PurchaseHistoryController::class, 'destroy']);
Route::delete('/purchase-history-destroy-forever/{id}', [PurchaseHistoryController::class, 'destroyForever']);
// Route::post('/comfirm-purchase', [PurchaseHistoryController::class, 'sendNotiComfirm']);

//WishList
Route::get('/wish-list/{id}', [WishListController::class, 'indexAll']); //Hiện thị tour theo user id
Route::post('/wish-list', [WishListController::class, 'index']); //check 1-1
// Route::post('/wish-list-store', [WishListController::class, 'store']);
// Route::get('/wish-list-check', [WishListController::class, 'show']);
Route::post('/use-wish-list', [WishListController::class, 'useWishList']); // Bật tắt yêu thích
// Route::delete('/wish-list-destroy/{id}', [WishListController::class, 'destroy']);

//Auth
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class,  'logout'])->middleware(['auth:sanctum']);

Route::post('/reset-password', [ResetPasswordController::class, 'sendMail']);
Route::put('/reset-password/{token}', [ResetPasswordController::class, 'reset']);

Route::match(['get', 'post'], '/vnpay-payment/{id}', [PaymentController::class, 'vnpayPayment']); //pay route
// Route::post('/vnpay-payment',[PaymentController::class,'vnpayPayment']);

Route::post('/check-coupon', [PurchaseHistoryController::class, 'check_coupon']);
Route::get('/list-coupon/{id}', [CouponController::class, 'listCouponUserId']);


Route::delete('/role-destroy/{id}', [RoleController::class, 'destroy'])->name('role.delete');
Route::delete('/allocation-destroy/{id}', [AllocationController::class, 'destroy'])->name('allocation.delete');


Route::get('/purchase-history/mark-as-read/{user_id}/{id}', [PurchaseHistoryController::class, 'purchaseHistoryMarkAsRead']);
Route::get('/purchase-history/mark-all-as-read/{user_id}', [PurchaseHistoryController::class, 'purchaseHistoryMarkAllAsRead']);

//Page
Route::get('/page', [TermAndPrivacyController::class, 'index']);
Route::post('/page-store', [TermAndPrivacyController::class, 'store']);
Route::get('/page-show/{id}', [TermAndPrivacyController::class, 'show']);
Route::put('/page-edit/{id}', [TermAndPrivacyController::class, 'update'])->name('api.page.edit');
Route::delete('/page-destroy/{id}', [TermAndPrivacyController::class, 'destroy']);
Route::delete('/page-destroy-forever/{id}', [TermAndPrivacyController::class, 'destroyForever']);

Route::get('/keyvalue',[KeyValueController::class,'index']);
Route::get('/keyvalue/{key}',[KeyValueController::class,'show']);
Route::post('/keyvalue-edit-all',[KeyValueController::class,'updateAll']);
Route::get('/banner',[ImageController::class,'bannerCall']);

//GG login
Route::get('/auth/google',[GoogleLoginController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback',[GoogleLoginController::class, 'handleGoogleCallback']);

//load more noti
Route::get('/get-notifications/{id}',[PurchaseHistoryController::class, 'getNotifications']);
// Route::get('/test', [PurchaseHistoryController::class, 'test']);
