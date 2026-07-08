<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // GỌI CHẠY THEO ĐÚNG THỨ TỰ LOGIC CHỐNG LỖI KHÓA NGOẠI
        $this->call([
            UserSeeder::class,
            SubjectSeeder::class,
            WorkspaceSeeder::class,
        ]);
    }
}
