@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div style="padding: 20px; max-width: 1200px; margin: 0 auto; margin-top: 70px;">
    <h1 style="margin-bottom: 30px; color: var(--green4); font-size: 2rem; display: flex; align-items: center;">
        <i class='bx bx-receipt' style="margin-right: 10px; color: var(--green1);"></i>
        Riwayat Transaksi
    </h1>
    
    @if($transactions->isEmpty())
        <div style="background: white; border-radius: 10px; box-shadow: var(--shadow1); padding: 60px 20px; text-align: center;">
            <i class='bx bx-package' style="font-size: 4rem; color: #ddd; margin-bottom: 20px;"></i>
            <h3 style="color:  #005E39;; margin-bottom: 10px;">Belum ada transaksi</h3>
            <p style="color: #999; margin-bottom: 20px;">Mulai belanja untuk melihat riwayat transaksi Anda</p>
            <a href="{{ route('shop') }}" style="background-color: var(--green2); color: white; padding: 12px 24px; border-radius: 5px; text-decoration: none; display: inline-block;">
                Mulai Belanja
            </a>
        </div>
    @else
        <div style="display: flex; flex-direction: column; gap: 20px;">
            @foreach ($transactions as $transaction)
                <div class="transaction-card" style="background: white; border-radius: 12px; box-shadow: var(--shadow1); padding: 20px; transition: transform 0.3s ease, box-shadow 0.3s ease;" 
                     onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.15)'" 
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow1)'">
                    
                    <!-- Header: Date, Type, Status -->
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #f0f0f0;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class='bx bx-shopping-bag' style="font-size: 1.2rem; color: var(--green1);"></i>
                            <div>
                                <div style="font-weight: 600; color:  #2a2a2a;">Belanja</div>
                                <div style="font-size: 0.85rem; color:  #005E39;;">{{ $transaction->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            @php
                                $statusLabels = [
                                    'belum_diproses' => 'Belum Diproses',
                                    'sedang_disiapkan' => 'Sedang Disiapkan',
                                    'sedang_dikirim' => 'Sedang Dikirim',
                                    'transaksi_selesai' => 'Transaksi Selesai',
                                    'dibatalkan' => 'Dibatalkan',
                                    'pending' => 'Belum Diproses',
                                    'processing' => 'Sedang Disiapkan',
                                    'completed' => 'Transaksi Selesai',
                                    'cancelled' => 'Dibatalkan',
                                ];
                                
                                $statusColors = [
                                    'belum_diproses' => '#ffc107',
                                    'sedang_disiapkan' => '#ff9800',
                                    'sedang_dikirim' => '#ff9800',
                                    'transaksi_selesai' => '#28a745',
                                    'dibatalkan' => '#dc3545',
                                    'pending' => '#ffc107',
                                    'processing' => '#ff9800',
                                    'completed' => '#28a745',
                                    'cancelled' => '#dc3545',
                                ];
                                
                                $status = $transaction->status ?? 'pending';
                                $statusLabel = $statusLabels[$status] ?? ucfirst($status);
                                $statusColor = $statusColors[$status] ?? '#6c757d';
                            @endphp
                            <span style="background: {{ $statusColor }}; color: white; padding: 6px 14px; border-radius: 20px; font-size: 0.85rem; font-weight: 500;">
                                {{ $statusLabel }}
                            </span>
                            <button style="background: none; border: none; cursor: pointer; padding: 5px; color:  #005E39;;" onclick="toggleTransactionMenu({{ $transaction->id }})">
                                <i class='bx bx-dots-vertical' style="font-size: 1.2rem;"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                        <div style="width: 80px; height: 120px; border-radius: 8px; overflow: hidden; flex-shrink: 0;">
                            <img src="{{ $transaction->book->cover_url }}" alt="{{ $transaction->book->title }}" 
                                 style="width: 100%; height: 100%; object-fit: cover;" 
                                 onerror="this.src='{{ asset('storage/cover_images/default-book.jpg') }}'">
                        </div>
                        <div style="flex: 1;">
                            <h3 style="margin: 0 0 5px 0; color:  #2a2a2a; font-size: 1rem; font-weight: 600;">
                                {{ $transaction->book->title }}
                            </h3>
                            <p style="margin: 0 0 10px 0; color:  #005E39;; font-size: 0.9rem;">
                                {{ $transaction->book->author }}
                            </p>
                            <div style="color:  #005E39;; font-size: 0.85rem;">
                                {{ $transaction->quantity }} barang
                            </div>
                        </div>
                    </div>

                    <!-- Total Price -->
                    <div style="margin-bottom: 15px; padding-top: 15px; border-top: 1px solid #f0f0f0;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color:  #005E39;; font-size: 0.9rem;">Total Belanja</span>
                            <span style="font-weight: 600; color:  #2a2a2a; font-size: 1.1rem;">
                                Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 10px;">
                        @if($status === 'sedang_disiapkan' || $status === 'processing')
                            <button style="flex: 1; background: var(--green1); color: white; border: none; padding: 10px; border-radius: 6px; cursor: pointer; font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <i class='bx bx-package' style="font-size: 1.1rem;"></i>
                                Lacak
                            </button>
                        @elseif($status === 'transaksi_selesai' || $status === 'completed')
                            <button style="flex: 1; background: var(--green1); color: white; border: none; padding: 10px; border-radius: 6px; cursor: pointer; font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <i class='bx bx-refresh' style="font-size: 1.1rem;"></i>
                                Beli Lagi
                            </button>
                        @elseif($status === 'dibatalkan' || $status === 'cancelled')
                            <div style="flex: 1; background: #e3f2fd; padding: 12px; border-radius: 6px; font-size: 0.85rem; color: #1976d2;">
                                <strong>Pembayaran sudah dikembalikan</strong> ke metode pembayaran yang kamu pakai. 
                                <a href="#" style="color: var(--green1); text-decoration: underline;">Lihat Detail</a>
                            </div>
                        @endif
                    </div>

                    <!-- Status History (if available) -->
                    @if($transaction->statusHistory && $transaction->statusHistory->count() > 0)
                        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #f0f0f0;">
                            <div style="font-size: 0.85rem; color:  #005E39;; margin-bottom: 8px;">Riwayat Status:</div>
                            <div style="display: flex; flex-direction: column; gap: 5px;">
                                @foreach($transaction->statusHistory->sortBy('created_at') as $history)
                                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; color: #999;">
                                        <span>{{ $history->status_label }}</span>
                                        <span>{{ $history->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
.transaction-card {
    transition: all 0.3s ease;
}

@media (max-width: 768px) {
    .transaction-card > div[style*="display: flex; gap: 15px"] {
        flex-direction: column !important;
    }
    
    .transaction-card > div[style*="display: flex; gap: 15px"] > div:first-child {
        width: 100% !important;
        height: 200px !important;
    }
}
</style>

<script>
function toggleTransactionMenu(transactionId) {
    // TODO: Implement transaction menu (view details, cancel, etc.)
    console.log('Transaction menu for:', transactionId);
}
</script>
@endsection
