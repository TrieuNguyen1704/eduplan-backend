<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Subject;

class WorkspaceSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'shellingofficial@gmail.com')->first();
        if (!$user) return;

        $sadSubject = Subject::where('code', 'SAD301')->first();
        $cdioSubject = Subject::where('code', 'CDIO401')->first();
        $psySubject = Subject::where('code', 'PSY101')->first();

        // ================= 1. NẠP DỮ LIỆU VÀO BẢNG NOTES (CHO GIAO DIỆN THẺ MÔN HỌC) =================
        if (Schema::hasTable('notes') && $sadSubject) {
            $sadNotes = [
                [
                    'title' => 'Slide Chương 1: Tổng quan Kiến trúc Phần mềm',
                    'content' => 'Tải về slide bài giảng và đọc trước lý thuyết Layered Architecture.',
                    'due' => '2026-07-15',
                ],
                [
                    'title' => 'Bài tập nhóm: Vẽ sơ đồ UML Use Case & Class Diagram',
                    'content' => 'Họp nhóm với 4 thành viên để phân rã module cho đồ án môn SAD.',
                    'due' => '2026-07-20',
                ],
                [
                    'title' => 'Tài liệu tham khảo: Clean Architecture (Robert C. Martin)',
                    'content' => 'Đọc chương 5 và chương 6 về nguyên lý SOLID trong thiết kế.',
                    'due' => '2026-07-28',
                ]
            ];

            foreach ($sadNotes as $n) {
                $data = [
                    'subject_id' => $sadSubject->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                // Tự động kiểm tra cột nào tồn tại thì mới gán giá trị
                if (Schema::hasColumn('notes', 'user_id')) $data['user_id'] = $user->id;
                if (Schema::hasColumn('notes', 'title')) $data['title'] = $n['title'];
                if (Schema::hasColumn('notes', 'name')) $data['name'] = $n['title'];
                if (Schema::hasColumn('notes', 'content')) $data['content'] = $n['content'];
                if (Schema::hasColumn('notes', 'description')) $data['description'] = $n['content'];
                if (Schema::hasColumn('notes', 'due_date')) $data['due_date'] = $n['due'];
                if (Schema::hasColumn('notes', 'deadline')) $data['deadline'] = $n['due'];
                if (Schema::hasColumn('notes', 'status')) $data['status'] = 'todo';

                DB::table('notes')->insert($data);
            }
        }

        // ================= 2. NẠP DỮ LIỆU VÀO BẢNG TASKS (CHO LỊCH CALENDAR & KANBAN) =================
        $tasksTable = Schema::hasTable('tasks') ? 'tasks' : (Schema::hasTable('workspace_tasks') ? 'workspace_tasks' : null);

        if ($tasksTable && $cdioSubject) {
            $cdioTasks = [
                ['title' => 'Hoàn thiện giao diện Lịch tháng (Calendar UI)', 'due' => '2026-07-10'],
                ['title' => 'Tích hợp Google SMTP gửi mail OTP Quên mật khẩu', 'due' => '2026-07-12'],
                ['title' => 'Xây dựng bộ thẻ Flashcard AI Gemini 3D Flip', 'due' => '2026-07-16'],
                ['title' => 'Phát triển Đồng hồ Pomodoro & Dashboard Admin', 'due' => '2026-07-25'],
            ];

            foreach ($cdioTasks as $t) {
                $data = [
                    'subject_id' => $cdioSubject->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                if (Schema::hasColumn($tasksTable, 'user_id')) $data['user_id'] = $user->id;
                if (Schema::hasColumn($tasksTable, 'title')) $data['title'] = $t['title'];
                if (Schema::hasColumn($tasksTable, 'name')) $data['name'] = $t['title'];
                if (Schema::hasColumn($tasksTable, 'due_date')) $data['due_date'] = $t['due'];
                if (Schema::hasColumn($tasksTable, 'deadline')) $data['deadline'] = $t['due'];

                DB::table($tasksTable)->insert($data);
            }
        }
    }
}
