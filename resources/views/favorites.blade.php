@extends('layouts.app')

@section('title', 'Favorit Saya')

@section('content')
<div style="padding: 20px; max-width: 1200px; margin: 0 auto;">
    <h1 style="margin-bottom: 20px; color: var(--black);">Favorit Saya</h1>
    
    @if($favorites->count() > 0)
        <div class="product-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;" class="favorites-grid">
            @foreach($favorites as $favorite)
                <div class="product-card" style="background: white; border-radius: 10px; box-shadow: var(--shadow1); overflow: hidden; transition: transform 0.3s ease;">
                    <div class="product-image" style="position: relative; height: 300px; overflow: hidden;">
                        <img src="{{ $favorite->book->cover_url }}" alt="{{ $favorite->book->title }}" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy" onerror="this.src='{{ asset('storage/cover_images/default-book.jpg') }}'">
                        <button class="favorite-btn remove-favorite" data-book-id="{{ $favorite->book->id }}" style="position: absolute; top: 10px; right: 10px; background: white; border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                            <i class='bx bxs-heart' style="font-size: 1.2rem; color: #ff6b6b;"></i>
                        </button>
                    </div>
                    <div class="product-info" style="padding: 15px;">
                        <span class="author" style="color: #808080; font-size: 0.9rem;">{{ $favorite->book->author }}</span>
                        <h3 style="margin: 5px 0; font-size: 1.2rem;">{{ $favorite->book->title }}</h3>
                        <div class="rating" style="color: #FFD700; margin: 5px 0;">⭐⭐⭐⭐⭐</div>
                        <div class="price-cart" style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                            <span class="price" style="font-weight: bold; font-size: 1.1rem;">Rp {{ number_format($favorite->book->price, 0, ',', '.') }}</span>
                            <a href="{{ route('books.show', $favorite->book->id) }}" class="btn-primary" style="background-color: var(--green2); color: white; padding: 8px 12px; border-radius: 5px; font-size: 0.9rem; text-decoration: none;">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 10px; box-shadow: var(--shadow1);">
            <i class='bx bx-heart' style="font-size: 4rem; color: #ddd; margin-bottom: 20px;"></i>
            <h3 style="color: #808080; margin-bottom: 10px;">Belum ada favorit</h3>
            <p style="color: #999; margin-bottom: 20px;">Mulai tambahkan buku ke favorit untuk menyimpannya di sini</p>
            <a href="{{ route('home') }}" class="btn-primary" style="background-color: var(--green2); color: white; padding: 12px 24px; border-radius: 5px; text-decoration: none; display: inline-block;">Mulai Berbelanja</a>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Remove from favorites functionality
    const removeFavoriteBtns = document.querySelectorAll('.remove-favorite');
    
    removeFavoriteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const bookId = this.getAttribute('data-book-id');
            
            fetch('/favorites/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    book_id: bookId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the card from the page
                    this.closest('.product-card').remove();
                    
                    // Show success message
                    showNotification(data.message, 'success');
                    
                    // Update favorites count
                    updateFavoritesCount();
                    
                    // Check if no favorites left
                    const remainingCards = document.querySelectorAll('.product-card');
                    if (remainingCards.length === 0) {
                        location.reload(); // Reload to show empty state
                    }
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
            ${type === 'success' ? 'background-color: #808080;' : 'background-color: #ff6b6b;'}
        `;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
    
    // Function to update favorites count
    function updateFavoritesCount() {
        fetch('/favorites/count')
            .then(response => response.json())
            .then(data => {
                const favoritesCountEl = document.querySelector('.favorites-count');
                if (favoritesCountEl) {
                    favoritesCountEl.textContent = data.count;
                    favoritesCountEl.style.display = data.count > 0 ? 'flex' : 'none';
                }
            });
    }
    
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
});

// Add responsive CSS for favorites
const responsiveStyle = document.createElement('style');
responsiveStyle.textContent = `
    @media (max-width: 768px) {
        .favorites-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)) !important;
            gap: 15px !important;
        }
    }
    
    @media (max-width: 480px) {
        .favorites-grid {
            grid-template-columns: 1fr !important;
            gap: 10px !important;
        }
        
        .product-card {
            max-width: 100% !important;
        }
    }
`;
document.head.appendChild(responsiveStyle);
});
</script>
@endsection