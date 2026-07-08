<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        // Danh sách các tài khoản test sẽ được gán môn học mẫu
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

        // Duyệt qua từng user và tạo các môn học mặc định
        foreach ($emails as $email) {

            // Tìm user theo email
            $user = User::where('email', $email)->first();

            // Nếu user chưa tồn tại thì bỏ qua
            if (!$user) {
                continue;
            }

            // Môn Tâm lý học đại cương
            Subject::updateOrCreate(
                [
                    'code' => 'PSY101',
                    'user_id' => $user->id
                ],
                [
                    'name' => 'Tâm lý học đại cương',
                    'credits' => 3,
                    'status' => 'active'
                ]
            );

            // Môn IELTS 3
            Subject::updateOrCreate(
                [
                    'code' => 'ENG103',
                    'user_id' => $user->id
                ],
                [
                    'name' => 'IELTS 3',
                    'credits' => 3,
                    'status' => 'active'
                ]
            );

            // Môn Cơ sở dữ liệu nâng cao
            Subject::updateOrCreate(
                [
                    'code' => 'IT202',
                    'user_id' => $user->id
                ],
                [
                    'name' => 'Cơ sở dữ liệu nâng cao',
                    'credits' => 4,
                    'status' => 'active'
                ]
            );
        }
    }
}