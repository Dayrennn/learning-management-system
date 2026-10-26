<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// auth
Route::post('/login', [AuthController::class, 'loginController']);
Route::middleware('jwt')->group(function() {
    Route::post('/register', [AuthController::class, 'registerController']);
});
