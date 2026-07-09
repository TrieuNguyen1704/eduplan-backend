<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FlashcardDeck extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'subject_id', 'title', 'description'];

    public function cards()
    {
        return $this->hasMany(Flashcard::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
