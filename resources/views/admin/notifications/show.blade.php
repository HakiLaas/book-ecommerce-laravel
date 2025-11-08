@extends('layouts.app')

@section('title', 'Detail Notifikasi - Admin')

@section('content')
<div style="padding: 20px; max-width: 1200px; margin: 0 auto; margin-top: 70px;">
    <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: var(--shadow1);">
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <a href="{{ route('admin.notifications.index') }}" style="color: var(--green1); text-decoration: none; margin-right: 15px;">
                    <i class='bx bx-arrow-back' style="font-size: 1.5rem;"></i>
                </a>
                <h1 style="margin: 0; color:   #2a2a2a; font-size: 1.8rem; display: inline;">
                    Detail Notifikasi
                </h1>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                @php
                    $currentStatus = $notification->status;
                @endphp
                
                @if($currentStatus === 'belum_diproses' || $currentStatus === 'pending')
                    <button onclick="updateStatus('sedang_disiapkan')" style="background: #ff9800; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 500;">
                        <i class='bx bx-package' style="margin-right: 5px;"></i>
                        Sedang Disiapkan
                    </button>
                    <button onclick="updateStatus('dibatalkan')" style="background: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 500;">
                        <i class='bx bx-x-circle' style="margin-right: 5px;"></i>
                        Batalkan
                    </button>
                @elseif($currentStatus === 'sedang_disiapkan' || $currentStatus === 'processing')
                    <button onclick="updateStatus('transaksi_selesai')" style="background: var(--green1); color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 500;">
                        <i class='bx bx-check-circle' style="margin-right: 5px;"></i>
                        Transaksi Selesai
                    </button>
                    <button onclick="updateStatus('belum_diproses')" style="background: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 500;">
                        <i class='bx bx-undo' style="margin-right: 5px;"></i>
                        Kembali ke Belum Diproses
                    </button>
                @elseif($currentStatus === 'transaksi_selesai' || $currentStatus === 'completed')
                    <span style="background: #28a745; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 500;">
                        <i class='bx bx-check-circle' style="margin-right: 5px;"></i>
                        Transaksi Selesai
                    </span>
                @elseif($currentStatus === 'dibatalkan' || $currentStatus === 'cancelled')
                    <span style="background: #dc3545; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 500;">
                        <i class='bx bx-x-circle' style="margin-right: 5px;"></i>
                        Dibatalkan
                    </span>
                @endif
                <button onclick="markAsRead()" style="background: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 500;">
                    <i class='bx bx-check-double' style="margin-right: 5px;"></i>
                    Tandai Dibaca
                </button>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
            <!-- Main Content -->
            <div>
                <!-- Notification Info -->
                <div style="background: #f8f9fa; border-radius: 10px; padding: 20px; margin-bottom: 20px;">
                    <div style="display: flex; align-items: center; margin-bottom: 15px;">
                        @php
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
                            $statusLabel = $statusLabels[$notification->status] ?? ucfirst($notification->status);
                        @endphp
                        <span class="status-badge status-{{ $notification->status }}" style="padding: 6px 15px; border-radius: 20px; font-size: 0.9rem; font-weight: 500; margin-right: 15px;">
                            {{ $statusLabel }}
                        </span>
                        @if(!$notification->is_read)
                            <span style="background: var(--green1); color: white; padding: 4px 10px; border-radius: 15px; font-size: 0.8rem; font-weight: 500;">
                                Belum Dibaca
                            </span>
                        @endif
                    </div>
                    <h2 style="margin: 0 0 10px; color:   #2a2a2a; font-size: 1.4rem;">{{ $notification->title }}</h2>
                    <p style="margin: 0 0 15px; color: #808080; line-height: 1.6; font-size: 1.1rem;">{{ $notification->message }}</p>
                    <div style="display: flex; align-items: center; gap: 20px; font-size: 0.9rem; color: #999;">
                        <span><i class='bx bx-time' style="margin-right: 5px;"></i>{{ $notification->created_at->format('d M Y, H:i') }}</span>
                        @if($notification->read_at)
                            <span><i class='bx bx-check-double' style="margin-right: 5px;"></i>Dibaca: {{ $notification->read_at->format('d M Y, H:i') }}</span>
                        @endif
                    </div>
                </div>

                <!-- Customer Info -->
                <div style="background: white; border: 1px solid #e9ecef; border-radius: 10px; padding: 20px; margin-bottom: 20px;">
                    <h3 style="margin: 0 0 15px; color:   #2a2a2a; font-size: 1.2rem; display: flex; align-items: center;">
                        <i class='bx bx-user' style="margin-right: 8px; color: var(--green1);"></i>
                        Informasi Customer
                    </h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label style="display: block; font-weight: 500; color: #808080; margin-bottom: 5px;">Nama</label>
                            <p style="margin: 0; color:   #2a2a2a;">{{ $notification->user->name }}</p>
                        </div>
                        <div>
                            <label style="display: block; font-weight: 500; color: #808080; margin-bottom: 5px;">Email</label>
                            <p style="margin: 0; color:   #2a2a2a;">{{ $notification->user->email }}</p>
                        </div>
                        @if($notification->data && isset($notification->data['user_info']['phone']))
                            <div>
                                <label style="display: block; font-weight: 500; color: #808080; margin-bottom: 5px;">Telepon</label>
                                <p style="margin: 0; color:   #2a2a2a;">{{ $notification->data['user_info']['phone'] }}</p>
                            </div>
                        @endif
                        <div>
                            <label style="display: block; font-weight: 500; color: #808080; margin-bottom: 5px;">Member Sejak</label>
                            <p style="margin: 0; color:   #2a2a2a;">{{ $notification->user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Transaction Info -->
                @if($notification->transaction)
                    <div style="background: white; border: 1px solid #e9ecef; border-radius: 10px; padding: 20px; margin-bottom: 20px;">
                        <h3 style="margin: 0 0 15px; color:   #2a2a2a; font-size: 1.2rem; display: flex; align-items: center;">
                            <i class='bx bx-receipt' style="margin-right: 8px; color: var(--green1);"></i>
                            Informasi Transaksi
                        </h3>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div>
                                <label style="display: block; font-weight: 500; color: #808080; margin-bottom: 5px;">ID Transaksi</label>
                                <p style="margin: 0; color:   #2a2a2a; font-weight: 600;">#{{ $notification->transaction->id }}</p>
                            </div>
                            <div>
                                <label style="display: block; font-weight: 500; color: #808080; margin-bottom: 5px;">Total Pembayaran</label>
                                <p style="margin: 0; color: var(--green1); font-weight: 600; font-size: 1.1rem;">Rp {{ number_format($notification->transaction->total_price ?? $notification->transaction->total_amount ?? 0, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <label style="display: block; font-weight: 500; color: #808080; margin-bottom: 5px;">Metode Pembayaran</label>
                                <p style="margin: 0; color:   #2a2a2a;">{{ ucfirst($notification->transaction->payment_method) }}</p>
                            </div>
                            <div>
                                <label style="display: block; font-weight: 500; color: #808080; margin-bottom: 5px;">Status</label>
                                @php
                                    $transStatusLabels = [
                                        'belum_diproses' => 'Belum Diproses',
                                        'sedang_disiapkan' => 'Sedang Disiapkan',
                                        'transaksi_selesai' => 'Transaksi Selesai',
                                        'dibatalkan' => 'Dibatalkan',
                                        'pending' => 'Belum Diproses',
                                        'processing' => 'Sedang Disiapkan',
                                        'completed' => 'Transaksi Selesai',
                                        'cancelled' => 'Dibatalkan',
                                    ];
                                    $transStatusLabel = $transStatusLabels[$notification->transaction->status ?? 'pending'] ?? ucfirst($notification->transaction->status ?? 'pending');
                                @endphp
                                <span class="status-badge status-{{ $notification->transaction->status ?? 'pending' }}" style="padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 500;">
                                    {{ $transStatusLabel }}
                                </span>
                            </div>
                        </div>
                        @if($notification->transaction->address)
                            <div style="margin-top: 15px;">
                                <label style="display: block; font-weight: 500; color: #808080; margin-bottom: 5px;">Alamat Pengiriman</label>
                                <p style="margin: 0; color:   #2a2a2a;">{{ $notification->transaction->address }}</p>
                            </div>
                        @endif
                        @if($notification->data && isset($notification->data['receiver_name']))
                            <div style="margin-top: 15px;">
                                <label style="display: block; font-weight: 500; color: #808080; margin-bottom: 5px;">Nama Penerima</label>
                                <p style="margin: 0; color:   #2a2a2a;">{{ $notification->data['receiver_name'] }}</p>
                            </div>
                        @endif
                        @if($notification->transaction->phone)
                            <div style="margin-top: 15px;">
                                <label style="display: block; font-weight: 500; color: #808080; margin-bottom: 5px;">No. Telepon</label>
                                <p style="margin: 0; color:   #2a2a2a;">{{ $notification->transaction->phone }}</p>
                            </div>
                        @endif
                        @if($notification->transaction->notes)
                            <div style="margin-top: 15px;">
                                <label style="display: block; font-weight: 500; color: #808080; margin-bottom: 5px;">Catatan</label>
                                <p style="margin: 0; color:   #2a2a2a;">{{ $notification->transaction->notes }}</p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Cart Items -->
                @if($notification->data && isset($notification->data['cart_items']))
                    <div style="background: white; border: 1px solid #e9ecef; border-radius: 10px; padding: 20px;">
                        <h3 style="margin: 0 0 15px; color:   #2a2a2a; font-size: 1.2rem; display: flex; align-items: center;">
                            <i class='bx bx-shopping-bag' style="margin-right: 8px; color: var(--green1);"></i>
                            Item yang Dipesan
                        </h3>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="background: #f8f9fa;">
                                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6; font-weight: 600;">Cover</th>
                                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6; font-weight: 600;">Judul Buku</th>
                                        <th style="padding: 12px; text-align: center; border-bottom: 1px solid #dee2e6; font-weight: 600;">Qty</th>
                                        <th style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6; font-weight: 600;">Harga</th>
                                        <th style="padding: 12px; text-align: right; border-bottom: 1px solid #dee2e6; font-weight: 600;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notification->data['cart_items'] as $item)
                                        <tr>
                                            <td style="padding: 12px; border-bottom: 1px solid #f0f0f0;">
                                                <img src="{{ $item['book_cover'] ?? asset('storage/cover_images/default-book.jpg') }}" 
                                                     alt="{{ $item['book_title'] }}" 
                                                     style="width: 50px; height: 70px; object-fit: cover; border-radius: 5px;"
                                                     onerror="this.src='{{ asset('storage/cover_images/default-book.jpg') }}'">
                                            </td>
                                            <td style="padding: 12px; border-bottom: 1px solid #f0f0f0;">
                                                <div>
                                                    <p style="margin: 0; font-weight: 500; color:   #2a2a2a;">{{ $item['book_title'] }}</p>
                                                    <p style="margin: 5px 0 0; font-size: 0.9rem; color: #808080;">{{ $item['book_author'] ?? 'Unknown Author' }}</p>
                                                </div>
                                            </td>
                                            <td style="padding: 12px; text-align: center; border-bottom: 1px solid #f0f0f0;">{{ $item['quantity'] }}</td>
                                            <td style="padding: 12px; text-align: right; border-bottom: 1px solid #f0f0f0;">Rp {{ number_format($item['book_price'], 0, ',', '.') }}</td>
                                            <td style="padding: 12px; text-align: right; border-bottom: 1px solid #f0f0f0; font-weight: 600;">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr style="background: #f8f9fa;">
                                        <td colspan="4" style="padding: 15px; text-align: right; font-weight: 600; font-size: 1.1rem;">Total:</td>
                                        <td style="padding: 15px; text-align: right; font-weight: 600; font-size: 1.1rem; color: var(--green1);">
                                            Rp {{ number_format(array_sum(array_column($notification->data['cart_items'], 'subtotal')), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                @endif

                <!-- WhatsApp Message -->
                @if($notification->data && isset($notification->data['whatsapp_message']))
                    <div style="background: #e8f5e8; border: 1px solid #c3e6c3; border-radius: 10px; padding: 20px; margin-top: 20px;">
                        <h3 style="margin: 0 0 15px; color:   #2a2a2a; font-size: 1.2rem; display: flex; align-items: center;">
                            <i class='bx bxl-whatsapp' style="margin-right: 8px; color: #25d366;"></i>
                            Pesan WhatsApp
                        </h3>
                        <p style="margin: 0; color:   #2a2a2a; line-height: 1.6; font-style: italic;">"{{ $notification->data['whatsapp_message'] }}"</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Quick Actions -->
                <div style="background: #f8f9fa; border-radius: 10px; padding: 20px; margin-bottom: 20px;">
                    <h3 style="margin: 0 0 15px; color:   #2a2a2a; font-size: 1.1rem;">Aksi Cepat</h3>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <a href="https://wa.me/{{ $notification->data['user_info']['phone'] ?? '' }}" target="_blank" 
                           style="background: #25d366; color: white; padding: 10px 15px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 500;">
                            <i class='bx bxl-whatsapp' style="margin-right: 5px;"></i>
                            Chat WhatsApp
                        </a>
                        <button onclick="copyOrderInfo()" style="background: #6c757d; color: white; border: none; padding: 10px 15px; border-radius: 8px; cursor: pointer; font-weight: 500;">
                            <i class='bx bx-copy' style="margin-right: 5px;"></i>
                            Copy Info Pesanan
                        </button>
                        <button onclick="printOrder()" style="background: #17a2b8; color: white; border: none; padding: 10px 15px; border-radius: 8px; cursor: pointer; font-weight: 500;">
                            <i class='bx bx-printer' style="margin-right: 5px;"></i>
                            Print Pesanan
                        </button>
                    </div>
                </div>

                <!-- Status Timeline -->
                <div style="background: white; border: 1px solid #e9ecef; border-radius: 10px; padding: 20px;">
                    <h3 style="margin: 0 0 15px; color:   #2a2a2a; font-size: 1.1rem;">Timeline Status</h3>
                    <div style="position: relative;">
                        <div style="position: absolute; left: 15px; top: 0; bottom: 0; width: 2px; background: #e9ecef;"></div>
                        
                        <div style="position: relative; padding-left: 40px; margin-bottom: 20px;">
                            <div style="position: absolute; left: 8px; top: 5px; width: 16px; height: 16px; background: var(--green1); border-radius: 50%; border: 3px solid white; box-shadow: 0 0 0 2px var(--green1);"></div>
                            <div>
                                <p style="margin: 0; font-weight: 500; color:   #2a2a2a;">Pesanan Dibuat</p>
                                <p style="margin: 5px 0 0; font-size: 0.9rem; color: #808080;">{{ $notification->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        @if($notification->status === 'sedang_disiapkan' || $notification->status === 'processing')
                            <div style="position: relative; padding-left: 40px; margin-bottom: 20px;">
                                <div style="position: absolute; left: 8px; top: 5px; width: 16px; height: 16px; background: #ff9800; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 0 2px #ff9800;"></div>
                                <div>
                                    <p style="margin: 0; font-weight: 500; color:   #2a2a2a;">Sedang Disiapkan</p>
                                    <p style="margin: 5px 0 0; font-size: 0.9rem; color: #808080;">{{ $notification->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($notification->status === 'transaksi_selesai' || $notification->status === 'completed')
                            <div style="position: relative; padding-left: 40px;">
                                <div style="position: absolute; left: 8px; top: 5px; width: 16px; height: 16px; background: var(--green1); border-radius: 50%; border: 3px solid white; box-shadow: 0 0 0 2px var(--green1);"></div>
                                <div>
                                    <p style="margin: 0; font-weight: 500; color:   #2a2a2a;">Transaksi Selesai</p>
                                    <p style="margin: 5px 0 0; font-size: 0.9rem; color: #808080;">{{ $notification->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.status-badge {
    font-weight: 500;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-processing {
    background: #d1ecf1;
    color: #0c5460;
}

.status-completed {
    background: #d4edda;
    color: #155724;
}

.status-cancelled {
    background: #f8d7da;
    color: #721c24;
}

@media (max-width: 768px) {
    div[style*="grid-template-columns: 2fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
    
    div[style*="display: grid; grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>

<script>
function updateStatus(status) {
    if (!confirm('Apakah Anda yakin ingin mengubah status menjadi: ' + status + '?')) {
        return;
    }
    
    fetch(`/admin/notifications/{{ $notification->id }}/status`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Status berhasil diubah!');
            location.reload();
        } else {
            alert('Gagal mengubah status: ' + (data.message || 'Terjadi kesalahan'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengubah status');
    });
}

function markAsRead() {
    fetch(`/admin/notifications/{{ $notification->id }}/read`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan', 'error');
    });
}

function copyOrderInfo() {
    const orderInfo = `
Pesanan #{{ $notification->transaction->id ?? 'N/A' }}
Customer: {{ $notification->user->name }}
Email: {{ $notification->user->email }}
Total: Rp {{ number_format($notification->transaction->total_price ?? $notification->transaction->total_amount ?? 0, 0, ',', '.') }}
Status: {{ ucfirst($notification->status) }}
Tanggal: {{ $notification->created_at->format('d M Y, H:i') }}
    `.trim();
    
    navigator.clipboard.writeText(orderInfo).then(() => {
        showNotification('Info pesanan berhasil disalin', 'success');
    }).catch(() => {
        showNotification('Gagal menyalin info pesanan', 'error');
    });
}

function printOrder() {
    window.print();
}
</script>
@endsection
