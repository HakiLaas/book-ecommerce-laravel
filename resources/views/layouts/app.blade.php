<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Econic Book Store')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script src="{{ asset('js/notifications.js') }}" defer></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: poppins, sans-serif;
            text-decoration: none;
            transition: all .3s ease;
            scroll-behavior: smooth;
        }

        body.dark {
            --black: #fafdff;
            --white: #0b140e;
            --whitegray: #cccccc;
            --shadow1: 0 8px 20px 0 hsla(0, 0%, 100%, 0.05);
            --shadow2: 0 4px 6px rgba(0, 0, 0, 0.1);
            --green3: #FBEAE0;
            --whitecream: #005E39;
            --green4: #52c713;
        }

        :root {
            /* Dark mode color */
            --white: #fafdff;
            --black: #0b140e;

            --whitegray: #b9b9b9;

            /* Primary Color */
            --green1: #005E39;
            --green2: #52c713;
            --green3: #005E39;
            --green4: #005E39;
            /* Secondary color */
            --orange1: #FD9852;
            --orange2: ;
            --whitecream: #FBEAE0;

            /* Shadow */
            --shadow1: 0 2px 10px rgba(0, 0, 0, 0.1);
            --shadow2: 0 4px 6px rgba(255, 255, 255, 0.4);
            /* Discount */
            --discount1: ;
            --discount2: ;

            /* Font Size */
            --fontsize1: 3.2rem;
            --fontsize2: 2.7rem;
            --fontsize3: 2.3rem;
            --fontsize4: 2.1rem;
            --fontsize5: 1.9rem;
            --fontsize6: 1.6rem;
            --fontsize7: 1.2rem;

            /* Radius */
            --radius-6: 6px;
            --radius-12: 12px;
            --radius-24: 24px;
            --radius-32: 32px;
            --radius-circle: 50%;

            /* Font Weight */
            --weight-thin: 300;
            --weight-normal: 400;
            --weight-medium: 500;
            --weight-semibold: 600;
            --weight-bold: 700;
            --weight-extrabold: 800;
        }

        body {
            background-color: #f4f4f4;
        }

        body.dark .shop-container,
        body.dark .product-detail-container,
        body.dark .search-filter-bar,
        body.dark .book-card,
        body.dark .product-card,
        body.dark .product-detail-main,
        body.dark .product-tabs,
        body.dark .cart-dropdown,
        body.dark .favorite-menu,
        body.dark .authors-panel {
            color: #2a2a2a;
        }

        /* body.dark .search-filter-bar,
        body.dark .book-card,
        body.dark .product-card {
            border: 1px solid #333;
        } */

        body.dark input,
        body.dark select,
        body.dark textarea {
            background-color: #2a2a2a;
            color: #2a2a2a;
            border-color: #444;
        }

        body.dark input::placeholder {
            color: #888;
        }

        body.dark .dropdown-menu {
            background-color: #1e1e1e;
            border-color: #333;
        }

        body.dark .dropdown-menu h4,
        body.dark .dropdown-menu ul li a {
            color: var(--black);
        }

        body.dark table {
            background-color: #1e1e1e;
        }

        body.dark th {
            background-color: #808080;
            color: #2a2a2a;
        }

        body.dark td {
            color: #2a2a2a;
            border-color: #333;
        }

        body.dark tr:nth-child(even) {
            background-color: #252525;
        }

        body.dark tr:hover {
            background-color: #808080;
        }

        body.dark .pagination li a,
        body.dark .pagination li span {
            background-color: #808080;
            border-color: #444;
            color: #2a2a2a;
        }

        body.dark .pagination .active span {
            background: var(--green2);
            color: white;
        }

        body.dark .pagination li.disabled span,
        body.dark .pagination li.disabled a {
            background: #1e1e1e;
        }

        /* Navbar Styles */
        #header {
            width: 100%;
            position: fixed;
            background: var(--green3);
            z-index: 999;
            top: 0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
            padding: 0 50px;
            border-bottom: 1px solid var(--white);
        }

        #navbar ul {
            display: flex;
            align-items: center;
        }

        .navbar ul li a,
        .navbar ul li .bx,
        .logo h2 {
            color: var(--white);
            cursor: pointer;
            font-size: 1rem;
        }

        .navbar span {
            color: var(--white);
        }

        #navbar ul li {
            padding: 0 20px;
            list-style: none;
        }

        .navbar.scrolled {
            background: var(--whitecream);
            box-shadow: var(--shadow1);
            border: none;
        }

        .navbar.scrolled ul li a,
        .navbar.scrolled i,
        .navbar.scrolled h2,
        .navbar.scrolled span,
        .navbar.scrolled ul li i {
            color: var(--black);
        }

        /* Dropdown Styles */
        .dropdown {
            position: relative;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: 40px;
            right: 0;
            background-color: white;
            border: 1px solid #ddd;
            width: 200px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 10px;
            display: none;
            z-index: 100;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .dropdown-menu h4 {
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: bold;
        }

        .dropdown-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: block;
        }

        .dropdown-menu ul li {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }

        .dropdown-menu ul li:last-child {
            border-bottom: none;
        }

        .dropdown:hover .dropdown-menu,
        .dropdown:focus-within .dropdown-menu {
            display: block;
            opacity: 1;
        }

        #user-dropdown {
            display: flex;
            opacity: 1;
            flex-direction: column;
        }

        /* Search Bar */
        .search-bar {
            display: flex;
            align-items: center;
            color: var(--black);
            border: 1px solid var(--whitegray);
            border-radius: 20px;
            padding: 5px 15px;
            background-color: rgba(255, 255, 255, 0.8);
        }

        .search-bar input {
            border: none;
            outline: none;
            color: var(--black);
            background: transparent;
            width: 200px;
            padding: 5px;
        }

        .search-bar input::placeholder {
            color: var(--whitegray);
        }

        .search-bar .bx {
            font-size: 1.2rem;
            color: var(--black);
        }

        /* Icons */
        .icons {
            display: flex;
            align-items: center;
        }

        .icons span {
            margin: 0 10px;
        }

        .icons ul {
            display: flex;
            align-items: center;
        }

        .icons ul li {
            position: relative;
        }

        /* Cart Count Badge */
        .cart-count,
        .favorites-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--orange1);
            color: white;
            font-size: 0.7rem;
            font-weight: bold;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .cart-count.show,
        .favorites-count.show {
            display: flex;
        }

        /* Cart Dropdown */
        .cart-dropdown {
            width: 320px;
            padding: 15px;
        }

        .cart-item {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .cart-item-image {
            width: 60px;
            height: 60px;
            border-radius: 5px;
            overflow: hidden;
            margin-right: 10px;
        }

        .cart-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-title {
            font-weight: 500;
            margin-bottom: 5px;
            font-size: 0.9rem;
            color: var(--black);
        }

        .cart-item-price {
            color: var(--green2);
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .cart-item-quantity {
            font-size: 0.8rem;
            color: #808080;
        }

        .cart-item-remove {
            color: #ff6b6b;
            cursor: pointer;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar .cart-total {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .navbar .cart-total-label {
            font-weight: 500;
            color: var(--black);
        }

        .navbar .cart-total-price {
            font-weight: 600;
            color: var(--black);
        }

        .cart-buttons {
            display: flex;
            gap: 10px;
        }

        .cart-view-btn,
        .cart-checkout-btn {
            flex: 1;
            padding: 8px 0;
            text-align: center;
            border-radius: 5px;
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .cart-view-btn {
            background-color: #f1f1f1;
            color: var(--black);
        }

        .cart-checkout-btn {
            background-color: var(--green2);
            color: white;
        }

        .cart-empty {
            text-align: center;
            padding: 20px 0;
            color: #808080;
        }

        /* Favorite Dropdown - Same style as Cart */
        .favorite-menu {
            width: 320px;
            padding: 15px;
        }

        .favorite-item {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .favorite-item-image {
            width: 60px;
            height: 60px;
            border-radius: 5px;
            overflow: hidden;
            margin-right: 10px;
        }

        .favorite-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .favorite-item-info {
            flex: 1;
        }

        .favorite-item-title {
            font-weight: 500;
            margin-bottom: 5px;
            font-size: 0.9rem;
            color: var(--black);
        }

        .favorite-item-price {
            color: var(--green1);
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .favorite-item-remove {
            color: #ff6b6b;
            cursor: pointer;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .favorite-total {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .navbar .favorite-total-label {
            font-weight: 500;
            color: var(--black);
        }

        .navbar .favorite-total-count {
            font-weight: 600;
            color: var(--black);
        }

        .favorite-buttons {
            display: flex;
            gap: 10px;
        }

        .favorite-view-btn {
            flex: 1;
            padding: 8px 0;
            text-align: center;
            border-radius: 5px;
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            background-color: var(--green2);
            color: white;
            text-decoration: none;
        }

        .favorite-empty {
            text-align: center;
            padding: 20px 0;
            color: #808080;
        }

        /* Pagination Styling */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            gap: 8px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .pagination li {
            margin: 0;
        }

        .pagination li a,
        .pagination li span {
            padding: 6px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: var(--black);
            transition: all 0.3s ease;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
        }

        .pagination li a:hover:not(.disabled) {
            background: var(--green2);
            color: white;
            border-color: var(--green2);
        }

        .pagination .active span {
            background: var(--green2);
            color: white;
            border-color: var(--green2);
            font-weight: 500;
        }

        .pagination li.disabled span,
        .pagination li.disabled a {
            opacity: 0.4;
            cursor: not-allowed;
            pointer-events: none;
            background: #f5f5f5;
        }

        .pagination li:first-child a,
        .pagination li:last-child a {
            font-weight: 500;
        }

        .icons ul li {
            margin: 0 5px;
        }

        .icons ul li a .bx,
        .icons ul li .bx {
            font-size: 1.5rem;
            padding: 5px;
        }

        /* Content Area */
        .content-area {
            margin-top: 70px;
        }

        /* Product Cards */
        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px 0;
        }

        .product-card {
            background: white;
            border-radius: var(--radius-12);
            overflow: hidden;
            box-shadow: var(--shadow1);
            width: 280px;
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            max-width: 100%;
            max-height: 100%;
        }

        .product-info {
            padding: 15px;
        }

        .product-info h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .product-info p {
            color: #808080;
            margin: 5px 0;
        }

        .price {
            font-weight: bold;
            color: var(--green1);
            font-size: 1.1rem;
        }

        .btn-primary {
            background-color: var(--green2);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: var(--radius-6);
            cursor: pointer;
            display: inline-block;
            margin-top: 10px;
            text-align: center;
        }

        .btn-primary:hover {
            background-color: var(--green1);
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: var(--shadow1);
            border-radius: var(--radius-6);
            overflow: hidden;
        }

        th {
            background-color: var(--green2);
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .favorite-items-container {
            max-height: 250px;
            overflow-y: auto;
        }

        .cart-items-container {
            max-height: 250px;
            overflow-y: auto;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                padding: 0 20px;
            }

            #navbar ul li {
                padding: 0 10px;
            }

            .search-bar {
                display: none;
            }

            .product-card {
                width: 100%;
                max-width: 300px;
            }

            .product-container {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 15px;
                padding: 15px;
            }

            .icons ul li {
                margin: 0 3px;
            }

            .icons ul li a .bx,
            .icons ul li .bx {
                font-size: 1.3rem;
            }

            .dropdown-menu {
                width: 180px;
                right: -10px;
            }

            .cart-dropdown {
                width: 280px;
            }

            .content-area {
                margin-top: 70px;
            }
        }

        @media (max-width: 480px) {
            .navbar {
                padding: 0 15px;
            }

            .logo h2 {
                font-size: 1.2rem;
            }

            #navbar ul li {
                padding: 0 5px;
            }

            #navbar ul li a {
                font-size: 0.9rem;
            }

            .icons ul li {
                margin: 0 2px;
            }

            .icons ul li a .bx,
            .icons ul li .bx {
                font-size: 1.2rem;
            }

            .product-container {
                grid-template-columns: 1fr;
                gap: 10px;
                padding: 10px;
            }

            .product-card {
                max-width: 100%;
            }

            .dropdown-menu {
                width: 160px;
                right: -20px;
            }

            .cart-dropdown {
                width: 260px;
            }
        }

        /* Form Responsive */
        @media (max-width: 768px) {
            .checkout-form {
                grid-template-columns: 1fr !important;
            }

            .product-detail-main {
                flex-direction: column !important;
            }

            .product-image-container {
                min-width: 100% !important;
            }

            .product-info-container {
                min-width: 100% !important;
                padding: 20px !important;
            }

            .action-buttons {
                flex-direction: column !important;
                gap: 10px !important;
            }

            .action-buttons button {
                flex: none !important;
                width: 100% !important;
            }
        }

        /* Table Responsive */
        @media (max-width: 768px) {
            table {
                font-size: 0.8rem;
            }

            th,
            td {
                padding: 8px;
            }

            .container1 {
                overflow-x: auto;
            }
        }

        /* Notification Responsive */
        @media (max-width: 480px) {
            .notification {
                right: 10px !important;
                left: 10px !important;
                width: auto !important;
            }
        }

        .navbar .cart-buttons a{
            color: #2a2a2a;
        }

        .navbar .favorite-buttons a{
            color: #2a2a2a;
        }

        .navbar .dropdown-menu ul li a{
            color: var(--black);
        }
    </style>
</head>

<body>
    <header id="header">
        <nav id="navbar" class="navbar">
            <div class="logo">
                <h2>Econic</h2>
            </div>
            <!-- <div class="search-bar" id="navSearch">
                <input type="text" placeholder="Search for anything">
                <i class='bx bx-search'></i>
            </div> -->
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('shop') }}">Shop</a></li>
                @if(Auth::check())
                    @if(Auth::user()->role === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    @endif
                    <li><a href="{{ route('transactions.index') }}">Transactions</a></li>
                @endif
                <li><a href="{{ route('about') }}">About</a></li>
                <li><a href="#footer">Contact</a></li>
            </ul>
            <div class="icons">
                <ul>
                    <!-- Cart Dropdown -->
                    <li class="dropdown">
                        <a href="#"><i class='bx bx-cart'></i></a>
                        <span class="cart-count">0</span>
                        <div class="dropdown-menu cart-dropdown">
                            <h4 style="color: var(--black);">Shopping Cart</h4>
                            <div class="cart-items-container">
                                <!-- Cart items will be dynamically added here -->
                            </div>
                            <div class="cart-total">
                                <span class="cart-total-label">Total:</span>
                                <span class="cart-total-price">Rp 0</span>
                            </div>
                            <div class="cart-buttons">
                                <a href="{{ route('cart.index') }}" class="cart-view-btn">View Cart</a>
                                <a href="{{ route('checkout') }}" class="cart-checkout-btn">Checkout</a>
                            </div>
                            <div class="cart-empty">
                                Your cart is empty
                            </div>
                        </div>
                    </li>

                    <!-- Favorite Dropdown -->
                    <li class="dropdown">
                        <a href="{{ route('favorites') }}"><i class='bx bx-heart'></i></a>
                        <span class="favorites-count">0</span>
                        <div class="dropdown-menu favorite-menu">
                            <h4 style="var(--black)">Favorite Items</h4>
                            <div class="favorite-items-container">
                                <!-- Favorite items will be dynamically added here -->
                            </div>
                            <div class="favorite-total">
                                <span class="favorite-total-label">Total Items:</span>
                                <span class="favorite-total-count">0</span>
                            </div>
                            <div class="favorite-buttons">
                                <a href="{{ route('favorites') }}" class="favorite-view-btn">View Favorites</a>
                            </div>
                            <div class="favorite-empty">
                                No favorites yet
                            </div>
                        </div>
                    </li>
                </ul>
                <span>|</span>
                <ul id="user-menu">
                    <li><i class='bx bx-moon' id="theme"></i></li>
                    @guest
                        <li><a href="{{ route('user.login') }}"><i class='bx bx-user'></i>Sign In</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#"><i class='bx bx-user'></i>{{ Auth::user()->name }}</a>
                            <div class="dropdown-menu">
                                <h4 style="color: var(--black);">Account</h4>
                                <ul id="user-dropdown">
                                    @if(Auth::user()->role === 'admin')
                                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li><br>
                                        <li><a href="{{ route('admin.books.index') }}">Manage Books</a></li><br>
                                    @else
                                        <li><a href="{{ route('user.dashboard') }}">My Dashboard</a></li><br>
                                    @endif
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                    this.closest('form').submit();">
                                                Logout
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>
    </header>

    <div class="content-area">
        @yield('content')
    </div>

    <footer id="footer" class="site-footer">
        <div class="footer-inner">
            <div class="footer-col">
                <h4>Econic</h4>
                <p>Platform buku untuk semua. Temukan, baca, dan jelajahi pengetahuan.</p>
                <div class="socials">
                    <a href="#" aria-label="Facebook"><i class='bx bxl-facebook'></i></a>
                    <a href="#" aria-label="Instagram"><i class='bx bxl-instagram'></i></a>
                    <a href="#" aria-label="Twitter"><i class='bx bxl-twitter'></i></a>
                    <a href="#" aria-label="LinkedIn"><i class='bx bxl-linkedin'></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h5>Navigation</h5>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('shop') }}">Shop</a></li>
                    <li><a href="{{ route('about') }}">About</a></li>
                    @auth
                        <li><a href="{{ route('transactions.index') }}">Transactions</a></li>
                    @endauth
                </ul>
            </div>
            <div class="footer-col">
                <h5>Important Links</h5>
                <ul>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Help Center</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h5>Contact</h5>
                <ul class="contact-list">
                    <li><i class='bx bx-map'></i> Jakarta, Indonesia</li>
                    <li><i class='bx bx-phone'></i> +62 811-0000-000</li>
                    <li><i class='bx bx-envelope'></i> support@econic.id</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="footer-bottom-inner">
                <span>© {{ date('Y') }} Econic. All rights reserved.</span>
                <div class="footer-mini-nav">
                    <a href="#">Sitemap</a>
                    <a href="#">Accessibility</a>
                    <a href="#">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const themeToggle = document.getElementById("theme");
            const body = document.body;

            // Load saved theme preference
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                body.classList.add("dark");
                if (themeToggle) {
                    themeToggle.classList.remove("bx-moon");
                    themeToggle.classList.add("bx-sun");
                }
            }

            if (themeToggle) {
                themeToggle.addEventListener("click", () => {
                    body.classList.toggle("dark");

                    // Save theme preference
                    if (body.classList.contains("dark")) {
                        localStorage.setItem('theme', 'dark');
                        themeToggle.classList.remove("bx-moon");
                        themeToggle.classList.add("bx-sun");
                    } else {
                        localStorage.setItem('theme', 'light');
                        themeToggle.classList.remove("bx-sun");
                        themeToggle.classList.add("bx-moon");
                    }
                });
            }

            window.addEventListener('scroll', function () {
                const navbar = document.getElementById('navbar');

                if (navbar) {
                    if (window.scrollY > 10) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                }
            });

            // Cart functionality
            // Initialize cart
            updateCartDisplay();

            // Function to update cart display from database
            function updateCartDisplay() {
                const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

                if (!isLoggedIn) {
                    return;
                }

                fetch('/cart/items/list')
                    .then(response => response.json())
                    .then(data => {
                        const cartItemsContainer = document.querySelector('.cart-items-container');
                        const cartEmptyMessage = document.querySelector('.cart-empty');
                        const cartCount = document.querySelector('.cart-count');
                        const cartTotalPrice = document.querySelector('.cart-total-price');

                        // Update cart count
                        cartCount.textContent = data.count || 0;
                        if (data.count > 0) {
                            cartCount.classList.add('show');
                        } else {
                            cartCount.classList.remove('show');
                        }

                        // Clear cart items container
                        cartItemsContainer.innerHTML = '';

                        // Show/hide empty cart message
                        if (!data.items || data.items.length === 0) {
                            cartEmptyMessage.style.display = 'block';
                            cartTotalPrice.textContent = 'Rp 0';
                            return;
                        }

                        cartEmptyMessage.style.display = 'none';

                        // Add cart items
                        data.items.forEach((item) => {
                            const cartItem = document.createElement('div');
                            cartItem.className = 'cart-item';
                            cartItem.innerHTML = `
                                <div class="cart-item-image">
                                    <img src="${item.image ? '{{ asset("storage/cover_images/") }}/' + item.image : '{{ asset("storage/cover_images/default-book.jpg") }}'}" alt="${item.title}" loading="lazy" onerror="this.src='{{ asset("storage/cover_images/default-book.jpg") }}'">
                                </div>
                                <div class="cart-item-info">
                                    <div class="cart-item-title">${item.title}</div>
                                    <div class="cart-item-price">Rp ${parseInt(item.price).toLocaleString('id-ID')}</div>
                                    <div class="cart-item-quantity">Qty: ${item.quantity}</div>
                                </div>
                                <div class="cart-item-remove" data-item-id="${item.id}">
                                    <i class='bx bx-x'></i>
                                </div>
                            `;

                            cartItemsContainer.appendChild(cartItem);

                            // Add event listener to remove button
                            cartItem.querySelector('.cart-item-remove').addEventListener('click', function () {
                                removeCartItem(this.dataset.itemId);
                            });
                        });

                        // Update total price
                        cartTotalPrice.textContent = `Rp ${parseInt(data.total || 0).toLocaleString('id-ID')}`;
                    })
                    .catch(error => {
                        console.error('Error fetching cart:', error);
                    });
            }

            // Function to remove cart item
            function removeCartItem(itemId) {
                fetch(`/cart/items/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateCartDisplay();
                            refreshCounts();
                        }
                    })
                    .catch(error => {
                        console.error('Error removing cart item:', error);
                    });
            }
        });
    </script>
    <script>
        // Favorites functionality
        function updateFavoriteDisplay() {
            const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

            if (!isLoggedIn) {
                return;
            }

            fetch('/favorites/items/list')
                .then(response => response.json())
                .then(data => {
                    const favoriteItemsContainer = document.querySelector('.favorite-items-container');
                    const favoriteEmptyMessage = document.querySelector('.favorite-empty');
                    const favoritesCount = document.querySelector('.favorites-count');
                    const favoriteTotalCount = document.querySelector('.favorite-total-count');

                    // Update favorites count badge
                    favoritesCount.textContent = data.count || 0;
                    if (data.count > 0) {
                        favoritesCount.classList.add('show');
                    } else {
                        favoritesCount.classList.remove('show');
                    }

                    // Clear favorite items container
                    favoriteItemsContainer.innerHTML = '';

                    // Show/hide empty favorite message
                    if (!data.items || data.items.length === 0) {
                        favoriteEmptyMessage.style.display = 'block';
                        favoriteTotalCount.textContent = '0';
                        return;
                    }

                    favoriteEmptyMessage.style.display = 'none';
                    favoriteTotalCount.textContent = data.count;

                    // Add favorite items
                    data.items.forEach((item) => {
                        const favoriteItem = document.createElement('div');
                        favoriteItem.className = 'favorite-item';
                        favoriteItem.innerHTML = `
                            <div class="favorite-item-image">
                                <img src="${item.image ? '{{ asset("storage/cover_images/") }}/' + item.image : '{{ asset("storage/cover_images/default-book.jpg") }}'}" alt="${item.title}" loading="lazy" onerror="this.src='{{ asset("storage/cover_images/default-book.jpg") }}'">
                            </div>
                            <div class="favorite-item-info">
                                <div class="favorite-item-title"><a href="/books/${item.book_id}" style="color: var(--black); text-decoration: none;">${item.title}</a></div>
                                <div class="favorite-item-price">Rp ${parseInt(item.price).toLocaleString('id-ID')}</div>
                            </div>
                            <div class="favorite-item-remove" data-book-id="${item.book_id}">
                                <i class='bx bx-x'></i>
                            </div>
                        `;

                        favoriteItemsContainer.appendChild(favoriteItem);

                        // Add event listener to remove button
                        favoriteItem.querySelector('.favorite-item-remove').addEventListener('click', function () {
                            removeFavorite(this.dataset.bookId);
                        });
                    });
                })
                .catch(error => {
                    console.error('Error fetching favorites:', error);
                });
        }

        function removeFavorite(bookId) {
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
                        updateFavoriteDisplay();
                        updateFavoritesCount();
                        refreshCounts();

                        // Update button appearance
                        const btn = document.querySelector(`[data-book-id="${bookId}"]`);
                        if (btn) {
                            const icon = btn.querySelector('i');
                            icon.classList.remove('bxs-heart');
                            icon.classList.add('bx-heart');
                            icon.style.color = '#999';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error removing favorite:', error);
                });
        }

        function toggleFavorite(book) {
            // Check if user is logged in
            const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

            if (!isLoggedIn) {
                showNotification('Silakan login untuk menambahkan ke favorit', 'error');
                return;
            }

            fetch('/favorites/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    book_id: book.id
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        updateFavoritesCount();
                        updateFavoriteDisplay();

                        // Update button appearance
                        const btn = document.querySelector(`[data-book-id="${book.id}"]`);
                        if (btn) {
                            const icon = btn.querySelector('i');
                            if (data.is_favorited) {
                                icon.classList.remove('bx-heart');
                                icon.classList.add('bxs-heart');
                                icon.style.color = '#ff6b6b';
                            } else {
                                icon.classList.remove('bxs-heart');
                                icon.classList.add('bx-heart');
                                icon.style.color = '#999';
                            }
                        }
                    } else {
                        showNotification(data.error || 'Terjadi kesalahan', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan', 'error');
                });
        }

        function updateFavoritesCount() {
            fetch('/favorites/count')
                .then(response => response.json())
                .then(data => {
                    const favoritesCountEl = document.querySelector('.favorites-count');
                    if (favoritesCountEl) {
                        favoritesCountEl.textContent = data.count;
                        if (data.count > 0) {
                            favoritesCountEl.classList.add('show');
                        } else {
                            favoritesCountEl.classList.remove('show');
                        }
                    }
                });
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
             ${type === 'success' ? 'background-color: #808080;' : 'background-color: #ff6b6b;'}
         `;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Attach listener to favorite buttons on page
        document.addEventListener('click', function (e) {
            if (e.target.closest('.favorite-btn')) {
                const btn = e.target.closest('.favorite-btn');
                const bookId = btn.getAttribute('data-book-id');

                if (!bookId) {
                    // Try to get book ID from various sources
                    const card = btn.closest('.product-card') || document.querySelector('.product-image-container');
                    const bookIdEl = card ? card.querySelector('[data-book-id]') : document.querySelector('[data-book-id]');
                    const bookIdValue = bookIdEl ? parseInt(bookIdEl.getAttribute('data-book-id')) : null;

                    if (!bookIdValue) {
                        // Try to extract from URL
                        const urlMatch = window.location.pathname.match(/\/books\/(\d+)/);
                        if (urlMatch) {
                            const book = {
                                id: parseInt(urlMatch[1]),
                                title: 'Unknown',
                                image: null,
                                price: 0
                            };
                            toggleFavorite(book);
                        }
                    } else {
                        const book = {
                            id: bookIdValue,
                            title: 'Unknown',
                            image: null,
                            price: 0
                        };
                        toggleFavorite(book);
                    }
                } else {
                    const book = {
                        id: parseInt(bookId),
                        title: 'Unknown',
                        image: null,
                        price: 0
                    };
                    toggleFavorite(book);
                }
            }
        });

        // Initial render
        updateFavoriteDisplay();
        updateFavoritesCount();
    </script>
    <script>
        function refreshCounts() {
            const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

            if (!isLoggedIn) {
                return;
            }

            fetch('/cart/count').then(r => r.json()).then(d => {
                const el = document.querySelector('.cart-count');
                if (el) {
                    el.textContent = d.count;
                    if (d.count > 0) {
                        el.classList.add('show');
                    } else {
                        el.classList.remove('show');
                    }
                }
                // Also update cart display
                updateCartDisplay();
            });
            fetch('/favorites/count').then(r => r.json()).then(d => {
                const el = document.querySelector('.favorites-count');
                if (el) {
                    el.textContent = d.count;
                    if (d.count > 0) {
                        el.classList.add('show');
                    } else {
                        el.classList.remove('show');
                    }
                }
                // Also update favorites display
                updateFavoriteDisplay();
            });
        }
        document.addEventListener('DOMContentLoaded', refreshCounts);
    </script>
</body>

</html>