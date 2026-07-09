<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flashcard extends Model
{
    use HasFactory;

    protected $fillable = ['flashcard_deck_id', 'front', 'back', 'is_remembered'];

    public function deck()
    {
        return $this->belongsTo(FlashcardDeck::class, 'flashcard_deck_id');
    }
}
