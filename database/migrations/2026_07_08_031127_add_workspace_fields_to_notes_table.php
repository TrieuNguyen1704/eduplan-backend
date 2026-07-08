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
        Schema::table('notes', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('content'); // Đường dẫn lưu file
            $table->string('file_name')->nullable()->after('file_path'); // Tên file gốc (VD: Slide_Chung_1.pdf)
            $table->integer('progress')->default(0)->after('file_name'); // Tiến độ hoàn thành (0% - 100%)
            $table->date('due_date')->nullable()->after('progress'); // Ngày hạn chót
            $table->string('status')->default('todo')->after('due_date'); // Trạng thái: todo, doing, done
            $table->string('label_color', 20)->default('blue')->after('status'); // Nhãn màu sắc (blue, red, green, amber, purple)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            //
        });
    }
};
