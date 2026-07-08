<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordOtpMail;
use Illuminate\Support\Carbon;

class ForgotPasswordController extends Controller
{
    // Bước 1: Kiểm tra email, sinh OTP 6 số và bắn mail qua SMTP Gmail
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = rand(100000, 999999);

        DB::table('password_otp_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10),
                'created_at' => Carbon::now()
            ]
        );

        try {
            Mail::to($request->email)->send(new ResetPasswordOtpMail($otp));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Lỗi kết nối máy chủ gửi mail SMTP: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Mã OTP khôi phục mật khẩu đã được gửi đến email của anh! Vui lòng kiểm tra hộp thư đến (hoặc mục Spam).'
        ]);
    }

    // Bước 2: Xác nhận OTP và đặt lại mật khẩu mới cho User
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $record = DB::table('password_otp_resets')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$record || Carbon::parse($record->expires_at)->isPast()) {
            return response()->json(['message' => 'Mã OTP không chính xác hoặc đã hết hạn sử dụng!'], 422);
        }

        $user = User::where('email', $request->email)->first();
        $user->update(['password' => Hash::make($request->password)]);

        DB::table('password_otp_resets')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Mật khẩu của anh đã được khôi phục thành công!']);
    }
}
