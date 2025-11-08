@extends('layouts.app')

@section('title', 'About - Econic')

@section('content')
    <section class="about-hero"
        style="padding: 90px 20px 30px; background: linear-gradient(180deg, rgba(82,199,19,0.12), transparent);">
        <div
            style="max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1.2fr 1fr;gap:24px;align-items:center;">
            <div>
                <h1 style="font-size:2.2rem;color:var(--black);margin-bottom:12px;">Tentang Econic</h1>
                <p style="color:var(--green4);line-height:1.7;">Econic adalah platform B2C buku yang berfokus pada pengalaman
                    belanja
                    yang bersih, cepat, dan aman. Kami menghubungkan pembaca dengan ribuan judul pilihan dengan kurasi
                    profesional.</p>
            </div>
            <div
                style="background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.08);height:220px;background-image:url('https://images.unsplash.com/photo-1514890547357-a9ee1c5c8d30?q=80&w=1400&auto=format&fit=crop');background-size:cover;background-position:center;">
            </div>
        </div>
    </section>

    <section class="about-content"
        style="max-width:1200px;margin:0 auto;padding:30px 20px 60px;display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:22px;">
        <div class="card" style="background:#fff;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.06);padding:20px;">
            <h3 style="padding-bottom:8px;color:#2a2a2a">Profil Perusahaan</h3>
            <p style="color:#005E39;line-height:1.7;">Didirikan untuk memudahkan akses literasi, Econic menghadirkan katalog
                buku luas, antarmuka intuitif, serta dukungan pelanggan yang responsif.</p>
        </div>
        <div class="card" style="background:#fff;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.06);padding:20px;">
            <h3 style="padding-bottom:8px;color:#2a2a2a">Visi & Misi</h3>
            <ul style="color:#005E39;line-height:1.8;padding-left:18px;">
                <li>Menyederhanakan penjelajahan dan pembelian buku secara digital.</li>
                <li>Mendorong pertumbuhan literasi melalui kurasi konten berkualitas.</li>
                <li>Menyediakan pengalaman pengguna yang cepat, aman, dan konsisten.</li>
            </ul>
        </div>
        <div class="card" style="background:#fff;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.06);padding:20px;">
            <h3 style="padding-bottom:8px;color:#2a2a2a">Tim Pengembang</h3>
            <p style="color:#005E39;line-height:1.7;">Tim lintas-disiplin yang berpengalaman dalam pengembangan web, UI/UX,
                dan
                manajemen produk, berkomitmen untuk inovasi berkelanjutan.</p>
        </div>
        <div class="card" style="background:#fff;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.06);padding:20px;">
            <h3 style="padding-bottom:8px;color:#2a2a2a">Testimonial</h3>
            <blockquote style="color:#444;border-left:4px solid var(--green2);padding-left:12px;margin:0;">
                “Antarmuka bersih dan mudah digunakan. Pengiriman cepat dan aman. Sangat direkomendasikan!” – Rina, Jakarta
            </blockquote>
        </div>
    </section>
@endsection