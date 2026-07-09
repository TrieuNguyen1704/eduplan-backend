<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Bảng lưu Bộ thẻ (Deck)
        Schema::create('flashcard_decks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->nullable()->constrained()->onDelete('set null'); // Có thể gắn vào môn học cụ thể
            $table->string('title'); // Tên bộ thẻ
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Bảng lưu Từng thẻ nhớ (Flashcard)
        Schema::create('flashcards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flashcard_deck_id')->constrained()->onDelete('cascade');
            $table->text('front'); // Mặt trước (Câu hỏi / Từ khóa)
            $table->text('back');  // Mặt sau (Định nghĩa / Câu trả lời)
            $table->boolean('is_remembered')->default(false); // Trạng thái đã thuộc hay chưa
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flashcards');
        Schema::dropIfExists('flashcard_decks');
    }
};
