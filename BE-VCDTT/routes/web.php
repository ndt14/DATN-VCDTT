<?php

use App\Http\Controllers\Api\BlogController;
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
Route::match(['GET','POST'],'/tour/add', [TourController::class, 'tourManagementAdd'])->name('tour.add');
Route::match(['GET','POST'], '/tour/edit/{id}', [TourController::class, 'tourManagementEdit'])->name('tour.edit');
Route::get('/tour/delete/{id}', [TourController::class, 'tourManagementDelete'])->name('tour.delete');

Route::get('/blog', [BlogController::class, 'blogManagementList'])->name('blog.list');
Route::get('/blog/add', [BlogController::class, 'blogManagementAdd'])->name('blog.add');
Route::post('/blog/add/new', [BlogController::class, 'blogManagementAddAction'])->name('blog.add.new');
Route::get('/blog/edit/{id}', [BlogController::class, 'blogManagementEdit'])->name('blog.edit');
Route::post('/blog/edit/post', [BlogController::class, 'blogManagementEditAction'])->name('blog.edit.post');
Route::get('/blog/delete/{id}', [BlogController::class, 'blogManagementDelete'])->name('blog.delete');


require __DIR__.'/auth.php';
