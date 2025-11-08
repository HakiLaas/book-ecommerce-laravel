@extends('layouts.app')

@section('title', 'Manajemen Buku - Admin Panel')

@section('content')
<div class="container" style="margin-top:80px">
    <div style="display:grid; grid-template-columns:260px 1fr; gap:20px;">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <main>
            <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: var(--shadow1);">
                <!-- Header -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                    <div>
                        <h1 style="margin: 0; color: var(--black); font-size: 1.8rem; display: flex; align-items: center;">
                            <i class='bx bx-book' style="margin-right: 10px; color: var(--green1);"></i>
                            Manajemen Buku
                        </h1>
                        <p style="margin: 5px 0 0; color: #808080; font-size: 0.9rem;">Kelola semua buku di toko Anda</p>
                    </div>
                    <a href="{{ route('admin.books.create') }}" 
                       style="display: flex; align-items: center; padding: 12px 24px; background: linear-gradient(135deg, var(--green1) 0%, var(--green2) 100%); color: white; border: none; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0, 94, 57, 0.2);"
                       onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0, 94, 57, 0.3)'"
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0, 94, 57, 0.2)'">
                        <i class='bx bx-plus-circle' style="margin-right: 8px; font-size: 1.2rem;"></i>
                        Tambah Buku
                    </a>
                </div>

                @if (session('success'))
                    <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #28a745; display: flex; align-items: center;">
                        <i class='bx bx-check-circle' style="margin-right: 10px; font-size: 1.2rem;"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div style="background: #fee; color: #c33; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #c33;">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($books->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, var(--green1) 0%, var(--green2) 100%); color: white;">
                                <th style="padding: 15px; text-align: left; font-weight: 600; border-radius: 8px 0 0 0;">Cover</th>
                                <th style="padding: 15px; text-align: left; font-weight: 600;">Title</th>
                                <th style="padding: 15px; text-align: left; font-weight: 600;">Author</th>
                                <th style="padding: 15px; text-align: right; font-weight: 600;">Price</th>
                                <th style="padding: 15px; text-align: left; font-weight: 600;">Description</th>
                                <th style="padding: 15px; text-align: center; font-weight: 600; border-radius: 0 8px 0 0;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $book)
                            <tr style="border-bottom: 1px solid #f0f0f0; transition: background-color 0.2s ease;"
                                onmouseover="this.style.backgroundColor='#f8f9fa'"
                                onmouseout="this.style.backgroundColor='white'">
                                <td style="padding: 15px;">
                                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" 
                                         style="width: 60px; height: 90px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);" 
                                         onerror="this.src='{{ asset('storage/cover_images/default-book.jpg') }}'">
                                </td>
                                <td style="padding: 15px; color: var(--black); font-weight: 500;">{{ $book->title }}</td>
                                <td style="padding: 15px; color: #808080;">{{ $book->author }}</td>
                                <td style="padding: 15px; text-align: right; color: var(--green1); font-weight: 600;">
                                    Rp {{ number_format($book->price, 0, ',', '.') }}
                                </td>
                                <td style="padding: 15px; color: #808080; max-width: 300px;">
                                    <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ Str::limit($book->description ?? 'Tidak ada deskripsi', 50) }}
                                    </div>
                                </td>
                                <td style="padding: 15px; text-align: center;">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <a href="{{ route('admin.books.edit', $book->id) }}" 
                                           style="display: inline-flex; align-items: center; padding: 8px 16px; background: var(--green1); color: white; border: none; border-radius: 6px; text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: all 0.3s ease;"
                                           onmouseover="this.style.background='var(--green2)'; this.style.transform='translateY(-2px)'"
                                           onmouseout="this.style.background='var(--green1)'; this.style.transform='translateY(0)'">
                                            <i class='bx bx-edit' style="margin-right: 5px;"></i>Edit
                                        </a>
                                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" style="display:inline; margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Yakin ingin menghapus buku ini?')"
                                                    style="display: inline-flex; align-items: center; padding: 8px 16px; background: #dc3545; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.9rem; font-weight: 500; transition: all 0.3s ease;"
                                                    onmouseover="this.style.background='#c82333'; this.style.transform='translateY(-2px)'"
                                                    onmouseout="this.style.background='#dc3545'; this.style.transform='translateY(0)'">
                                                <i class='bx bx-trash' style="margin-right: 5px;"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div style="text-align: center; padding: 60px 20px;">
                    <i class='bx bx-book-open' style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
                    <p style="color: #808080; font-size: 1.1rem; margin: 0 0 20px 0;">Belum ada buku</p>
                    <a href="{{ route('admin.books.create') }}" 
                       style="display: inline-flex; align-items: center; padding: 12px 24px; background: linear-gradient(135deg, var(--green1) 0%, var(--green2) 100%); color: white; border: none; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        <i class='bx bx-plus-circle' style="margin-right: 8px;"></i>
                        Tambah Buku Pertama
                    </a>
                </div>
                @endif
            </div>
        </main>
    </div>
</div>

<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns:260px 1fr"] {
        grid-template-columns: 1fr !important;
    }
    
    aside {
        order: 2;
    }
    
    main {
        order: 1;
    }
    
    table {
        font-size: 0.85rem;
    }
    
    th, td {
        padding: 10px 8px !important;
    }
    
    div[style*="display: flex; justify-content: space-between"] {
        flex-direction: column;
        gap: 15px;
    }
    
    a[style*="display: flex; align-items: center; padding: 12px 24px"] {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection
