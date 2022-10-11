<?php

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

Route::controller(EmployeeController::class)->middleware(['auth:sanctum'])->group(function () {
    Route::get('/employee/detail', 'index');
    Route::get('/employee', 'show');
    Route::post('/employee', 'store');
    Route::put('/employee', 'update');
    Route::delete('/employee', 'destroy');
});
