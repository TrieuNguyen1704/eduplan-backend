<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            // Cột liên kết: Môn học này thuộc về User nào (Xóa user sẽ tự xóa luôn môn học của user đó)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('name'); // Tên môn học (VD: IELTS 3)
            $table->string('code', 50)->nullable(); // Mã môn (CỘT ĐANG THIẾU NÈ ANH: ENG103)
            $table->integer('credits')->default(3); // Số tín chỉ
            $table->string('status')->default('active'); // Trạng thái môn học
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
