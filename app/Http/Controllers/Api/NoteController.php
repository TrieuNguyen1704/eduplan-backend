<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth; // ĐÃ IMPORT CHUẨN XÁC

class NoteController extends Controller
{
    // Lấy chi tiết 1 môn học kèm theo toàn bộ ghi chú của môn đó
    public function getSubjectWorkspace($subjectId)
    {
        $subject = Subject::with('notes')
            ->where('user_id', Auth::id())
            ->findOrFail($subjectId);

        return response()->json($subject);
    }

    // Thêm ghi chú / tài liệu mới vào môn học
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'type' => 'required|in:note,link',
            'url' => 'nullable|url'
        ]);

        // Đảm bảo môn học này đúng là của user đang đăng nhập
        Subject::where('user_id', Auth::id())->findOrFail($request->subject_id);

        $note = Note::create([
            'user_id' => Auth::id(),
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'url' => $request->url,
        ]);

        return response()->json($note, 201);
    }

    // Xóa ghi chú
    public function destroy($id)
    {
        $note = Note::where('user_id', Auth::id())->findOrFail($id);
        $note->delete();

        return response()->json(['message' => 'Đã xóa thành công']);
    }
}
