<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PomodoroSession extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'subject_id', 'duration_minutes', 'mode'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
