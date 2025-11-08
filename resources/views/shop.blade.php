@extends('layouts.app')

@section('title', 'Shop - Temukan Buku Favorit Anda')

@section('content')
<div class="shop-container" style="padding: 20px; max-width: 1400px; margin: 0 auto; margin-top: 70px;">
    
    <!-- Page Header -->
    <div class="shop-header" style="margin-bottom: 30px;">
        <h1 style="margin-bottom: 10px; color: var(--green4); font-size: 2.5rem;"><i class='bx bxs-book'></i>Econic Buku</h1>
        <p style="color: var(--black); font-size: 1.1rem;">Temukan buku favorit Anda dari koleksi terpilih kami</p>
    </div>

    <!-- Search and Filter Bar -->
    <div class="search-filter-bar" style="background: white; padding: 20px; border-radius: 10px; box-shadow: var(--shadow1); margin-bottom: 30px;">
        <form id="searchForm" method="GET" action="{{ route('shop') }}">
            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 15px; align-items: center;">
                <!-- Search Input -->
                <div class="search-input-group" style="position: relative;">
                    <i class='bx bx-search' style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color:  #2a2a2a; font-size: 1.2rem; z-index: 1;"></i>
                    <input type="text" name="search" id="shopSearchInput" value="{{ request('search') }}" placeholder="Cari buku, penulis, atau genre..." style="width: 100%; padding: 12px 15px 12px 45px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem;">
                    
                    <!-- Authors Panel -->
                    <div id="shopAuthorsPanel" class="authors-panel" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.15); margin-top: 8px; padding: 20px; z-index: 1000; max-height: 400px; overflow-y: auto;">
                        <h4 style="margin: 0 0 15px 0; font-size: 1.1rem; font-weight: 600; color:  #2a2a2a;">Penulis</h4>
                        <div id="shopAuthorsList" class="authors-list" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                            <!-- Authors will be loaded here -->
                        </div>
                        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
                            <h5 style="margin: 0 0 10px 0; font-size: 0.95rem; font-weight: 600; color:  #2a2a2a;">Popular Search:</h5>
                            <div id="shopPopularSearches" style="display: flex; flex-wrap: wrap; gap: 8px;">
                                <!-- Popular searches will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="filter-group">
                    <select name="category" style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; cursor: pointer;" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @php
                            try {
                                $categories = \App\Models\Category::where('is_active', true)->orderBy('name')->get();
                            } catch (\Exception $e) {
                                $categories = collect([]);
                            }
                        @endphp
                        @if($categories->isNotEmpty())
                            @foreach($categories as $category)
                                <option value="{{ $category->name }}" {{ request('category') == $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        @endif
                        {{-- Legacy categories for backward compatibility --}}
                        @if($categories->isEmpty())
                            <option value="Fiksi" {{ request('category') == 'Fiksi' ? 'selected' : '' }}>Fiksi</option>
                            <option value="Non-Fiksi" {{ request('category') == 'Non-Fiksi' ? 'selected' : '' }}>Non-Fiksi</option>
                            <option value="Pendidikan" {{ request('category') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                            <option value="Teknologi" {{ request('category') == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                            <option value="Bisnis" {{ request('category') == 'Bisnis' ? 'selected' : '' }}>Bisnis</option>
                            <option value="Agama" {{ request('category') == 'Agama' ? 'selected' : '' }}>Agama</option>
                            <option value="Anak-anak" {{ request('category') == 'Anak-anak' ? 'selected' : '' }}>Anak-anak</option>
                            <option value="Komik" {{ request('category') == 'Komik' ? 'selected' : '' }}>Komik</option>
                            <option value="Seni" {{ request('category') == 'Seni' ? 'selected' : '' }}>Seni</option>
                            <option value="Kesehatan" {{ request('category') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                            <option value="Kuliner" {{ request('category') == 'Kuliner' ? 'selected' : '' }}>Kuliner</option>
                            <option value="Sastra" {{ request('category') == 'Sastra' ? 'selected' : '' }}>Sastra</option>
                        @endif
                    </select>
                </div>

                <!-- Sort By -->
                <div class="filter-group">
                    <select name="sort" style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; cursor: pointer;" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Terendah</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Tertinggi</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                    </select>
                </div>
            </div>

            <!-- Advanced Filter Button -->
            <div style="margin-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                <button type="button" id="advancedFilterBtn" style="background: none; border: 2px solid var(--green1); color: var(--green1); padding: 8px 15px; border-radius: 8px; cursor: pointer; font-weight: 500;">
                    <i class='bx bx-slider-alt'></i> Filter Lanjutan
                </button>
                @if(request('search') || request('category') || request('sort'))
                    <a href="{{ route('shop') }}" style="color: var(--green1); text-decoration: none; font-weight: 500;">
                        <i class='bx bx-x'></i> Reset Filter
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Advanced Filter Panel (Hidden by default) -->
    <div id="advancedFilterPanel" style="display: none; background: white; padding: 20px; border-radius: 10px; box-shadow: var(--shadow1); margin-bottom: 30px;">
        <form method="GET" action="{{ route('shop') }}">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Format</label>
                    <select name="format" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">Semua Format</option>
                        <option value="digital" {{ request('format') == 'digital' ? 'selected' : '' }}>Digital</option>
                        <option value="print" {{ request('format') == 'print' ? 'selected' : '' }}>Fisik</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Bahasa</label>
                    <select name="language" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">Semua Bahasa</option>
                        <option value="Indonesia" {{ request('language') == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                        <option value="English" {{ request('language') == 'English' ? 'selected' : '' }}>English</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Rating Minimal</label>
                    <select name="rating" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">Semua Rating</option>
                        <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 ⭐</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4+ ⭐</option>
                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3+ ⭐</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Rentang Harga</label>
                    <select name="price_range" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">Semua Harga</option>
                        <option value="0-50000" {{ request('price_range') == '0-50000' ? 'selected' : '' }}>Rp 0 - 50.000</option>
                        <option value="50000-100000" {{ request('price_range') == '50000-100000' ? 'selected' : '' }}>Rp 50.000 - 100.000</option>
                        <option value="100000-200000" {{ request('price_range') == '100000-200000' ? 'selected' : '' }}>Rp 100.000 - 200.000</option>
                        <option value="200000" {{ request('price_range') == '200000' ? 'selected' : '' }}>Rp 200.000+</option>
                    </select>
                </div>
            </div>
            <div style="margin-top: 15px; display: flex; gap: 10px;">
                <button type="submit" style="background: var(--green2); color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: 500;">
                    Terapkan Filter
                </button>
                <a href="{{ route('shop') }}" style="background: #f1f1f1; color:  #2a2a2a; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: 500; text-decoration: none; display: inline-block;">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Results Info -->
    <div style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
        <p style="margin: 0; color:  #2a2a2a; font-size: 0.9rem;">
            Menampilkan <strong>{{ $books->firstItem() ?? 0 }}</strong> - <strong>{{ $books->lastItem() ?? 0 }}</strong> dari <strong>{{ $books->total() }}</strong> buku
            @if(request('search'))
                untuk "<strong>{{ request('search') }}</strong>"
            @endif
        </p>
    </div>

    <!-- Books Grid -->
    <div class="books-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 25px; margin-bottom: 40px;">
        @forelse($books as $book)
            <div class="book-card" style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 5px 20px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">
                <!-- Book Cover -->
                <div class="book-cover" style="position: relative; height: 300px; overflow: hidden; background: #f0f0f0;">
                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='{{ asset('storage/cover_images/default-book.jpg') }}' loading='lazy'">
                    
                    <!-- Category Badge -->
                    @if($book->category_id && $book->category)
                        <span style="position: absolute; top: 10px; left: 10px; background: var(--green2); color: white; padding: 5px 10px; border-radius: 5px; font-size: 0.75rem; font-weight: 600;">{{ $book->category->name }}</span>
                    @elseif($book->category)
                        <span style="position: absolute; top: 10px; left: 10px; background: var(--green2); color: white; padding: 5px 10px; border-radius: 5px; font-size: 0.75rem; font-weight: 600;">{{ $book->category }}</span>
                    @endif

                    <!-- Favorite Button -->
                    <button class="favorite-btn" data-book-id="{{ $book->id }}" style="position: absolute; top: 10px; right: 10px; background: white; border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                        <i class='bx bx-heart' style="font-size: 1.2rem; color: #999;"></i>
                    </button>
                </div>

                <!-- Book Info -->
                <div style="padding: 15px;">
                    <h3 style="margin: 0 0 5px 0; font-size: 1rem; color:  #2a2a2a; line-height: 1.3; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                        <a href="{{ route('books.show', $book->id) }}" style="color: #2a2a2a; text-decoration: none;">{{ $book->title }}</a>
                    </h3>
                    <p style="margin: 0 0 8px 0; color: #2a2a2a; font-size: 0.85rem;">{{ $book->author }}</p>
                    
                    <!-- Rating -->
                    <div style="margin-bottom: 10px; color: #FFD700;">
                        @php
                            $avgRating = \App\Models\Review::where('book_id', $book->id)->avg('rating') ?? 0;
                            $rating = round($avgRating, 1);
                        @endphp
                        {{ str_repeat('⭐', floor($rating)) }}{{ str_repeat('☆', 5 - floor($rating)) }}
                        <span style="color:  #2a2a2a; font-size: 0.8rem;">({{ $rating }})</span>
                    </div>

                    <!-- Price -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <span style="font-size: 1.2rem; font-weight: bold; color: var(--green1);">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                        @if($book->format)
                            <span style="background: #f0f0f0; color:  #2a2a2a; padding: 3px 8px; border-radius: 5px; font-size: 0.75rem;">{{ $book->format }}</span>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('books.show', $book->id) }}" style="flex: 1; background: var(--green2); color: white; padding: 8px; border-radius: 5px; text-align: center; text-decoration: none; font-size: 0.85rem; font-weight: 500; display: flex; align-items: center; justify-content: center;">
                            <i class='bx bx-info-circle' style="margin-right: 5px;"></i> Detail
                        </a>
                        <button class="add-cart-btn" data-book-id="{{ $book->id }}" style="flex: 1; background: var(--green1); color: white; border: none; padding: 8px; border-radius: 5px; cursor: pointer; font-size: 0.85rem; font-weight: 500; display: flex; align-items: center; justify-content: center;">
                            <i class='bx bx-cart-add' style="margin-right: 5px;"></i> Keranjang
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
                <i class='bx bx-book' style="font-size: 4rem; color: #ddd; margin-bottom: 20px;"></i>
                <h3 style="color:  #2a2a2a; margin-bottom: 10px;">Tidak ada buku ditemukan</h3>
                <p style="color: #999; margin-bottom: 20px;">Coba ubah filter atau pencarian Anda</p>
                <a href="{{ route('shop') }}" style="background-color: var(--green2); color: white; padding: 12px 24px; border-radius: 5px; text-decoration: none; display: inline-block;">Reset Filter</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($books->hasPages())
        <div class="pagination-container">
            {{ $books->links() }}
        </div>
    @endif

    <!-- Scroll to Top Button -->
    <button id="scrollToTop" class="scroll-to-top-btn">
        <i class='bx bx-up-arrow-alt'></i>
    </button>
</div>

<style>
    .search-input-group {
        position: relative;
    }

    /* Pagination Container */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-bottom: 40px;
        margin-top: 30px;
    }

    /* Scroll to Top Button */
    .scroll-to-top-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: var(--green2);
        color: white;
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        z-index: 1000;
        transition: all 0.3s ease;
    }

    .scroll-to-top-btn i {
        font-size: 1.5rem;
    }

    .scroll-to-top-btn:hover {
        background: var(--green1);
        transform: translateY(-3px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .search-filter-bar form > div {
            grid-template-columns: 1fr !important;
            gap: 10px !important;
        }

        .books-grid {
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)) !important;
            gap: 15px !important;
        }

        #scrollToTop {
            width: 45px !important;
            height: 45px !important;
            bottom: 20px !important;
            right: 20px !important;
        }
    }

    @media (max-width: 480px) {
        .books-grid {
            grid-template-columns: 1fr !important;
        }

        .shop-header h1 {
            font-size: 1.8rem !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Advanced Filter Toggle
        const advancedFilterBtn = document.getElementById('advancedFilterBtn');
        const advancedFilterPanel = document.getElementById('advancedFilterPanel');
        
        if (advancedFilterBtn && advancedFilterPanel) {
            advancedFilterBtn.addEventListener('click', function() {
                advancedFilterPanel.style.display = advancedFilterPanel.style.display === 'none' ? 'block' : 'none';
            });
        }

        // Scroll to Top Button
        const scrollToTopBtn = document.getElementById('scrollToTop');
        
        window.addEventListener('scroll', function() {
            if (scrollToTopBtn) {
                if (window.pageYOffset > 300) {
                    scrollToTopBtn.style.display = 'flex';
                } else {
                    scrollToTopBtn.style.display = 'none';
                }
            }
        });

        if (scrollToTopBtn) {
            scrollToTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        // Add to Cart functionality
        const addCartBtns = document.querySelectorAll('.add-cart-btn');
        addCartBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const bookId = this.getAttribute('data-book-id');
                const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
                
                if (!isLoggedIn) {
                    showNotification('Silakan login untuk menambahkan ke keranjang', 'error');
                    return;
                }
                
                fetch('/cart/items', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        book_id: bookId,
                        quantity: 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message || 'Produk ditambahkan ke keranjang', 'success');
                        updateCartCount();
                    } else {
                        showNotification(data.error || 'Terjadi kesalahan', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan', 'error');
                });
            });
        });

        // Function to update cart count
        function updateCartCount() {
            const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
            
            if (isLoggedIn) {
                fetch('/cart/count')
                    .then(response => response.json())
                    .then(data => {
                        const cartCountElement = document.querySelector('.cart-count');
                        if (cartCountElement) {
                            cartCountElement.textContent = data.count;
                            cartCountElement.style.display = data.count > 0 ? 'flex' : 'none';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        // Function to show notification
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                border-radius: 5px;
                color: white;
                font-weight: 500;
                z-index: 1000;
                animation: slideIn 0.3s ease;
                max-width: 300px;
                ${type === 'success' ? 'background-color:  #2a2a2a;' : 'background-color: #ff6b6b;'}
            `;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => notification.remove(), 3000);
        }

        // Add CSS animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);

        // Authors Panel Functionality for Shop
        const shopSearchInput = document.getElementById('shopSearchInput');
        const shopAuthorsPanel = document.getElementById('shopAuthorsPanel');
        const shopAuthorsList = document.getElementById('shopAuthorsList');
        const shopPopularSearches = document.getElementById('shopPopularSearches');

        function loadShopAuthors() {
            fetch('/api/authors')
                .then(response => response.json())
                .then(data => {
                    shopAuthorsList.innerHTML = '';
                    if (data.authors && data.authors.length > 0) {
                        data.authors.forEach(author => {
                            const authorItem = document.createElement('div');
                            authorItem.className = 'author-item';
                            authorItem.style.cssText = 'display: flex; align-items: center; gap: 10px; padding: 8px; border-radius: 8px; cursor: pointer; transition: background 0.2s;';
                            authorItem.onmouseover = function() { this.style.background = '#f5f5f5'; };
                            authorItem.onmouseout = function() { this.style.background = 'transparent'; };
                            authorItem.onclick = function() {
                                window.location.href = '{{ route("shop") }}?search=' + encodeURIComponent(author.name);
                            };
                            
                            const img = document.createElement('img');
                            img.src = author.image ? '{{ asset("storage/cover_images/") }}/' + author.image : '{{ asset("storage/cover_images/default-book.jpg") }}';
                            img.alt = author.name;
                            img.style.cssText = 'width: 40px; height: 40px; border-radius: 50%; object-fit: cover;';
                            
                            const name = document.createElement('span');
                            name.textContent = author.name;
                            name.style.cssText = 'color: #2a2a2a; font-size: 0.9rem;';
                            
                            authorItem.appendChild(img);
                            authorItem.appendChild(name);
                            shopAuthorsList.appendChild(authorItem);
                        });
                    }
                })
                .catch(error => console.error('Error loading authors:', error));
        }

        function loadShopPopularSearches() {
            fetch('/api/popular-searches')
                .then(response => response.json())
                .then(data => {
                    shopPopularSearches.innerHTML = '';
                    if (data.categories && data.categories.length > 0) {
                        data.categories.forEach((category) => {
                            const link = document.createElement('a');
                            link.href = '{{ route("shop") }}?category=' + encodeURIComponent(category);
                            link.textContent = category;
                            link.style.cssText = 'color: var(--green1); text-decoration: none; padding: 4px 8px; border: 1px solid var(--green1); border-radius: 4px; font-size: 0.85rem; transition: all 0.2s;';
                            link.onmouseover = function() { 
                                this.style.background = 'var(--green1)'; 
                                this.style.color = 'white'; 
                            };
                            link.onmouseout = function() { 
                                this.style.background = 'transparent'; 
                                this.style.color = 'var(--green1)'; 
                            };
                            shopPopularSearches.appendChild(link);
                        });
                    }
                })
                .catch(error => console.error('Error loading popular searches:', error));
        }

        if (shopSearchInput) {
            shopSearchInput.addEventListener('focus', function() {
                shopAuthorsPanel.style.display = 'block';
                loadShopAuthors();
                loadShopPopularSearches();
            });

            shopSearchInput.addEventListener('blur', function(e) {
                setTimeout(() => {
                    if (!shopAuthorsPanel.contains(e.relatedTarget)) {
                        shopAuthorsPanel.style.display = 'none';
                    }
                }, 200);
            });
        }
    });
</script>
@endsection
