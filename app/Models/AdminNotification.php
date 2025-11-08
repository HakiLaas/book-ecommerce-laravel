<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_id',
        'type',
        'title',
        'message',
        'data',
        'status',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public function markAsUnread(): void
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['pending', 'belum_diproses']);
    }

    public function getStatusLabelAttribute()
    {
        $statusLabels = [
            'belum_diproses' => 'Belum Diproses',
            'sedang_disiapkan' => 'Sedang Disiapkan',
            'transaksi_selesai' => 'Transaksi Selesai',
            'dibatalkan' => 'Dibatalkan',
            'pending' => 'Belum Diproses',
            'processing' => 'Sedang Disiapkan',
            'completed' => 'Transaksi Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        return $statusLabels[$this->status] ?? ucfirst($this->status);
    }
}
