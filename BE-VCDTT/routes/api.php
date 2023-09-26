<?php

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
    Route::get('/tour', [ApiStudentController::class, 'index']);
    Route::post('/tour-store', [ApiStudentController::class, 'store']);
    Route::get('/tour-show/{id}', [ApiStudentController::class, 'show']);
    Route::put('/tour-edit/{id}', [ApiStudentController::class, 'update']);
    Route::delete('/tour-destroy/{id}', [ApiStudentController::class, 'destroy']);
    
});