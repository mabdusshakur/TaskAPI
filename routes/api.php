<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;


// Authentication routes
Route::group(['prefix'=> 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware('auth:sanctum')->group(function () {
    // Auth Routes
    Route::post('/auth/logout', [AuthController::class,'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);


    // Task Routes
    Route::apiResource('tasks', TaskController::class);
});