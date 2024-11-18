<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Owner Dashboard</title>
    <style>
        body {
            display: flex;
            flex-direction: column; /* Navbar di atas, sidebar dan konten di bawah */
            min-height: 100vh;
            padding-top: 56px; /* Ruang untuk navbar */
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1050; /* Navbar di atas sidebar */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #f8f9fa;
            position: fixed;
            top: 0;
            left: 0;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 1040; /* Sidebar di bawah navbar */
            margin-top: 56px; /* Jarak dari navbar */
            padding-top: 20px;
        }
        .sidebar.visible {
            transform: translateX(0);
        }
        .content {
            margin-left: 0;
            padding: 20px;
            width: 100%;
            transition: margin-left 0.3s ease;
        }
        .content.sidebar-visible {
            margin-left: 250px;
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
        .toggle-btn {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1100; /* Di atas sidebar */
            background-color: #f8f9fa;
            border: none;
            padding: 10px;
            border-radius: 0px;
            cursor: pointer;
            /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); */
        }
        .navbar-brand-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
        .navbar-logo {
            width: 40px;
            height: 40px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <!-- Centered Title -->
            <a class="navbar-brand navbar-brand-center" href="{{ route('login.dashboard') }}">
                Kantin FT UNY
            </a>

            <!-- Right Logo -->
            <div class="ms-auto">
                <a href="{{ route('owner.dashboard') }}">
                    <img src="{{ asset('img/INFO_MADANG.png') }}" class="navbar-logo" alt="InfoMadang Logo">
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
        <a href="{{ route('dashboard.owner') }}" class="{{ request()->routeIs('dashboard.owner') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('owner.products') }}" class="{{ request()->routeIs('owner.products') ? 'active' : '' }}">Produk</a>
        <a href="{{ route('owner.orders') }}" class="{{ request()->routeIs('owner.orders') ? 'active' : '' }}">Pesanan</a>
        <a href="{{ route('owner.reports') }}" class="{{ request()->routeIs('owner.reports') ? 'active' : '' }}">Laporan</a>
        <a href="{{ route('owner.profile') }}" class="{{ request()->routeIs('owner.profile') ? 'active' : '' }}">Profil</a>
        {{-- <form action="{{ route('logout') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="btn btn-link text-danger w-100 text-start">Logout</button>
        </form> --}}
    </div>

    <!-- Content -->
    <div class="content" id="mainContent">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('sidebarToggle');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('visible');
            content.classList.toggle('sidebar-visible');
        });
    </script>
</body>
</html>
