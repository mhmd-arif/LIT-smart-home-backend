<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\DeviceUsageController;
use App\Http\Controllers\Api\TotalUsageController;
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

// auth
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    // device
    Route::apiResource('devices', DeviceController::class)->middleware('checkUserDevice');
    Route::patch('devices/update_state/{id}', [DeviceController::class, 'updateState']);
    Route::patch('devices/update_favorite/{id}', [DeviceController::class, 'updateFavorite']);

    // device usage per device
    Route::apiResource('device_usages', DeviceUsageController::class);
    Route::post('device_usages/create', [DeviceUsageController::class, 'createUsage']);
    Route::get('device_usages/get_usage/{id}', [DeviceUsageController::class, 'getUsage']);

    // usages total all device
    Route::get('total_usages', [TotalUsageController::class, 'getTotalUsage']);
    Route::get('total_usages/hourly/', [TotalUsageController::class, 'getTotalUsageHourly']);
    Route::get('total_usages/daily', [TotalUsageController::class, 'getTotalUsageDaily']);
    Route::get('total_usages/weekly', [TotalUsageController::class, 'getTotalUsageWeekly']);
    Route::get('total_usages/monthly', [TotalUsageController::class, 'getTotalUsageMonthly']);

    // crud user
    Route::get('auth/current_user', [AuthController::class, 'getCurrentUser']);
    Route::put('auth/update_user', [AuthController::class, 'updateUser']);

    Route::post('auth/logout', [AuthController::class, 'logout']);
});