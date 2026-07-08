<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SubjectController; // 1. THÊM DÒNG NÀY
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\CalendarController;
use App\Http\Controllers\Api\ForgotPasswordController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// API Khôi phục mật khẩu do Duy Toàn phụ trách
Route::post('password/email', [ForgotPasswordController::class, 'sendOtp']);
Route::post('password/reset', [ForgotPasswordController::class, 'resetPassword']);
// Nhóm các tuyến đường bắt buộc phải có Token mới được vào
Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // 2. THÊM DÒNG NÀY: Tự động tạo toàn bộ route CRUD cho Môn học
    Route::apiResource('subjects', SubjectController::class);
    // Route cho Workspace Môn học & Ghi chú
    Route::get('/subjects/{id}/workspace', [NoteController::class, 'getSubjectWorkspace']);
    Route::apiResource('notes', NoteController::class)->only(['store', 'update', 'destroy']);
    // API Lịch hạn chót nhiệm vụ do Hùng Nguyễn phụ trách
    Route::get('calendar/deadlines', [CalendarController::class, 'getDeadlines']);
});
