<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Nhạc trưởng gọi toàn bộ bộ nạp dữ liệu của EduPlan
     */
    public function run(): void
    {
        $this->command->info('⏳ Đang khởi tạo hệ thống dữ liệu EduPlan CDIO...');

        // Gọi lần lượt các Seeder theo thứ tự phụ thuộc khóa ngoại
        $this->call([
            UserSeeder::class,
            SubjectSeeder::class,
            WorkspaceSeeder::class,
            FlashcardSeeder::class,
        ]);

        $this->command->info('----------------------------------------------------');
        $this->command->info('🎉 HOÀN TẤT NẠP DỮ LIỆU MẪU TOÀN DIỆN!');
        $this->command->info('👤 Tech Lead Account : shellingofficial@gmail.com');
        $this->command->info('🔑 Password          : 123456');
        $this->command->info('----------------------------------------------------');
    }
}
