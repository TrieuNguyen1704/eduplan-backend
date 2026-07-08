<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * Lấy danh sách tất cả thẻ nhiệm vụ có cài ngày hạn chót (Deadline)
     * của người dùng đang đăng nhập, kèm theo thông tin môn học.
     */
    public function getDeadlines()
    {
        $tasks = Note::with('subject')
            ->where('user_id', Auth::id())
            ->whereNotNull('due_date')
            ->orderBy('due_date', 'asc')
            ->get();

        return response()->json($tasks);
    }
}
