<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Dashboard</title>
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Navbar Styling */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1040; /* Ensure navbar is above everything */
        }

        .navbar-brand-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .navbar-brand-logo {
            width: 40px;
            height: 40px;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #f8f9fa;
            position: fixed;
            top: 0;
            left: 0;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 1050;
            padding-top: 80px; /* Offset navbar height */
        }

        .sidebar.visible {
            transform: translateX(0);
        }

        .sidebar a {
            text-decoration: none;
            color: #333;
            display: block;
            padding: 10px 20px;
        }

        .sidebar a:hover {
            background-color: #e9ecef;
            border-radius: 5px;
        }

        .sidebar .active {
            background-color: #e9ecef;
            font-weight: bold;
            border-radius: 5px;
        }

        /* Content Styling */
        .content {
            flex: 1;
            padding: 20px;
            width: 100%;
            margin-top: 80px; /* Offset navbar height */
            z-index: 1000;
            background-color: #fff; /* Ensure visible content area */
        }

        /* Toggle Button */
        .toggle-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1100;
            background-color: #f8f9fa;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand navbar-brand-center" href="{{ route('login.dashboard') }}">
                Kantin FT UNY
            </a>
            <div class="ms-auto">
                <a href="{{ route('login.dashboard') }}">
                    <img src="{{ asset('img/INFO_MADANG.png') }}" class="navbar-brand-logo" alt="InfoMadang Logo">
                </a>
            </div>
        </div>
    </nav>

    <!-- Toggle Button -->
    <button class="toggle-btn" id="sidebarToggle">☰</button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="text-center mb-4">
            <img src="{{ asset('img/INFO_MADANG.png') }}" style="width: 60px; height: 60px;" alt="Logo">
            <h5>Kantin FT UNY</h5>
        </div>
        <a href="{{ route('login.dashboard') }}" class="{{ request()->routeIs('login.dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('customer.cart') }}" class="{{ request()->routeIs('customer.cart') ? 'active' : '' }}">Keranjang</a>
        <a href="{{ route('customer.orders') }}" class="{{ request()->routeIs('customer.orders') ? 'active' : '' }}">Status dan Riwayat Pembelian</a>
        <a href="{{ route('customer.profile') }}" class="{{ request()->routeIs('customer.profile') ? 'active' : '' }}">Profil</a>
    </div>

    <!-- Content -->
    <div class="content" id="mainContent">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('visible');
        });
    </script>
</body>
</html>
