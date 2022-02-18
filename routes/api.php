<?php

use App\Http\Controllers\Design\DesignController;
use App\Http\Controllers\Open\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->prefix('presets')->group(function (){
    Route::get('list', [DesignController::class, 'list']);
    Route::post('save', [DesignController::class, 'savePreset']);
    Route::post('delete', [DesignController::class, 'deletePreset']);
});
