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
        Schema::create('flashcards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deck_id');
            $table->string('keyword');
            $table->string('phonetics', 100)->nullable();
            $table->string('word_type', 50)->nullable();
            $table->text('meaning')->nullable();
            $table->text('example')->nullable();
            $table->text('grammar_structure')->nullable();
            $table->text('synonyms')->nullable();
            $table->text('antonyms')->nullable();
            $table->timestamps();

            $table->foreign('deck_id')->references('id')->on('decks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flashcards');
    }
};
