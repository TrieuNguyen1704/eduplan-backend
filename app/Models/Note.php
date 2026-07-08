<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    // ĐÃ KHAI BÁO ĐẦY ĐỦ 100% CỘT MỚI
    protected $fillable = [
        'user_id',
        'subject_id',
        'title',
        'content',
        'type',
        'url',
        'file_path',
        'file_name',
        'progress',
        'due_date',
        'status',
        'label_color'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
