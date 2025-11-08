@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div style="padding:20px; max-width: 1200px; margin:0 auto;">
    <h1 style="margin-bottom: 20px; color: var(--black);">Checkout</h1>

    @if($cart && $cart->items->count() > 0)
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;" class="checkout-form">
            <div style="background:#fff; border-radius:10px; box-shadow: var(--shadow1); padding:20px;">
                <h3 style="margin-bottom:20px; color: var(--black);">Informasi Pengiriman</h3>
                <form id="checkoutForm" method="POST" action="{{ route('transactions.store') }}">
                    @csrf

                    <div style="margin-bottom:15px;">
                        <label style="display:block; margin-bottom:5px; font-weight:500;">Nama Penerima</label>
                        <input type="text" name="receiver_name" required minlength="3" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:6px; font-size:14px;" placeholder="Masukkan nama lengkap penerima" />
                    </div>
                    
                    <div style="margin-bottom:15px;">
                        <label style="display:block; margin-bottom:5px; font-weight:500;">No. Telepon / WhatsApp</label>
                        <input type="tel" name="phone" required minlength="8" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:6px; font-size:14px;" placeholder="Contoh: 081234567890" />
                    </div>
                    
                    <div style="margin-bottom:15px;">
                        <label style="display:block; margin-bottom:5px; font-weight:500;">Alamat Lengkap</label>
                        <textarea name="address" required minlength="10" rows="4" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:6px; font-size:14px; resize:vertical;" placeholder="Masukkan alamat lengkap termasuk RT/RW, kelurahan, kecamatan, kota, dan kode pos"></textarea>
                    </div>
                    
                    <div style="margin-bottom:20px;">
                        <label style="display:block; margin-bottom:5px; font-weight:500;">Metode Pembayaran</label>
                        <select name="payment_method" required style="width:100%; padding:12px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                            <option value="">Pilih metode pembayaran</option>
                            <option value="COD">COD (Bayar di tempat)</option>
                            <option value="Transfer Bank">Transfer Bank</option>
                        </select>
                    </div>

                    <button type="submit" class="buy-now-btn" style="display:block; width:100%; background: var(--green2); color:#fff; padding:15px; border-radius:6px; border:none; cursor:pointer; font-weight:bold; font-size:16px;">
                        <i class='bx bx-whatsapp' style="margin-right:8px;"></i>Konfirmasi & Beli via WhatsApp
                    </button>
                </form>
            </div>

            <div style="background:#fff; border-radius:10px; box-shadow: var(--shadow1); padding:20px;">
                <h3 style="margin-bottom:20px; color: var(--black);">Ringkasan Pesanan</h3>
                
                <div style="margin-bottom:20px;">
                    @foreach($cart->items as $item)
                        <div style="display:flex; gap:12px; align-items:center; margin-bottom:15px; padding-bottom:15px; border-bottom:1px solid #eee;">
                            <img src="{{ $item->book->cover_url }}" alt="{{ $item->book->title }}" width="60" height="90" loading="lazy" style="object-fit:cover; border-radius:6px;" onerror="this.src='{{ asset('storage/cover_images/default-book.jpg') }}'"/>
                            <div style="flex:1;">
                                <div style="font-weight:600; margin-bottom:5px;">{{ $item->book->title }}</div>
                                <div style="color:#005E39; font-size:0.9rem; margin-bottom:5px;">{{ $item->book->author }}</div>
                                <div style="color:#005E39; font-size:0.9rem;">Qty: {{ $item->quantity }}</div>
                                <div style="color:var(--green1); font-weight:bold; margin-top:5px;">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <hr style="margin:20px 0;"/>
                
                <div style="margin-bottom:10px;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                        <span>Subtotal ({{ $cart->items->sum('quantity') }} item):</span>
                        <span id="subtotal">Rp {{ number_format($cart->total(), 0, ',', '.') }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                        <span>Pengiriman:</span>
                        <span id="shipping">Rp 0</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-weight:700; font-size:1.1rem; margin-top:15px; padding-top:15px; border-top:2px solid var(--green1);">
                        <span>Total:</span>
                        <span id="total" style="color:var(--green1);">Rp {{ number_format($cart->total(), 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <div style="margin-top:20px; padding:15px; background:#f8f9fa; border-radius:6px; border-left:4px solid var(--green2);">
                    <h4 style="margin:0 0 10px 0; color:var(--black);">Informasi Penting:</h4>
                    <ul style="margin:0; padding-left:20px; color:#005E39; font-size:0.9rem;">
                        <li>Pesanan akan diproses setelah konfirmasi via WhatsApp</li>
                        <li>Estimasi pengiriman 1-3 hari kerja</li>
                        <li>Kode transaksi akan diberikan setelah konfirmasi</li>
                    </ul>
                </div>
            </div>
        </div>
    @elseif($book)
        <!-- Legacy single book checkout -->
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
            <div style="background:#fff; border-radius:10px; box-shadow: var(--shadow1); padding:20px;">
                <h3 style="margin-bottom:10px;">Alamat Pengiriman</h3>
                <form id="checkoutForm" method="POST" action="{{ route('transactions.store') }}">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}" />
                    <input type="hidden" name="quantity" value="{{ $quantity }}" />

                    <div style="margin-bottom:10px;">
                        <label>Nama Penerima</label>
                        <input type="text" name="receiver_name" required minlength="3" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;" />
                    </div>
                    <div style="margin-bottom:10px;">
                        <label>No. Telepon / WhatsApp</label>
                        <input type="tel" name="phone" required minlength="8" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;" />
                    </div>
                    <div style="margin-bottom:10px;">
                        <label>Alamat Lengkap</label>
                        <textarea name="address" required minlength="10" rows="4" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;"></textarea>
                    </div>
                    <div style="margin-bottom:10px;">
                        <label>Metode Pembayaran</label>
                        <select name="payment_method" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
                            <option value="COD">COD (Bayar di tempat)</option>
                            <option value="Transfer Bank">Transfer Bank</option>
                        </select>
                    </div>

                    <button type="submit" class="buy-now-btn" style="display:inline-block; background: var(--green2); color:#fff; padding:12px 18px; border-radius:6px; border:none; cursor:pointer;">Konfirmasi & Beli via WhatsApp</button>
                </form>
            </div>

            <div style="background:#fff; border-radius:10px; box-shadow: var(--shadow1); padding:20px;">
                <h3 style="margin-bottom:10px;">Detail Produk</h3>
                <div style="display:flex; gap:12px; align-items:center;">
                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" width="80" height="120" loading="lazy" style="object-fit:cover; border-radius:6px;" onerror="this.src='{{ asset('storage/cover_images/default-book.jpg') }}'"/>
                    <div>
                        <div style="font-weight:600;">{{ $book->title }}</div>
                        <div>Qty: {{ $quantity }}</div>
                        <div>Harga: Rp {{ number_format($book->price, 0, ',', '.') }}</div>
                    </div>
                </div>
                <hr/>
                <div style="display:flex; justify-content:space-between;">
                    <span>Subtotal</span>
                    <span id="subtotal">Rp {{ number_format($book->price * $quantity, 0, ',', '.') }}</span>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span>Pengiriman</span>
                    <span id="shipping">Rp 0</span>
                </div>
                <div style="display:flex; justify-content:space-between; font-weight:700;">
                    <span>Total</span>
                    <span id="total">Rp {{ number_format($book->price * $quantity, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 10px; box-shadow: var(--shadow1);">
            <i class='bx bx-cart' style="font-size: 4rem; color: #ddd; margin-bottom: 20px;"></i>
            <h3 style="color: #808080; margin-bottom: 10px;">Tidak ada item untuk checkout</h3>
            <p style="color: #999; margin-bottom: 20px;">Silakan tambahkan produk ke keranjang terlebih dahulu</p>
            <a href="{{ route('home') }}" class="btn-primary" style="background-color: var(--green2); color: white; padding: 12px 24px; border-radius: 5px; text-decoration: none; display: inline-block;">Mulai Berbelanja</a>
        </div>
    @endif
</div>

<script>
// Feedback visual saat submit
const form = document.getElementById('checkoutForm');
if (form) {
    form.addEventListener('submit', function() {
        const btn = form.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="bx bx-loader-alt bx-spin" style="margin-right:8px;"></i>Memproses...';
    });
}

// Form validation
if (form) {
    form.addEventListener('submit', function(e) {
        const receiverName = form.querySelector('input[name="receiver_name"]').value.trim();
        const phone = form.querySelector('input[name="phone"]').value.trim();
        const address = form.querySelector('textarea[name="address"]').value.trim();
        const paymentMethod = form.querySelector('select[name="payment_method"]').value;
        
        // Clear previous error styles
        clearErrorStyles();
        
        let hasErrors = false;
        
        if (!receiverName || receiverName.length < 3) {
            showFieldError('receiver_name', 'Nama penerima minimal 3 karakter');
            hasErrors = true;
        }
        
        if (!phone || phone.length < 8) {
            showFieldError('phone', 'Nomor telepon minimal 8 karakter');
            hasErrors = true;
        } else if (!/^[0-9+\-\s()]+$/.test(phone)) {
            showFieldError('phone', 'Format nomor telepon tidak valid');
            hasErrors = true;
        }
        
        if (!address || address.length < 10) {
            showFieldError('address', 'Alamat minimal 10 karakter');
            hasErrors = true;
        }
        
        if (!paymentMethod) {
            showFieldError('payment_method', 'Silakan pilih metode pembayaran');
            hasErrors = true;
        }
        
        if (hasErrors) {
            e.preventDefault();
            showNotification('Silakan perbaiki error di atas', 'error');
            return;
        }
        
        // Show loading state
        const btn = form.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="bx bx-loader-alt bx-spin" style="margin-right:8px;"></i>Memproses...';
    });
}

function showFieldError(fieldName, message) {
    const field = form.querySelector(`[name="${fieldName}"]`);
    if (field) {
        field.style.borderColor = '#ff6b6b';
        field.style.backgroundColor = '#fff5f5';
        
        // Remove existing error message
        const existingError = field.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
        
        // Add error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.style.cssText = 'color: #ff6b6b; font-size: 0.8rem; margin-top: 5px;';
        errorDiv.textContent = message;
        field.parentNode.appendChild(errorDiv);
    }
}

function clearErrorStyles() {
    const fields = form.querySelectorAll('input, textarea, select');
    fields.forEach(field => {
        field.style.borderColor = '#ddd';
        field.style.backgroundColor = '';
    });
    
    const errorMessages = form.querySelectorAll('.field-error');
    errorMessages.forEach(error => error.remove());
}

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
    }, 5000);
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

</script>
@endsection