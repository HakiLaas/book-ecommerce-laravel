<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Review;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('dashboardproduct', compact('books'));
    }

    public function create()
    {
        $categories = \App\Models\Category::where('is_active', true)->orderBy('name')->get();
        return view('create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price' => 'required|numeric|min:0',
            'format' => 'required|in:digital,print',
            'pages' => 'nullable|integer|min:1',
            'dimensions' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:100',
            'publisher' => 'nullable|string|max:150',
            'author_info' => 'nullable|string',
            'category' => 'nullable|string|max:150',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|string',
        ]);

        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->price = $request->price;
        $book->format = $request->format;
        $book->pages = $request->pages;
        $book->dimensions = $request->dimensions;
        $book->language = $request->language;
        $book->publisher = $request->publisher;
        $book->author_info = $request->author_info;
        $book->category = $request->category;
        $book->category_id = $request->category_id;
        $book->tags = $request->tags;

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Store file
            $path = $file->storeAs('cover_images', $filename, 'public');
            
            if ($path) {
                $book->cover_image = $filename;
            }
        }

        $book->save();
        
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = \App\Models\Category::where('is_active', true)->orderBy('name')->get();
        return view('edit', compact('book', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price' => 'required|numeric|min:0',
            'format' => 'required|in:digital,print',
            'pages' => 'nullable|integer|min:1',
            'dimensions' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:100',
            'publisher' => 'nullable|string|max:150',
            'author_info' => 'nullable|string',
            'category' => 'nullable|string|max:150',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|string',
        ]);

        $book = Book::findOrFail($id);
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->price = $request->price;
        $book->format = $request->format;
        $book->pages = $request->pages;
        $book->dimensions = $request->dimensions;
        $book->language = $request->language;
        $book->publisher = $request->publisher;
        $book->author_info = $request->author_info;
        $book->category = $request->category;
        $book->category_id = $request->category_id;
        $book->tags = $request->tags;

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($book->cover_image) {
                $oldImagePath = storage_path('app/public/cover_images/' . $book->cover_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            $file = $request->file('cover_image');
            
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Store file
            $path = $file->storeAs('cover_images', $filename, 'public');
            
            if ($path) {
                $book->cover_image = $filename;
            }
        }

        $book->save();
        
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        if ($book->cover_image) {
            $imagePath = storage_path('app/public/cover_images/' . $book->cover_image);
            if (file_exists($imagePath)) {
                unlink($imagePath); 
            }
        }

        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully.');
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);

        $filterRating = request()->query('rating');
        $reviewsQuery = Review::with('user')
            ->where('book_id', $id)
            ->where('status', 'approved');
        if ($filterRating) {
            $reviewsQuery->where('rating', (int) $filterRating);
        }
        $reviews = $reviewsQuery->orderBy('created_at', 'desc')->paginate(5)->appends(request()->query());
        $reviewCount = Review::where('book_id', $id)->where('status', 'approved')->count();
        $avgRating = Review::where('book_id', $id)->where('status', 'approved')->avg('rating');
        $avgRating = $avgRating ? round((float) $avgRating, 1) : 0;

        $verifiedUserIds = Transaction::where('book_id', $id)->pluck('user_id')->unique();

        return view('books.show', compact('book', 'reviews', 'reviewCount', 'avgRating', 'verifiedUserIds'));
    }

    public function dashboard()
    {
        $totalUsers = User::count();
        $totalProducts = Book::count();
        $totalRevenue = Transaction::sum('total_price');

        return view('admin.dashboard', compact('totalUsers', 'totalProducts', 'totalRevenue'));
    }

    public function dashboardProduct()
    {
        $books = Book::all();
        return view('dashboardproduct', compact('books'));
    }

    public function userDashboard()
    {
        $books = Book::latest()->take(6)->get();
        
        // Get user statistics
        $favoritesCount = \App\Models\Favorite::where('user_id', auth()->id())->count();
        $transactionsCount = Transaction::where('user_id', auth()->id())->count();
        $booksRead = Transaction::where('user_id', auth()->id())->count(); // Simplified
        $reviewsCount = Review::where('user_id', auth()->id())->count();
        
        // Mock recent activities - can be uncommented and populated with real data later
        $recentActivities = [];
        
        return view('user.dashboard', compact('books', 'favoritesCount', 'transactionsCount', 'booksRead', 'reviewsCount', 'recentActivities'));
    }

    public function shop(Request $request)
    {
        $query = Book::query();

        // Search by title, author, or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where(function($q) use ($request) {
                $q->where('category', $request->category)
                  ->orWhereHas('category', function($catQuery) use ($request) {
                      $catQuery->where('name', $request->category)
                               ->orWhere('slug', $request->category);
                  });
            });
        }

        // Filter by format
        if ($request->filled('format')) {
            $query->where('format', $request->format);
        }

        // Filter by language
        if ($request->filled('language')) {
            $query->where('language', $request->language);
        }

        // Filter by price range
        if ($request->filled('price_range')) {
            $range = $request->price_range;
            if ($range == '0-50000') {
                $query->whereBetween('price', [0, 50000]);
            } elseif ($range == '50000-100000') {
                $query->whereBetween('price', [50000, 100000]);
            } elseif ($range == '100000-200000') {
                $query->whereBetween('price', [100000, 200000]);
            } elseif ($range == '200000') {
                $query->where('price', '>=', 200000);
            }
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'latest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'popular':
                    $query->withCount('reviews')->orderBy('reviews_count', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'rating':
                    $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination with category relationship
        $books = $query->with('category')->paginate(12)->appends(request()->query());

        return view('shop', compact('books'));
    }

    public function getAuthors()
    {
        // Get unique authors with their book count, ordered by popularity
        $authors = Book::select('author')
            ->selectRaw('COUNT(*) as book_count')
            ->groupBy('author')
            ->orderBy('book_count', 'desc')
            ->orderBy('author', 'asc')
            ->limit(12)
            ->get()
            ->map(function($item) {
                // Get author image if available (using first book's cover as placeholder)
                $firstBook = Book::where('author', $item->author)->first();
                return [
                    'name' => $item->author,
                    'book_count' => $item->book_count,
                    'image' => $firstBook ? $firstBook->cover_image : null
                ];
            });

        return response()->json(['authors' => $authors]);
    }

    public function getPopularSearches()
    {
        // Get popular categories and search terms
        $popularCategories = \App\Models\Category::where('is_active', true)
            ->orderBy('name')
            ->limit(6)
            ->pluck('name');

        // Fallback to default categories if no categories exist
        if ($popularCategories->isEmpty()) {
            $popularCategories = collect(['Fiksi', 'Non-Fiksi', 'Pendidikan', 'Teknologi', 'Bisnis', 'Agama']);
        }

        return response()->json(['categories' => $popularCategories]);
    }
}
