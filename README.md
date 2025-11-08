# Econic Book Store

Sistem toko buku online dengan fitur lengkap untuk manajemen produk, keranjang belanja, favorit, dan integrasi WhatsApp.

## Fitur Utama

### 1. Sistem Cover Gambar
- ✅ Upload dan manajemen gambar cover buku
- ✅ Sistem fallback untuk gambar yang tidak tersedia
- ✅ Validasi path gambar sebelum ditampilkan
- ✅ Lazy loading untuk optimasi performa
- ✅ Gambar default untuk produk tanpa cover

### 2. Sistem Favorit Produk
- ✅ Menyimpan produk ke daftar favorit
- ✅ Simpan data favorit di database
- ✅ Halaman khusus untuk menampilkan favorit
- ✅ Link langsung ke halaman produk
- ✅ Fitur hapus dari favorit
- ✅ Counter favorit di navbar

### 3. Sistem Pembelian Buku
- ✅ Halaman checkout dengan form lengkap
- ✅ Form alamat pengiriman dengan validasi
- ✅ Pilihan metode pembayaran (COD dan Transfer Bank)
- ✅ Detail produk yang dibeli
- ✅ Perhitungan otomatis total pembayaran
- ✅ Tombol konfirmasi pembelian

### 4. Integrasi WhatsApp
- ✅ Redirect ke WhatsApp saat checkout
- ✅ Template pesan dinamis berdasarkan metode pembayaran
- ✅ Format pesan yang terstruktur dengan emoji
- ✅ Informasi lengkap produk dan pelanggan
- ✅ Instruksi pembayaran sesuai metode yang dipilih
- ✅ Tombol WhatsApp langsung di halaman produk

### 5. Desain Responsif
- ✅ Responsif untuk semua device (desktop, tablet, mobile)
- ✅ Grid layout yang adaptif
- ✅ Form yang user-friendly di mobile
- ✅ Navigation yang mudah digunakan
- ✅ Optimasi untuk berbagai ukuran layar

### 6. Validasi Input
- ✅ Validasi form checkout yang komprehensif
- ✅ Feedback visual untuk error
- ✅ Validasi nomor telepon
- ✅ Validasi alamat lengkap
- ✅ Loading state saat submit

## Instalasi

1. Clone repository
```bash
git clone <repository-url>
cd book_store
```

2. Install dependencies
```bash
composer install
npm install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Konfigurasi database di `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=book_store
DB_USERNAME=root
DB_PASSWORD=
```

5. Konfigurasi WhatsApp dan Bank
```env
WHATSAPP_NUMBER=6285934832133
BANK_DETAILS="BCA 1234567890 a/n Econic Book Store"
STORE_NAME="Econic Book Store"
```

6. Jalankan migrasi
```bash
php artisan migrate
```

7. Buat symbolic link untuk storage
```bash
php artisan storage:link
```

8. Jalankan server
```bash
php artisan serve
```

## Struktur File

### Controllers
- `BookController.php` - Manajemen buku
- `CartController.php` - Manajemen keranjang
- `FavoriteController.php` - Manajemen favorit
- `TransactionController.php` - Manajemen transaksi

### Models
- `Book.php` - Model buku dengan accessor untuk cover URL
- `Cart.php` - Model keranjang
- `CartItem.php` - Model item keranjang
- `Favorite.php` - Model favorit
- `Transaction.php` - Model transaksi

### Views
- `layouts/app.blade.php` - Layout utama dengan navbar responsif
- `welcome.blade.php` - Halaman beranda
- `books/show.blade.php` - Detail produk
- `cart/index.blade.php` - Halaman keranjang
- `favorites.blade.php` - Halaman favorit
- `checkout.blade.php` - Halaman checkout

### Helpers
- `WhatsAppHelper.php` - Helper untuk generate pesan WhatsApp

### Config
- `store.php` - Konfigurasi toko dan WhatsApp

## Konfigurasi WhatsApp

Untuk mengubah nomor WhatsApp dan detail bank, edit file `config/store.php` atau set environment variables:

```env
WHATSAPP_NUMBER=6281234567890
BANK_DETAILS="BCA 1234567890 a/n Econic Book Store"
STORE_NAME="Econic Book Store"
```

## Fitur Keamanan

- ✅ CSRF protection untuk semua form
- ✅ Validasi input server-side dan client-side
- ✅ Authentication untuk akses fitur tertentu
- ✅ Authorization berdasarkan role user

## Performa

- ✅ Lazy loading untuk gambar
- ✅ Optimasi query database dengan eager loading
- ✅ Caching untuk data yang jarang berubah
- ✅ Compressed assets

## Browser Support

- ✅ Chrome (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Edge (latest)
- ✅ Mobile browsers

## Kontribusi

1. Fork repository
2. Buat feature branch
3. Commit perubahan
4. Push ke branch
5. Buat Pull Request

## Lisensi

MIT License