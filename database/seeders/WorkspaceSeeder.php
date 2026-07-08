<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Subject;
use App\Models\Note;
// Tạm thời chưa import Flashcard vì mình chưa chạy migrate tạo bảng nhen anh

class WorkspaceSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy tài khoản chính để gắn dữ liệu mẫu
        $user = User::where('email', 'shellingofficial@gmail.com')->first();
        if (!$user) return;

        // --- SEED DỮ LIỆU THẺ KANBAN (NOTES) ---
        
        // 1. Gắn thẻ vào môn Tâm lý học đại cương
        $subPsy = Subject::where('code', 'PSY101')->first();
        if ($subPsy) {
            Note::create([
                'user_id' => $user->id,
                'subject_id' => $subPsy->id,
                'title' => 'Slide Chương 1: Tổng quan hành vi',
                'content' => 'Đọc kỹ chương 1 và chuẩn bị câu hỏi thảo luận cho buổi học ngày mai nhen anh.',
                'progress' => 40,
                'status' => 'doing',
                'label_color' => 'blue',
                'due_date' => '2026-07-15'
            ]);

            Note::create([
                'user_id' => $user->id,
                'subject_id' => $subPsy->id,
                'title' => 'Bài tập nhóm giữa kỳ',
                'content' => 'Làm tiểu luận phân tích tâm lý người tiêu dùng. Hạn chót nộp bài lên hệ thống trường.',
                'progress' => 0,
                'status' => 'todo',
                'label_color' => 'red',
                'due_date' => '2026-07-28'
            ]);
        }

        // 2. Gắn thẻ vào môn IELTS 3
        $subEng = Subject::where('code', 'ENG103')->first();
        if ($subEng) {
            Note::create([
                'user_id' => $user->id,
                'subject_id' => $subEng->id,
                'title' => 'Slide 3: Listening & Speaking Skills',
                'content' => 'Đã nghe xong và giải hết đề Section 3. Từ vựng thuộc chủ đề Education nắm rất chắc.',
                'progress' => 100,
                'status' => 'done',
                'label_color' => 'green',
                'due_date' => '2026-07-05'
            ]);
        }

        // 📌 PHẦN FLASHCARD: Khi nào anh em mình code xong giao diện Vue 3 cho Flashcard 
        // và chạy lệnh nạp bảng vào MySQL thì mình sẽ bảo bạn Data mở phần này ra sau nhen!
    }
}
