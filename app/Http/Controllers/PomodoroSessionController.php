<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PomodoroSession;
use Illuminate\Support\Facades\Auth;

class PomodoroController extends Controller
{
    // Lấy thống kê thời gian tập trung trong ngày và danh sách lịch sử
    public function index()
    {
        $userId = Auth::id();

        // Tổng số phút tập trung hôm nay
        $todayMinutes = PomodoroSession::where('user_id', $userId)
            ->where('mode', 'work')
            ->whereDate('created_at', now()->toDateString())
            ->sum('duration_minutes');

        // Tổng số phiên Pomodoro hoàn thành hôm nay
        $todaySessions = PomodoroSession::where('user_id', $userId)
            ->where('mode', 'work')
            ->whereDate('created_at', now()->toDateString())
            ->count();

        // 5 phiên gần nhất
        $recentSessions = PomodoroSession::with('subject')
            ->where('user_id', $userId)
            ->where('mode', 'work')
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'today_minutes' => (int) $todayMinutes,
            'today_sessions' => $todaySessions,
            'recent_sessions' => $recentSessions
        ]);
    }

    // Lưu lại 1 phiên tập trung vừa hoàn thành
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'nullable|exists:subjects,id',
            'duration_minutes' => 'required|integer|min:1',
            'mode' => 'required|string|in:work,short_break,long_break'
        ]);

        $session = PomodoroSession::create([
            'user_id' => Auth::id(),
            'subject_id' => $validated['subject_id'] ?? null,
            'duration_minutes' => $validated['duration_minutes'],
            'mode' => $validated['mode']
        ]);

        return response()->json(['message' => 'Đã ghi nhận phiên tập trung!', 'data' => $session], 201);
    }
}
