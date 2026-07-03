<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SubjectController; // 1. THÊM DÒNG NÀY

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Nhóm các tuyến đường bắt buộc phải có Token mới được vào
Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // 2. THÊM DÒNG NÀY: Tự động tạo toàn bộ route CRUD cho Môn học
    Route::apiResource('subjects', SubjectController::class);
});
