<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\User;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'shellingofficial@gmail.com')->first();
        if (!$user) return;

        // Đã gỡ bỏ cột description để khớp 100% với cấu trúc bảng subjects thực tế
        $subjects = [
            [
                'code' => 'SAD301',
                'name' => 'Kiến trúc Phần mềm (Software Architecture Design)',
                'credits' => 4,
            ],
            [
                'code' => 'CDIO401',
                'name' => 'Dự án CDIO - Phát triển Hệ thống EduPlan',
                'credits' => 3,
            ],
            [
                'code' => 'PSY101',
                'name' => 'Tâm lý học Đại cương & Hành vi (Behaviorism)',
                'credits' => 3,
            ],
            [
                'code' => 'ENG202',
                'name' => 'Tiếng Anh Giao tiếp & Từ vựng IELTS/TOEIC',
                'credits' => 3,
            ],
        ];

        foreach ($subjects as $sub) {
            Subject::updateOrCreate(
                ['code' => $sub['code'], 'user_id' => $user->id],
                array_merge($sub, ['user_id' => $user->id])
            );
        }
    }
}
