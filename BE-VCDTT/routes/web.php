<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\FAQController;
use App\Http\Controllers\Api\TourController;
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

Route::get('/', function () {
    // return ['Laravel' => app()->version()];
    return view('admin.common.layout');
});

Route::get('/test', function(){
    return view('admin.common.layout');
});

Route::get('/tour', [TourController::class, 'tourManagementList'])->name('tour.list');
Route::get('/tour/add', [TourController::class, 'tourManagementAdd'])->name('tour.add');
Route::get('/tour/edit/{id}', [TourController::class, 'tourManagementEdit'])->name('tour.edit');
Route::get('/tour/detail/{id}', [TourController::class, 'tourManagementDetail'])->name('tour.detail');

Route::get('/blog', [BlogController::class, 'blogManagementList'])->name('blog.list');
Route::get('/blog/add', [BlogController::class, 'blogManagementAdd'])->name('blog.add');
Route::get('/blog/edit/{id}', [BlogController::class, 'blogManagementEdit'])->name('blog.edit');
Route::get('/blog/detail/{id}', [BlogController::class, 'blogManagementDetail'])->name('blog.detail');

Route::get('/faq', [FAQController::class, 'faqManagementList'])->name('faq.list');
Route::get('/faq/add', [FAQController::class,'faqManagementAdd'])->name('faq.add');
Route::get('/faq/edit/{id}', [FAQController::class,'faqManagementEdit'])->name('faq.edit');
Route::get('/faq/detail/{id}', [FaqController::class, 'faqManagementDetail'])->name('faq.detail');

require __DIR__.'/auth.php';
