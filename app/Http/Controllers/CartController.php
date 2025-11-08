<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat keranjang.');
        }

        $cart = Cart::with(['items.book'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$cart) {
            $cart = Cart::create(['user_id' => Auth::id()]);
        }

        return view('cart.index', compact('cart'));
    }

    public function addItem(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Silakan login terlebih dahulu'], 401);
        }

        $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $book = Book::findOrFail($request->book_id);
        
        // Get or create cart
        $cart = Cart::where('user_id', Auth::id())->first();
        if (!$cart) {
            $cart = Cart::create(['user_id' => Auth::id()]);
        }

        // Check if item already exists
        $existingItem = CartItem::where('cart_id', $cart->id)
            ->where('book_id', $request->book_id)
            ->first();

        if ($existingItem) {
            $existingItem->quantity += $request->quantity;
            $existingItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'book_id' => $request->book_id,
                'quantity' => $request->quantity,
                'unit_price' => $book->price
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk ditambahkan ke keranjang'
        ]);
    }

    public function updateItem(Request $request, CartItem $item)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Silakan login terlebih dahulu'], 401);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($item->cart->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $item->quantity = $request->quantity;
        $item->save();

        return response()->json([
            'success' => true,
            'message' => 'Jumlah produk diperbarui'
        ]);
    }

    public function removeItem(CartItem $item)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Silakan login terlebih dahulu'], 401);
        }

        if ($item->cart->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk dihapus dari keranjang'
        ]);
    }

    public function count()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $cart = Cart::where('user_id', Auth::id())->first();
        $count = $cart ? $cart->items->sum('quantity') : 0;
        
        return response()->json(['count' => $count]);
    }

    public function getItems()
    {
        if (!Auth::check()) {
            return response()->json(['items' => [], 'total' => 0, 'count' => 0]);
        }

        $cart = Cart::with(['items.book'])->where('user_id', Auth::id())->first();
        
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'items' => [],
                'total' => 0,
                'count' => 0
            ]);
        }

        $items = $cart->items->map(function ($item) {
            return [
                'id' => $item->id,
                'book_id' => $item->book_id,
                'title' => $item->book->title,
                'price' => $item->unit_price,
                'quantity' => $item->quantity,
                'image' => $item->book->cover_image,
                'subtotal' => $item->unit_price * $item->quantity
            ];
        });

        return response()->json([
            'items' => $items,
            'total' => $cart->total(),
            'count' => $cart->items->sum('quantity')
        ]);
    }
}
