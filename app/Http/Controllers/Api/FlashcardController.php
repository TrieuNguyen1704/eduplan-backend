<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FlashcardDeck;
use App\Models\Flashcard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FlashcardController extends Controller
{
    // 1. Lấy danh sách tất cả các bộ thẻ của User
    public function index()
    {
        $decks = FlashcardDeck::withCount('cards')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        return response()->json($decks);
    }

    // 2. Tạo bộ thẻ mới (Deck)
    public function storeDeck(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'nullable|exists:subjects,id',
            'description' => 'nullable|string'
        ]);

        $deck = FlashcardDeck::create([
            'user_id' => Auth::id(),
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Tạo bộ thẻ thành công!', 'deck' => $deck]);
    }

    // 3. Lấy chi tiết một bộ thẻ kèm toàn bộ các thẻ bên trong
    public function showDeck($id)
    {
        $deck = FlashcardDeck::with('cards')->where('user_id', Auth::id())->findOrFail($id);
        return response()->json($deck);
    }

    // 4. Thém thẻ nhớ mới vào bộ thẻ
    public function storeCard(Request $request, $deck_id)
    {
        $request->validate([
            'front' => 'required|string',
            'back' => 'required|string',
        ]);

        $deck = FlashcardDeck::where('user_id', Auth::id())->findOrFail($deck_id);

        $card = $deck->cards()->create([
            'front' => $request->front,
            'back' => $request->back,
        ]);

        return response()->json(['message' => 'Thêm thẻ thành công!', 'card' => $card]);
    }

    // 5. Cập nhật trạng thái đã nhớ / chưa nhớ của thẻ
    public function toggleRemember($card_id)
    {
        $card = Flashcard::whereHas('deck', function ($q) {
            $q->where('user_id', Auth::id());
        })->findOrFail($card_id);

        $card->update(['is_remembered' => !$card->is_remembered]);

        return response()->json(['message' => 'Cập nhật trạng thái thành công!', 'card' => $card]);
    }

    // 6. Xóa bộ thẻ hoặc xóa thẻ con
    public function destroyDeck($id)
    {
        FlashcardDeck::where('user_id', Auth::id())->findOrFail($id)->delete();
        return response()->json(['message' => 'Đã xóa bộ thẻ!']);
    }

    public function destroyCard($id)
    {
        Flashcard::whereHas('deck', function ($q) {
            $q->where('user_id', Auth::id());
        })->findOrFail($id)->delete();
        return response()->json(['message' => 'Đã xóa thẻ nhớ!']);
    }

    // 🤖 7. TÍCH HỢP GEMINI AI: Tự động tạo định nghĩa từ khóa
    public function generateAiDefinition(Request $request)
    {
        $request->validate(['keyword' => 'required|string|max:100']);

        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return response()->json(['message' => 'Chưa cấu hình GEMINI_API_KEY trên server!'], 500);
        }

        $prompt = "Bạn là một trợ lý học tập CDIO thông minh. Hãy giải thích ngắn gọn, dễ hiểu, xúc tích khái niệm sau đây trong khoảng 2-3 câu bằng tiếng Việt để làm mặt sau của thẻ Flashcard học tập. Nếu khái niệm truyền vào là một từ vựng tiếng Anh, hãy định dạng mặt sau đầy đủ xuống dòng theo cấu trúc sau:\n- Loại từ:\n- Phiên âm IPA:\n- Nghĩa tiếng Việt:\n- Ví dụ: (kèm dịch nghĩa)\nBỏ những câu chào hay giới thiệu thừa thãi của em khỏi mặt sau thẻ nhé. Khái niệm: \"" . $request->keyword . "\"";
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $definition = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Không tạo được định nghĩa.';
                return response()->json(['definition' => trim($definition)]);
            }

            return response()->json(['message' => 'Lỗi kết nối Gemini AI: ' . $response->body()], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi hệ thống: ' . $e->getMessage()], 500);
        }
    }
}
