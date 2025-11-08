@extends('layouts.app')

@section('title', 'Tambah Buku Baru - Admin Panel')

@section('content')
<div class="container" style="margin-top:80px">
    <div style="display:grid; grid-template-columns:260px 1fr; gap:20px;">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <main>
<div style="max-width: 100%;">
    <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: var(--shadow1);">
        <div style="display: flex; align-items: center; margin-bottom: 30px;">
            <a href="{{ route('admin.books.index') }}" style="margin-right: 15px; color: var(--green1); text-decoration: none;">
                <i class='bx bx-arrow-back' style="font-size: 1.5rem;"></i>
            </a>
            <h1 style="margin: 0; color: var(--black); font-size: 1.8rem;">Tambah Buku Baru</h1>
        </div>

        @if ($errors->any())
            <div style="background: #fee; color: #c33; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #c33;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" id="bookForm">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <!-- Left Column - Basic Info -->
                <div>
                    <h3 style="margin-bottom: 20px; color: var(--black); font-size: 1.2rem;">Informasi Dasar</h3>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--black);">Judul Buku *</label>
                        <input type="text" name="title" placeholder="Masukkan judul buku" required 
                               style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;"
                               onfocus="this.style.borderColor='var(--green1)'" onblur="this.style.borderColor='#e1e5e9'">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--black);">Penulis *</label>
                        <input type="text" name="author" placeholder="Masukkan nama penulis" required
                               style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;"
                               onfocus="this.style.borderColor='var(--green1)'" onblur="this.style.borderColor='#e1e5e9'">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--black);">Harga *</label>
                        <input type="number" name="price" placeholder="Masukkan harga" required min="0" step="100"
                               style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;"
                               onfocus="this.style.borderColor='var(--green1)'" onblur="this.style.borderColor='#e1e5e9'">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--black);">Format *</label>
                        <select name="format" required
                                style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;"
                                onfocus="this.style.borderColor='var(--green1)'" onblur="this.style.borderColor='#e1e5e9'">
                            <option value="">-- Pilih Format --</option>
                            <option value="digital">Digital</option>
                            <option value="print">Cetak</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--black);">Kategori</label>
                        <div style="position: relative;">
                            <input type="text" id="categorySearch" placeholder="Cari atau pilih kategori..." autocomplete="off"
                                   style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;"
                                   onfocus="this.style.borderColor='var(--green1)'; showCategoryDropdown()" 
                                   onblur="setTimeout(() => hideCategoryDropdown(), 200)" 
                                   onkeyup="filterCategories(this.value)">
                            <input type="hidden" name="category_id" id="categoryId">
                            <div id="categoryDropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 2px solid #e1e5e9; border-top: none; border-radius: 0 0 8px 8px; max-height: 200px; overflow-y: auto; z-index: 1000; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                @foreach($categories as $category)
                                    <div class="category-option" data-id="{{ $category->id }}" data-name="{{ $category->name }}" 
                                         onclick="selectCategory({{ $category->id }}, '{{ $category->name }}')"
                                         style="padding: 10px 12px; cursor: pointer; border-bottom: 1px solid #f0f0f0; transition: background-color 0.2s;"
                                         onmouseover="this.style.backgroundColor='#f8f9fa'" 
                                         onmouseout="this.style.backgroundColor='white'">
                                        {{ $category->name }}
                                    </div>
                                @endforeach
                                @if($categories->isEmpty())
                                    <div style="padding: 10px 12px; color: #999; font-style: italic;">Belum ada kategori</div>
                                @endif
                            </div>
                        </div>
                        <small style="color: #808080; display: block; margin-top: 5px;">Ketik untuk mencari kategori</small>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--black);">Bahasa</label>
                        <input type="text" name="language" placeholder="Masukkan bahasa"
                               style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;"
                               onfocus="this.style.borderColor='var(--green1)'" onblur="this.style.borderColor='#e1e5e9'">
                    </div>
                </div>

                <!-- Right Column - Additional Info & Image -->
                <div>
                    <h3 style="margin-bottom: 20px; color: var(--black); font-size: 1.2rem;">Detail Tambahan</h3>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--black);">Deskripsi</label>
                        <textarea name="description" placeholder="Masukkan deskripsi buku" rows="4"
                                  style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease; resize: vertical;"
                                  onfocus="this.style.borderColor='var(--green1)'" onblur="this.style.borderColor='#e1e5e9'"></textarea>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--black);">Jumlah Halaman</label>
                        <input type="number" name="pages" placeholder="Masukkan jumlah halaman" min="1"
                               style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;"
                               onfocus="this.style.borderColor='var(--green1)'" onblur="this.style.borderColor='#e1e5e9'">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--black);">Dimensi</label>
                        <input type="text" name="dimensions" placeholder="Contoh: 5.5 x 8.5 inches"
                               style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;"
                               onfocus="this.style.borderColor='var(--green1)'" onblur="this.style.borderColor='#e1e5e9'">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--black);">Penerbit</label>
                        <input type="text" name="publisher" placeholder="Masukkan nama penerbit"
                               style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;"
                               onfocus="this.style.borderColor='var(--green1)'" onblur="this.style.borderColor='#e1e5e9'">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--black);">Informasi Penulis</label>
                        <textarea name="author_info" placeholder="Masukkan informasi tentang penulis" rows="3"
                                  style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease; resize: vertical;"
                                  onfocus="this.style.borderColor='var(--green1)'" onblur="this.style.borderColor='#e1e5e9'"></textarea>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--black);">Tags</label>
                        <input type="text" name="tags" placeholder="Masukkan tags (pisahkan dengan koma)"
                               style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 1rem; transition: border-color 0.3s ease;"
                               onfocus="this.style.borderColor='var(--green1)'" onblur="this.style.borderColor='#e1e5e9'">
                    </div>
                </div>
            </div>

            <!-- Cover Image Upload -->
            <div style="margin-top: 30px; padding-top: 30px; border-top: 2px solid #f0f0f0;">
                <h3 style="margin-bottom: 20px; color: var(--black); font-size: 1.2rem;">Cover Buku</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; align-items: start;">
                    <div>
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--black);">Upload Gambar Cover</label>
                        <div style="border: 2px dashed #e1e5e9; border-radius: 8px; padding: 20px; text-align: center; transition: all 0.3s ease;" 
                             id="uploadArea" ondrop="handleDrop(event)" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)">
                            <input type="file" name="cover_image" id="coverImage" accept="image/*" style="display: none;" onchange="handleFileSelect(event)">
                            <i class='bx bx-cloud-upload' style="font-size: 3rem; color: #ccc; margin-bottom: 10px;"></i>
                            <p style="margin: 0; color: #808080;">Drag & drop gambar atau <span style="color: var(--green1); cursor: pointer;" onclick="document.getElementById('coverImage').click()">klik untuk memilih</span></p>
                            <p style="margin: 5px 0 0; font-size: 0.8rem; color: #999;">Format: JPG, PNG, GIF, WebP (Max: 2MB)</p>
                        </div>
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--black);">Preview</label>
                        <div id="imagePreview" style="width: 100%; height: 200px; border: 2px solid #e1e5e9; border-radius: 8px; display: flex; align-items: center; justify-content: center; background: #f8f9fa;">
                            <div style="text-align: center; color: #999;">
                                <i class='bx bx-image' style="font-size: 3rem; margin-bottom: 10px;"></i>
                                <p style="margin: 0;">Gambar akan muncul di sini</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div style="margin-top: 30px; text-align: center;">
                <button type="submit" style="background: linear-gradient(135deg, var(--green1) 0%, var(--green2) 100%); color: white; border: none; padding: 15px 40px; border-radius: 8px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0, 94, 57, 0.3)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <i class='bx bx-plus-circle' style="margin-right: 8px;"></i>
                    Tambah Buku
                </button>
            </div>
        </form>
    </div>
</div>
        </main>
    </div>
</div>

<script>
function handleFileSelect(event) {
    const file = event.target.files[0];
    if (file) {
        previewImage(file);
    }
}

function handleDrop(event) {
    event.preventDefault();
    const uploadArea = document.getElementById('uploadArea');
    uploadArea.style.borderColor = '#e1e5e9';
    uploadArea.style.backgroundColor = 'transparent';
    
    const files = event.dataTransfer.files;
    if (files.length > 0) {
        const file = files[0];
        if (file.type.startsWith('image/')) {
            document.getElementById('coverImage').files = files;
            previewImage(file);
        } else {
            showError('Silakan pilih file gambar yang valid.');
        }
    }
}

function handleDragOver(event) {
    event.preventDefault();
    const uploadArea = document.getElementById('uploadArea');
    uploadArea.style.borderColor = 'var(--green1)';
    uploadArea.style.backgroundColor = 'rgba(0, 94, 57, 0.05)';
}

function handleDragLeave(event) {
    event.preventDefault();
    const uploadArea = document.getElementById('uploadArea');
    uploadArea.style.borderColor = '#e1e5e9';
    uploadArea.style.backgroundColor = 'transparent';
}

function previewImage(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;" alt="Preview">`;
    };
    reader.readAsDataURL(file);
}

function showError(message) {
    if (window.showError) {
        window.showError(message);
    } else {
        alert(message);
    }
}

// Category dropdown functions
function showCategoryDropdown() {
    const dropdown = document.getElementById('categoryDropdown');
    if (dropdown) {
        dropdown.style.display = 'block';
    }
}

function hideCategoryDropdown() {
    const dropdown = document.getElementById('categoryDropdown');
    if (dropdown) {
        dropdown.style.display = 'none';
    }
}

function filterCategories(searchTerm) {
    const options = document.querySelectorAll('.category-option');
    const searchLower = searchTerm.toLowerCase();
    
    options.forEach(option => {
        const name = option.dataset.name.toLowerCase();
        if (name.includes(searchLower)) {
            option.style.display = 'block';
        } else {
            option.style.display = 'none';
        }
    });
}

function selectCategory(id, name) {
    document.getElementById('categoryId').value = id;
    document.getElementById('categorySearch').value = name;
    hideCategoryDropdown();
}

// Form validation
document.getElementById('bookForm').addEventListener('submit', function(e) {
    const requiredFields = ['title', 'author', 'price', 'format'];
    let isValid = true;
    
    requiredFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (!field.value.trim()) {
            field.style.borderColor = '#ff3b30';
            isValid = false;
        } else {
            field.style.borderColor = '#e1e5e9';
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        showError('Mohon lengkapi semua field yang wajib diisi.');
    }
});
</script>

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
    
    div[style*="grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
    
    div[style*="grid-template-columns: 1fr 1fr; gap: 30px; align-items: start;"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection