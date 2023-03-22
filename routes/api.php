<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DeviceUsageController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// device
Route::apiResource('devices', DeviceController::class);
Route::patch('devices/update_state/{id}', [DeviceController::class, 'updateState']);
Route::patch('devices/update_favorite/{id}', [DeviceController::class, 'updateFavorite']);

// device usage
Route::apiResource('device_usages', DeviceUsageController::class);
Route::post('device_usages/create', [DeviceUsageController::class, 'createUsage']);
Route::get('device_usages/get_usage/{id}', [DeviceUsageController::class, 'getUsage']);
// Route::get('device_usages/get_usage_all', [DeviceUsageController::class, 'getUsageAll']);

// user
Route::apiResource('users', UserController::class);

// auth
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);