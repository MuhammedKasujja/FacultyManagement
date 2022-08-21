<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'jwt.verify'], function () {
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::group(['prefix' => 'students', 'middleware' => 'jwt.verify'], function () {
    Route::post('/', [StudentController::class, 'index']);
    Route::post('view', [StudentController::class, 'show']);
    Route::post('delete', [StudentController::class, 'destroy']);
    Route::post('create', [StudentController::class, 'create']);
    Route::post('update', [StudentController::class, 'update']);
});

Route::group(['prefix' => 'courses', 'middleware' => 'jwt.verify'], function () {
    Route::post('/', [CourseController::class, 'index']);
    Route::post('view', [CourseController::class, 'show']);
    Route::post('delete', [CourseController::class, 'destroy']);
    Route::post('create', [CourseController::class, 'create']);
    Route::post('update', [CourseController::class, 'update']);
});
