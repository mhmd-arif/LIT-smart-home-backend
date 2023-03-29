<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\DeviceUsageController;
use App\Http\Controllers\Api\TotalUsageController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserDeviceController;

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

// device usage automation
Route::post('device_usages/create', [DeviceUsageController::class, 'createUsage']);

// device
Route::post('devices/create', [DeviceController::class, 'createDevice']);
Route::get('devices', [DeviceController::class, 'getDevices']);
Route::get('devices/{id}', [DeviceController::class, 'findDevice']);
Route::put('devices/update_device/{id}', [DeviceController::class, 'updateDevice']);
Route::delete('devices/delete/{id}', [DeviceController::class, 'deleteDevices']);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    // User device
    Route::post('user_devices/create', [UserDeviceController::class, 'createUserDevice']);
    Route::get('user_devices', [UserDeviceController::class, 'getUserDevices']);
    Route::get('user_devices/{id}', [UserDeviceController::class, 'findUserDevice']);
    Route::put('user_devices/update_device/{id}', [UserDeviceController::class, 'updateUserDevice']);
    Route::patch('user_devices/update_state/{id}', [UserDeviceController::class, 'updateState']);
    Route::patch('user_devices/update_favorite/{id}', [UserDeviceController::class, 'updateFavorite']);
    Route::delete('user_devices/delete/{id}', [UserDeviceController::class, 'deleteUserDevices']);

    // device usage per device
    Route::get('device_usages', [DeviceUsageController::class, 'getUsages']);
    Route::get('device_usages/get_usage/{id}', [DeviceUsageController::class, 'findUsage']);

    // usages total all device
    Route::get('total_usages', [TotalUsageController::class, 'getTotalUsage']);
    Route::get('total_usages/hourly/', [TotalUsageController::class, 'getTotalUsageHourly']);
    Route::get('total_usages/daily', [TotalUsageController::class, 'getTotalUsageDaily']);
    Route::get('total_usages/weekly', [TotalUsageController::class, 'getTotalUsageWeekly']);
    Route::get('total_usages/monthly', [TotalUsageController::class, 'getTotalUsageMonthly']);

    // crud user
    Route::get('auth/current_user', [AuthController::class, 'getCurrentUser']);
    Route::put('auth/update_user', [AuthController::class, 'updateUser']);

    // logout
    Route::post('auth/logout', [AuthController::class, 'logout']);
});