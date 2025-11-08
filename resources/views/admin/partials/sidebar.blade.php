<!-- Admin Sidebar -->
<aside style="background:white; border-radius:15px; box-shadow:var(--shadow1); padding:20px; height: fit-content; position: sticky; top: 100px;">
    <div style="text-align: center; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 2px solid #f0f0f0;">
        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--green1) 0%, var(--green2) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
            <i class='bx bx-shield-check' style="font-size: 1.8rem; color: white;"></i>
        </div>
        <h4 style="margin: 0; color:   #2a2a2a; font-size: 1.1rem;">Admin Panel</h4>
        <p style="margin: 5px 0 0; color: #808080; font-size: 0.8rem;">{{ Auth::user()->name }}</p>
    </div>
    
    <nav>
        <ul style="display:grid; gap:8px; list-style: none; padding: 0; margin: 0;">
            @php
                $currentRoute = Route::currentRouteName();
            @endphp
            <li>
                <a href="{{ route('admin.dashboard') }}" 
                   style="display: flex; align-items: center; padding: 12px; border-radius: 8px; color: {{ $currentRoute === 'admin.dashboard' ? 'white' : '  #2a2a2a' }}; text-decoration: none; transition: all 0.3s ease; background: {{ $currentRoute === 'admin.dashboard' ? 'var(--green1)' : 'transparent' }};"
                   onmouseover="if('{{ $currentRoute }}' !== 'admin.dashboard') this.style.background='#f8f9fa'"
                   onmouseout="if('{{ $currentRoute }}' !== 'admin.dashboard') this.style.background='transparent'">
                    <i class='bx bxs-dashboard' style="margin-right: 10px;"></i>Dashboard Overview
                </a>
            </li>
            <li>
                <a href="{{ route('admin.books.index') }}" 
                   style="display: flex; align-items: center; padding: 12px; border-radius: 8px; color: {{ strpos($currentRoute, 'admin.books') !== false ? 'white' : '  #2a2a2a' }}; text-decoration: none; transition: all 0.3s ease; background: {{ strpos($currentRoute, 'admin.books') !== false ? 'var(--green1)' : 'transparent' }};"
                   onmouseover="if('{{ $currentRoute }}'.indexOf('admin.books') === -1) this.style.background='#f8f9fa'"
                   onmouseout="if('{{ $currentRoute }}'.indexOf('admin.books') === -1) this.style.background='transparent'">
                    <i class='bx bx-book' style="margin-right: 10px;"></i>Manajemen Buku
                </a>
            </li>
            <li>
                <a href="#" 
                   style="display: flex; align-items: center; padding: 12px; border-radius: 8px; color:   #2a2a2a; text-decoration: none; transition: all 0.3s ease;"
                   onmouseover="this.style.background='#f8f9fa'"
                   onmouseout="this.style.background='transparent'">
                    <i class='bx bx-category' style="margin-right: 10px;"></i>Manajemen Kategori
                </a>
            </li>
            <li>
                <a href="#" 
                   style="display: flex; align-items: center; padding: 12px; border-radius: 8px; color:   #2a2a2a; text-decoration: none; transition: all 0.3s ease;"
                   onmouseover="this.style.background='#f8f9fa'"
                   onmouseout="this.style.background='transparent'">
                    <i class='bx bx-user' style="margin-right: 10px;"></i>Manajemen User
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transactions.index') }}" 
                   style="display: flex; align-items: center; padding: 12px; border-radius: 8px; color: {{ strpos($currentRoute, 'admin.transactions') !== false ? 'white' : '  #2a2a2a' }}; text-decoration: none; transition: all 0.3s ease; background: {{ strpos($currentRoute, 'admin.transactions') !== false ? 'var(--green1)' : 'transparent' }};"
                   onmouseover="if('{{ $currentRoute }}'.indexOf('admin.transactions') === -1) this.style.background='#f8f9fa'"
                   onmouseout="if('{{ $currentRoute }}'.indexOf('admin.transactions') === -1) this.style.background='transparent'">
                    <i class='bx bx-receipt' style="margin-right: 10px;"></i>Transaksi & Pembayaran
                </a>
            </li>
            <li>
                <a href="{{ route('admin.notifications.index') }}" 
                   style="display: flex; align-items: center; padding: 12px; border-radius: 8px; color:   #2a2a2a; text-decoration: none; transition: all 0.3s ease;"
                   onmouseover="this.style.background='#f8f9fa'"
                   onmouseout="this.style.background='transparent'">
                    <i class='bx bx-bar-chart' style="margin-right: 10px;"></i>Laporan Penjualan
                </a>
            </li>
            <li>
                <a href="#" 
                   style="display: flex; align-items: center; padding: 12px; border-radius: 8px; color:   #2a2a2a; text-decoration: none; transition: all 0.3s ease;"
                   onmouseover="this.style.background='#f8f9fa'"
                   onmouseout="this.style.background='transparent'">
                    <i class='bx bx-cog' style="margin-right: 10px;"></i>Pengaturan Website
                </a>
            </li>
            <li style="margin-top: 10px;">
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); this.closest('form').submit();" 
                       style="display: flex; align-items: center; padding: 12px; border-radius: 8px; color: #dc3545; text-decoration: none; transition: all 0.3s ease;"
                       onmouseover="this.style.background='#fee'"
                       onmouseout="this.style.background='transparent'">
                        <i class='bx bx-log-out' style="margin-right: 10px;"></i>Logout
                    </a>
                </form>
            </li>
        </ul>
    </nav>
</aside>

