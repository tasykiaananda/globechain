@extends('layouts.app')

@section('content')
    <style>
        /* ====== ADMIN DASHBOARD - DARK NAVY THEME ====== */
        .admin-dashboard { display: flex; flex-direction: column; height: 100%; gap: 1.1rem; }

        /* Header Bar */
        .admin-header {
            display: flex; justify-content: space-between; align-items: center;
            flex-shrink: 0;
        }
        .admin-header .title-group h3 {
            font-size: 1.35rem; font-weight: 800; color: #e2e8f0;
            margin-bottom: 0.1rem; letter-spacing: -0.5px;
        }
        .admin-header .title-group p {
            font-size: 0.78rem; color: #94a3b8; margin: 0;
        }
        .btn-back-dashboard {
            background: rgba(255,255,255,0.06); border: 1.5px solid #2a3f66; color: #94a3b8;
            padding: 0.5rem 1rem; border-radius: 10px; font-weight: 600; font-size: 0.8rem;
            transition: all 0.25s ease; display: flex; align-items: center; gap: 0.4rem;
            text-decoration: none;
        }
        .btn-back-dashboard:hover {
            background: #4f7ddb; color: #fff; border-color: #4f7ddb;
            transform: translateY(-1px); box-shadow: 0 4px 15px rgba(79,125,219,0.3);
        }

        /* ====== STAT CARDS ====== */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; flex-shrink: 0; }

        .stat-card {
            background: #111d35; border-radius: 16px; padding: 1.4rem;
            position: relative; overflow: hidden; cursor: pointer;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #1e3054;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            text-decoration: none; color: inherit; display: block;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.25);
            border-color: #2a4580;
        }
        .stat-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            border-radius: 16px 16px 0 0;
        }
        .stat-card.card-users::before { background: linear-gradient(90deg, #6366f1, #8b5cf6); }
        .stat-card.card-ports::before { background: linear-gradient(90deg, #4f7ddb, #38bdf8); }
        .stat-card.card-articles::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }

        .stat-card .card-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.9rem; }
        .stat-card .card-icon {
            width: 46px; height: 46px; border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; color: #fff;
            transition: transform 0.3s ease;
        }
        .stat-card:hover .card-icon { transform: scale(1.1) rotate(-5deg); }
        .stat-card.card-users .card-icon { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
        .stat-card.card-ports .card-icon { background: linear-gradient(135deg, #4f7ddb, #38bdf8); }
        .stat-card.card-articles .card-icon { background: linear-gradient(135deg, #f59e0b, #fbbf24); }

        .stat-card .card-number {
            font-size: 1.9rem; font-weight: 800; color: #f1f5f9;
            line-height: 1; letter-spacing: -1px;
        }
        .stat-card .card-label {
            font-size: 0.78rem; font-weight: 700; color: #cbd5e1;
            margin-bottom: 0.2rem; letter-spacing: -0.2px;
        }
        .stat-card .card-desc {
            font-size: 0.7rem; color: #64748b; line-height: 1.4;
            margin-bottom: 0.9rem;
        }

        .stat-card .card-action {
            display: flex; align-items: center; gap: 0.5rem;
            font-size: 0.73rem; font-weight: 700; padding: 0.45rem 0;
            border-top: 1px solid #1e3054; margin-top: auto;
            transition: all 0.25s ease;
        }
        .stat-card.card-users .card-action { color: #8b5cf6; }
        .stat-card.card-ports .card-action { color: #38bdf8; }
        .stat-card.card-articles .card-action { color: #fbbf24; }
        .stat-card:hover .card-action { gap: 0.75rem; }
        .stat-card .card-action i.fa-arrow-right { transition: transform 0.3s ease; font-size: 0.68rem; }
        .stat-card:hover .card-action i.fa-arrow-right { transform: translateX(4px); }

        /* Background decoration on cards */
        .stat-card .card-bg-deco {
            position: absolute; bottom: -20px; right: -15px; font-size: 4.5rem;
            opacity: 0.04; transform: rotate(-15deg);
            transition: all 0.4s ease; color: #fff;
        }
        .stat-card:hover .card-bg-deco { opacity: 0.08; transform: rotate(-10deg) scale(1.1); }

        /* ====== BOTTOM GRID ====== */
        .bottom-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; flex: 1; min-height: 0; }

        /* Activity Panel */
        .activity-panel {
            background: #111d35; border-radius: 16px; padding: 1.15rem;
            border: 1px solid #1e3054;
            display: flex; flex-direction: column; overflow: hidden;
        }
        .panel-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 0.8rem; flex-shrink: 0;
        }
        .panel-header .panel-title {
            font-size: 0.82rem; font-weight: 700; color: #e2e8f0;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .panel-header .panel-title .dot {
            width: 7px; height: 7px; border-radius: 50%; background: #22c55e;
            animation: pulse-dot 2s infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.75); }
        }
        .panel-header .panel-badge {
            font-size: 0.62rem; font-weight: 600;
            background: rgba(79,125,219,0.15); color: #4f7ddb;
            padding: 0.22rem 0.55rem; border-radius: 20px;
        }

        .activity-list { flex: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 0; }
        .activity-item {
            display: flex; align-items: center; gap: 0.75rem; padding: 0.6rem 0.5rem;
            border-bottom: 1px solid #1a2744; transition: background 0.2s ease; border-radius: 8px;
        }
        .activity-item:hover { background: rgba(79,125,219,0.05); }
        .activity-item:last-child { border-bottom: none; }
        .activity-item .activity-icon {
            width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem;
        }
        .activity-icon.icon-users { background: rgba(99,102,241,0.15); color: #818cf8; }
        .activity-icon.icon-ports { background: rgba(56,189,248,0.12); color: #38bdf8; }
        .activity-icon.icon-articles { background: rgba(245,158,11,0.12); color: #fbbf24; }
        .activity-icon.icon-system { background: rgba(34,197,94,0.12); color: #4ade80; }

        .activity-item .activity-info { flex: 1; min-width: 0; }
        .activity-item .activity-title {
            font-size: 0.75rem; font-weight: 600; color: #cbd5e1;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .activity-item .activity-time {
            font-size: 0.65rem; color: #64748b;
        }
        .activity-item .activity-badge {
            font-size: 0.58rem; font-weight: 700; padding: 0.2rem 0.5rem;
            border-radius: 12px; flex-shrink: 0; letter-spacing: 0.3px;
        }

        /* Quick Actions Panel */
        .quick-panel {
            background: #111d35; border-radius: 16px; padding: 1.15rem;
            border: 1px solid #1e3054;
            display: flex; flex-direction: column; overflow: hidden;
        }
        .quick-action-list { flex: 1; display: flex; flex-direction: column; gap: 0.45rem; overflow-y: auto; }
        .quick-action-btn {
            display: flex; align-items: center; gap: 0.65rem; padding: 0.6rem 0.75rem;
            border-radius: 11px; border: 1.5px solid #1e3054;
            background: #0d1a30; color: #94a3b8; text-decoration: none;
            font-size: 0.76rem; font-weight: 600; transition: all 0.25s ease;
        }
        .quick-action-btn:hover {
            border-color: #4f7ddb; background: rgba(79,125,219,0.08);
            transform: translateX(3px); color: #e2e8f0;
        }
        .quick-action-btn .qa-icon {
            width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem; color: #fff;
        }
        .qa-icon.qa-user { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
        .qa-icon.qa-port { background: linear-gradient(135deg, #4f7ddb, #38bdf8); }
        .qa-icon.qa-article { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
        .qa-icon.qa-map { background: linear-gradient(135deg, #059669, #34d399); }
        .qa-icon.qa-dashboard { background: linear-gradient(135deg, #0f172a, #475569); }

        .quick-action-btn .qa-arrow {
            margin-left: auto; font-size: 0.65rem; color: #334155;
            transition: all 0.25s ease;
        }
        .quick-action-btn:hover .qa-arrow { color: #4f7ddb; transform: translateX(2px); }

        /* System Info Bar */
        .system-bar {
            background: #0a1525; border-radius: 12px; padding: 0.7rem 1.1rem; flex-shrink: 0;
            display: flex; align-items: center; gap: 1.5rem;
            border: 1px solid #152240;
        }
        .system-bar .sys-item {
            display: flex; align-items: center; gap: 0.35rem;
            font-size: 0.68rem; color: #64748b;
        }
        .system-bar .sys-item i { font-size: 0.6rem; color: #475569; }
        .system-bar .sys-item .sys-val { color: #94a3b8; font-weight: 600; }
        .system-bar .sys-divider { width: 1px; height: 14px; background: #1e3054; }

        /* Animated entry */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .stat-card { animation: fadeInUp 0.5s ease forwards; opacity: 0; }
        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.15s; }
        .stat-card:nth-child(3) { animation-delay: 0.25s; }
        .bottom-grid { animation: fadeInUp 0.5s ease 0.3s forwards; opacity: 0; }
        .system-bar { animation: fadeInUp 0.5s ease 0.4s forwards; opacity: 0; }
    </style>

    <div class="admin-dashboard" style="background: linear-gradient(180deg, #0d1e3d 0%, #0f2044 100%); margin: -1.25rem -1.5rem; padding: 1.25rem 1.5rem; height: calc(100% + 2.5rem);">

        {{-- Header --}}
        <div class="admin-header">
            <div class="title-group">
                <h3><i class="fa-solid fa-shield-halved me-2" style="color: #4f7ddb;"></i>Admin Control Panel</h3>
                <p>Kelola master data, pengguna, dan artikel analisis secara terpusat.</p>
            </div>
            <div>
                <a href="/" class="btn-back-dashboard">
                    <i class="fa-solid fa-arrow-left"></i> Dashboard Utama
                </a>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="stats-grid">

            {{-- Card: Manajemen Pengguna --}}
            <a href="{{ route('admin.users') }}" class="stat-card card-users" id="card-users">
                <div class="card-bg-deco"><i class="fa-solid fa-users-gear"></i></div>
                <div class="card-top">
                    <div class="card-icon"><i class="fa-solid fa-users-gear"></i></div>
                    <div class="card-number" data-count="{{ $totalUsers }}">{{ $totalUsers }}</div>
                </div>
                <div class="card-label">Manajemen Pengguna</div>
                <div class="card-desc">Atur hak akses admin dan pantau aktivitas pengguna platform.</div>
                <div class="card-action">
                    <span>Kelola User</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </div>
            </a>

            {{-- Card: Dataset Pelabuhan --}}
            <a href="{{ route('admin.ports') }}" class="stat-card card-ports" id="card-ports">
                <div class="card-bg-deco"><i class="fa-solid fa-anchor"></i></div>
                <div class="card-top">
                    <div class="card-icon"><i class="fa-solid fa-anchor"></i></div>
                    <div class="card-number" data-count="{{ $totalPorts }}">{{ number_format($totalPorts) }}</div>
                </div>
                <div class="card-label">Dataset Pelabuhan</div>
                <div class="card-desc">Kelola data dan titik koordinat World Port Index.</div>
                <div class="card-action">
                    <span>Kelola Pelabuhan</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </div>
            </a>

            {{-- Card: Artikel Analisis --}}
            <a href="{{ route('admin.articles') }}" class="stat-card card-articles" id="card-articles">
                <div class="card-bg-deco"><i class="fa-solid fa-newspaper"></i></div>
                <div class="card-top">
                    <div class="card-icon"><i class="fa-solid fa-newspaper"></i></div>
                    <div class="card-number" data-count="{{ $totalArticles }}">{{ $totalArticles }}</div>
                </div>
                <div class="card-label">Artikel Analisis</div>
                <div class="card-desc">Tulis dan terbitkan laporan analisis intelijen risiko.</div>
                <div class="card-action">
                    <span>Kelola Artikel</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </div>
            </a>

        </div>

        {{-- Bottom: Activity + Quick Actions --}}
        <div class="bottom-grid">

            {{-- Activity Panel --}}
            <div class="activity-panel">
                <div class="panel-header">
                    <div class="panel-title">
                        <span class="dot"></span> Ringkasan Sistem
                    </div>
                    <span class="panel-badge">Real-time</span>
                </div>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon icon-users"><i class="fa-solid fa-user-shield"></i></div>
                        <div class="activity-info">
                            <div class="activity-title">Total {{ $totalUsers }} akun pengguna terdaftar di sistem</div>
                            <div class="activity-time">Termasuk admin & user biasa</div>
                        </div>
                        <span class="activity-badge" style="background: rgba(99,102,241,0.15); color: #818cf8;">Aktif</span>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon icon-ports"><i class="fa-solid fa-anchor"></i></div>
                        <div class="activity-info">
                            <div class="activity-title">{{ number_format($totalPorts) }} titik pelabuhan World Port Index</div>
                            <div class="activity-time">Dataset Geospatial terhubung ke peta</div>
                        </div>
                        <span class="activity-badge" style="background: rgba(56,189,248,0.12); color: #38bdf8;">Synced</span>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon icon-articles"><i class="fa-solid fa-pen-nib"></i></div>
                        <div class="activity-info">
                            <div class="activity-title">{{ $totalArticles }} artikel analisis intelijen risiko</div>
                            <div class="activity-time">Laporan analisis rantai pasok</div>
                        </div>
                        <span class="activity-badge" style="background: rgba(245,158,11,0.12); color: #fbbf24;">Published</span>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon icon-system"><i class="fa-solid fa-server"></i></div>
                        <div class="activity-info">
                            <div class="activity-title">Sistem berjalan normal — semua layanan aktif</div>
                            <div class="activity-time">Uptime: {{ now()->format('d M Y, H:i') }} WIB</div>
                        </div>
                        <span class="activity-badge" style="background: rgba(34,197,94,0.12); color: #4ade80;">Online</span>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon icon-users"><i class="fa-solid fa-shield-halved"></i></div>
                        <div class="activity-info">
                            <div class="activity-title">Login terakhir oleh {{ Auth::user()->name ?? 'Admin' }}</div>
                            <div class="activity-time">Sesi saat ini — Role: {{ ucfirst(Auth::user()->role ?? 'admin') }}</div>
                        </div>
                        <span class="activity-badge" style="background: rgba(99,102,241,0.15); color: #818cf8;">Verified</span>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="quick-panel">
                <div class="panel-header">
                    <div class="panel-title">
                        <i class="fa-solid fa-bolt" style="color: #fbbf24;"></i> Aksi Cepat
                    </div>
                </div>
                <div class="quick-action-list">
                    <a href="{{ route('admin.users') }}" class="quick-action-btn">
                        <div class="qa-icon qa-user"><i class="fa-solid fa-user-plus"></i></div>
                        <span>Tambah Pengguna</span>
                        <i class="fa-solid fa-chevron-right qa-arrow"></i>
                    </a>
                    <a href="{{ route('admin.ports') }}" class="quick-action-btn">
                        <div class="qa-icon qa-port"><i class="fa-solid fa-map-pin"></i></div>
                        <span>Tambah Pelabuhan</span>
                        <i class="fa-solid fa-chevron-right qa-arrow"></i>
                    </a>
                    <a href="{{ route('admin.articles') }}" class="quick-action-btn">
                        <div class="qa-icon qa-article"><i class="fa-solid fa-pen-nib"></i></div>
                        <span>Tulis Artikel</span>
                        <i class="fa-solid fa-chevron-right qa-arrow"></i>
                    </a>
                    <a href="{{ route('map.index') }}" class="quick-action-btn">
                        <div class="qa-icon qa-map"><i class="fa-solid fa-earth-asia"></i></div>
                        <span>Lihat Peta</span>
                        <i class="fa-solid fa-chevron-right qa-arrow"></i>
                    </a>
                    <a href="/" class="quick-action-btn">
                        <div class="qa-icon qa-dashboard"><i class="fa-solid fa-chart-line"></i></div>
                        <span>Dashboard Utama</span>
                        <i class="fa-solid fa-chevron-right qa-arrow"></i>
                    </a>
                </div>
            </div>

        </div>

        {{-- System Info Bar --}}
        <div class="system-bar">
            <div class="sys-item">
                <i class="fa-solid fa-microchip"></i>
                <span>Platform:</span>
                <span class="sys-val">Nexora Global v2.0</span>
            </div>
            <div class="sys-divider"></div>
            <div class="sys-item">
                <i class="fa-solid fa-database"></i>
                <span>Records:</span>
                <span class="sys-val">{{ number_format($totalUsers + $totalPorts + $totalArticles) }}</span>
            </div>
            <div class="sys-divider"></div>
            <div class="sys-item">
                <i class="fa-solid fa-clock"></i>
                <span>Server:</span>
                <span class="sys-val">{{ now()->format('H:i:s') }}</span>
            </div>
            <div class="sys-divider"></div>
            <div class="sys-item">
                <i class="fa-solid fa-circle" style="color: #22c55e; font-size: 0.45rem;"></i>
                <span class="sys-val">All Systems Operational</span>
            </div>
        </div>

    </div>

    <script>
        // Animated Counter for stat numbers
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.card-number[data-count]').forEach(el => {
                const target = parseInt(el.dataset.count);
                if (target <= 0) return;
                const duration = 1200;
                const step = Math.max(1, Math.ceil(target / (duration / 16)));
                let current = 0;
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    el.textContent = current.toLocaleString('id-ID');
                }, 16);
            });
        });
    </script>
@endsection