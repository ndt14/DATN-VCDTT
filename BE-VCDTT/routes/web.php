<?php

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
Route::post('/tour/add/new', [TourController::class, 'tourManagementAddAction'])->name('tour.add.new');
Route::match(['GET','POST'], '/tour/edit/{id}', [TourController::class, 'tourManagementEdit'])->name('tour.edit');
Route::get('/tour/delete/{id}', [TourController::class, 'tourManagementDelete'])->name('tour.delete');

require __DIR__.'/auth.php';
