<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    // Lấy danh sách môn học của User đang đăng nhập
    public function index()
    {
        $subjects = Subject::where('user_id', Auth::id())->latest()->get();
        return response()->json($subjects);
    }

    // Thêm môn học mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'credits' => 'nullable|integer|min:1',
        ]);

        $subject = Subject::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'code' => $request->code,
            'credits' => $request->credits ?? 3,
            'status' => 'active'
        ]);

        return response()->json($subject, 201);
    }

    // Cập nhật môn học
    public function update(Request $request, string $id)
    {
        $subject = Subject::where('user_id', Auth::id())->findOrFail($id);

        $subject->update($request->only(['name', 'code', 'credits', 'status']));
        return response()->json($subject);
    }

    // Xóa môn học
    public function destroy(string $id)
    {
        $subject = Subject::where('user_id', Auth::id())->findOrFail($id);
        $subject->delete();

        return response()->json(['message' => 'Đã xóa môn học thành công']);
    }
}
