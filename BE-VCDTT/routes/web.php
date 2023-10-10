<?php

use App\Http\Controllers\Api\FAQController;
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
    return view('admin.layouts.app');
});

Route::get('/test', function(){
    return view('admin.layouts.app');
});

# /\/\/\/\/\/\/\ ================================== List Route FAQ ========================= /\/\/\/\/\/\/\/\/\ #

Route::get('faq/create', [FAQController::class, 'get_form_add'])->name('faq.create');
Route::get('faq/update', [FAQController::class, 'get_form_update'])->name('faq.update');
Route::get("faq/list", [FAQController::class,'get_list_faq'])->name('faq.list');

require __DIR__.'/auth.php';
