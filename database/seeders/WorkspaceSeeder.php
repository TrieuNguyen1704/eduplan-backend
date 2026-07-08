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
         /*
        |--------------------------------------------------------------------------
        | Workspace Seeder
        |--------------------------------------------------------------------------
        | Seeder này tạo dữ liệu Note/Kanban mẫu cho các tài khoản test.
        | Mỗi user sẽ được gán các thẻ công việc tương ứng với 3 môn:
        | - PSY101: Tâm lý học đại cương
        | - ENG103: IELTS 3
        | - IT202 : Cơ sở dữ liệu nâng cao
        |--------------------------------------------------------------------------
        */

        $emails = [
            'shellingofficial@gmail.com',
            'nin@gmail.com',
            'hieu@gmail.com',
            'giang@gmail.com',
            'hung@gmail.com',
            'toan@gmail.com',
            'sinhvien7@gmail.com',
            'sinhvien8@gmail.com',
            'sinhvien9@gmail.com',
            'sinhvien10@gmail.com',
        ];

        foreach ($emails as $email) {

            // Tìm user theo email
            $user = User::where('email', $email)->first();

            // Nếu chưa có user thì bỏ qua
            if (!$user) {
                continue;
            }

            # PSY101 - Tâm lý học đại cương
            $subPsy = Subject::where('user_id', $user->id)
                ->where('code', 'PSY101')
                ->first();

            if ($subPsy) {

                Note::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'subject_id' => $subPsy->id,
                        'title' => 'Slide Chương 1: Tổng quan hành vi'
                    ],
                    [
                        'content' => 'Đọc kỹ chương 1 và chuẩn bị câu hỏi thảo luận cho buổi học tiếp theo.',
                        'progress' => 40,
                        'status' => 'doing',
                        'label_color' => 'blue',
                        'due_date' => '2026-07-15'
                    ]
                );

                Note::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'subject_id' => $subPsy->id,
                        'title' => 'Bài tập nhóm giữa kỳ'
                    ],
                    [
                        'content' => 'Hoàn thành tiểu luận phân tích tâm lý người tiêu dùng.',
                        'progress' => 0,
                        'status' => 'todo',
                        'label_color' => 'red',
                        'due_date' => '2026-07-28'
                    ]
                );
            }

            # ENG103 - IELTS 3
            $subEng = Subject::where('user_id', $user->id)
                ->where('code', 'ENG103')
                ->first();

            if ($subEng) {

                Note::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'subject_id' => $subEng->id,
                        'title' => 'Slide 3: Listening & Speaking Skills'
                    ],
                    [
                        'content' => 'Đã hoàn thành luyện tập Section 3 và ôn tập từ vựng chủ đề Education.',
                        'progress' => 100,
                        'status' => 'done',
                        'label_color' => 'green',
                        'due_date' => '2026-07-05'
                    ]
                );
            }

            # IT202 - Cơ sở dữ liệu nâng cao
            $subIT = Subject::where('user_id', $user->id)
                ->where('code', 'IT202')
                ->first();

            if ($subIT) {

                Note::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'subject_id' => $subIT->id,
                        'title' => 'Thiết kế ERD cho đồ án'
                    ],
                    [
                        'content' => 'Hoàn thiện sơ đồ ERD và chuẩn hóa dữ liệu trước buổi review.',
                        'progress' => 60,
                        'status' => 'doing',
                        'label_color' => 'yellow',
                        'due_date' => '2026-07-20'
                    ]
                );

                Note::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'subject_id' => $subIT->id,
                        'title' => 'Ôn tập SQL nâng cao'
                    ],
                    [
                        'content' => 'Luyện tập JOIN, VIEW, PROCEDURE và TRIGGER để chuẩn bị kiểm tra giữa kỳ.',
                        'progress' => 20,
                        'status' => 'todo',
                        'label_color' => 'purple',
                        'due_date' => '2026-07-25'
                    ]
                );
            }
        }

    }

        // 📌 PHẦN FLASHCARD: Khi nào anh em mình code xong giao diện Vue 3 cho Flashcard 
        // và chạy lệnh nạp bảng vào MySQL thì mình sẽ bảo bạn Data mở phần này ra sau nhen!
}
