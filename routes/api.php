<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BoardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'Login']);

// Authincated Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'Logout']);
    Route::apiResource('/boards', BoardController::class);
});
