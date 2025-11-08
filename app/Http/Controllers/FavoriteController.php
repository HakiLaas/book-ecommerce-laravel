<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat favorit.');
        }
        
        $favorites = Favorite::with('book')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();
            
        return view('favorites', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Silakan login terlebih dahulu'], 401);
        }

        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        $bookId = $request->book_id;
        $userId = Auth::id();

        $existingFavorite = Favorite::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->first();

        if ($existingFavorite) {
            $existingFavorite->delete();
            $isFavorited = false;
        } else {
            Favorite::create([
                'user_id' => $userId,
                'book_id' => $bookId
            ]);
            $isFavorited = true;
        }

        return response()->json([
            'success' => true,
            'is_favorited' => $isFavorited,
            'message' => $isFavorited ? 'Ditambahkan ke favorit' : 'Dihapus dari favorit'
        ]);
    }

    public function count()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $count = Favorite::where('user_id', Auth::id())->count();
        return response()->json(['count' => $count]);
    }

    public function getItems()
    {
        if (!Auth::check()) {
            return response()->json(['items' => [], 'count' => 0]);
        }

        $favorites = Favorite::with('book')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        if ($favorites->isEmpty()) {
            return response()->json([
                'items' => [],
                'count' => 0
            ]);
        }

        $items = $favorites->map(function ($favorite) {
            return [
                'id' => $favorite->id,
                'book_id' => $favorite->book_id,
                'title' => $favorite->book->title,
                'price' => $favorite->book->price,
                'image' => $favorite->book->cover_image
            ];
        });

        return response()->json([
            'items' => $items,
            'count' => $favorites->count()
        ]);
    }

    public function remove(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Silakan login terlebih dahulu'], 401);
        }

        $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        $favorite = Favorite::where('user_id', Auth::id())
            ->where('book_id', $request->book_id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['success' => true, 'message' => 'Dihapus dari favorit']);
        }

        return response()->json(['error' => 'Favorit tidak ditemukan'], 404);
    }
}
