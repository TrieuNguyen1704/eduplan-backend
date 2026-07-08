<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
{
    // Lấy toàn bộ thẻ nhiệm vụ của môn học
    public function getSubjectWorkspace($subjectId)
    {
        $subject = Subject::with('notes')
            ->where('user_id', Auth::id())
            ->findOrFail($subjectId);

        return response()->json($subject);
    }

    // Tạo thẻ nhanh từ bên ngoài (Chỉ cần tiêu đề)
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
        ]);

        Subject::where('user_id', Auth::id())->findOrFail($request->subject_id);

        $note = Note::create([
            'user_id' => Auth::id(),
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'status' => 'todo',
            'progress' => 0,
            'label_color' => 'blue'
        ]);

        return response()->json($note, 201);
    }

    // Cập nhật chi tiết thẻ từ bên trong Modal (Mô tả, Tiến độ, Upload File, Nhãn màu)
    public function update(Request $request, $id)
    {
        $note = Note::where('user_id', Auth::id())->findOrFail($id);

        $data = $request->only(['title', 'content', 'progress', 'due_date', 'status', 'label_color']);

        // Xử lý upload tài liệu đính kèm (PDF, Word, Slide...)
        if ($request->hasFile('file')) {
            // Xóa file cũ trong bộ nhớ nếu có
            if ($note->file_path) {
                Storage::disk('public')->delete($note->file_path);
            }
            $file = $request->file('file');
            $path = $file->store('materials', 'public');
            $data['file_path'] = $path;
            $data['file_name'] = $file->getClientOriginalName();
        }

        $note->update($data);

        return response()->json($note);
    }

    // Xóa thẻ và xóa luôn file đính kèm
    public function destroy($id)
    {
        $note = Note::where('user_id', Auth::id())->findOrFail($id);
        if ($note->file_path) {
            Storage::disk('public')->delete($note->file_path);
        }
        $note->delete();

        return response()->json(['message' => 'Đã xóa thành công']);
    }
}
