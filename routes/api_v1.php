<?php

use App\Http\Controllers\API\v1\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\EmployeeController;

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

Route::get('/', function () {
    return 'API V1';
});

// Public routes
Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login'); // Login
});

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::controller(UserController::class)->middleware(['auth:sanctum'])->group(function () {
    Route::get('/users/detail', 'index');
    Route::get('/users', 'show');
    Route::post('/users', 'store');
    Route::put('/users', 'update');
    Route::delete('/users', 'destroy');
});

Route::controller(EmployeeController::class)->middleware(['auth:sanctum'])->group(function () {
    Route::get('/employees/detail', 'index');
    Route::get('/employees', 'show');
    Route::post('/employees', 'store');
    Route::put('/employees', 'update');
    Route::delete('/employees', 'destroy');
});
