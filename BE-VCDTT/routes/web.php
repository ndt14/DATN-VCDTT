<?php

use App\Http\Controllers\Api\AllocationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UploadController;

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\FAQController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\KeyValueController;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\PurchaseHistoryController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TermAndPrivacyController;
use App\Http\Middleware\checkIsAdmin;
use App\Models\Allocation;
use App\Models\Rating;

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
    // return redirect()->route('login');
    return redirect()->route('login');
});
Route::middleware(['auth', 'check.admin'])->group(function () {

    Route::get('/test', function () {
        return view('admin.common.layout');
    });
    Route::get('/dashboard', function () {
        return redirect()->route('dashboard');
    });

    // Route::get('/tour', [TourController::class, 'tourManagementList'])->name('tour.list');
    // Route::get('/tour/add', [TourController::class, 'tourManagementAdd'])->name('tour.add');
    // Route::get('/tour/edit/{id}', [TourController::class, 'tourManagementEdit'])->name('tour.edit');
    // Route::get('/tour/detail/{id}', [TourController::class, 'tourManagementDetail'])->name('tour.detail');

    // Route::get('/blog', [BlogController::class, 'blogManagementList'])->name('blog.list');
    // Route::get('/blog/add', [BlogController::class, 'blogManagementAdd'])->name('blog.add');
    // Route::get('/blog/edit/{id}', [BlogController::class, 'blogManagementEdit'])->name('blog.edit');
    // Route::get('/blog/detail/{id}', [BlogController::class, 'blogManagementDetail'])->name('blog.detail');

    // Route::get('/faq', [FAQController::class, 'faqManagementList'])->name('faq.list');
    // Route::get('/faq/add', [FAQController::class,'faqManagementAdd'])->name('faq.add');
    // Route::get('/faq/edit/{id}', [FAQController::class,'faqManagementEdit'])->name('faq.edit');
    // Route::get('/faq/detail/{id}', [FaqController::class, 'faqManagementDetail'])->name('faq.detail');

    // Route::get('/rating', [RatingController::class, 'allRatingManagementList'])->name('all.rating.list');
    // Route::get('/rating/{id}', [RatingController::class, 'ratingManagementList'])->name('rating.list');
    // Route::get('/rating/add', [RatingController::class,'ratingManagementAdd'])->name('rating.add');
    // Route::get('/rating/edit/{id}', [RatingController::class,'ratingManagementEdit'])->name('rating.edit');
    // Route::get('/rating/detail/{id}', [RatingController::class, 'ratingManagementDetail'])->name('rating.detail');

    // Route::get('/coupon', [CouponController::class, 'couponManagementList'])->name('coupon.list');
    // Route::get('/coupon/add', [CouponController::class,'couponManagementAdd'])->name('coupon.add');
    // Route::match(['GET','POST'],'/coupon/edit/{id}', [CouponController::class,'couponManagementEdit'])->name('coupon.edit');
    // Route::get('/coupon/detail/{id}', [CouponController::class, 'couponManagementDetail'])->name('coupon.detail');

    // Route::get('/user', [UserController::class, 'userManagementList'])->name('user.list');
    // Route::get('/user/detail/{id}', [UserController::class, 'userManagementDetail'])->name('user.detail');
    // Route::get('/user/add', [UserController::class, 'userManagementAdd'])->name('user.add');
    // Route::get('/user/edit/{id}', [UserController::class,'userManagementEdit'])->name('user.edit');

    // Route::get('/category', [CategoryController::class,'cateManagementList'])->name('category.list');
    // Route::get('/category/add', [CategoryController::class,'cateManagementAdd'])->name('category.add');
    // Route::post('/category/store', [CategoryController::class,'cateManagementStore'])->name('category.store');
    // Route::match(['GET','POST'],'/category/edit/{id}', [CategoryController::class,'cateManagementEidt'])->name('category.edit');


    // Route::post('/file-upload', [FileController::class, 'store'])->name('file.store');

    // Route::get('/purchase-history', [PurchaseHistoryController::class, 'purchaseHistoryManagementList'])->name('purchase_histories.list');
    // Route::get('/purchase-history/edit/{id}', [PurchaseHistoryController::class, 'purchaseHistoryManagementEdit'])->name('purchase_histories.edit');
    // Route::get('/purchase-history/detail/{id}', [PurchaseHistoryController::class, 'purchaseHistoryManagementDetail'])->name('purchase_histories.detail');
    // Route::get('/purchase-history/mark-as-read', [PurchaseHistoryController::class, 'purchaseHistoryMarkAsRead'])->name('purchase_histories.mark_as_read');

    // Route::get('/role', [RoleController::class, 'roleManagementList'])->name('role.list');
    // Route::match(['GET','POST'],'/role/add',[RoleController::class,'roleManagementAdd'])->name('role.add');
    // Route::match(['GET','POST'],'/role/edit/{id}', [RoleController::class, 'roleManagementEdit'])->name('role.edit');

    Route::get('/tour', [TourController::class, 'tourManagementList'])->name('tour.list')->middleware(['permission:admin|access tour|add tour|edit tour|delete tour|reply review']);
    Route::match(['GET', 'POST'], '/tour/add', [TourController::class, 'tourManagementAdd'])->name('tour.add')->middleware(['permission:admin|add tour']);
    Route::match(['GET', 'POST'], '/tour/edit/{id}', [TourController::class, 'tourManagementEdit'])->name('tour.edit')->middleware(['permission:admin|edit tour']);
    Route::get('/tour/detail/{id}', [TourController::class, 'tourManagementDetail'])->name('tour.detail')->middleware(['permission:admin|access tour|add tour|edit tour|delete tour|reply review']);




    Route::get('/blog', [BlogController::class, 'blogManagementList'])->name('blog.list')->middleware(['permission:admin|access post|add post|edit post|delete post']);
    Route::match(['GET', 'POST'], '/blog/add', [BlogController::class, 'blogManagementAdd'])->name('blog.add')->middleware(['permission:admin|add post']);
    Route::match(['GET', 'POST'], '/blog/edit/{id}', [BlogController::class, 'blogManagementEdit'])->name('blog.edit')->middleware(['permission:admin|edit post']);
    Route::get('/blog/detail/{id}', [BlogController::class, 'blogManagementDetail'])->name('blog.detail')->middleware(['permission:admin|access post|add post|edit post|delete post']);
    Route::get('/blog/trash', [BlogController::class, 'blogManagementTrash'])->name('blog.trash')->middleware(['permission:admin|delete post']);
    Route::get('/blog/restore/{id}', [BlogController::class, 'blogManagementRestore'])->name('blog.restore')->middleware(['permission:admin|delete post']);


    Route::get('/faq', [FAQController::class, 'faqManagementList'])->name('faq.list')->middleware(['permission:admin|access faq|add faq|edit faq|delete faq']);
    Route::match(['GET', 'POST'], '/faq/add', [FAQController::class, 'faqManagementAdd'])->name('faq.add')->middleware(['permission:admin|add faq']);
    Route::match(['GET', 'POST'], '/faq/edit/{id}', [FAQController::class, 'faqManagementEdit'])->name('faq.edit')->middleware(['permission:admin|edit faq']);
    Route::get('/faq/detail/{id}', [FaqController::class, 'faqManagementDetail'])->name('faq.detail')->middleware(['permission:admin|access faq|add faq|edit faq|delete faq']);
    Route::get('/faq/trash', [FAQController::class, 'faqManagementTrash'])->name('faq.trash')->middleware(['permission:admin|delete faq']);
    Route::get('faq/restore/{id}', [FAQController::class, 'faqManagementRestore'])->name('faq.restore')->middleware(['permission:admin|delete faq']);

    Route::get('/rating', [RatingController::class, 'allRatingManagementList'])->name('all.rating.list')->middleware(['permission:admin|access review|reply review|delete review']);
    Route::get('/rating/{id}', [RatingController::class, 'ratingManagementList'])->name('rating.list')->middleware(['permission:admin|access review|reply review|delete review']);
    Route::get('/rating/add', [RatingController::class, 'ratingManagementAdd'])->name('rating.add')->middleware(['permission:admin|reply review']);
    Route::match(['GET', 'POST'],'/rating/edit/{id}', [RatingController::class, 'ratingManagementEdit'])->name('rating.edit')->middleware(['permission:admin|reply review']);
    Route::get('/rating/detail/{id}', [RatingController::class, 'ratingManagementDetail'])->name('rating.detail')->middleware(['permission:admin|access review|reply review|delete review']);
    Route::get('/rating/trash/all', [RatingController::class, 'ratingManagementTrash'])->name('rating.trash')->middleware(['permission:admin|delete rating']);
    Route::get('rating/restore/{id}', [RatingController::class, 'ratingManagementRestore'])->name('rating.restore')->middleware(['permission:admin|delete rating']);

    Route::get('/coupon', [CouponController::class, 'couponManagementList'])->name('coupon.list')->middleware(['permission:admin|access discount|add discount|edit discount|delete discount']);
    Route::match(['GET', 'POST'], '/coupon/add', [CouponController::class, 'couponManagementAdd'])->name('coupon.add')->middleware(['permission:admin|add discount']);
    Route::match(['GET', 'POST'], '/coupon/edit/{id}', [CouponController::class, 'couponManagementEdit'])->name('coupon.edit')->middleware(['permission:admin|edit discount']);
    Route::get('/coupon/detail/{id}', [CouponController::class, 'couponManagementDetail'])->name('coupon.detail')->middleware(['permission:admin|access discount|add discount|edit discount|delete discount']);
    Route::get('/coupon/trash', [CouponController::class, 'couponManagementTrash'])->name('coupon.trash')->middleware(['permission:admin|delete coupon']);
    Route::get('coupon/restore/{id}', [CouponController::class, 'couponManagementRestore'])->name('coupon.restore')->middleware(['permission:admin|delete coupon']);

    Route::get('/user', [UserController::class, 'userManagementList'])->name('user.list')->middleware(['permission:admin|access account|add account|edit account|delete account']);
    Route::get('/user/detail/{id}', [UserController::class, 'userManagementDetail'])->name('user.detail')->middleware(['permission:admin|access account|add account|edit account|delete account']);
    Route::match(['GET', 'POST'], '/user/add', [UserController::class, 'userManagementAdd'])->name('user.add')->middleware(['permission:admin|add account']);
    Route::match(['GET', 'POST'], '/user/edit/{id}', [UserController::class, 'userManagementEdit'])->name('user.edit')->middleware(['permission:admin|edit account']);
    Route::get('/user/trash', [UserController::class, 'userManagementTrash'])->name('user.trash')->middleware(['permission:admin|delete user']);
    Route::get('user/restore/{id}', [UserController::class, 'userManagementRestore'])->name('user.restore')->middleware(['permission:admin|delete account']);

    Route::get('/category', [CategoryController::class, 'cateManagementList'])->name('category.list')->middleware(['permission:admin|access category|add category|edit category|delete category']);
    Route::get('/category/add', [CategoryController::class, 'cateManagementAdd'])->name('category.add')->middleware(['permission:admin|add category']);
    Route::post('/category/store', [CategoryController::class, 'cateManagementStore'])->name('category.store')->middleware(['permission:admin|add category']);
    Route::match(['GET', 'POST'], '/category/edit/{id}', [CategoryController::class, 'cateManagementEdit'])->name('category.edit')->middleware(['permission:admin|edit category']);

    Route::get('/page', [TermAndPrivacyController::class, 'pageManagementList'])->name('page.list')->middleware(['permission:admin']);;
    Route::match(['GET', 'POST'], '/page/add', [TermAndPrivacyController::class, 'pageManagementAdd'])->name('page.add')->middleware(['permission:admin']);;
    Route::match(['GET', 'POST'], '/page/edit/{id}', [TermAndPrivacyController::class, 'pageManagementEdit'])->name('page.edit')->middleware(['permission:admin']);;
    Route::get('/page/detail/{id}', [TermAndPrivacyController::class, 'pageManagementDetail'])->name('page.detail')->middleware(['permission:admin']);;
    Route::get('/page/trash', [TermAndPrivacyController::class, 'pageManagementTrash'])->name('page.trash')->middleware(['permission:admin']);;
    Route::get('page/restore/{id}', [TermAndPrivacyController::class, 'pageManagementRestore'])->name('page.restore')->middleware(['permission:admin']);;

    //Image
    Route::get('/image', [ImageController::class, 'index'])->name('image.list')->middleware(['permission:admin|access tour|add tour|edit tour|delete tour|reply review|access post|add post|edit post|delete post']);
    Route::get('/image/image-list', [ImageController::class, 'imageList'])->middleware(['permission:admin|access tour|add tour|edit tour|delete tour|reply review|access post|add post|edit post|delete post']);

    Route::get('/image/dropzone', [ImageController::class, 'dropzone'])->middleware(['permission:admin|access tour|add tour|edit tour|delete tour|reply review|access post|add post|edit post|delete post']);
    Route::post('/image-add', [ImageController::class, 'add'])->name('image.add')->middleware(['permission:admin|access tour|add tour|edit tour|delete tour|reply review|access post|add post|edit post|delete post']);
    Route::get('/image-download/{id}', [ImageController::class, 'download'])->middleware(['permission:admin|access tour|add tour|edit tour|delete tour|reply review|access post|add post|edit post|delete post']);
    Route::delete('/image-destroy/{id}', [ImageController::class, 'destroy'])->middleware(['permission:admin|access tour|add tour|edit tour|delete tour|reply review|access post|add post|edit post|delete post']);

    Route::post('/file-upload', [FileController::class, 'store'])->name('file.store');
    Route::post('/upload-file-ckeditor', [UploadController::class, 'upload'])->name('ckeditor.upload');

    Route::get('/purchase-history', [PurchaseHistoryController::class, 'purchaseHistoryManagementList'])->name('purchase_histories.list')->middleware(['permission:admin|access bill|edit bill|delete bill']);
    Route::match(['GET', 'POST'],'/purchase-history/edit/{id}', [PurchaseHistoryController::class, 'purchaseHistoryManagementEdit'])->name('purchase_histories.edit')->middleware(['permission:admin|edit bill']);
    Route::get('/purchase-history/detail/{id}', [PurchaseHistoryController::class, 'purchaseHistoryManagementDetail'])->name('purchase_histories.detail')->middleware(['permission:admin|access bill|edit bill|delete bill']);

    Route::get('/purchase-history/trash', [PurchaseHistoryController::class, 'purchaseHistoryManagementTrash'])->name('purchase_histories.trash')->middleware(['permission:admin|delete bill']);
    Route::get('purchase-history/restore/{id}', [PurchaseHistoryController::class, 'purchaseHistoryManagementRestore'])->name('purchase_histories.restore')->middleware(['permission:admin|delete bill']);

    Route::match(['GET', 'POST'],'/settings',[KeyValueController::class,'keyvalueManagementEditAll'])->name('settings')->middleware(['permission:admin']);

    Route::middleware('isAdmin')->group(function(){
    Route::get('/role', [RoleController::class, 'roleManagementList'])->name('role.list');
    Route::match(['GET', 'POST'], '/role/add', [RoleController::class, 'roleManagementAdd'])->name('role.add');
    Route::match(['GET','POST'], '/role/edit/{id}', [RoleController::class, 'roleManagementEdit'])->name('role.edit');
    Route::get('/allocation', [AllocationController::class,'allocationManagementList'])->name('allocation.list');
    Route::match(['GET','POST'], '/allocation/add', [AllocationController::class, 'allocationManagementAdd'])->name('allocation.add');
    Route::match(['GET','POST'], '/allocation/edit/{user_id}', [AllocationController::class, 'allocationManagementEdit'])->name('allocation.edit');
    Route::get('/allocation/delete', [AllocationController::class, 'delete_one_user_role'])->name('allocation.delete.one');
    });
    Route::match(['GET', 'POST'],'/dashboard',[DashboardController::class,'totalEarnDashboard'])->name('dashboard.tour');
    Route::match(['GET', 'POST'],'/dashboard/user',[DashboardController::class,'userDashboard'])->name('dashboard.user');
});

// Route::get('/test', [PurchaseHistoryController::class, 'test']);



require __DIR__ . '/auth.php';
