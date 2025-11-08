@extends('layouts.app')

@section('title', 'Econic Book Store')

@section('content')
    <section class="hero hero-slider" style="height: 85vh; position: relative; overflow: hidden;">
        <div class="slides">
            <div class="slide"
                style="background-image: url('https://images.unsplash.com/photo-1516979187457-637abb4f9353?q=80&w=1600&auto=format&fit=crop');">
            </div>
            <div class="slide"
                style="background-image: url('https://images.unsplash.com/photo-1519682337058-a94d519337bc?q=80&w=1600&auto=format&fit=crop');">
            </div>
            <div class="slide"
                style="background-image: url('https://images.unsplash.com/photo-1495446815901-a7297e633e8d?q=80&w=1600&auto=format&fit=crop');">
            </div>
        </div>
        <div class="overlay" style="position:absolute;inset:0;background:rgba(0,0,0,.25);"></div>
        <div class="hero-content"
            style="position: relative; z-index: 2; padding: 100px 50px; color: #fafdff; max-width: 1200px; margin: 0 auto;">
            <h1 style="font-size: 3rem; margin-bottom: 16px; line-height: 1.1;">Discover Your Next Favorite Book</h1>
            <p style="max-width: 640px; color: #e9f5ec; margin-bottom: 24px;">Koleksi buku terkurasi dengan pengalaman
                berbelanja yang cepat, aman, dan nyaman.</p>
            <div class="search-wrapper" style="position: relative; max-width: 720px;">
                <form action="{{ route('shop') }}" method="GET" class="bar-search" id="heroSearch"
                    style="display:flex;background:rgba(255,255,255,0.9);border-radius:12px;overflow:hidden;position:relative;">
                    <i class='bx bx-search' style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: #2a2a2a; font-size: 1.2rem; z-index: 1;"></i>
                    <input type="text" name="search" id="heroSearchInput" placeholder="Cari buku, penulis, atau genre..."
                        style="flex:1;padding:14px 16px 14px 50px;border:none;outline:none;color:var(--black);background:transparent">
                    <button class="search-btn" type="submit"
                        style="padding: 14px 22px; background: var(--green2); color: white; border: none; cursor: pointer; font-weight:600;">Search</button>
                </form>
                
                <!-- Authors Panel -->
                <div id="authorsPanel" class="authors-panel" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.15); margin-top: 8px; padding: 20px; z-index: 1000; max-height: 400px; overflow-y: auto;">
                    <h4 style="margin: 0 0 15px 0; font-size: 1.1rem; font-weight: 600; color: #2a2a2a;">Penulis</h4>
                    <div id="authorsList" class="authors-list" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                        <!-- Authors will be loaded here -->
                    </div>
                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
                        <h5 style="margin: 0 0 10px 0; font-size: 0.95rem; font-weight: 600; color: #2a2a2a;">Popular Search:</h5>
                        <div id="popularSearches" style="display: flex; flex-wrap: wrap; gap: 8px;">
                            <!-- Popular searches will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <button class="slider-nav prev" aria-label="Previous"
            style="position:absolute;left:24px;top:50%;transform:translateY(-50%);z-index:3;background:var(--whitecream);border:none;border-radius:50%;width:44px;height:44px;display:flex;align-items:center;justify-content:center;cursor:pointer;">
            <i class='bx bx-chevron-left' style="font-size:24px;color:var(--green1)"></i>
        </button>
        <button class="slider-nav next" aria-label="Next"
            style="position:absolute;right:24px;top:50%;transform:translateY(-50%);z-index:3;background:var(--whitecream);border:none;border-radius:50%;width:44px;height:44px;display:flex;align-items:center;justify-content:center;cursor:pointer;">
            <i class='bx bx-chevron-right' style="font-size:24px;color:var(--green1)"></i>
        </button> -->
    </section>

    <section class="feature" style="background-color: var(--black); padding: 30px 0; color: white;">
        <div class="feature-container"
            style="display: flex; justify-content: space-around; max-width: 1200px; margin: 0 auto; flex-wrap: wrap;">
            <div class="feature-card" style="text-align: center; padding: 20px; width: 250px;">
                <div class="icon" style="font-size: 2.5rem; margin-bottom: 10px;"><i class='bx bx-book-reader'
                        style="color: var(--green2);"></i></div>
                <p>Wide Selection of Books</p>
            </div>
            <div class="feature-card" style="text-align: center; padding: 20px; width: 250px;">
                <div class="icon" style="font-size: 2.5rem; margin-bottom: 10px;"><i class='bx bx-package'
                        style="color: var(--green2);"></i></div>
                <p>Fast & Secure Delivery</p>
            </div>
            <div class="feature-card" style="text-align: center; padding: 20px; width: 250px;">
                <div class="icon" style="font-size: 2.5rem; margin-bottom: 10px;"><i class='bx bxs-discount'
                        style="color: var(--green2);"></i></div>
                <p>Special Discounts</p>
            </div>
            <div class="feature-card" style="text-align: center; padding: 20px; width: 250px;">
                <div class="icon" style="font-size: 2.5rem; margin-bottom: 10px;"><i class='bx bx-support'
                        style="color: var(--green2);"></i></div>
                <p>24/7 Customer Support</p>
            </div>
        </div>
    </section>

    <section id="product1" style="padding: 60px 0; background-color: var(--white);">
        <h2 style="text-align: center; margin-bottom: 8px; font-size: 2rem; color: var(--black);">Produk Terpopuler</h2>
        <p style="text-align: center; margin-bottom: 28px; color: #808080;">Pilihan terbaik untuk Anda, terinspirasi dari tren
            pembaca</p>
        @php
            $topBooks = isset($popularBooks) && $popularBooks->count() ? $popularBooks : ($books ?? collect());
            $topBooks = $topBooks->take(4);
        @endphp
        <div class="books-grid"
            style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 25px; max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            @foreach ($topBooks as $book)
                <div class="book-card"
                    style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer;"
                    onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 5px 20px rgba(0,0,0,0.15)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">
                    <div class="book-cover" style="position: relative; height: 300px; overflow: hidden; background: #f0f0f0;">
                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}"
                            style="width: 100%; height: 100%; object-fit: cover;"
                            onerror="this.src='{{ asset('storage/cover_images/default-book.jpg') }}'" loading="lazy">
                        <button class="favorite-btn" data-book-id="{{ $book->id }}"
                            style="position: absolute; top: 10px; right: 10px; background: white; border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                            <i class='bx bx-heart' style="font-size: 1.2rem; color: #999;"></i>
                        </button>
                    </div>
                    <div style="padding: 15px;">
                        <h3
                            style="margin: 0 0 5px 0; font-size: 1rem; color: var(--black); line-height: 1.3; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                            <a href="{{ route('books.show', $book->id) }}"
                                style="color: var(--black); text-decoration: none;">{{ $book->title }}</a>
                        </h3>
                        <p style="margin: 0 0 8px 0; color: #808080; font-size: 0.85rem;">{{ $book->author }}</p>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span style="font-size: 1.1rem; font-weight: bold; color: var(--green1);">Rp
                                {{ number_format($book->price, 0, ',', '.') }}</span>
                        </div>
                        <div style="display:flex;gap:8px;">
                            <a href="{{ route('books.show', $book->id) }}"
                                style="flex: 1; background: var(--green2); color: white; padding: 8px; border-radius: 5px; text-align: center; text-decoration: none; font-size: 0.85rem; font-weight: 500; display: flex; align-items: center; justify-content: center;">
                                <i class='bx bx-info-circle' style="margin-right: 5px;"></i> Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div style="text-align:center; margin-top: 24px;">
            <a href="{{ route('shop') }}" class="btn-primary"
                style="background: var(--green2); color: #fff; padding: 10px 18px; border-radius: 8px; display:inline-block;">Lihat
                Semua</a>
        </div>
    </section>
    <script>
        (function () {
            const slides = document.querySelectorAll('.hero-slider .slide');
            const prev = document.querySelector('.hero-slider .prev');
            const next = document.querySelector('.hero-slider .next');
            let index = 0;
            function update() {
                slides.forEach((s, i) => {
                    s.style.opacity = i === index ? '1' : '0';
                    s.style.transform = i === index ? 'scale(1.02)' : 'scale(1)';
                });
            }
            function go(n) { index = (n + slides.length) % slides.length; update(); }
            if (prev && next) {
                prev.addEventListener('click', () => go(index - 1));
                next.addEventListener('click', () => go(index + 1));
            }
            update();
            setInterval(() => go(index + 1), 6000);
        })();

        // Authors Panel Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('heroSearchInput');
            const authorsPanel = document.getElementById('authorsPanel');
            const authorsList = document.getElementById('authorsList');
            const popularSearches = document.getElementById('popularSearches');

            // Load authors
            function loadAuthors() {
                fetch('/api/authors')
                    .then(response => response.json())
                    .then(data => {
                        authorsList.innerHTML = '';
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
                                authorsList.appendChild(authorItem);
                            });
                        }
                    })
                    .catch(error => console.error('Error loading authors:', error));
            }

            // Load popular searches
            function loadPopularSearches() {
                fetch('/api/popular-searches')
                    .then(response => response.json())
                    .then(data => {
                        popularSearches.innerHTML = '';
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
                                popularSearches.appendChild(link);
                            });
                        }
                    })
                    .catch(error => console.error('Error loading popular searches:', error));
            }

            // Show/hide authors panel
            if (searchInput) {
                searchInput.addEventListener('focus', function() {
                    authorsPanel.style.display = 'block';
                    loadAuthors();
                    loadPopularSearches();
                });

                searchInput.addEventListener('blur', function(e) {
                    // Delay to allow click on author items
                    setTimeout(() => {
                        if (!authorsPanel.contains(e.relatedTarget)) {
                            authorsPanel.style.display = 'none';
                        }
                    }, 200);
                });
            }
        });
    </script>
@endsection