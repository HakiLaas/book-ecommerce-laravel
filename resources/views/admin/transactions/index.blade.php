@extends('layouts.app')

@section('title', 'Transaksi & Pembayaran - Admin Panel')

@section('content')
<div class="container" style="margin-top:80px">
    <div style="display:grid; grid-template-columns:260px 1fr; gap:20px;">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <main>
            <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: var(--shadow1);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                    <div>
                        <h1 style="margin: 0; color: var(--black); font-size: 1.8rem; display: flex; align-items: center;">
                            <i class='bx bx-receipt' style="margin-right: 10px; color: var(--green1);"></i>
                            Transaksi & Pembayaran
                        </h1>
                        <p style="margin: 5px 0 0; color: #808080; font-size: 0.9rem;">Kelola semua transaksi dan pembayaran</p>
                    </div>
                </div>

                @if($transactions->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, var(--green1) 0%, var(--green2) 100%); color: white;">
                                <th style="padding: 15px; text-align: left; font-weight: 600; border-radius: 8px 0 0 0;">ID</th>
                                <th style="padding: 15px; text-align: left; font-weight: 600;">Pengguna</th>
                                <th style="padding: 15px; text-align: left; font-weight: 600;">Buku</th>
                                <th style="padding: 15px; text-align: center; font-weight: 600;">Jumlah</th>
                                <th style="padding: 15px; text-align: right; font-weight: 600;">Total Harga</th>
                                <th style="padding: 15px; text-align: center; font-weight: 600; border-radius: 0 8px 0 0;">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr style="border-bottom: 1px solid #f0f0f0; transition: background-color 0.2s ease;"
                                onmouseover="this.style.backgroundColor='#f8f9fa'"
                                onmouseout="this.style.backgroundColor='white'">
                                <td style="padding: 15px; color: var(--black); font-weight: 500;">#{{ $transaction->id }}</td>
                                <td style="padding: 15px; color: var(--black);">{{ $transaction->user->name ?? 'N/A' }}</td>
                                <td style="padding: 15px; color: var(--black);">{{ $transaction->book->title ?? 'N/A' }}</td>
                                <td style="padding: 15px; text-align: center; color: var(--black);">
                                    <span style="background: #e3f2fd; color: #1976d2; padding: 5px 12px; border-radius: 20px; font-weight: 500; font-size: 0.9rem;">
                                        {{ $transaction->quantity }}
                                    </span>
                                </td>
                                <td style="padding: 15px; text-align: right; color: var(--green1); font-weight: 600;">
                                    Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                </td>
                                <td style="padding: 15px; text-align: center; color: #808080; font-size: 0.9rem;">
                                    {{ $transaction->created_at->format('d M Y') }}<br>
                                    <small style="color: #999;">{{ $transaction->created_at->format('H:i') }}</small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div style="text-align: center; padding: 60px 20px;">
                    <i class='bx bx-receipt' style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
                    <p style="color: #808080; font-size: 1.1rem; margin: 0;">Belum ada transaksi</p>
                </div>
                @endif
            </div>
        </main>
    </div>
</div>

<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns:260px 1fr"] {
        grid-template-columns: 1fr !important;
    }
    
    aside {
        order: 2;
    }
    
    main {
        order: 1;
    }
    
    table {
        font-size: 0.85rem;
    }
    
    th, td {
        padding: 10px 8px !important;
    }
}
</style>
@endsection