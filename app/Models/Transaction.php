<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'book_id', 'quantity', 'total_price',
        'receiver_name', 'phone', 'address', 'payment_method', 'status'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusHistory()
    {
        return $this->hasMany(TransactionStatusHistory::class);
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

    public function getStatusColorAttribute()
    {
        $statusColors = [
            'belum_diproses' => '#ffc107',
            'sedang_disiapkan' => '#ff9800',
            'transaksi_selesai' => '#28a745',
            'dibatalkan' => '#dc3545',
            'pending' => '#ffc107',
            'processing' => '#ff9800',
            'completed' => '#28a745',
            'cancelled' => '#dc3545',
        ];

        return $statusColors[$this->status] ?? '#6c757d';
    }
}
