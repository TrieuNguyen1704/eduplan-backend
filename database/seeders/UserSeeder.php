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

        //Tài khoản test của Nin
        User::updateOrCreate(
            ['email' => 'nin@gmail.com'],
            ['name' => 'Nguyễn Văn A', 'password' => Hash::make('123456')]
        );
    }
}
