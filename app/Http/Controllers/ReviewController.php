<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $bookId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $comment = $request->comment ?? '';
        $status = $this->moderate($comment) ? 'approved' : 'pending';
        $sentiment = $this->analyzeSentiment($comment);

        $review = Review::create([
            'user_id' => Auth::id(),
            'book_id' => $bookId,
            'rating' => (int) $request->rating,
            'comment' => $comment,
            'status' => $status,
            'sentiment' => $sentiment,
        ]);

        return redirect()->route('books.show', ['id' => $bookId])
            ->with('success', $status === 'approved' ? 'Review dipublikasikan.' : 'Review menunggu moderasi.');
    }

    public function report(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        // Optional: Only allow reporting by authenticated users
        if (!Auth::check()) {
            abort(403);
        }
        $review->reported = true;
        $review->save();

        return back()->with('success', 'Review telah dilaporkan.');
    }

    private function moderate(string $comment): bool
    {
        // Simple moderation: block if contains banned words
        $banned = ['spam', 'hate', 'abuse', 'insult', 'racist'];
        foreach ($banned as $word) {
            if (stripos($comment, $word) !== false) {
                return false;
            }
        }
        return true;
    }

    private function analyzeSentiment(string $comment): ?string
    {
        if ($comment === '') return null;
        $positiveWords = ['great','excellent','amazing','love','fantastic','good','nice','recommended'];
        $negativeWords = ['bad','terrible','awful','hate','poor','disappointed','boring'];

        $score = 0;
        foreach ($positiveWords as $w) {
            if (stripos($comment, $w) !== false) $score++;
        }
        foreach ($negativeWords as $w) {
            if (stripos($comment, $w) !== false) $score--;
        }

        if ($score > 0) return 'positive';
        if ($score < 0) return 'negative';
        return 'neutral';
    }
}