<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/overtimes-pays/calculate', [Api\OvertimePayController::class, 'index']);
Route::patch('/setting/{setting}', [Api\SettingController::class, 'update']);
Route::post('/employees', [Api\EmployeeController::class, 'store']);
Route::post('/overtimes', [Api\OvertimeController::class, 'store']);

