<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    // CẤP QUYỀN LƯU DỮ LIỆU CHO CÁC CỘT NÀY
    protected $fillable = [
        'user_id',
        'name',
        'code',
        'credits',
        'status',
    ];

    // Tạo mối quan hệ: Một môn học thuộc về một User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
