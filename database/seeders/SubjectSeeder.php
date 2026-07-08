<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy ra user đầu tiên để gắn môn học vào
        $user = User::where('email', 'shellingofficial@gmail.com')->first();
        if (!$user) return;

        Subject::updateOrCreate(
            ['code' => 'PSY101', 'user_id' => $user->id],
            ['name' => 'Tâm lý học đại cương', 'credits' => 3, 'status' => 'active']
        );

        Subject::updateOrCreate(
            ['code' => 'ENG103', 'user_id' => $user->id],
            ['name' => 'IELTS 3', 'credits' => 3, 'status' => 'active']
        );

        Subject::updateOrCreate(
            ['code' => 'IT202', 'user_id' => $user->id],
            ['name' => 'Cơ sở dữ liệu nâng cao', 'credits' => 4, 'status' => 'active']
        );
        //Nin
         $user = User::where('email', 'nin@gmail.com')->first();
        if (!$user) return;

        Subject::updateOrCreate(
            ['code' => 'PSY101', 'user_id' => $user->id],
            ['name' => 'Tâm lý học đại cương', 'credits' => 3, 'status' => 'active']
        );

        Subject::updateOrCreate(
            ['code' => 'ENG103', 'user_id' => $user->id],
            ['name' => 'IELTS 3', 'credits' => 3, 'status' => 'active']
        );

        Subject::updateOrCreate(
            ['code' => 'IT202', 'user_id' => $user->id],
            ['name' => 'Cơ sở dữ liệu nâng cao', 'credits' => 4, 'status' => 'active']
        );
    }
}
