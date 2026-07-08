<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Subject Seeder
        |--------------------------------------------------------------------------
        | Seeder này tạo dữ liệu môn học mẫu cho các tài khoản test trong
        | UserSeeder. Mỗi user sẽ được gán 3 môn học mặc định:
        | - PSY101: Tâm lý học đại cương
        | - ENG103: IELTS 3
        | - IT202 : Cơ sở dữ liệu nâng cao
        |
        | Sử dụng updateOrCreate để tránh tạo dữ liệu trùng lặp khi seed nhiều lần.
        |--------------------------------------------------------------------------
        */
        // Tài test của anh Nguyên
        User::updateOrCreate(
            ['email' => 'shellingofficial@gmail.com'],
            ['name' => 'Anh Shelling', 'password' => Hash::make('123456')]
        );

        // Tài khoản test của Nin
         User::updateOrCreate(
            ['email' => 'nin@gmail.com'],
            ['name' => 'nin', 'password' => Hash::make('123456')]
        );

        // Tài khoản test của anh Hiệu
        User::updateOrCreate(
            ['email' => 'hieu@gmail.com'],
            ['name' => 'Hiệu', 'password' => Hash::make('123456')]
        );

        // Tài khoản test của Giang
        User::updateOrCreate(
            ['email' => 'giang@gmail.com'],
            ['name' => 'Giang', 'password' => Hash::make('123456')]
        );

        // Tài khoản test của anh Hùng
        User::updateOrCreate(
            ['email' => 'hung@gmail.com'],
            ['name' => 'Hùng', 'password' => Hash::make('123456')]
        );

        // Tài khoản test của anh Toàn
        User::updateOrCreate(
            ['email' => 'toan@gmail.com'],
            ['name' => 'Toàn', 'password' => Hash::make('123456')]
        );

        // Tài khoản test của của các user khác
        User::updateOrCreate(
            ['email' => 'sinhvien7@gmail.com'],
            ['name' => 'Nguyễn Văn F', 'password' => Hash::make('123456')]
        );

        User::updateOrCreate(
            ['email' => 'sinhvien8@gmail.com'],
            ['name' => 'Nguyễn Văn G', 'password' => Hash::make('123456')]
        );

        User::updateOrCreate(
            ['email' => 'sinhvien9@gmail.com'],
            ['name' => 'Nguyễn Văn H', 'password' => Hash::make('123456')]
        );

        User::updateOrCreate(
            ['email' => 'sinhvien10@gmail.com'],
            ['name' => 'Nguyễn Văn I', 'password' => Hash::make('123456')]
        );
    }
}