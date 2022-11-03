<?php

use App\Http\Controllers\API\v1\EmployeeController;
use App\Http\Controllers\API\v1\RoleController;
use App\Http\Controllers\API\v1\UserController;
use App\Http\Controllers\Auth\AuthController;

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

Route::controller(RoleController::class)->middleware(['auth:sanctum'])->group(function () {
    Route::get('/roles/detail', 'index');
    Route::get('/roles', 'show');
    Route::post('/roles', 'store');
    Route::put('/roles', 'update');
    Route::delete('/roles', 'destroy');

    Route::post('/roles/assign-permissions', 'assign');
    Route::post('/roles/revoke-permissions', 'revoke');
});

Route::controller(UserController::class)->middleware(['auth:sanctum'])->group(function () {
    Route::get('/users/detail', 'index');
    Route::get('/users', 'show');
    Route::post('/users', 'store');
    Route::put('/users', 'update');
    Route::delete('/users', 'destroy');

    Route::post('/users/assign-roles', 'assign');
    Route::post('/users/revoke-roles', 'revoke');
});

Route::controller(EmployeeController::class)->middleware(['auth:sanctum'])->group(function () {
    Route::get('/employees/detail', 'index');
    Route::get('/employees', 'show');
    Route::post('/employees', 'store');
    Route::put('/employees', 'update');
    Route::delete('/employees', 'destroy');
});
