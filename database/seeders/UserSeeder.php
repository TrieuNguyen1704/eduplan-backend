<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Tài khoản chính của anh
        User::updateOrCreate(
            ['email' => 'shellingofficial@gmail.com'],
            ['name' => 'Anh Shelling', 'password' => Hash::make('123456')]
        );

        // Bạn có thể bảo bạn phụ trách data seed thêm hàng loạt tài khoản test ở dưới này
        User::updateOrCreate(
            ['email' => 'sinhvien1@gmail.com'],
            ['name' => 'Nguyễn Văn A', 'password' => Hash::make('123456')]
        );
         User::updateOrCreate(
            ['email' => 'nin@gmail.com'],
            ['name' => 'nin', 'password' => Hash::make('123456')]
        );
    }
}