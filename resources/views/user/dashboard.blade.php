@extends('layouts.app')

@section('title', 'Dashboard User - Econic Book Store')

@section('content')
<div style="padding: 20px; max-width: 1400px; margin: 0 auto;">
    <!-- Welcome Section -->
    <div style="background: linear-gradient(135deg, var(--green1) 0%, var(--green2) 100%); color: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: var(--shadow1);">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
            <div>
                <h1 style="font-size: 2.5rem; margin-bottom: 10px; font-weight: 700;">Selamat datang kembali!</h1>
                <h2 style="font-size: 1.5rem; margin-bottom: 15px; opacity: 0.9;">{{ Auth::user()->name }}</h2>
                <p style="font-size: 1.1rem; opacity: 0.8;">Kelola koleksi buku favorit dan riwayat pembelian Anda</p>
            </div>
            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                    <i class='bx bx-user' style="font-size: 2.5rem;"></i>
                </div>
                <p style="opacity: 0.8;">Member sejak {{ Auth::user()->created_at->format('M Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: var(--shadow1); text-align: center;">
            <div style="color: var(--green1); font-size: 2rem; margin-bottom: 10px;">
                <i class='bx bx-heart'></i>
            </div>
            <h3 style="font-size: 1.5rem; margin-bottom: 5px;">{{ $favoritesCount ?? 0 }}</h3>
            <p style="color: #808080;">Buku Favorit</p>
        </div>
        
        <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: var(--shadow1); text-align: center;">
            <div style="color: var(--orange1); font-size: 2rem; margin-bottom: 10px;">
                <i class='bx bx-shopping-bag'></i>
            </div>
            <h3 style="font-size: 1.5rem; margin-bottom: 5px;">{{ $transactionsCount ?? 0 }}</h3>
            <p style="color: #808080;">Total Pembelian</p>
        </div>
        
        <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: var(--shadow1); text-align: center;">
            <div style="color: var(--green2); font-size: 2rem; margin-bottom: 10px;">
                <i class='bx bx-book-reader'></i>
            </div>
            <h3 style="font-size: 1.5rem; margin-bottom: 5px;">{{ $booksRead ?? 0 }}</h3>
            <p style="color: #808080;">Buku Dibaca</p>
        </div>
        
        <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: var(--shadow1); text-align: center;">
            <div style="color: #6c5ce7; font-size: 2rem; margin-bottom: 10px;">
                <i class='bx bx-star'></i>
            </div>
            <h3 style="font-size: 1.5rem; margin-bottom: 5px;">{{ $reviewsCount ?? 0 }}</h3>
            <p style="color: #808080;">Review Ditulis</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
        <!-- Quick Navigation -->
        <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: var(--shadow1);">
            <h3 style="margin-bottom: 20px; color:  #2a2a2a; font-size: 1.3rem; display: flex; align-items: center;">
                <i class='bx bx-navigation' style="margin-right: 10px; color: var(--green1);"></i>
                Navigasi Cepat
            </h3>
            <div style="display: grid; gap: 15px;">
                <a href="{{ route('shop') }}" style="display: flex; align-items: center; padding: 15px; background: #f8f9fa; border-radius: 10px; text-decoration: none; color:  #2a2a2a; transition: all 0.3s ease;">
                    <i class='bx bx-home' style="font-size: 1.5rem; margin-right: 15px; color: var(--green1);"></i>
                    <div>
                        <h4 style="margin: 0; font-size: 1rem;">Beranda</h4>
                        <p style="margin: 0; font-size: 0.8rem; color: #808080;">Lihat semua buku</p>
                    </div>
                </a>
                
                <a href="{{ route('favorites') }}" style="display: flex; align-items: center; padding: 15px; background: #f8f9fa; border-radius: 10px; text-decoration: none; color:  #2a2a2a; transition: all 0.3s ease;">
                    <i class='bx bx-heart' style="font-size: 1.5rem; margin-right: 15px; color: #ff6b6b;"></i>
                    <div>
                        <h4 style="margin: 0; font-size: 1rem;">Wishlist</h4>
                        <p style="margin: 0; font-size: 0.8rem; color: #808080;">Buku favorit Anda</p>
                    </div>
                </a>
                
                <a href="{{ route('transactions.index') }}" style="display: flex; align-items: center; padding: 15px; background: #f8f9fa; border-radius: 10px; text-decoration: none; color:  #2a2a2a; transition: all 0.3s ease;">
                    <i class='bx bx-receipt' style="font-size: 1.5rem; margin-right: 15px; color: var(--orange1);"></i>
                    <div>
                        <h4 style="margin: 0; font-size: 1rem;">Riwayat Pembelian</h4>
                        <p style="margin: 0; font-size: 0.8rem; color: #808080;">Lihat transaksi</p>
                    </div>
                </a>
                
                <a href="{{ route('cart.index') }}" style="display: flex; align-items: center; padding: 15px; background: #f8f9fa; border-radius: 10px; text-decoration: none; color:  #2a2a2a; transition: all 0.3s ease;">
                    <i class='bx bx-cart' style="font-size: 1.5rem; margin-right: 15px; color: var(--green2);"></i>
                    <div>
                        <h4 style="margin: 0; font-size: 1rem;">Keranjang</h4>
                        <p style="margin: 0; font-size: 0.8rem; color: #808080;">Lanjutkan belanja</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: var(--shadow1);">
            <h3 style="margin-bottom: 20px; color:  #2a2a2a; font-size: 1.3rem; display: flex; align-items: center;">
                <i class='bx bx-time-five' style="margin-right: 10px; color: var(--green1);"></i>
                Aktivitas Terbaru
            </h3>
            <div style="max-height: 300px; overflow-y: auto;">
                @if(isset($recentActivities) && count($recentActivities) > 0)
                    @foreach($recentActivities as $activity)
                    <div style="display: flex; align-items: center; padding: 12px 0; border-bottom: 1px solid #f0f0f0;">
                        <div style="width: 40px; height: 40px; background: {{ $activity['color'] ?? '#f0f0f0' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                            <i class='{{ $activity['icon'] ?? 'bx bx-info-circle' }}' style="color: white; font-size: 1.2rem;"></i>
                        </div>
                        <div style="flex: 1;">
                            <p style="margin: 0; font-size: 0.9rem; color:  #2a2a2a;">{{ $activity['message'] }}</p>
                            <p style="margin: 0; font-size: 0.8rem; color: #808080;">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div style="text-align: center; padding: 40px 0; color: #808080;">
                        <i class='bx bx-info-circle' style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;"></i>
                        <p>Belum ada aktivitas terbaru</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recommended Books -->
    <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: var(--shadow1); margin-bottom: 30px;">
        <h3 style="margin-bottom: 20px; color:  #2a2a2a; font-size: 1.3rem; display: flex; align-items: center;">
            <i class='bx bx-star' style="margin-right: 10px; color: var(--green1);"></i>
            Rekomendasi untuk Anda
        </h3>
        <div class="product-container">
            @foreach($books as $book)
            <div class="product-card">
                <div class="product-image" style="position: relative; height: 300px; overflow: hidden;">
                    @if($book->cover_image)
                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; background-color: #eee; display: flex; align-items: center; justify-content: center; color: #999;">No Image</div>
                    @endif
                    <button class="favorite-btn" style="position: absolute; top: 10px; right: 10px; background: white; border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);" data-book-id="{{ $book->id }}">
                        <i class='bx bx-heart' style="color: #999;"></i>
                    </button>
                </div>
                <div class="product-info" style="padding: 15px;">
                    <span class="author" style="color: #808080; font-size: 0.9rem;">{{ $book->author }}</span>
                    <h3 style="margin: 5px 0; font-size: 1.2rem;">{{ $book->title }}</h3>
                    <div class="rating" style="color: #FFD700; margin: 5px 0;">⭐⭐⭐⭐⭐</div>
                    <div class="price-cart" style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                        <span class="price" style="font-weight: bold; font-size: 1.1rem;">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                        <a href="{{ route('books.show', $book->id) }}" class="btn-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Account Settings -->
    <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: var(--shadow1);">
        <h3 style="margin-bottom: 20px; color:  #2a2a2a; font-size: 1.3rem; display: flex; align-items: center;">
            <i class='bx bx-cog' style="margin-right: 10px; color: var(--green1);"></i>
            Pengaturan Akun
        </h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            <div style="padding: 20px; background: #f8f9fa; border-radius: 10px;">
                <h4 style="margin-bottom: 10px; color:  #2a2a2a;">Profil</h4>
                <p style="color: #808080; margin-bottom: 15px; font-size: 0.9rem;">Kelola informasi profil Anda</p>
                <button style="background: var(--green1); color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer;">Edit Profil</button>
            </div>
            
            <div style="padding: 20px; background: #f8f9fa; border-radius: 10px;">
                <h4 style="margin-bottom: 10px; color:  #2a2a2a;">Keamanan</h4>
                <p style="color: #808080; margin-bottom: 15px; font-size: 0.9rem;">Ubah password dan keamanan</p>
                <button style="background: var(--green1); color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer;">Ubah Password</button>
            </div>
            
            <div style="padding: 20px; background: #f8f9fa; border-radius: 10px;">
                <h4 style="margin-bottom: 10px; color:  #2a2a2a;">Alamat</h4>
                <p style="color: #808080; margin-bottom: 15px; font-size: 0.9rem;">Kelola alamat pengiriman</p>
                <button style="background: var(--green1); color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer;">Kelola Alamat</button>
            </div>
        </div>
    </div>
</div>

<style>
.product-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.product-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
}

@media (max-width: 768px) {
    .product-container {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
    }
    
    div[style*="grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
    
    div[style*="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr))"] {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}
</style>
@endsection