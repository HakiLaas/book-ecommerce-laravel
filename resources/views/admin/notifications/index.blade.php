@extends('layouts.app')

@section('title', 'Admin Notifications - Daftar Pesanan')

@section('content')

<div class="container" style="margin-top:80px">
    <div style="display:grid; grid-template-columns:260px 1fr; gap:20px;">
                <!-- Sidebar -->
                @include('admin.partials.sidebar')
<div style="padding: 20px; max-width: 1400px; margin: 0 auto; margin-top: 70px;">
    <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: var(--shadow1);">
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h1 style="margin: 0; color:   #2a2a2a; font-size: 1.8rem; display: flex; align-items: center;">
                    <i class='bx bx-bell' style="margin-right: 10px; color: var(--green1);"></i>
                    Notifikasi Admin
                </h1>
                <p style="margin: 5px 0 0; color: #808080;">Kelola pesanan dan konfirmasi pembelian dari customer</p>
            </div>
            <div style="display: flex; gap: 10px;">
                <button id="markAllReadBtn" style="background: var(--green2); color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 500;">
                    <i class='bx bx-check-double' style="margin-right: 5px;"></i>
                    Tandai Semua Dibaca
                </button>
                <button id="refreshBtn" style="background: #f8f9fa; color:   #2a2a2a; border: 1px solid #ddd; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 500;">
                    <i class='bx bx-refresh' style="margin-right: 5px;"></i>
                    Refresh
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 10px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 2rem;" id="totalNotifications">{{ $notifications->total() }}</h3>
                        <p style="margin: 5px 0 0; opacity: 0.9;">Total Notifikasi</p>
                    </div>
                    <i class='bx bx-bell' style="font-size: 2.5rem; opacity: 0.7;"></i>
                </div>
            </div>
            <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 20px; border-radius: 10px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 2rem;" id="unreadCount">{{ $notifications->where('is_read', false)->count() }}</h3>
                        <p style="margin: 5px 0 0; opacity: 0.9;">Belum Dibaca</p>
                    </div>
                    <i class='bx bx-envelope' style="font-size: 2.5rem; opacity: 0.7;"></i>
                </div>
            </div>
            <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 20px; border-radius: 10px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 2rem;" id="pendingCount">{{ $notifications->whereIn('status', ['pending', 'belum_diproses'])->count() }}</h3>
                        <p style="margin: 5px 0 0; opacity: 0.9;">Menunggu Diproses</p>
                    </div>
                    <i class='bx bx-time-five' style="font-size: 2.5rem; opacity: 0.7;"></i>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div style="margin-bottom: 20px;">
            <div style="display: flex; gap: 10px; border-bottom: 2px solid #f0f0f0;">
                <button class="filter-tab active" data-filter="all" style="background: none; border: none; padding: 10px 20px; cursor: pointer; font-weight: 500; color: var(--green1); border-bottom: 2px solid var(--green1);">
                    Semua ({{ $notifications->total() }})
                </button>
                <button class="filter-tab" data-filter="unread" style="background: none; border: none; padding: 10px 20px; cursor: pointer; font-weight: 500; color: #808080;">
                    Belum Dibaca ({{ $notifications->where('is_read', false)->count() }})
                </button>
                <button class="filter-tab" data-filter="pending" style="background: none; border: none; padding: 10px 20px; cursor: pointer; font-weight: 500; color: #808080;">
                    Belum Diproses ({{ $notifications->whereIn('status', ['pending', 'belum_diproses'])->count() }})
                </button>
                <button class="filter-tab" data-filter="processing" style="background: none; border: none; padding: 10px 20px; cursor: pointer; font-weight: 500; color: #808080;">
                    Sedang Disiapkan ({{ $notifications->whereIn('status', ['processing', 'sedang_disiapkan'])->count() }})
                </button>
                <button class="filter-tab" data-filter="completed" style="background: none; border: none; padding: 10px 20px; cursor: pointer; font-weight: 500; color: #808080;">
                    Selesai ({{ $notifications->whereIn('status', ['completed', 'transaksi_selesai'])->count() }})
                </button>
            </div>
        </div>
        

        <!-- Notifications List -->
        <div id="notificationsList">
            @forelse($notifications as $notification)
                <div class="notification-item" data-status="{{ $notification->status }}" data-read="{{ $notification->is_read ? 'true' : 'false' }}" 
                     style="background: {{ $notification->is_read ? '#f8f9fa' : 'white' }}; border: 1px solid #e9ecef; border-radius: 10px; padding: 20px; margin-bottom: 15px; transition: all 0.3s ease; cursor: pointer;"
                     onclick="viewNotification({{ $notification->id }})">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                @if(!$notification->is_read)
                                    <div style="width: 8px; height: 8px; background: var(--green1); border-radius: 50%; margin-right: 10px;"></div>
                                @endif
                                <h3 style="margin: 0; color:   #2a2a2a; font-size: 1.1rem;">{{ $notification->title }}</h3>
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
                                <span class="status-badge status-{{ $notification->status }}" style="margin-left: 10px; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 500;">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                            <p style="margin: 0 0 10px; color: #808080; line-height: 1.5;">{{ $notification->message }}</p>
                            <div style="display: flex; align-items: center; gap: 15px; font-size: 0.85rem; color: #999;">
                                <span><i class='bx bx-user' style="margin-right: 5px;"></i>{{ $notification->user->name }}</span>
                                <span><i class='bx bx-time' style="margin-right: 5px;"></i>{{ $notification->created_at->diffForHumans() }}</span>
                                @if($notification->transaction)
                                    <span><i class='bx bx-receipt' style="margin-right: 5px;"></i>Transaksi #{{ $notification->transaction->id }}</span>
                                @endif
                            </div>
                        </div>
                        <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                            @php
                                $currentStatus = $notification->status;
                                $statusOptions = [
                                    'belum_diproses' => ['label' => 'Belum Diproses', 'color' => '#ffc107', 'icon' => 'bx-time'],
                                    'sedang_disiapkan' => ['label' => 'Sedang Disiapkan', 'color' => '#ff9800', 'icon' => 'bx-package'],
                                    'transaksi_selesai' => ['label' => 'Transaksi Selesai', 'color' => '#28a745', 'icon' => 'bx-check-circle'],
                                    'dibatalkan' => ['label' => 'Dibatalkan', 'color' => '#dc3545', 'icon' => 'bx-x-circle'],
                                ];
                            @endphp
                            
                            @if($currentStatus === 'belum_diproses' || $currentStatus === 'pending')
                                <button onclick="event.stopPropagation(); updateStatus({{ $notification->id }}, 'sedang_disiapkan')" 
                                        style="background: #ff9800; color: white; border: none; padding: 6px 12px; border-radius: 5px; font-size: 0.8rem; cursor: pointer; font-weight: 500;">
                                    <i class='bx bx-package' style="margin-right: 4px;"></i> Sedang Disiapkan
                                </button>
                                <button onclick="event.stopPropagation(); updateStatus({{ $notification->id }}, 'dibatalkan')" 
                                        style="background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 5px; font-size: 0.8rem; cursor: pointer; font-weight: 500;">
                                    <i class='bx bx-x-circle' style="margin-right: 4px;"></i> Batalkan
                                </button>
                            @elseif($currentStatus === 'sedang_disiapkan' || $currentStatus === 'processing')
                                <button onclick="event.stopPropagation(); updateStatus({{ $notification->id }}, 'transaksi_selesai')" 
                                        style="background: #28a745; color: white; border: none; padding: 6px 12px; border-radius: 5px; font-size: 0.8rem; cursor: pointer; font-weight: 500;">
                                    <i class='bx bx-check-circle' style="margin-right: 4px;"></i> Selesai
                                </button>
                                <button onclick="event.stopPropagation(); updateStatus({{ $notification->id }}, 'belum_diproses')" 
                                        style="background: #6c757d; color: white; border: none; padding: 6px 12px; border-radius: 5px; font-size: 0.8rem; cursor: pointer; font-weight: 500;">
                                    <i class='bx bx-undo' style="margin-right: 4px;"></i> Kembali
                                </button>
                            @elseif($currentStatus === 'transaksi_selesai' || $currentStatus === 'completed')
                                <span style="background: #28a745; color: white; padding: 6px 12px; border-radius: 5px; font-size: 0.8rem; font-weight: 500;">
                                    <i class='bx bx-check-circle' style="margin-right: 4px;"></i> Selesai
                                </span>
                            @elseif($currentStatus === 'dibatalkan' || $currentStatus === 'cancelled')
                                <span style="background: #dc3545; color: white; padding: 6px 12px; border-radius: 5px; font-size: 0.8rem; font-weight: 500;">
                                    <i class='bx bx-x-circle' style="margin-right: 4px;"></i> Dibatalkan
                                </span>
                            @endif
                            <button onclick="event.stopPropagation(); markAsRead({{ $notification->id }})" 
                                    style="background: #6c757d; color: white; border: none; padding: 5px 10px; border-radius: 5px; font-size: 0.8rem; cursor: pointer;">
                                <i class='bx bx-check-double'></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 60px 20px;">
                    <i class='bx bx-bell-off' style="font-size: 4rem; color: #ddd; margin-bottom: 20px;"></i>
                    <h3 style="color: #808080; margin-bottom: 10px;">Belum ada notifikasi</h3>
                    <p style="color: #999;">Notifikasi akan muncul ketika ada konfirmasi pembelian dari customer</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div style="margin-top: 30px; display: flex; justify-content: center;">
                {{ $notifications->links() }}
            </div>
        @endif
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

