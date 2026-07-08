<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    // ĐÃ KHAI BÁO ĐẦY ĐỦ 100% CỘT ĐỂ KHÔNG BỊ LỖI MASS ASSIGNMENT
    protected $fillable = [
        'user_id',
        'subject_id',
        'title',
        'content',
        'type',
        'url',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
