@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:80px">
    <div style="display:grid; grid-template-columns:260px 1fr; gap:20px;">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <main>
            <!-- Welcome Card -->
            <div style="background: linear-gradient(135deg, var(--green1) 0%, var(--green2) 100%); color: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: var(--shadow1);">
                <h1 style="font-size: 2rem; margin-bottom: 10px;">Selamat Datang, Admin {{ Auth::user()->name }}</h1>
                <p style="opacity: 0.9; font-size: 1.1rem;">Kelola seluruh aspek toko buku online Anda</p>
            </div>

            <!-- Stats Cards -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(250px, 1fr)); gap:20px; margin-bottom:30px;">
                <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: var(--shadow1); text-align: center;">
                    <div style="background: linear-gradient(135deg, #007bff, #0056b3); color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class='bx bx-user' style="font-size: 1.8rem;"></i>
                    </div>
                    <h3 style="font-size: 2rem; margin-bottom: 5px; color:   #2a2a2a;">{{ $totalUsers }}</h3>
                    <p style="color: #808080; margin: 0;">Total Pengguna</p>
                    <div style="margin-top: 10px; padding: 5px 10px; background: #e3f2fd; color: #1976d2; border-radius: 20px; font-size: 0.8rem; display: inline-block;">
                        <i class='bx bx-trending-up'></i> +12% dari bulan lalu
                    </div>
                </div>
                
                <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: var(--shadow1); text-align: center;">
                    <div style="background: linear-gradient(135deg, #28a745, #1e7e34); color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class='bx bx-book' style="font-size: 1.8rem;"></i>
                    </div>
                    <h3 style="font-size: 2rem; margin-bottom: 5px; color:   #2a2a2a;">{{ $totalProducts }}</h3>
                    <p style="color: #808080; margin: 0;">Total Produk</p>
                    <div style="margin-top: 10px; padding: 5px 10px; background: #e8f5e8; color: #28a745; border-radius: 20px; font-size: 0.8rem; display: inline-block;">
                        <i class='bx bx-plus'></i> +5 produk baru
                    </div>
                </div>
                
                <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: var(--shadow1); text-align: center;">
                    <div style="background: linear-gradient(135deg, #ffc107, #e0a800); color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <i class='bx bx-dollar' style="font-size: 1.8rem;"></i>
                    </div>
                    <h3 style="font-size: 2rem; margin-bottom: 5px; color:   #2a2a2a;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p style="color: #808080; margin: 0;">Total Pendapatan</p>
                    <div style="margin-top: 10px; padding: 5px 10px; background: #fff3cd; color: #856404; border-radius: 20px; font-size: 0.8rem; display: inline-block;">
                        <i class='bx bx-trending-up'></i> +8% dari bulan lalu
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: var(--shadow1); margin-bottom: 30px;">
                <h3 style="margin-bottom: 20px; color:   #2a2a2a; font-size: 1.3rem; display: flex; align-items: center;">
                    <i class='bx bx-bolt' style="margin-right: 10px; color: var(--green1);"></i>
                    Aksi Cepat
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <a href="{{ route('admin.books.create') }}" style="display: flex; align-items: center; padding: 15px; background: #f8f9fa; border-radius: 10px; text-decoration: none; color:   #2a2a2a; transition: all 0.3s ease;">
                        <i class='bx bx-plus-circle' style="font-size: 1.5rem; margin-right: 10px; color: var(--green1);"></i>
                        <div>
                            <h4 style="margin: 0; font-size: 0.9rem;">Tambah Buku</h4>
                            <p style="margin: 0; font-size: 0.8rem; color: #808080;">Tambah produk baru</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.transactions.index') }}" style="display: flex; align-items: center; padding: 15px; background: #f8f9fa; border-radius: 10px; text-decoration: none; color:   #2a2a2a; transition: all 0.3s ease;">
                        <i class='bx bx-receipt' style="font-size: 1.5rem; margin-right: 10px; color: var(--orange1);"></i>
                        <div>
                            <h4 style="margin: 0; font-size: 0.9rem;">Lihat Transaksi</h4>
                            <p style="margin: 0; font-size: 0.8rem; color: #808080;">Kelola pesanan</p>
                        </div>
                    </a>
                    
                    <a href="#" style="display: flex; align-items: center; padding: 15px; background: #f8f9fa; border-radius: 10px; text-decoration: none; color:   #2a2a2a; transition: all 0.3s ease;">
                        <i class='bx bx-bar-chart' style="font-size: 1.5rem; margin-right: 10px; color: #6c5ce7;"></i>
                        <div>
                            <h4 style="margin: 0; font-size: 0.9rem;">Laporan</h4>
                            <p style="margin: 0; font-size: 0.8rem; color: #808080;">Analisis penjualan</p>
                        </div>
                    </a>
                    
                    <a href="#" style="display: flex; align-items: center; padding: 15px; background: #f8f9fa; border-radius: 10px; text-decoration: none; color:   #2a2a2a; transition: all 0.3s ease;">
                        <i class='bx bx-cog' style="font-size: 1.5rem; margin-right: 10px; color: #808080;"></i>
                        <div>
                            <h4 style="margin: 0; font-size: 0.9rem;">Pengaturan</h4>
                            <p style="margin: 0; font-size: 0.8rem; color: #808080;">Konfigurasi sistem</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: var(--shadow1);">
                <h3 style="margin-bottom: 20px; color:   #2a2a2a; font-size: 1.3rem; display: flex; align-items: center;">
                    <i class='bx bx-time-five' style="margin-right: 10px; color: var(--green1);"></i>
                    Aktivitas Terbaru
                </h3>
                <div style="max-height: 400px; overflow-y: auto;">
                    <div style="display: flex; align-items: center; padding: 15px 0; border-bottom: 1px solid #f0f0f0;">
                        <div style="width: 40px; height: 40px; background: #e3f2fd; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                            <i class='bx bx-user-plus' style="color: #1976d2; font-size: 1.2rem;"></i>
                        </div>
                        <div style="flex: 1;">
                            <p style="margin: 0; font-size: 0.9rem; color:   #2a2a2a;">User baru mendaftar</p>
                            <p style="margin: 0; font-size: 0.8rem; color: #808080;">2 menit yang lalu</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; padding: 15px 0; border-bottom: 1px solid #f0f0f0;">
                        <div style="width: 40px; height: 40px; background: #e8f5e8; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                            <i class='bx bx-shopping-bag' style="color: #28a745; font-size: 1.2rem;"></i>
                        </div>
                        <div style="flex: 1;">
                            <p style="margin: 0; font-size: 0.9rem; color:   #2a2a2a;">Pembelian baru - Rp 150.000</p>
                            <p style="margin: 0; font-size: 0.8rem; color: #808080;">15 menit yang lalu</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; padding: 15px 0; border-bottom: 1px solid #f0f0f0;">
                        <div style="width: 40px; height: 40px; background: #fff3cd; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                            <i class='bx bx-book-add' style="color: #856404; font-size: 1.2rem;"></i>
                        </div>
                        <div style="flex: 1;">
                            <p style="margin: 0; font-size: 0.9rem; color:   #2a2a2a;">Buku baru ditambahkan</p>
                            <p style="margin: 0; font-size: 0.8rem; color: #808080;">1 jam yang lalu</p>
                        </div>
                    </div>
                    
                    <div style="text-align: center; padding: 20px 0; color: #808080;">
                        <i class='bx bx-info-circle' style="font-size: 2rem; margin-bottom: 10px; opacity: 0.5;"></i>
                        <p>Grafik penjualan dan aktivitas terbaru dapat ditambahkan di sini (Chart.js)</p>
                    </div>
                </div>
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
    
    div[style*="grid-template-columns:repeat(auto-fit, minmax(250px, 1fr))"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection