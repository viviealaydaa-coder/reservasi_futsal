<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KickIn — Book It, Own It')</title>

    {{-- Bootstrap & Font Awesome --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    {{-- FONT MODERN (Montserrat + Inter) --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --cream: #0f0f0f;
            --kickin-orange: #e85d00;
            --kickin-orange-light: #ff7a1a;
            --kickin-orange-dark: #c44d00;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(160deg, #141414 0%, #0f0f0f 50%, #111008 100%);
            background-attachment: fixed;
            color: #d0d0d0;
            font-family: 'Inter', 'Poppins', 'Segoe UI', sans-serif;
        }

        /* NAVBAR */
        .navbar {
            background: linear-gradient(90deg, #1a1a1a 0%, #141414 100%) !important;
            border-bottom: 1px solid #2a2a2a;
            box-shadow: 0 2px 20px rgba(0,0,0,0.4);
        }

        .navbar-brand, .nav-link {
            color: #ffffff !important;
            font-weight: 600;
        }

        .nav-link:hover { color: #e85d00 !important; }

        /* BUTTONS */
        .btn-primary {
            background: linear-gradient(135deg, #e85d00, #ff7a1a);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #c44d00, #e85d00);
        }

        .btn-warning-custom {
            background: linear-gradient(135deg, #e85d00, #ff7a1a);
            color: #ffffff;
            font-weight: bold;
            border: none;
        }

        .btn-warning-custom:hover {
            background: linear-gradient(135deg, #c44d00, #e85d00);
            color: #fff;
        }

        .btn-outline-light {
            border-color: #e85d00;
            color: #e85d00;
        }

        .btn-outline-light:hover {
            background: linear-gradient(135deg, #e85d00, #ff7a1a);
            border-color: transparent;
            color: #fff;
        }

        /* CARDS */
        .card {
            background: linear-gradient(145deg, #1c1c1c, #161616);
            border: 1px solid #272727 !important;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.3);
            transition: transform 0.3s, box-shadow 0.3s;
            color: #d0d0d0;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 32px rgba(232,93,0,0.15);
            border-color: #e85d00 !important;
        }

        /* FORM */
        .form-control, .form-select {
            background: #161616;
            border-color: #2a2a2a;
            color: #d0d0d0;
        }

        .form-control:focus, .form-select:focus {
            background: #1a1a1a;
            border-color: #e85d00;
            color: #d0d0d0;
            box-shadow: 0 0 0 3px rgba(232,93,0,0.15);
        }

        /* DROPDOWN */
        .dropdown-menu {
            background: linear-gradient(145deg, #1c1c1c, #161616);
            border: 1px solid #272727;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.4);
        }

        .dropdown-item {
            color: #aaa;
        }

        .dropdown-item:hover {
            background: linear-gradient(90deg, rgba(232,93,0,0.15), transparent);
            color: #e85d00;
        }

        /* BADGE */
        .badge.bg-success {
            background: linear-gradient(135deg, #e85d00, #ff7a1a) !important;
        }

        .text-muted { color: #777 !important; }
        .navbar-toggler { border-color: #333; }
        .navbar-toggler-icon { filter: invert(1); }

        /* SOSMED BUTTON STYLE */
        .sosmed-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.08);
            color: #ffcc99;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: 0.2s;
            border: 1px solid rgba(255, 140, 0, 0.3);
        }

        .sosmed-btn:hover {
            background: linear-gradient(135deg, #e85d00, #ff7a1a);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
        }

        /* ========== DASHBOARD ADMIN ========== */
        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #e0e0e0;
            margin-bottom: 4px;
        }
        .section-subtitle {
            font-size: 12px;
            color: #666;
            margin-bottom: 16px;
            border-left: 3px solid #e85d00;
            padding-left: 10px;
        }
        .dashboard-panel {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
        }
        .table-arena {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #0f5132;
        }
        .table-arena thead tr {
            background: linear-gradient(90deg, #b84500, #e85d00, #ff7a1a, #ff9a4a);
        }
        .table-arena thead th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            color: white;
            border: 1px solid #0f5132;
        }
        .table-arena tbody tr:nth-child(even) {
            background-color: #ffffff;
        }
        .table-arena tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
        .table-arena tbody tr:hover {
            background-color: #ffe5d0;
        }
        .table-arena tbody td {
            padding: 10px 12px;
            color: #1a1a1a;
            vertical-align: middle;
            font-size: 13px;
            border: 1px solid #0f5132;
        }
        .status-badge-sm {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 700;
            text-align: center;
            min-width: 100px;
        }
        .badge-waiting { background: #f97316; color: #000; }
        .badge-paid { background: #22c55e; color: #000; }
        .badge-danger { background: #ef4444; color: #fff; }
        .btn-verify {
            background: #e85d00;
            border: none;
            border-radius: 6px;
            padding: 4px 12px;
            font-size: 11px;
            font-weight: 600;
            color: white;
            transition: 0.2s;
        }
        .btn-verify:hover { background: #ff6a1a; }
        .inactive-lapangan {
            background: rgba(239,68,68,0.1);
            border-left: 3px solid #ef4444;
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 8px;
            font-size: 13px;
        }
        .alert-pending {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(232,93,0,0.12);
            border: 1px solid rgba(232,93,0,0.3);
            border-radius: 30px;
            color: #e85d00;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }
        .booking-time {
            font-family: monospace;
            font-size: 12px;
            background: #e8e8e8;
            padding: 2px 6px;
            border-radius: 6px;
            white-space: nowrap;
            color: #333;
        }
        .lapangan-name { font-weight: 600; color: #1a1a1a; }
    </style>

    @stack('styles')
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <span style="font-family:'Montserrat',sans-serif; font-weight:900; font-size:1.8rem; letter-spacing:2px;">KICK<span style="color:#e85d00">IN</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    {{-- Menu Home untuk semua role --}}
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>

                    @auth
            @if(auth()->user()->role == 'admin')
                {{-- ADMIN: hanya Home, Dashboard Admin, Kelola Arena, Kelola Booking, Laporan Keuangan, Account --}}
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.lapangans.index') }}">Kelola Arena</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.bookings.index') }}">Kelola Booking</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('laporan.keuangan') }}">Laporan Keuangan</a></li>  {{-- TAMBAHAN --}}
            @else
                {{-- USER BIASA --}}
                <li class="nav-item"><a class="nav-link" href="{{ route('lapangans.index') }}">Arena</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('bookings.history') }}">MyBookings</a></li>
            @endif


                        {{-- Dropdown Account untuk semua yang sudah login --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Account
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil Saya</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    @else
                        {{-- GUEST --}}
                        <li class="nav-item"><a class="nav-link" href="{{ route('lapangans.index') }}">Arena</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Account
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                                <li><a class="dropdown-item" href="{{ route('register') }}">Daftar</a></li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer style="position:relative; overflow:hidden; background:linear-gradient(135deg, #2a0a00 0%, #5c1f00 40%, #b83d00 100%); border-top-left-radius: 45% 40px; border-top-right-radius: 45% 40px; margin-top:50px; box-shadow: 0 -20px 40px rgba(0,0,0,0.3);">

        <div style="position:absolute; top:-25px; left:5%; width:90%; height:50px; background:radial-gradient(ellipse at center, rgba(232,93,0,0.4) 0%, transparent 70%); border-radius:50%; pointer-events:none;"></div>
        <div style="position:absolute; top:-80px; left:-80px; width:300px; height:300px; background:radial-gradient(circle, rgba(232,93,0,0.08), transparent 70%); pointer-events:none;"></div>
        <div style="position:absolute; bottom:-60px; right:-60px; width:250px; height:250px; background:radial-gradient(circle, rgba(232,93,0,0.06), transparent 70%); pointer-events:none;"></div>

        <div class="container py-5" style="position:relative; z-index:2;">
            <div class="row g-4 align-items-start">

                <div class="col-md-5">
                    <div style="font-family:'Montserrat',sans-serif; font-weight:900; font-size:2rem; letter-spacing:2px; background:linear-gradient(135deg, #ffd89b, #ff7e05); background-clip:text; -webkit-background-clip:text; color:transparent;">
                        KICKIN
                    </div>
                    <p style="color:#ffcc99; font-size:13px; margin-top:12px; line-height:1.6;">
                        Platform booking lapangan futsal tercepat.<br>
                        <strong style="color:#ffb347;">Book It, Own It.</strong>
                    </p>
                    <div style="display:flex; gap:12px; margin-top:16px;">
                        <div style="width:34px; height:34px; border-radius:8px; background:rgba(255,255,255,0.08); display:flex; align-items:center; justify-content:center;">
                            🕒
                        </div>
                        <span style="color:#ffcc99; font-size:13px;">Open everyday · <strong>08:00 AM – 11:00 PM</strong></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div style="font-size:11px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:#ffb347; margin-bottom:16px;">Tentang Kami</div>
                    <p style="color:#ffcc99; font-size:13px; line-height:1.6;">
                        KickIn hadir untuk memudahkan Anda booking lapangan futsal kapan saja dan di mana saja.
                        Nikmati kemudahan pembayaran Cash atau QRIS, harga transparan, dan layanan 24/7.
                        #KickInAja 🔥⚽
                    </p>
                </div>

                <div class="col-md-3">
                    <div style="font-size:11px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:#ffb347; margin-bottom:16px;">Hubungi Kami</div>
                    <div style="display:flex; flex-direction:column; gap:12px;">
                        <a href="https://wa.me/6281387907606" target="_blank" rel="noopener noreferrer" onclick="window.open('https://wa.me/6281387907606','_blank'); return false;" class="sosmed-btn">
                            <i class="fab fa-whatsapp" style="font-size:16px;"></i> WhatsApp
                        </a>
                        <a href="https://instagram.com/viviealaydaa" target="_blank" rel="noopener noreferrer" onclick="window.open('https://instagram.com/viviealaydaa','_blank'); return false;" class="sosmed-btn">
                            <i class="fab fa-instagram" style="font-size:16px;"></i> Instagram
                        </a>
                        <a href="https://maps.app.goo.gl/ETyGKGPtnXjhw8DJ9" target="_blank" rel="noopener noreferrer" onclick="window.open('https://maps.app.goo.gl/ETyGKGPtnXjhw8DJ9','_blank'); return false;" class="sosmed-btn">
                            <i class="fas fa-map-marker-alt" style="font-size:16px;"></i> Google Maps
                        </a>
                    </div>
                </div>
            </div>

            <div style="border-top:1px solid rgba(255,140,0,0.2); margin-top:40px; padding-top:20px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                <span style="color:#cc8844; font-size:12px;">&copy; {{ date('Y') }} KickIn. All rights reserved.</span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
</body>
</html>