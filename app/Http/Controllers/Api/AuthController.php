<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // Đảm bảo có dòng này
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; // THÊM DÒNG NÀY VÀO ĐẦU FILE

class AuthController extends Controller
{
    // 1. ĐĂNG KÝ (Register)
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = bin2hex(random_bytes(40));
        $user->forceFill(['api_token' => hash('sha256', $token)])->save();

        return response()->json([
            'message' => 'Đăng ký tài khoản thành công!',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 201);
    }

    // 2. ĐĂNG NHẬP (Login)
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Thông tin đăng nhập không chính xác'], 401);
        }

        $user = Auth::user();

        // TẠO TOKEN MỚI THEO CHUẨN LARAVEL 12 (Xóa bỏ dòng $user->tokens()->delete() nếu có)
        $token = bin2hex(random_bytes(40));
        $user->forceFill(['api_token' => hash('sha256', $token)])->save();

        return response()->json([
            'access_token' => $token,
            'user' => $user
        ]);
    }

    // 3. ĐĂNG XUẤT (Logout)
    public function logout(Request $request)
    {
        $request->user()->forceFill(['api_token' => null])->save();

        return response()->json([
            'message' => 'Đăng xuất thành công!'
        ], 200);
    }

    // 4. LẤY THÔNG TIN USER (Profile)
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
