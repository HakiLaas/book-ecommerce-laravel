@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div style="padding: 20px; max-width: 1200px; margin: 0 auto;">
    <h1 style="margin-bottom: 20px; color:  var(--black);">Keranjang Belanja</h1>
    
    @if($cart->items->count() > 0)
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;" class="cart-layout">
            <!-- Cart Items -->
            <div style="background: white; border-radius: 10px; box-shadow: var(--shadow1); padding: 20px;">
                <h3 style="margin-bottom: 20px; color:  #2a2a2a;">Item dalam Keranjang</h3>
                
                @foreach($cart->items as $item)
                    <div class="cart-item" style="display: flex; align-items: center; padding: 15px 0; border-bottom: 1px solid #eee;">
                        <div class="item-image" style="width: 80px; height: 120px; margin-right: 15px; border-radius: 5px; overflow: hidden;">
                            <img src="{{ $item->book->cover_url }}" alt="{{ $item->book->title }}" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy" onerror="this.src='{{ asset('storage/cover_images/default-book.jpg') }}'">
                        </div>
                        
                        <div class="item-info" style="flex: 1;">
                            <h4 style="margin: 0 0 5px 0; color:  #2a2a2a;">{{ $item->book->title }}</h4>
                            <p style="margin: 0 0 5px 0; color: #808080; font-size: 0.9rem;">{{ $item->book->author }}</p>
                            <p style="margin: 0; color: var(--green1); font-weight: bold;">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                        </div>
                        
                        <div class="quantity-controls" style="display: flex; align-items: center; margin: 0 15px;">
                            <button class="qty-btn minus" data-item-id="{{ $item->id }}" style="width: 30px; height: 30px; background: #f1f1f1; border: 1px solid #ddd; border-radius: 5px 0 0 5px; cursor: pointer;">-</button>
                            <input type="number" class="quantity-input" value="{{ $item->quantity }}" min="1" data-item-id="{{ $item->id }}" style="width: 50px; height: 30px; padding: 0 5px; border: 1px solid #ddd; border-left: none; border-right: none; text-align: center; background-color: white;">
                            <button class="qty-btn plus" data-item-id="{{ $item->id }}" style="width: 30px; height: 30px; background: #f1f1f1; border: 1px solid #ddd; border-radius: 0 5px 5px 0; cursor: pointer;">+</button>
                        </div>
                        
                        <div class="item-total" style="margin: 0 15px; font-weight: bold; color: var(--green1);">
                            Rp {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}
                        </div>
                        
                        <button class="remove-item" data-item-id="{{ $item->id }}" style="background: #ff6b6b; color: white; border: none; border-radius: 5px; padding: 8px 12px; cursor: pointer;">
                            <i class='bx bx-trash'></i>
                        </button>
                    </div>
                @endforeach
            </div>
            
            <!-- Order Summary -->
            <div style="background: white; border-radius: 10px; box-shadow: var(--shadow1); padding: 20px; height: fit-content;">
                <h3 style="margin-bottom: 20px; color:  #2a2a2a;">Ringkasan Pesanan</h3>
                
                <div style="margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span>Subtotal:</span>
                        <span id="subtotal">Rp {{ number_format($cart->total(), 0, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span>Pengiriman:</span>
                        <span id="shipping">Rp 0</span>
                    </div>
                    <hr style="margin: 15px 0;">
                    <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.1rem;">
                        <span>Total:</span>
                        <span id="total" style="color: var(--green1);">Rp {{ number_format($cart->total(), 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <a href="{{ route('checkout') }}" class="checkout-btn" style="display: block; background-color: var(--green2); color: white; text-align: center; padding: 15px; border-radius: 5px; text-decoration: none; font-weight: bold; margin-bottom: 10px;">
                    Lanjut ke Checkout
                </a>
                
                <a href="{{ route('home') }}" style="display: block; background-color: #f1f1f1; color:  #2a2a2a; text-align: center; padding: 15px; border-radius: 5px; text-decoration: none;">
                    Lanjut Belanja
                </a>
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 10px; box-shadow: var(--shadow1);">
            <i class='bx bx-cart' style="font-size: 4rem; color: #ddd; margin-bottom: 20px;"></i>
            <h3 style="color: #808080; margin-bottom: 10px;">Keranjang Kosong</h3>
            <p style="color: #999; margin-bottom: 20px;">Tambahkan beberapa buku ke keranjang untuk memulai</p>
            <a href="{{ route('home') }}" class="btn-primary" style="background-color: var(--green2); color: white; padding: 12px 24px; border-radius: 5px; text-decoration: none; display: inline-block;">Mulai Berbelanja</a>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity controls
    const minusBtns = document.querySelectorAll('.qty-btn.minus');
    const plusBtns = document.querySelectorAll('.qty-btn.plus');
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const removeBtns = document.querySelectorAll('.remove-item');
    
    // Minus button functionality
    minusBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
            let currentValue = parseInt(input.value);
            
            if (currentValue > 1) {
                updateQuantity(itemId, currentValue - 1);
            }
        });
    });
    
    // Plus button functionality
    plusBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
            let currentValue = parseInt(input.value);
            
            updateQuantity(itemId, currentValue + 1);
        });
    });
    
    // Input change functionality
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const itemId = this.getAttribute('data-item-id');
            const value = parseInt(this.value);
            
            if (value >= 1) {
                updateQuantity(itemId, value);
            } else {
                this.value = 1;
            }
        });
    });
    
    // Remove item functionality
    removeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            
            if (confirm('Yakin ingin menghapus item ini dari keranjang?')) {
                removeItem(itemId);
            }
        });
    });
    
    // Function to update quantity
    function updateQuantity(itemId, quantity) {
        fetch(`/cart/items/${itemId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Reload to update totals
            } else {
                showNotification(data.error || 'Terjadi kesalahan', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan', 'error');
        });
    }
    
    // Function to remove item
    function removeItem(itemId) {
        fetch(`/cart/items/${itemId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Reload to update display
            } else {
                showNotification(data.error || 'Terjadi kesalahan', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan', 'error');
        });
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
            ${type === 'success' ? 'background-color: #808080;' : 'background-color: #ff6b6b;'}
        `;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
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

// Add responsive CSS for cart
const responsiveStyle = document.createElement('style');
responsiveStyle.textContent = `
    @media (max-width: 768px) {
        .cart-layout {
            grid-template-columns: 1fr !important;
        }
        
        .cart-item {
            flex-direction: column !important;
            align-items: flex-start !important;
        }
        
        .item-image {
            width: 100% !important;
            height: 200px !important;
            margin-bottom: 15px !important;
        }
        
        .quantity-controls {
            margin: 10px 0 !important;
        }
        
        .item-total {
            margin: 10px 0 !important;
        }
        
        .remove-item {
            align-self: flex-end !important;
        }
    }
    
    @media (max-width: 480px) {
        .cart-item {
            padding: 10px 0 !important;
        }
        
        .quantity-controls {
            flex-direction: column !important;
            gap: 10px !important;
        }
        
        .qty-btn, .quantity-input {
            width: 100% !important;
            border-radius: 5px !important;
        }
    }
`;
document.head.appendChild(responsiveStyle);
});
</script>
@endsection