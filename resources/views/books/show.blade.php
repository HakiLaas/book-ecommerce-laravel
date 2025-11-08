@extends('layouts.app')

@section('title', $book->title)

@section('content')
<div class="product-detail-container" style="padding: 20px; max-width: 1200px; margin: 0 auto;">
    <!-- Breadcrumb Navigation -->
    <div class="breadcrumb" style="margin-bottom: 20px; font-size: 0.9rem; color: #808080;">
        <a href="{{ url('/') }}" style="color: var(--green1);">Home</a> &gt; 
        <a href="{{ route('home') }}" style="color: var(--green1);">Shop</a> &gt; 
        <span>{{ $book->title }}</span>
    </div>

    <!-- Main Product Detail Section -->
    <div class="product-detail-main" style="display: flex; flex-wrap: wrap; background: white; border-radius: 10px; box-shadow: var(--shadow1); overflow: hidden; margin-bottom: 30px;">
        <!-- Product Image Section -->
        <div class="product-image-container" style="flex: 1; min-width: 300px; position: relative;">
            @if($book->cover_image)
                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" style="width: 100%; height: 100%; object-fit: cover; max-height: 500px;" onerror="this.src='{{ asset('storage/cover_images/default-book.jpg') }}'">
                <div class="image-overlay" style="position: absolute; top: 10px; right: 10px;">
                    <button class="favorite-btn" data-book-id="{{ $book->id }}" style="background: white; border: none; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2); margin-bottom: 10px;">
                        <i class='bx bx-heart' style="font-size: 1.5rem; color: #ff6b6b;"></i>
                    </button>
                    <button class="share-btn" style="background: white; border: none; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                        <i class='bx bx-share-alt' style="font-size: 1.5rem; color: var(--green1);"></i>
                    </button>
                </div>
            @else
                <img src="{{ asset('storage/cover_images/default-book.jpg') }}" alt="{{ $book->title }}" style="width: 100%; height: 100%; object-fit: cover; max-height: 500px;">
            @endif
        </div>

        <!-- Product Info Section -->
        <div class="product-info-container" style="flex: 1; min-width: 300px; padding: 30px;">
            <h1 style="margin-bottom: 10px; color:  #2a2a2a; font-size: 2rem;">{{ $book->title }}</h1>
            <p style="color: #808080; margin-bottom: 10px; font-size: 1.1rem;">By: <span style="color: var(--green1);">{{ $book->author }}</span></p>
            
            <div class="rating-container" style="display: flex; align-items: center; margin: 15px 0;">
                @php
                    $bookAvgRating = isset($avgRating) ? $avgRating : 0;
                    $bookReviewCount = isset($reviewCount) ? $reviewCount : 0;
                    $bookRounded = (int) round($bookAvgRating);
                @endphp
                <div style="color: #FFD700; margin-right: 10px;">{{ str_repeat('⭐', $bookRounded) }}{{ str_repeat('☆', max(5 - $bookRounded, 0)) }}</div>
                <span style="color: #808080;">({{ number_format($bookAvgRating, 1) }}/5 - {{ $bookReviewCount }} reviews)</span>
            </div>
            
            <div class="product-price" style="margin: 20px 0;">
                <p style="font-size: 1.5rem; font-weight: bold; color: var(--green1);">Rp {{ number_format($book->price, 0, ',', '.') }}</p>
                <span style="display: inline-block; background-color: #e6f7e6; color: var(--green2); padding: 5px 10px; border-radius: 5px; font-size: 0.9rem; margin-top: 5px;">In Stock</span>
            </div>
            
            <div class="product-short-desc" style="margin: 20px 0; padding: 15px; background-color: #f9f9f9; border-radius: 5px;">
                <p style="line-height: 1.6; color: #555; font-size: 0.95rem;">{{ \Illuminate\Support\Str::limit($book->description ?? '', 150) }}</p>
            </div>
            
            <form id="addToCartForm" class="add-to-cart-form" style="margin-top: 30px;">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <input type="hidden" name="book_title" value="{{ $book->title }}">
                <input type="hidden" name="book_price" value="{{ $book->price }}">
                <input type="hidden" name="book_image" value="{{ $book->cover_image }}">
                
                <div style="margin-bottom: 20px;">
                    <label for="quantity" style="display: block; margin-bottom: 8px; font-weight: 500; color: #2a2a2a;">Quantity:</label>
                    <div style="display: flex; align-items: center;">
                        <button type="button" class="qty-btn minus" style="width: 40px; height: 40px; background: #f1f1f1; border: 1px solid #ddd; border-radius: 5px 0 0 5px; cursor: pointer;">-</button>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" style="width: 60px; height: 40px; padding: 0 10px; border: 1px solid #ddd; border-left: none; border-right: none; text-align: center; background-color: white;">
                        <button type="button" class="qty-btn plus" style="width: 40px; height: 40px; background: #f1f1f1; border: 1px solid #ddd; border-radius: 0 5px 5px 0; cursor: pointer;">+</button>
                    </div>
                </div>
                
                <div class="action-buttons" style="display: flex; gap: 10px;">
                    <button type="submit" class="add-to-cart-btn" style="flex: 2; background-color: var(--green2); color: white; border: none; padding: 12px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; display: flex; align-items: center; justify-content: center;">
                        <i class='bx bx-cart-add' style="font-size: 1.2rem; margin-right: 8px;"></i> Tambah ke Keranjang
                    </button>
                    <button type="button" class="buy-now-btn" style="flex: 2; background-color: var(--green1); color: white; border: none; padding: 12px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; display: flex; align-items: center; justify-content: center;">
                        <i class='bx bxl-whatsapp' style="font-size: 1.2rem; margin-right: 8px;"></i> Beli via WhatsApp
                    </button>
                </div>
            </form>
            
            <!-- Success Alert (Hidden by default) -->
            <div class="alert-success" id="addToCartSuccess" style="display: none; margin-top: 15px; padding: 10px; background-color: #d4edda; color: #155724; border-radius: 5px; border: 1px solid #c3e6cb;">
                <i class='bx bx-check-circle' style="margin-right: 8px;"></i> Produk berhasil ditambahkan ke keranjang!
            </div>
            
            <div class="product-meta" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                <p style="margin-bottom: 10px; font-size: 0.9rem; color: #808080;">
                    <span style="font-weight: 500;">Category:</span> 
                    <a href="#" style="color: var(--green1); text-decoration: none;">
                        @if($book->category_id && $book->category)
                            {{ $book->category->name }}
                        @elseif($book->category)
                            {{ $book->category }}
                        @else
                            N/A
                        @endif
                    </a>
                </p>
                <p style="margin-bottom: 10px; font-size: 0.9rem; color: #808080;">
                    <span style="font-weight: 500;">Tags:</span>
                    @if($book->tags)
                        @php
                            $tags = explode(',', $book->tags);
                        @endphp
                        @foreach($tags as $tag)
                            <a href="#" style="color: var(--green1); text-decoration: none;">{{ trim($tag) }}</a>@if(!$loop->last), @endif
                        @endforeach
                    @else
                        <span>-</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Product Description & Reviews Tabs -->
    <div class="product-tabs" style="background: white; border-radius: 10px; box-shadow: var(--shadow1); overflow: hidden; margin-bottom: 30px;">
        <div class="tabs-header" style="display: flex; border-bottom: 1px solid #eee;">
            <button class="tab-btn active" data-tab="description" style="flex: 1; padding: 15px; background: none; border: none; cursor: pointer; font-weight: 500; color: var(--green1); border-bottom: 2px solid var(--green1);">Description</button>
            <button class="tab-btn" data-tab="reviews" style="flex: 1; padding: 15px; background: none; border: none; cursor: pointer; font-weight: 500; color: #808080;">Reviews ({{ $reviewCount ?? 0 }})</button>
        </div>
        
        <div class="tab-content">
            <div id="description-tab" class="tab-pane active" style="padding: 30px;">
                <h3 style="margin-bottom: 15px; color:  #2a2a2a;">Product Description</h3>
                <p style="line-height: 1.8; color: #333;">{{ $book->description ?? 'Tidak ada deskripsi tersedia.' }}</p>
                
                <div class="book-details" style="margin-top: 30px; display: flex; flex-wrap: wrap;">
                    <div class="detail-item" style="flex: 1; min-width: 200px; margin-bottom: 20px;">
                        <h4 style="margin-bottom: 10px; color:  #2a2a2a;">Book Details</h4>
                        <ul style="list-style: none; padding: 0;">
                            <li style="margin-bottom: 8px; display: flex;"><span style="font-weight: 500; width: 120px;">Format:</span> {{ $book->format ?? '-' }}</li>
                            <li style="margin-bottom: 8px; display: flex;"><span style="font-weight: 500; width: 120px;">Pages:</span> {{ $book->pages ?? '-' }}</li>
                            <li style="margin-bottom: 8px; display: flex;"><span style="font-weight: 500; width: 120px;">Dimensions:</span> {{ $book->dimensions ?? '-' }}</li>
                            <li style="margin-bottom: 8px; display: flex;"><span style="font-weight: 500; width: 120px;">Language:</span> {{ $book->language ?? '-' }}</li>
                            <li style="margin-bottom: 8px; display: flex;"><span style="font-weight: 500; width: 120px;">Publisher:</span> {{ $book->publisher ?? '-' }}</li>
                        </ul>
                    </div>
                    
                    <div class="detail-item" style="flex: 1; min-width: 200px; margin-bottom: 20px;">
                        <h4 style="margin-bottom: 10px; color:  #2a2a2a;">Author Information</h4>
                        <p style="line-height: 1.6; color: #333;">{{ $book->author_info ?? ($book->author . ' - author info not provided') }}</p>
                    </div>
                </div>
            </div>
            
            <div id="reviews-tab" class="tab-pane" style="padding: 30px; display: none;">
                <div class="reviews-summary" style="display: flex; flex-wrap: wrap; margin-bottom: 30px;">
                    <div class="rating-summary" style="flex: 1; min-width: 200px; margin-bottom: 20px;">
                        <h3 style="margin-bottom: 15px; color:  #2a2a2a;">Ulasan Pelanggan</h3>
                        <div style="display: flex; align-items: center; margin-bottom: 10px;">
                            <span style="font-size: 3rem; font-weight: bold; margin-right: 15px; color: #2a2a2a;">{{ isset($avgRating) ? number_format($avgRating, 1) : '0.0' }}</span>
                            <div>
                                @php
                                    $rounded = isset($avgRating) ? (int) round($avgRating) : 0;
                                @endphp
                                <div style="color: #FFD700;">{{ str_repeat('⭐', $rounded) }}{{ str_repeat('☆', max(5 - $rounded, 0)) }}</div>
                                <p style="margin-top: 5px; color: #2a2a2a;;">Berdasarkan {{ isset($reviewCount) ? $reviewCount : 0 }} ulasan</p>
                            </div>
                        </div>
                        
                        <div class="rating-bars">
                            @php
                                $totalReviews = isset($reviewCount) ? (int)$reviewCount : 0;
                                $ratingCounts = [];
                                $ratingBarsHtml = '';
                                
                                if ($totalReviews > 0) {
                                    for ($i = 5; $i >= 1; $i--) {
                                        $ratingCounts[$i] = \App\Models\Review::where('book_id', $book->id)
                                            ->where('rating', $i)
                                            ->where('status', 'approved')
                                            ->count();
                                    }
                                    
                                    // Generate rating bars HTML
                                    for ($i = 5; $i >= 1; $i--) {
                                        $count = isset($ratingCounts[$i]) ? (int)$ratingCounts[$i] : 0;
                                        $percentage = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
                                        $ratingBarsHtml .= '<div class="rating-bar" style="display: flex; align-items: center; margin-bottom: 8px;">';
                                        $ratingBarsHtml .= '<span style="width: 30px;">' . $i . '★</span>';
                                        $ratingBarsHtml .= '<div style="flex: 1; height: 8px; background: #eee; border-radius: 4px; margin: 0 10px; overflow: hidden;">';
                                        $ratingBarsHtml .= '<div style="width: ' . $percentage . '%; height: 100%; background: var(--green2);"></div>';
                                        $ratingBarsHtml .= '</div>';
                                        $ratingBarsHtml .= '<span style="width: 30px;">' . $percentage . '%</span>';
                                        $ratingBarsHtml .= '</div>';
                                    }
                                }
                            @endphp
                            @if(isset($reviewCount) && $reviewCount > 0 && !empty($ratingBarsHtml))
                                {!! $ratingBarsHtml !!}
                            @else
                                <p style=" color: #2a2a2a; font-style: italic;">Belum ada rating untuk buku ini</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="write-review" style="flex: 1; min-width: 300px; margin-bottom: 20px; padding-left: 20px;">
                        <h3 style="margin-bottom: 15px; color:  #2a2a2a;">Tulis Review</h3>
                        @auth
                        <form action="{{ route('reviews.store', ['id' => $book->id]) }}" method="POST" style="display: grid; gap: 10px;">
                            @csrf
                            <label style="font-weight: 500;">Rating (1-5)</label>
                            <select name="rating" required style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                                @for($r=1;$r<=5;$r++)
                                    <option value="{{ $r }}">{{ $r }}</option>
                                @endfor
                            </select>
                            <label style="font-weight: 500;">Komentar</label>
                            <textarea name="comment" rows="4" placeholder="Tulis pengalaman anda..." style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;"></textarea>
                            <button type="submit" style="background-color: var(--green1); color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: 500;">Kirim Review</button>
                            <small style="color:#005E39;">Catatan: Review dapat melalui moderasi otomatis.</small>
                        </form>
                        @else
                            <p style="margin-bottom: 15px; color: #808080;">Silakan <a href="{{ route('user.login') }}" style="color: var(--green1);">login</a> untuk menulis review.</p>
                        @endauth
                    </div>
                </div>
                
                <div class="reviews-list">
                    <h3 style="margin-bottom: 20px; color:  #2a2a2a;">Recent Reviews</h3>

                    @forelse($reviews as $rev)
                        <div class="review-item" style="margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid #eee;">
                            <div class="review-header" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <div class="reviewer-info" style="display: flex; align-items: center;">
                                    <div class="avatar" style="width: 40px; height: 40px; border-radius: 50%; background-color: var(--green1); color: white; display: flex; align-items: center; justify-content: center; margin-right: 10px; font-weight: bold;">{{ strtoupper(substr($rev->user->name ?? 'U',0,1)) }}</div>
                                    <div>
                                        <h4 style="margin: 0; color:  #2a2a2a;">{{ $rev->user->name ?? 'Unknown' }}</h4>
                                        @if(in_array($rev->user_id, $verifiedBuyerIds ?? []))
                                            <p style="margin: 0; font-size: 0.8rem; color: #808080;">Verified Buyer</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="review-date" style="color: #808080; font-size: 0.9rem;">{{ $rev->created_at->format('M d, Y') }}</div>
                            </div>
                            <div style="color: #FFD700; margin-bottom: 10px;">
                                @for($s=1;$s<=5;$s++)
                                    {!! $s <= $rev->rating ? '⭐' : '☆' !!}
                                @endfor
                            </div>
                            <p style="line-height: 1.6; color: #333;">{{ $rev->comment }}</p>

                            <div style="display:flex; gap:10px; align-items:center; color:#005E39;">
                                <span>Status: {{ ucfirst($rev->status) }}</span>
                                @if($rev->sentiment)
                                    <span>• Sentiment: {{ ucfirst($rev->sentiment) }}</span>
                                @endif
                                <form action="{{ route('reviews.report',$rev->id) }}" method="POST" style="margin-left:auto;">
                                    @csrf
                                    <button type="submit" style="background:none;border:1px solid #e74c3c;color:#e74c3c;padding:6px 10px;border-radius:5px;cursor:pointer;">Report</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p style="color:#005E39;">Belum ada review untuk buku ini.</p>
                    @endforelse

                    <div style="margin-top: 20px; display:flex; justify-content: space-between; align-items:center;">
                        <div>
                            <form method="GET" action="{{ route('books.show',$book->id) }}" style="display:flex; gap:8px; align-items:center;">
                                <label for="ratingFilter" style="color:#005E39;">Filter rating</label>
                                <select id="ratingFilter" name="rating" onchange="this.form.submit()" style="padding:6px;border:1px solid #ccc;border-radius:5px;">
                                    <option value="">All</option>
                                    @for($r=5;$r>=1;$r--)
                                        <option value="{{ $r }}" {{ (request('rating')==$r)?'selected':'' }}>{{ $r }}★</option>
                                    @endfor
                                </select>
                            </form>
                        </div>
                        <div>
                            {{ $reviews->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products Section -->
    <div class="related-products">
        <h2 style="margin-bottom: 20px; color:  #2a2a2a;">You May Also Like</h2>
        <div class="product-container" style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 30px;">
            <!-- Related Product 1 -->
            <!-- <div class="product-card" style="flex: 1; min-width: 250px; max-width: 280px; background: white; border-radius: 10px; box-shadow: var(--shadow1); overflow: hidden; transition: transform 0.3s ease;">
                <div class="product-image" style="position: relative; height: 250px; overflow: hidden;">
                    <img src="{{ asset('storage/cover_images/default-book.jpg') }}" alt="Related Book" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                    <button class="favorite-btn" style="position: absolute; top: 10px; right: 10px; background: white; border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                        <i class='bx bx-heart' style="font-size: 1.2rem; color: #ff6b6b;"></i>
                    </button>
                </div>
                <div class="product-info" style="padding: 15px;">
                    <span class="author" style="color: #808080; font-size: 0.9rem;">Jane Austen</span>
                    <h3 style="margin: 5px 0; font-size: 1.2rem;">Pride and Prejudice</h3>
                    <div class="rating" style="color: #FFD700; margin: 5px 0;">⭐⭐⭐⭐⭐</div>
                    <div class="price-cart" style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                        <span class="price" style="font-weight: bold; font-size: 1.1rem;">Rp 150.000</span>
                        <a href="#" class="btn-primary" style="background-color: var(--green2); color: white; padding: 8px 12px; border-radius: 5px; font-size: 0.9rem; text-decoration: none;">View Details</a>
                    </div>
                </div>
            </div>
            
            Related Product 2
            <div class="product-card" style="flex: 1; min-width: 250px; max-width: 280px; background: white; border-radius: 10px; box-shadow: var(--shadow1); overflow: hidden; transition: transform 0.3s ease;">
                <div class="product-image" style="position: relative; height: 250px; overflow: hidden;">
                    <img src="{{ asset('storage/cover_images/default-book.jpg') }}" alt="Related Book" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                    <button class="favorite-btn" style="position: absolute; top: 10px; right: 10px; background: white; border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                        <i class='bx bx-heart' style="font-size: 1.2rem; color: #ff6b6b;"></i>
                    </button>
                </div>
                <div class="product-info" style="padding: 15px;">
                    <span class="author" style="color: #808080; font-size: 0.9rem;">F. Scott Fitzgerald</span>
                    <h3 style="margin: 5px 0; font-size: 1.2rem;">The Great Gatsby</h3>
                    <div class="rating" style="color: #FFD700; margin: 5px 0;">⭐⭐⭐⭐⭐</div>
                    <div class="price-cart" style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                        <span class="price" style="font-weight: bold; font-size: 1.1rem;">Rp 145.000</span>
                        <a href="#" class="btn-primary" style="background-color: var(--green2); color: white; padding: 8px 12px; border-radius: 5px; font-size: 0.9rem; text-decoration: none;">View Details</a>
                    </div>
                </div>
            </div>
            
            Related Product 3
            <div class="product-card" style="flex: 1; min-width: 250px; max-width: 280px; background: white; border-radius: 10px; box-shadow: var(--shadow1); overflow: hidden; transition: transform 0.3s ease;">
                <div class="product-image" style="position: relative; height: 250px; overflow: hidden;">
                    <img src="{{ asset('storage/cover_images/default-book.jpg') }}" alt="Related Book" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                    <button class="favorite-btn" style="position: absolute; top: 10px; right: 10px; background: white; border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                        <i class='bx bx-heart' style="font-size: 1.2rem; color: #ff6b6b;"></i>
                    </button>
                </div>
                <div class="product-info" style="padding: 15px;">
                    <span class="author" style="color: #808080; font-size: 0.9rem;">George Orwell</span>
                    <h3 style="margin: 5px 0; font-size: 1.2rem;">1984</h3>
                    <div class="rating" style="color: #FFD700; margin: 5px 0;">⭐⭐⭐⭐⭐</div>
                    <div class="price-cart" style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                        <span class="price" style="font-weight: bold; font-size: 1.1rem;">Rp 135.000</span>
                        <a href="#" class="btn-primary" style="background-color: var(--green2); color: white; padding: 8px 12px; border-radius: 5px; font-size: 0.9rem; text-decoration: none;">View Details</a>
                    </div>
                </div>
            </div>
            
            Related Product 4
            <div class="product-card" style="flex: 1; min-width: 250px; max-width: 280px; background: white; border-radius: 10px; box-shadow: var(--shadow1); overflow: hidden; transition: transform 0.3s ease;">
                <div class="product-image" style="position: relative; height: 250px; overflow: hidden;">
                    <img src="{{ asset('storage/cover_images/default-book.jpg') }}" alt="Related Book" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                    <button class="favorite-btn" style="position: absolute; top: 10px; right: 10px; background: white; border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                        <i class='bx bx-heart' style="font-size: 1.2rem; color: #ff6b6b;"></i>
                    </button>
                </div>
                <div class="product-info" style="padding: 15px;">
                    <span class="author" style="color: #808080; font-size: 0.9rem;">J.K. Rowling</span>
                    <h3 style="margin: 5px 0; font-size: 1.2rem;">Harry Potter</h3>
                    <div class="rating" style="color: #FFD700; margin: 5px 0;">⭐⭐⭐⭐⭐</div>
                    <div class="price-cart" style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                        <span class="price" style="font-weight: bold; font-size: 1.1rem;">Rp 160.000</span>
                        <a href="#" class="btn-primary" style="background-color: var(--green2); color: white; padding: 8px 12px; border-radius: 5px; font-size: 0.9rem; text-decoration: none;">View Details</a>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity buttons functionality
        const minusBtn = document.querySelector('.qty-btn.minus');
        const plusBtn = document.querySelector('.qty-btn.plus');
        const quantityInput = document.querySelector('#quantity');
        
        minusBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });
        
        plusBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
        });
        
        // Tab switching functionality
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');
        
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                
                // Remove active class from all buttons and panes
                tabBtns.forEach(btn => btn.classList.remove('active'));
                tabPanes.forEach(pane => pane.classList.remove('active'));
                
                // Add active class to current button and pane
                this.classList.add('active');
                document.getElementById(`${tabId}-tab`).classList.add('active');
                
                // Show current pane and hide others
                tabPanes.forEach(pane => {
                    pane.style.display = 'none';
                });
                document.getElementById(`${tabId}-tab`).style.display = 'block';
            });
        });
        
        // Add to Cart functionality
        const addToCartForm = document.getElementById('addToCartForm');
        const addToCartSuccess = document.getElementById('addToCartSuccess');
        const buyNowBtn = document.querySelector('.buy-now-btn');
        
        addToCartForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const bookId = this.querySelector('input[name="book_id"]').value;
            const quantity = this.querySelector('input[name="quantity"]').value;
            
            // Check if user is logged in
            const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
            
            if (!isLoggedIn) {
                showNotification('Silakan login untuk menambahkan ke keranjang', 'error');
                return;
            }
            
            // Add to cart via API
            fetch('/cart/items', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    book_id: bookId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count
                    updateCartCount();
                    
                    // Show success message
                    addToCartSuccess.style.display = 'block';
                    
                    // Hide success message after 3 seconds
                    setTimeout(function() {
                        addToCartSuccess.style.display = 'none';
                    }, 3000);
                } else {
                    showNotification(data.error || 'Terjadi kesalahan', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan', 'error');
            });
        });
        
        // Buy Now button functionality
        buyNowBtn.addEventListener('click', function() {
            const quantity = document.querySelector('#quantity').value;
            const bookTitle = '{{ $book->title }}';
            const bookAuthor = '{{ $book->author }}';
            const bookPrice = {{ $book->price }};
            const totalPrice = bookPrice * quantity;
            
            // First add to cart via API
            const bookId = document.querySelector('input[name="book_id"]').value;
            const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
            
            if (!isLoggedIn) {
                // If not logged in, redirect to WhatsApp directly
                const message = `- *PESANAN CEPAT - Econic Book Store*

Halo Admin, saya ingin memesan buku berikut:

📚 *${bookTitle}*
👤 Penulis: ${bookAuthor}
📦 Jumlah: ${quantity}
💰 Harga: Rp ${bookPrice.toLocaleString('id-ID')}
💰 Total: Rp ${totalPrice.toLocaleString('id-ID')}

Silakan hubungi saya untuk detail pengiriman dan pembayaran.

Terima kasih! 🙏`;
                
                const encodedMessage = encodeURIComponent(message);
                const whatsappUrl = `https://wa.me/6285934832133?text=${encodedMessage}`;
                
                window.open(whatsappUrl, '_blank');
                return;
            }
            
            // If logged in, add to cart first then go to checkout
            fetch('/cart/items', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    book_id: bookId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirect to checkout
                    window.location.href = '{{ route("checkout") }}';
                } else {
                    showNotification(data.error || 'Terjadi kesalahan', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan', 'error');
            });
        });
        
        // Function to update cart count in navbar
        function updateCartCount() {
            const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
            
            if (!isLoggedIn) {
                // Use localStorage for non-logged-in users
                const cart = JSON.parse(localStorage.getItem('cart')) || [];
                const cartCount = cart.reduce((total, item) => total + parseInt(item.quantity), 0);
                
                const cartCountElement = document.querySelector('.cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = cartCount;
                    cartCountElement.style.display = cartCount > 0 ? 'flex' : 'none';
                }
            } else {
                // Use API for logged-in users
                fetch('/cart/count')
                    .then(response => response.json())
                    .then(data => {
                        const cartCountElement = document.querySelector('.cart-count');
                        if (cartCountElement) {
                            cartCountElement.textContent = data.count;
                            cartCountElement.style.display = data.count > 0 ? 'flex' : 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching cart count:', error);
                    });
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
                ${type === 'success' ? 'background-color: #808080;' : 'background-color: #ff6b6b;'}
            `;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
        
        // Initialize cart count on page load
        updateCartCount();
        
        // Product card hover effect
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
    
    // Add CSS animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endsection