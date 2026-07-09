<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tài khoản chính chủ Admin / Tech Lead: Trương Công Triều Nguyên
        User::updateOrCreate(
            ['email' => 'shellingofficial@gmail.com'],
            [
                'name' => 'Triều Nguyên',
                'password' => Hash::make('123456'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Các thành viên trong nhóm Đồ án CDIO & SAD
        $teamMembers = [
            ['name' => 'Hương Giang', 'email' => 'huonggiang2006tgdd@gmail.com'],
            ['name' => 'Duy Toàn', 'email' => 'dtoan2411@gmail.com'],
            ['name' => 'Hà Ninh', 'email' => 'hathininh23@gmail.com'],
            ['name' => 'Hiệu Nguyễn', 'email' => 'hieunguyen@gmail.com'],
            ['name' => 'Hùng Nguyễn', 'email' => 'hungnguyen@gmail.com'],
        ];

        foreach ($teamMembers as $member) {
            User::updateOrCreate(
                ['email' => $member['email']],
                [
                    'name' => $member['name'],
                    'password' => Hash::make('123456'),
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