.notification-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.filter-tab.active {
    color: var(--green1) !important;
    border-bottom-color: var(--green1) !important;
}

@media (max-width: 768px) {
    div[style*="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr))"] {
        grid-template-columns: 1fr !important;
    }
    
    div[style*="display: flex; justify-content: space-between; align-items: center;"] {
        flex-direction: column !important;
        gap: 15px !important;
    }
}
</style>

<script>
let currentFilter = 'all';

// Filter functionality
document.querySelectorAll('.filter-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        // Remove active class from all tabs
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        // Add active class to clicked tab
        this.classList.add('active');
        
        currentFilter = this.dataset.filter;
        filterNotifications();
    });
});

function filterNotifications() {
    const items = document.querySelectorAll('.notification-item');
    
    items.forEach(item => {
        const status = item.dataset.status;
        const isRead = item.dataset.read === 'true';
        
        let show = false;
        
        switch(currentFilter) {
            case 'all':
                show = true;
                break;
            case 'unread':
                show = !isRead;
                break;
            case 'pending':
                show = status === 'pending' || status === 'belum_diproses';
                break;
            case 'processing':
                show = status === 'processing' || status === 'sedang_disiapkan';
                break;
            case 'completed':
                show = status === 'completed' || status === 'transaksi_selesai';
                break;
        }
        
        item.style.display = show ? 'block' : 'none';
    });
}

function viewNotification(id) {
    window.location.href = `/admin/notifications/${id}`;
}

function markAsRead(id) {
    fetch(`/admin/notifications/${id}/read`, {
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

function updateStatus(id, status) {
    fetch(`/admin/notifications/${id}/status`, {
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
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan', 'error');
    });
}

document.getElementById('markAllReadBtn').addEventListener('click', function() {
    fetch('/admin/notifications/read-all', {
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
});

document.getElementById('refreshBtn').addEventListener('click', function() {
    location.reload();
});

// Auto refresh every 30 seconds
setInterval(function() {
    fetch('/api/admin/notifications/unread/count')
        .then(response => response.json())
        .then(data => {
            document.getElementById('unreadCount').textContent = data.count;
        })
        .catch(error => console.error('Error:', error));
}, 30000);
</script>
@endsection
