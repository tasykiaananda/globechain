<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SupplySync - Global Risk Intelligence</title>
    <!-- PENGAMAN ANTI-BACK CACHE BROWSER -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --sidebar-bg: #0f2044;
            --sidebar-hover: #1a3060;
            --sidebar-active: #1e3a70;
            --sidebar-accent: #4f7ddb;
            --sidebar-text: #a8bde0;
            --sidebar-text-bright: #dce8f8;
            --sidebar-label: #506080;
            --matcha-50: #f0f4ff;
            --matcha-100: #dde8ff;
            --matcha-500: #3d5fc0;
            --matcha-700: #2a45a0;
            --corporate-dark: #0f172a;
            --corporate-gray: #64748b;
        }

        /* Mengunci seluruh halaman agar tidak bisa di-scroll */
        html, body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: var(--corporate-dark);
            height: 100vh;
            max-height: 100vh;
            overflow: hidden;
        }

        .app-wrapper {
            display: flex;
            height: 100vh;
            max-height: 100vh;
            overflow: hidden;
        }

        /* ====== SIDEBAR DARK NAVY ====== */
        .sidebar {
            width: 220px;
            min-width: 220px;
            background: linear-gradient(180deg, #0d1e3d 0%, #0f2044 60%, #0a1a38 100%);
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            padding: 0;
            box-shadow: 4px 0 20px rgba(0,0,0,0.25);
            flex-shrink: 0;
        }

        .sidebar::-webkit-scrollbar { width: 3px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }

        /* Brand / Logo */
        .sidebar-brand {
            padding: 1.2rem 1.2rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .sidebar-brand .brand-icon {
            width: 34px;
            height: 34px;
            background: rgba(79,125,219,0.25);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--sidebar-accent);
            font-size: 0.95rem;
            border: 1px solid rgba(79,125,219,0.3);
        }
        .sidebar-brand .brand-text {
            font-size: 0.95rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.3px;
        }
        .sidebar-brand .brand-sub {
            font-size: 0.6rem;
            color: var(--sidebar-text);
            font-weight: 400;
        }

        /* User info */
        .sidebar-user {
            padding: 0.9rem 1.2rem 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.7rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .sidebar-user .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--sidebar-accent), #7ba7ff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            color: white;
            font-weight: 700;
            flex-shrink: 0;
        }
        .sidebar-user .user-info .user-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--sidebar-text-bright);
            line-height: 1.2;
        }
        .sidebar-user .user-info .user-role {
            font-size: 0.65rem;
            color: var(--sidebar-text);
        }

        /* Menu Section */
        .sidebar-nav {
            padding: 0.5rem 0;
            flex: 1;
        }

        .menu-label {
            font-size: 0.60rem;
            font-weight: 700;
            letter-spacing: 1.2px;
            color: var(--sidebar-label);
            text-transform: uppercase;
            margin-top: 1rem;
            margin-bottom: 0.3rem;
            padding: 0 1.2rem;
        }

        .sidebar-nav .nav-link {
            color: var(--sidebar-text);
            font-weight: 500;
            font-size: 0.82rem;
            padding: 0.55rem 1rem 0.55rem 1.2rem;
            border-radius: 0;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            transition: all 0.2s ease;
            position: relative;
            border-left: 3px solid transparent;
        }

        .sidebar-nav .nav-link i {
            width: 18px;
            text-align: center;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .sidebar-nav .nav-link:hover {
            background-color: rgba(255,255,255,0.06);
            color: var(--sidebar-text-bright);
            border-left-color: rgba(79,125,219,0.4);
        }

        .sidebar-nav .nav-link.active {
            background-color: rgba(79,125,219,0.18);
            color: #ffffff;
            border-left-color: var(--sidebar-accent);
            font-weight: 600;
        }
        .sidebar-nav .nav-link.active i {
            color: var(--sidebar-accent);
        }

        /* Sidebar Footer */
        .sidebar-footer {
            padding: 0.8rem 1rem;
            border-top: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-footer .nav-link {
            color: #ef9090;
            font-size: 0.82rem;
            padding: 0.5rem 0.8rem;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .sidebar-footer .nav-link:hover {
            background-color: rgba(239,68,68,0.12);
            color: #f87171;
        }
        .sidebar-footer .nav-link i {
            width: 18px;
            text-align: center;
        }

        /* ====== MAIN CONTENT ====== */
        .main-content {
            flex: 1;
            background-color: #f1f5f9;
            height: 100vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .content-inner {
            flex: 1;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            padding: 1.25rem 1.5rem;
            height: 100%;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .card-corporate {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            background-color: #ffffff;
        }

        .text-matcha { color: var(--matcha-700); }
        .bg-matcha { background-color: var(--matcha-500); color: #ffffff; }
    </style>
</head>

<body>
    <div class="app-wrapper">

        <!-- ====== SIDEBAR DARK NAVY ====== -->
        <aside class="sidebar">

            <!-- Brand -->
            <div class="sidebar-brand">
                <div class="brand-icon">
                    <i class="fa-solid fa-ship"></i>
                </div>
                <div>
                    <div class="brand-text">Nexora Global</div>
                    <div class="brand-sub">Supply Chain Intelligence</div>
                </div>
            </div>

            <!-- User Info -->
            @if(Auth::check())
            <div class="sidebar-user">
                <div class="avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name ?? 'User' }}</div>
                    <div class="user-role">{{ ucfirst(Auth::user()->role ?? 'User') }}</div>
                </div>
            </div>
            @endif

            <!-- Navigation -->
            <nav class="sidebar-nav">

                <div class="menu-label">Akses Dasbor Anda</div>
                <a class="nav-link {{ request()->is('country*') || request()->is('/') ? 'active' : '' }}" href="/country">
                    <i class="fa-solid fa-chart-line"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                    <i class="fa-solid fa-circle-user"></i> Profil
                </a>

                <div class="menu-label">Risk &amp; Analytics</div>
                  <a class="nav-link {{ request()->routeIs('analytics.risk') ? 'active fw-bold text-success' : '' }}"
                            href="{{ route('analytics.risk') }}">
                            <i class="fa-solid fa-shield-halved me-2"></i> Risk Scoring Engine
                        </a>

                    <a class="nav-link {{ request()->routeIs('analytics.visualization') ? 'active fw-bold text-success' : '' }}"
                            href="{{ route('analytics.visualization') }}">
                            <i class="fa-solid fa-chart-pie me-2"></i> Data Visualization
                        </a>

                <div class="menu-label">Geospatial Monitoring</div>
                <a class="nav-link {{ request()->routeIs('map.index') ? 'active' : '' }}" href="{{ route('map.index') }}">
                    <i class="fa-solid fa-map-location-dot"></i> Geospatial Map
                </a>

                <div class="menu-label">Market Intelligence</div>
                <a class="nav-link {{ request()->routeIs('market.currency') ? 'active' : '' }}" href="{{ route('market.currency') }}">
                    <i class="fa-solid fa-coins"></i> Currency
                </a>
                <a class="nav-link {{ request()->routeIs('market.news') ? 'active' : '' }}" href="{{ route('market.news') }}">
                    <i class="fa-solid fa-newspaper"></i> News &amp; Sentiment
                </a>

                <div class="menu-label">Advanced Tools</div>
                <a class="nav-link {{ request()->routeIs('tools.comparison') ? 'active' : '' }}" href="{{ route('tools.comparison') }}">
                    <i class="fa-solid fa-scale-balanced"></i> Country Comparison
                </a>
                <a class="nav-link {{ request()->routeIs('tools.favorites') ? 'active' : '' }}" href="{{ route('tools.favorites') }}">
                    <i class="fa-solid fa-star"></i> Favorite Monitoring
                </a>

                @if(Auth::check() && Auth::user()->role === 'admin')
                <div class="menu-label">System Admin</div>
                <a class="nav-link {{ request()->is('admin*') ? 'active' : '' }}" href="/admin/dashboard">
                    <i class="fa-solid fa-sliders"></i> Admin Panel
                </a>
                @endif

            </nav>

            <!-- Footer Logout -->
            <div class="sidebar-footer">
                <a class="nav-link" href="#"
                    onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin keluar dari sistem?')) { document.getElementById('logout-form').submit(); }">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>

        </aside>

        <!-- ====== AREA KONTEN UTAMA ====== -->
        <main class="main-content">
            <div class="content-inner">
                @yield('content')
            </div>
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2-country').select2({
                width: 'resolve'
            });
        });
    </script>
</body>

</html>