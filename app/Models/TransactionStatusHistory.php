<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'transaction_status_history';

    protected $fillable = [
        'transaction_id',
        'status',
        'notes',
        'changed_by',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public function getStatusLabelAttribute()
    {
        $statusLabels = [
            'belum_diproses' => 'Belum Diproses',
            'sedang_disiapkan' => 'Sedang Disiapkan',
            'transaksi_selesai' => 'Transaksi Selesai',
            'dibatalkan' => 'Dibatalkan',
        ];

        return $statusLabels[$this->status] ?? ucfirst($this->status);
    }
}

