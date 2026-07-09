<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\PomodoroSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    // 1. Lấy thống kê tổng quan toàn hệ thống
    public function getStats()
    {
        // Kiểm tra quyền Admin (Nếu không phải admin, chặn luôn từ cửa)
        if (auth()->user()->role !== 'admin' && auth()->user()->email !== 'shellingofficial@gmail.com') {
            return response()->json(['message' => 'Bạn không có quyền truy cập khu vực Admin!'], 403);
        }

        $totalUsers = User::count();
        $totalSubjects = Subject::count();
        $totalPomodoroMinutes = PomodoroSession::sum('duration_minutes');

        // Kiểm tra bảng tasks hoặc workspace_tasks
        $tasksTable = Schema::hasTable('tasks') ? 'tasks' : (Schema::hasTable('workspace_tasks') ? 'workspace_tasks' : null);
        $totalTasks = $tasksTable ? DB::table($tasksTable)->count() : 0;

        // Kiểm tra bảng flashcards
        $totalFlashcards = Schema::hasTable('flashcards') ? DB::table('flashcards')->count() : 0;

        return response()->json([
            'total_users' => $totalUsers,
            'total_subjects' => $totalSubjects,
            'total_tasks' => $totalTasks,
            'total_flashcards' => $totalFlashcards,
            'total_pomodoro_minutes' => (int) $totalPomodoroMinutes,
        ]);
    }

    // 2. Lấy danh sách toàn bộ thành viên trong hệ thống
    public function getUsers()
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->email !== 'shellingofficial@gmail.com') {
            return response()->json(['message' => 'Từ chối truy cập!'], 403);
        }

        $users = User::select('id', 'name', 'email', 'role', 'created_at')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($users);
    }

    // 3. Xóa / Khóa tài khoản thành viên (Ngoại trừ chính Admin)
    public function deleteUser($id)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->email !== 'shellingofficial@gmail.com') {
            return response()->json(['message' => 'Từ chối truy cập!'], 403);
        }

        $user = User::findOrFail($id);

        if ($user->email === 'shellingofficial@gmail.com' || $user->role === 'admin') {
            return response()->json(['message' => 'Không thể xóa tài khoản Tech Lead / Admin!'], 400);
        }

        $user->delete();
        return response()->json(['message' => 'Đã xóa tài khoản thành công!']);
    }
}
