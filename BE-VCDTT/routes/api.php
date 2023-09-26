<?php

use App\Http\Controllers\Admin\TourController;
use Illuminate\Http\Request;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('admin')->group(function () {
    // Tour management
    Route::get('/tour', [TourController::class, 'index']);
    Route::post('/tour-store', [TourController::class, 'store']);
    Route::get('/tour-show/{id}', [TourController::class, 'show']);
    Route::put('/tour-edit/{id}', [TourController::class, 'update']);
    Route::delete('/tour-destroy/{id}', [TourController::class, 'destroy']);

});