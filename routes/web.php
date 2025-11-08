<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminNotificationController;
use App\Models\Book;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;

// Rute publik
Route::get('/', function () {
    // Fetch books for display (can be used elsewhere on home)
    $books = Book::latest()->take(12)->get();

    // Pick up to 4 "popular" books; fallback to first 4 if no relation
    try {
        if (method_exists(Book::class, 'reviews')) {
            $popularBooks = Book::withCount('reviews')
                ->orderByDesc('reviews_count')
                ->take(4)
                ->get();
        } else {
            $popularBooks = Book::latest()->take(4)->get();
        }
    } catch (\Throwable $e) {
        $popularBooks = $books->take(4);
    }

    return view('welcome', compact('books', 'popularBooks'));
})->name('home');

// About page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Shop page
Route::get('/shop', [BookController::class, 'shop'])->name('shop');
Route::get('/api/authors', [BookController::class, 'getAuthors'])->name('api.authors');
Route::get('/api/popular-searches', [BookController::class, 'getPopularSearches'])->name('api.popular-searches');

Route::get('/favorites', function () {
    return view('favorites');
})->name('favorites');

// Rute autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('user.login');
Route::post('/login', [AuthController::class, 'userLogin']);
Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute untuk user biasa
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/dashboard', [BookController::class, 'userDashboard'])->name('user.dashboard');

    // Checkout
    Route::get('/checkout', [TransactionController::class, 'checkout'])->name('checkout');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
    Route::get('/cart/items/list', [CartController::class, 'getItems'])->name('cart.items.get');
    Route::post('/cart/items', [CartController::class, 'addItem'])->name('cart.items.add');
    Route::patch('/cart/items/{item}', [CartController::class, 'updateItem'])->name('cart.items.update');
    Route::delete('/cart/items/{item}', [CartController::class, 'removeItem'])->name('cart.items.remove');

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
    Route::get('/favorites/count', [FavoriteController::class, 'count'])->name('favorites.count');
    Route::get('/favorites/items/list', [FavoriteController::class, 'getItems'])->name('favorites.items.get');
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

    // Reviews
    Route::post('/books/{id}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/reviews/{id}/report', [ReviewController::class, 'report'])->name('reviews.report');
});

// Rute publik detail buku
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');

// Rute khusus admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [BookController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/books', [BookController::class, 'index'])->name('admin.books.index');
    Route::get('/books/create', [BookController::class, 'create'])->name('admin.books.create');
    Route::post('/books', [BookController::class, 'store'])->name('admin.books.store');
    Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('admin.books.edit');
    Route::put('/books/{id}', [BookController::class, 'update'])->name('admin.books.update');
    Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('admin.books.destroy');
    Route::get('/transactions', [TransactionController::class, 'adminIndex'])->name('admin.transactions.index');

    // Admin Notifications
    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');
    Route::get('/notifications/{id}', [AdminNotificationController::class, 'show'])->name('admin.notifications.show');
    Route::put('/notifications/{id}/read', [AdminNotificationController::class, 'markAsRead'])->name('admin.notifications.read');
    Route::put('/notifications/read-all', [AdminNotificationController::class, 'markAllAsRead'])->name('admin.notifications.read-all');
    Route::put('/notifications/{id}/status', [AdminNotificationController::class, 'updateStatus'])->name('admin.notifications.status');
});

