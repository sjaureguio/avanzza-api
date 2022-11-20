<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Custom Controllers
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FileController;

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

// Route::controller(LoginController::class)->prefix('/v1/login')->group(function () {
//     Route::post('', 'login');
// });

Route::prefix('/v1')->group(function () {

    Route::controller(LoginController::class)->prefix('login')->group(function () {
        Route::post('', 'login');
    });


    Route::controller(FileController::class)->middleware('auth:sanctum')->prefix('/files')->group(function () {
    // Route::controller(FileController::class)->prefix('/files')->group(function () {
        Route::get('', 'index');
        // Route::get('/{id}', 'record');
        // Route::get('file/{id}', 'getFile')->name('file.download');
        Route::post('', 'store')->middleware('counter.verify');
        Route::delete('soft-delete/{id}', 'softDelete');
        Route::delete('destroy/{id}', 'destroy');
    });

});