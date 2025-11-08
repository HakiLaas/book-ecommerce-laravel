<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Book;
use App\Models\Cart;
use App\Models\AdminNotification;
use App\Helpers\WhatsAppHelper;
use App\Http\Controllers\AdminNotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $transactions = Transaction::with(['book', 'statusHistory.changedBy'])
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();
        return view('transactions.index', compact('transactions'));
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk checkout.');
        }
        
        // Get cart items
        $cart = Cart::with(['items.book'])
            ->where('user_id', Auth::id())
            ->first();
            
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong. Silakan tambahkan produk terlebih dahulu.');
        }
        
        // Single book checkout (legacy support)
        $bookId = $request->query('book_id');
        $quantity = max(1, (int) $request->query('quantity', 1));
        $book = $bookId ? Book::find($bookId) : null;
        
        return view('checkout', compact('cart', 'book', 'quantity'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to make a purchase.');
        }

        $request->validate([
            'receiver_name' => 'required|string|min:3',
            'phone' => 'required|string|min:8',
            'address' => 'required|string|min:10',
            'payment_method' => 'required|in:COD,Transfer Bank',
        ]);

        // Get cart items
        $cart = Cart::with(['items.book'])
            ->where('user_id', Auth::id())
            ->first();
            
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $totalPrice = $cart->total();
        $items = $cart->items;

        // Create transaction for each item (or single transaction with multiple items)
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'book_id' => $items->first()->book_id, // Primary book for reference
            'quantity' => $items->sum('quantity'),
            'total_price' => $totalPrice,
            'receiver_name' => $request->receiver_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        // Generate WhatsApp message using helper
        $customerInfo = [
            'receiver_name' => $request->receiver_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_method' => $request->payment_method,
        ];
        
        $message = WhatsAppHelper::generateOrderMessage($items, $customerInfo, $transaction);
        $waUrl = WhatsAppHelper::generateWhatsAppUrl($message);

        // Create admin notification
        $cartItems = $items->map(function($item) {
            return [
                'book_id' => $item->book->id,
                'book_title' => $item->book->title,
                'book_author' => $item->book->author,
                'book_cover' => $item->book->cover_url,
                'quantity' => $item->quantity,
                'price' => $item->book->price,
                'subtotal' => $item->quantity * $item->book->price,
            ];
        })->toArray();

        AdminNotification::create([
            'user_id' => Auth::id(),
            'transaction_id' => $transaction->id,
            'type' => 'order_confirmation',
            'title' => 'Konfirmasi Pembelian Baru - ' . Auth::user()->name,
            'message' => "Pembeli " . Auth::user()->name . " telah mengkonfirmasi pembelian via WhatsApp. Total: Rp " . number_format($totalPrice, 0, ',', '.'),
            'data' => [
                'cart_items' => $cartItems,
                'user_info' => [
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ],
                'receiver_name' => $request->receiver_name,
                'payment_method' => $request->payment_method,
                'whatsapp_message' => $message,
            ],
            'status' => 'belum_diproses',
        ]);

        // Create initial status history (optional - only if table exists)
        try {
            \App\Models\TransactionStatusHistory::create([
                'transaction_id' => $transaction->id,
                'status' => 'belum_diproses',
                'notes' => 'Pesanan dibuat oleh pembeli',
                'changed_by' => Auth::id(),
            ]);
        } catch (\Exception $e) {
            // Table might not exist yet, skip status history creation
            // This won't break the checkout process
        }

        // Clear cart after successful order
        $cart->items()->delete();

        return redirect($waUrl);
    }

    public function adminIndex()
    {
        $transactions = Transaction::with(['book', 'user'])->get();
        return view('admin.transactions.index', compact('transactions'));
    }
}
