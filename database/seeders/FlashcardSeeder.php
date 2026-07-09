<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Subject;
use App\Models\FlashcardDeck;
use App\Models\Flashcard;

class FlashcardSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'shellingofficial@gmail.com')->first();
        if (!$user) return;

        $psySubject = Subject::where('code', 'PSY101')->where('user_id', $user->id)->first();
        $sadSubject = Subject::where('code', 'SAD301')->where('user_id', $user->id)->first();

        // 1. Bộ thẻ Tâm lý học Hành vi
        $deck1 = FlashcardDeck::updateOrCreate(
            ['user_id' => $user->id, 'title' => 'Tâm lý học Hành vi (Behaviorism)'],
            [
                'subject_id' => $psySubject?->id,
                'description' => 'Các khái niệm cốt lõi về trường phái hành vi của B.F. Skinner, Pavlov và Watson.',
            ]
        );

        $cardsDeck1 = [
            [
                'front' => 'Phản xạ có điều kiện (Conditioned Reflex)',
                'back' => "Là phản xạ tự tập nhiễm, được hình thành trong quá trình sống thông qua việc kết hợp một kích thích trung tính với một kích thích vô điều kiện (Thí nghiệm kinh điển với loài chó của Ivan Pavlov).",
                'is_remembered' => true,
            ],
            [
                'front' => 'Operant Conditioning',
                'back' => "- Loại từ: Noun Phrase\n- Phiên âm IPA: /ˈɒp.ər.ənt kənˈdɪʃ.ən.ɪŋ/\n- Nghĩa tiếng Việt: Điều kiện hóa thao tác / công cụ (Lý thuyết của B.F. Skinner).\n- Ví dụ: Skinner used operant conditioning to train pigeons.\n(Skinner đã sử dụng điều kiện hóa thao tác để huấn luyện chim bồ câu.)",
                'is_remembered' => false,
            ],
            [
                'front' => 'Củng cố tích cực (Positive Reinforcement)',
                'back' => "Việc bổ sung một phần thưởng hoặc kích thích dễ chịu ngay sau khi một hành vi mong muốn xảy ra, nhằm làm tăng tần suất lặp lại của hành vi đó trong tương lai.",
                'is_remembered' => false,
            ],
        ];

        foreach ($cardsDeck1 as $card) {
            Flashcard::updateOrCreate(
                ['flashcard_deck_id' => $deck1->id, 'front' => $card['front']],
                ['back' => $card['back'], 'is_remembered' => $card['is_remembered']]
            );
        }

        // 2. Bộ thẻ Kiến trúc phần mềm & CDIO
        $deck2 = FlashcardDeck::updateOrCreate(
            ['user_id' => $user->id, 'title' => 'Chuyên ngành - Kiến trúc Phần mềm (SAD)'],
            [
                'subject_id' => $sadSubject?->id,
                'description' => 'Thuật ngữ tiếng Anh và khái niệm kỹ thuật trong thiết kế kiến trúc phần mềm SaaS.',
            ]
        );

        $cardsDeck2 = [
            [
                'front' => 'Clean Architecture',
                'back' => "- Loại từ: Noun Phrase\n- Phiên âm IPA: /kliːn ˈɑː.kɪ.tek.tʃər/\n- Nghĩa tiếng Việt: Kiến trúc Sạch (Tách biệt hoàn toàn logic nghiệp vụ cốt lõi khỏi UI và Database).\n- Ví dụ: Clean architecture makes the application easier to test and maintain.",
                'is_remembered' => true,
            ],
            [
                'front' => 'Repository Pattern',
                'back' => "Một mẫu thiết kế (Design Pattern) đóng vai trò trung gian giữa tầng Business Logic và tầng Data Access, giúp code không bị phụ thuộc trực tiếp vào ORM hay Database cụ thể.",
                'is_remembered' => true,
            ],
            [
                'front' => 'Refactoring',
                'back' => "- Loại từ: Noun / Gerund\n- Phiên âm IPA: /ˌriːˈfæk.tər.ɪŋ/\n- Nghĩa tiếng Việt: Tái cấu trúc mã nguồn (cải thiện cấu trúc bên trong mà không làm thay đổi hành vi bên ngoài).",
                'is_remembered' => false,
            ],
        ];

        foreach ($cardsDeck2 as $card) {
            Flashcard::updateOrCreate(
                ['flashcard_deck_id' => $deck2->id, 'front' => $card['front']],
                ['back' => $card['back'], 'is_remembered' => $card['is_remembered']]
            );
        }
    }
}
