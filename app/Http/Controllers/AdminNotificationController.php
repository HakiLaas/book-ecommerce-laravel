<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\Transaction;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $notifications = AdminNotification::with(['user', 'transaction'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function show($id)
    {
        $notification = AdminNotification::with(['user', 'transaction'])->findOrFail($id);
        
        // Mark as read when viewed
        if (!$notification->is_read) {
            $notification->markAsRead();
        }

        return view('admin.notifications.show', compact('notification'));
    }

    public function markAsRead($id)
    {
        $notification = AdminNotification::findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        AdminNotification::where('is_read', false)->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled,belum_diproses,sedang_disiapkan,transaksi_selesai,dibatalkan'
        ]);

        $notification = AdminNotification::with(['transaction', 'user'])->findOrFail($id);
        $oldStatus = $notification->status;
        $newStatus = $request->status;

        // Map new statuses to old ones for backward compatibility
        $statusMap = [
            'belum_diproses' => 'pending',
            'sedang_disiapkan' => 'processing',
            'transaksi_selesai' => 'completed',
            'dibatalkan' => 'cancelled',
        ];

        $notification->update(['status' => $newStatus]);

        // Update transaction status if exists
        if ($notification->transaction) {
            $transactionStatus = $statusMap[$newStatus] ?? $newStatus;
            $notification->transaction->update(['status' => $transactionStatus]);

            // Create status history (optional - only if table exists)
            try {
                \App\Models\TransactionStatusHistory::create([
                    'transaction_id' => $notification->transaction->id,
                    'status' => $newStatus,
                    'notes' => $request->notes ?? null,
                    'changed_by' => Auth::id(),
                ]);
            } catch (\Exception $e) {
                // Table might not exist yet, skip status history creation
                // This won't break the status update process
            }

            // Create user notification
            \App\Models\UserNotification::create([
                'user_id' => $notification->user_id,
                'transaction_id' => $notification->transaction->id,
                'type' => 'status_update',
                'title' => 'Status Pesanan Diperbarui',
                'message' => "Status pesanan Anda telah diubah menjadi: " . $this->getStatusLabel($newStatus),
                'data' => [
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'transaction_id' => $notification->transaction->id,
                ],
                'is_read' => false,
            ]);
        }

        return response()->json(['success' => true, 'status' => $notification->status]);
    }

    private function getStatusLabel($status)
    {
        $labels = [
            'belum_diproses' => 'Belum Diproses',
            'sedang_disiapkan' => 'Sedang Disiapkan',
            'transaksi_selesai' => 'Transaksi Selesai',
            'dibatalkan' => 'Dibatalkan',
            'pending' => 'Belum Diproses',
            'processing' => 'Sedang Disiapkan',
            'completed' => 'Transaksi Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        return $labels[$status] ?? ucfirst($status);
    }

    public function getUnreadCount()
    {
        $count = AdminNotification::unread()->count();
        return response()->json(['count' => $count]);
    }

    public function getRecentNotifications()
    {
        $notifications = AdminNotification::with(['user'])
            ->unread()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json($notifications);
    }

    // Method to create notification when user confirms purchase via WhatsApp
    public static function createOrderConfirmation($userId, $cartData)
    {
        $user = \App\Models\User::find($userId);
        
        // Create transaction record
        $transaction = Transaction::create([
            'user_id' => $userId,
            'total_amount' => $cartData['total'],
            'status' => 'pending',
            'payment_method' => 'whatsapp',
            'shipping_address' => $cartData['shipping_address'] ?? '',
            'notes' => $cartData['notes'] ?? '',
        ]);

        // Create admin notification
        $notification = AdminNotification::create([
            'user_id' => $userId,
            'transaction_id' => $transaction->id,
            'type' => 'order_confirmation',
            'title' => 'Konfirmasi Pembelian Baru',
            'message' => "User {$user->name} telah mengkonfirmasi pembelian via WhatsApp. Total: Rp " . number_format($cartData['total'], 0, ',', '.'),
            'data' => [
                'cart_items' => $cartData['items'],
                'user_info' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? '',
                ],
                'whatsapp_message' => $cartData['whatsapp_message'] ?? '',
            ],
            'status' => 'pending',
        ]);

        return $notification;
    }
}