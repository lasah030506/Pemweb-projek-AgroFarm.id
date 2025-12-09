<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroFarm Dashboard</title>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('style/style.css') }}">
    <link rel="stylesheet" href="{{ asset('style/dashboard.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <!-- SIDEBAR -->
    <div class="sidebar" style="background: #2D4A3E; border-radius: 0 20px 20px 0; border: none; padding-top: 30px;">
        <h2 style="text-align: center; color: #8FBC8F; font-size: 1.5rem; margin-bottom: 50px; display: flex; align-items: center; justify-content: center; gap: 10px;">
            <i class="fas fa-leaf"></i> AgroFarm
        </h2>
        <ul class="sidebar-menu">
            <li>
                <a href="#" style="color: rgba(255,255,255,0.8);">
                    <i class="fas fa-info-circle"></i>
                    <span>Tentang AgroFarm</span>
                </a>
            </li>
            <li>
                <a href="{{ route('commodities.index') }}" class="{{ request()->routeIs('commodities.*') ? 'active' : '' }}" style="color: rgba(255,255,255,0.8);">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Harga Pasar</span>
                </a>
            </li>
            <li style="margin-top: 30px;">
                <a href="#" style="color: rgba(255,255,255,0.8);">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- NAVBAR -->
    <nav class="navbar--dashboard" style="background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border-radius: 15px; border: none; padding: 15px 30px; box-shadow: none;">
        <h1 style="font-size: 1.2rem; color: #2ecc71; font-weight: bold;">
            Dashboard Pengguna
        </h1>
        <div style="display: flex; align-items: center; gap: 10px; color: #555; font-size: 0.9rem;">
            <span>Selamat datang, User 👋</span>
        </div>
    </nav>

    <!-- TOAST NOTIFICATION -->
    @if(session('success'))
        <div class="toast show">
            <i class="fas fa-check-circle" style="margin-right: 10px;"></i>
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.toast').classList.remove('show');
            }, 3000);
        </script>
    @endif

    <!-- MAIN CONTENT -->
    <main style="margin-top: 100px;">
        @yield('content')
    </main>

</body>
</html>
