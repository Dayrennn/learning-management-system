<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\pelajaranController;
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

// pelajaran
Route::middleware('jwt')->group(function() {
    Route::post('/create-pelajaran', [pelajaranController::class, "addPelajaran"]);
    Route::get('/lihat-pelajaran', [pelajaranController::class, "seeAllPelajaran"]);
    Route::delete('/delete-pelajaran/{id}', [pelajaranController::class, "removePelajaran"]);
});