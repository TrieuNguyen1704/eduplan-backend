<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Subject;
use App\Models\Note;
use Illuminate\Support\Facades\Hash; // IMPORT THƯ VIỆN MÃ HÓA PASSWORD

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. TẠO TÀI KHOẢN ADMIN TEST THEO Ý ANH
        $user = User::updateOrCreate(
            ['email' => 'shellingofficial@gmail.com'],
            [
                'name' => 'Triều Nguyên',
                'password' => Hash::make('123456'), // Mã hóa mật khẩu chuẩn Laravel
            ]
        );

        // 2. TẠO CÁC MÔN HỌC MẪU CHO TÀI KHOẢN NÀY
        $sub1 = Subject::create([
            'user_id' => $user->id,
            'name' => 'Tâm lý học đại cương',
            'code' => 'PSY101',
            'credits' => 3,
            'status' => 'active'
        ]);

        $sub2 = Subject::create([
            'user_id' => $user->id,
            'name' => 'IELTS 3',
            'code' => 'ENG103',
            'credits' => 3,
            'status' => 'active'
        ]);

        $sub3 = Subject::create([
            'user_id' => $user->id,
            'name' => 'Cơ sở dữ liệu nâng cao',
            'code' => 'IT202',
            'credits' => 4,
            'status' => 'active'
        ]);

        // 3. TẠO CÁC THẺ NHIỆM VỤ MẪU (KANBAN CARDS) ĐỂ HIỂN THỊ TRONG WORKSPACE
        // Môn Tâm lý học
        Note::create([
            'user_id' => $user->id,
            'subject_id' => $sub1->id,
            'title' => 'Slide Chương 1: Tổng quan hành vi',
            'content' => 'Đọc kỹ chương 1 và chuẩn bị câu hỏi thảo luận cho buổi học ngày mai nhen anh.',
            'progress' => 40,
            'status' => 'doing',
            'label_color' => 'blue',
            'due_date' => '2026-07-15'
        ]);

        Note::create([
            'user_id' => $user->id,
            'subject_id' => $sub1->id,
            'title' => 'Bài tập nhóm giữa kỳ',
            'content' => 'Làm tiểu luận phân tích tâm lý người tiêu dùng. Hạn chót nộp bài lên hệ thống trường.',
            'progress' => 0,
            'status' => 'todo',
            'label_color' => 'red',
            'due_date' => '2026-07-28'
        ]);

        // Môn IELTS 3
        Note::create([
            'user_id' => $user->id,
            'subject_id' => $sub2->id,
            'title' => 'Slide 3: Listening & Speaking Skills',
            'content' => 'Đã nghe xong và giải hết đề Section 3. Từ vựng thuộc chủ đề Education nắm rất chắc.',
            'progress' => 100,
            'status' => 'done',
            'label_color' => 'green',
            'due_date' => '2026-07-05'
        ]);

        // Môn Cơ sở dữ liệu
        Note::create([
            'user_id' => $user->id,
            'subject_id' => $sub3->id,
            'title' => 'Thiết kế sơ đồ ERD đồ án',
            'content' => 'Vẽ sơ đồ thực thể mối quan hệ cho database dự án EduPlan. Nhớ chuẩn hóa dữ liệu dạng 3NF.',
            'progress' => 15,
            'status' => 'doing',
            'label_color' => 'purple',
            'due_date' => '2026-07-20'
        ]);
    }
}
