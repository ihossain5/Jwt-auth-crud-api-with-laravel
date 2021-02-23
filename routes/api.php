<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentApiController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('students', [StudentApiController::class, 'index']);
// Route::post('students/create', [StudentApiController::class, 'create']);
// Route::get('students/{id}', [StudentApiController::class, 'getStudent']);
// Route::post('students/update/{id}', [StudentApiController::class, 'update']);
// Route::delete('students/{id}', [StudentApiController::class, 'delete']);

// Route::group([
//     'middleware' => 'api',
//     'prefix'     => 'auth',

// ], function ($router) {
//     Route::post('/login', [AuthController::class, 'login']);
//     Route::post('/register', [AuthController::class, 'register']);
//     Route::post('/logout', [AuthController::class, 'logout']);
//     Route::post('/refresh', [AuthController::class, 'refresh']);
//     Route::get('/user-profile', [AuthController::class, 'userProfile']);
// });
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth.jwt'], function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);

    Route::get('students', [StudentApiController::class, 'index']);
    Route::post('students/create', [StudentApiController::class, 'create']);
    Route::get('students/{id}', [StudentApiController::class, 'getStudent']);
    Route::post('students/update/{id}', [StudentApiController::class, 'update']);
    Route::delete('students/{id}', [StudentApiController::class, 'delete']);
});