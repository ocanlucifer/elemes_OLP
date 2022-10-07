<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

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

Route::controller(UserController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::delete('delete_user/{id}', 'delete_user');
    });

    Route::apiResource('category', CategoryController::class);
    Route::apiResource('course', CourseController::class);
    Route::get('statistics', [CourseController::class, 'get_statistics']);
    Route::get('popular_category_course', [CategoryController::class, 'popularCategory']);
});
