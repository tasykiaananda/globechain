@extends('layouts.app')

@section('content')
<style>
/* ===== NEWS & SENTIMENT PAGE ===== */
.news-page { display:flex; flex-direction:column; height:100%; overflow-y:auto; }

@keyframes slideDown {
    from { opacity:0; transform:translateY(-8px); }
    to   { opacity:1; transform:translateY(0); }
}

/* Live badge */
.live-badge {
    display:inline-flex; align-items:center; gap:6px;
    background:#ecfdf5; border:1px solid #6ee7b7;
    border-radius:99px; padding:3px 10px;
    font-size:0.68rem; font-weight:700; color:#059669;
}
.pulse-dot {
    width:6px; height:6px; border-radius:50%; background:#10b981;
    animation:livePulse 1.5s infinite;
}
@keyframes livePulse {
    0%   { box-shadow:0 0 0 0 rgba(16,185,129,.7); }
    70%  { box-shadow:0 0 0 5px rgba(16,185,129,0); }
    100% { box-shadow:0 0 0 0 rgba(16,185,129,0); }
}

/* Search capsule — identik dengan dashboard */
.search-capsule {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 99px;
    display: flex; align-items: center;
    padding: 4px 4px 4px 12px; gap: 6px;
    width: 360px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    flex-shrink: 0;
}
.search-capsule:hover,
.search-capsule:focus-within {
    border-color: var(--matcha-400, #3d5fc0);
    box-shadow: 0 6px 16px rgba(61, 95, 192, 0.15);
    transform: translateY(-2px);
}
.btn-analyze {
    transition: all 0.2s ease-in-out;
    background-color: var(--matcha-500, #3d5fc0);
    color: #ffffff !important;
    border: none; border-radius: 99px;
    padding: 0 18px; height: 34px;
    font-size: 0.75rem; font-weight: 700;
    display: flex; align-items: center; gap: 6px;
    cursor: pointer; white-space: nowrap;
}
.btn-analyze:hover {
    filter: brightness(0.85);
    color: #ffffff !important;
    transform: scale(1.05);
}
.btn-analyze:active { transform: scale(0.95); }

/* Stat cards */
.stat-row { display:flex; gap:12px; flex-shrink:0; margin-bottom:14px; }
.stat-card {
    flex:1; background:#fff; border-radius:12px;
    padding:12px 16px; border:1px solid #eef0f6;
    box-shadow:0 2px 8px rgba(0,0,0,.04);
    display:flex; align-items:center; gap:12px;
    transition:box-shadow .2s, transform .2s;
}
.stat-card:hover { box-shadow:0 6px 20px rgba(61,95,192,.10); transform:translateY(-2px); }
.stat-icon {
    width:40px; height:40px; border-radius:10px;
    display:flex; align-items:center; justify-content:center;
    font-size:1rem; flex-shrink:0;
}
.stat-label { font-size:.65rem; font-weight:700; text-transform:uppercase; letter-spacing:.8px; color:#94a3b8; margin-bottom:3px; }
.stat-value { font-size:1.15rem; font-weight:800; color:#0f172a; letter-spacing:-.5px; line-height:1; }
.stat-sub   { font-size:.7rem; color:#94a3b8; margin-top:3px; }

/* Progress bar mini */
.mini-progress {
    height:4px; border-radius:99px;
    background:#f1f5f9; margin-top:6px; overflow:hidden;
}
.mini-progress-fill { height:100%; border-radius:99px; transition:width .8s ease; }

/* Main grid */
.main-grid {
    flex:1; display:grid;
    grid-template-columns:300px 1fr;
    gap:14px;
    min-height:420px;
    /* Pastikan bisa scroll kalau konten membesar */
    overflow-y:auto;
}

/* Panel */
.panel-card {
    background:#fff; border-radius:14px;
    border:1px solid #eef0f6;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
    display:flex; flex-direction:column;
    overflow:hidden; min-height:0;
}
.panel-header {
    padding:12px 16px 10px; border-bottom:1px solid #f3f4f6;
    display:flex; justify-content:space-between;
    align-items:center; flex-shrink:0;
}
.panel-title {
    font-size:.88rem; font-weight:700; color:#111827;
    display:flex; align-items:center; gap:8px;
}
.panel-icon {
    width:28px; height:28px; border-radius:7px;
    display:flex; align-items:center; justify-content:center;
    font-size:.72rem; color:#fff; flex-shrink:0;
}
.panel-body {
    padding:14px 16px; flex:1;
    display:flex; flex-direction:column;
    min-height:0; overflow:hidden;
}

/* Donut wrapper */
.donut-wrap {
    position:relative; width:130px; height:130px;
    margin:0 auto 12px; flex-shrink:0;
}
.donut-center {
    position:absolute; top:50%; left:50%;
    transform:translate(-50%,-50%);
    text-align:center; pointer-events:none;
}
.donut-center .dc-val { font-size:1.3rem; font-weight:800; color:#0f172a; line-height:1; }
.donut-center .dc-lbl { font-size:.60rem; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; }

/* Sentiment legend */
.sent-legend { display:flex; flex-direction:column; gap:6px; flex-shrink:0; }
.sent-item { display:flex; align-items:center; gap:8px; }
.sent-dot { width:10px; height:10px; border-radius:3px; flex-shrink:0; }
.sent-info { flex:1; }
.sent-name { font-size:.72rem; font-weight:700; color:#374151; }
.sent-count { font-size:.68rem; color:#94a3b8; }
.sent-pct { font-size:.78rem; font-weight:800; margin-left:auto; }

/* News list scroll */
.news-list {
    flex:1; overflow-y:auto; display:flex;
    flex-direction:column; gap:8px;
    padding-right:4px;
    min-height:0;
}
.news-list::-webkit-scrollbar { width:4px; }
.news-list::-webkit-scrollbar-thumb { background:#e2e8f0; border-radius:99px; }
.news-list::-webkit-scrollbar-thumb:hover { background:#cbd5e1; }

/* News article card */
.article-card {
    background:#fff; border-radius:10px;
    border:1px solid #f1f5f9;
    border-left:3px solid;
    padding:10px 14px;
    display:flex; flex-direction:column;
    gap:6px;
    transition:box-shadow .2s, transform .2s;
    flex-shrink:0;
    text-decoration:none;
}
.article-card:hover {
    box-shadow:0 4px 16px rgba(61,95,192,.10);
    transform:translateX(2px);
    background:#fafbff;
}
.article-source {
    font-size:.65rem; font-weight:700;
    text-transform:uppercase; letter-spacing:.5px; color:#94a3b8;
    display:flex; align-items:center; gap:5px;
}
.article-title {
    font-size:.82rem; font-weight:700; color:#0f172a;
    line-height:1.45;
    display:-webkit-box; -webkit-line-clamp:2;
    -webkit-box-orient:vertical; overflow:hidden;
}
.article-title:hover { color:#3d5fc0; }
.article-footer {
    display:flex; justify-content:space-between;
    align-items:center; margin-top:2px;
}
.score-chip {
    font-size:.67rem; font-weight:700;
    padding:2px 8px; border-radius:99px;
    border:1px solid;
}
.sent-badge {
    font-size:.62rem; font-weight:700;
    padding:2px 9px; border-radius:99px;
    text-transform:uppercase; letter-spacing:.4px;
}

/* Filter chips */
.filter-chips { display:flex; gap:6px; flex-wrap:wrap; }
.chip {
    font-size:.70rem; font-weight:600; padding:4px 12px;
    border-radius:99px; cursor:pointer; border:1.5px solid #e2e8f0;
    background:#f8fafc; color:#64748b; transition:all .2s; user-select:none;
}
.chip:hover { border-color:#3d5fc0; color:#3d5fc0; background:#f0f4ff; }
.chip.active { background:#3d5fc0; color:#fff; border-color:#3d5fc0; }

/* Empty state */
.empty-state {
    flex:1; display:flex; flex-direction:column;
    align-items:center; justify-content:center;
    gap:10px; color:#94a3b8; padding:30px;
}
</style>

@php
    $posPct = $totalNews > 0 ? round(($positive / $totalNews) * 100) : 0;
    $neuPct = $totalNews > 0 ? round(($neutral  / $totalNews) * 100) : 0;
    $negPct = $totalNews > 0 ? round(($negative / $totalNews) * 100) : 0;

    /* Dominant sentiment */
    $dom = 'Netral'; $domColor = '#64748b';
    if ($positive >= $negative && $positive >= $neutral) { $dom = 'Positif'; $domColor = '#16a34a'; }
    elseif ($negative >= $positive && $negative >= $neutral) { $dom = 'Negatif'; $domColor = '#dc2626'; }
@endphp

<div class="news-page" style="animation:slideDown .4s ease-out;">

    {{-- ===== HEADER ===== --}}
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:14px;gap:12px;flex-shrink:0;">
        <div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <h1 style="font-size:1.25rem;font-weight:800;color:#0f172a;letter-spacing:-.5px;margin:0;">News &amp; Market Sentiment</h1>
                <div class="live-badge">
                    <span class="pulse-dot"></span>
                    Sentiment Engine Active
                    <span style="opacity:.3;">|</span>
                    <span id="live-clock"><i class="fa-regular fa-clock me-1"></i>--:--:--</span>
                </div>
            </div>
            <p style="font-size:.82rem;color:#64748b;margin:0;">
                <i class="fa-solid fa-chart-pie me-1"></i>Pemantauan sentimen berita ekonomi &amp; rantai pasok secara real-time untuk <strong>{{ $selectedCountry }}</strong>.
            </p>
        </div>

        <form id="monitor-form" action="{{ route('market.news') }}" method="GET" class="search-capsule">
            @csrf
            <div class="ps-3 pe-2 flex-shrink-0">
                <i class="fa-solid fa-earth-americas" style="font-size: 0.9rem; color: var(--matcha-500, #3d5fc0);"></i>
            </div>
            <div class="flex-grow-1 px-1" style="min-width: 0;">
                <select name="country" class="form-select select2-news border-0 bg-transparent shadow-none p-0"
                        style="width: 100%; cursor: pointer; font-size: 0.85rem; font-weight: 600; color: #374151;">
                    @foreach($countries as $c)
                        <option value="{{ $c }}" {{ $selectedCountry == $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" id="btn-analyze" class="btn-analyze flex-shrink-0">
                <i class="fa-solid fa-magnifying-glass" id="btn-icon" style="font-size: 0.75rem;"></i>
                <span id="btn-text" style="font-size: 0.75rem;">Analisis</span>
            </button>
        </form>
    </div>

    {{-- ===== STAT CARDS ===== --}}
    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#3d5fc0,#6b8ff7);">
                <i class="fa-solid fa-newspaper" style="color:#fff;"></i>
            </div>
            <div>
                <div class="stat-label">Total Artikel</div>
                <div class="stat-value">{{ $totalNews }}</div>
                <div class="stat-sub">artikel diproses</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#16a34a,#4ade80);">
                <i class="fa-solid fa-arrow-trend-up" style="color:#fff;"></i>
            </div>
            <div style="flex:1;">
                <div style="display:flex;justify-content:space-between;align-items:baseline;">
                    <div class="stat-label">Positif</div>
                    <span style="font-size:.75rem;font-weight:800;color:#16a34a;">{{ $posPct }}%</span>
                </div>
                <div class="stat-value" style="color:#16a34a;">{{ $positive }}</div>
                <div class="mini-progress">
                    <div class="mini-progress-fill" style="width:{{ $posPct }}%;background:#16a34a;"></div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#64748b,#94a3b8);">
                <i class="fa-solid fa-minus" style="color:#fff;"></i>
            </div>
            <div style="flex:1;">
                <div style="display:flex;justify-content:space-between;align-items:baseline;">
                    <div class="stat-label">Netral</div>
                    <span style="font-size:.75rem;font-weight:800;color:#64748b;">{{ $neuPct }}%</span>
                </div>
                <div class="stat-value" style="color:#64748b;">{{ $neutral }}</div>
                <div class="mini-progress">
                    <div class="mini-progress-fill" style="width:{{ $neuPct }}%;background:#94a3b8;"></div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#dc2626,#f87171);">
                <i class="fa-solid fa-arrow-trend-down" style="color:#fff;"></i>
            </div>
            <div style="flex:1;">
                <div style="display:flex;justify-content:space-between;align-items:baseline;">
                    <div class="stat-label">Negatif</div>
                    <span style="font-size:.75rem;font-weight:800;color:#dc2626;">{{ $negPct }}%</span>
                </div>
                <div class="stat-value" style="color:#dc2626;">{{ $negative }}</div>
                <div class="mini-progress">
                    <div class="mini-progress-fill" style="width:{{ $negPct }}%;background:#dc2626;"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MAIN GRID ===== --}}
    <div class="main-grid">

        {{-- LEFT: Sentiment Overview Panel --}}
        <div class="panel-card" style="overflow-y:auto;">
            <div class="panel-header">
                <div class="panel-title">
                    <div class="panel-icon" style="background:linear-gradient(135deg,#7c3aed,#a78bfa);">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                    Sentiment Overview
                </div>
            </div>
            <div class="panel-body" style="gap:0;overflow-y:auto;padding:12px 14px;">

                {{-- Donut Chart --}}
                <div class="donut-wrap">
                    <canvas id="donutChart" width="160" height="160"></canvas>
                    <div class="donut-center">
                        <div class="dc-val" style="color:{{ $domColor }};">{{ $totalNews }}</div>
                        <div class="dc-lbl">Artikel</div>
                    </div>
                </div>

                {{-- Sentiment legend items --}}
                <div class="sent-legend">
                    <div class="sent-item">
                        <div class="sent-dot" style="background:#16a34a;"></div>
                        <div class="sent-info">
                            <div class="sent-name">Positif</div>
                            <div class="mini-progress" style="margin-top:4px;">
                                <div class="mini-progress-fill" style="width:{{ $posPct }}%;background:#16a34a;"></div>
                            </div>
                        </div>
                        <span class="sent-pct" style="color:#16a34a;">{{ $posPct }}%</span>
                    </div>
                    <div class="sent-item">
                        <div class="sent-dot" style="background:#94a3b8;"></div>
                        <div class="sent-info">
                            <div class="sent-name">Netral</div>
                            <div class="mini-progress" style="margin-top:4px;">
                                <div class="mini-progress-fill" style="width:{{ $neuPct }}%;background:#94a3b8;"></div>
                            </div>
                        </div>
                        <span class="sent-pct" style="color:#64748b;">{{ $neuPct }}%</span>
                    </div>
                    <div class="sent-item">
                        <div class="sent-dot" style="background:#dc2626;"></div>
                        <div class="sent-info">
                            <div class="sent-name">Negatif</div>
                            <div class="mini-progress" style="margin-top:4px;">
                                <div class="mini-progress-fill" style="width:{{ $negPct }}%;background:#dc2626;"></div>
                            </div>
                        </div>
                        <span class="sent-pct" style="color:#dc2626;">{{ $negPct }}%</span>
                    </div>
                </div>

                {{-- Dominant insight --}}
                <div style="margin-top:14px;">
                    <div style="background:#f8fafc;border-radius:10px;padding:12px;border:1px solid #eef0f6;">
                        <div style="font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#94a3b8;margin-bottom:5px;">Dominan Pasar</div>
                        <div style="font-size:1rem;font-weight:800;color:{{ $domColor }};">
                            <i class="fa-solid {{ $dom === 'Positif' ? 'fa-circle-check' : ($dom === 'Negatif' ? 'fa-circle-exclamation' : 'fa-circle-minus') }} me-1"></i>
                            {{ $dom }}
                        </div>
                        <div style="font-size:.72rem;color:#64748b;margin-top:3px;">
                            {{ $dom === 'Positif' ? 'Kondisi rantai pasok kondusif' : ($dom === 'Negatif' ? 'Perlu pemantauan risiko operasional' : 'Situasi berimbang, monitor berkala') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Article List --}}
        <div class="panel-card">
            <div class="panel-header">
                <div class="panel-title">
                    <div class="panel-icon" style="background:linear-gradient(135deg,#3d5fc0,#6b8ff7);">
                        <i class="fa-solid fa-list-ul"></i>
                    </div>
                    Daftar Artikel
                    <span style="font-size:.72rem;color:#94a3b8;font-weight:500;">— {{ $totalNews }} ditemukan</span>
                </div>
                {{-- Filter chips --}}
                <div class="filter-chips" id="filterChips">
                    <span class="chip active" data-filter="all">Semua</span>
                    <span class="chip" data-filter="Positive" style="border-color:#bbf7d0;color:#16a34a;">Positif</span>
                    <span class="chip" data-filter="Neutral" style="border-color:#e2e8f0;color:#64748b;">Netral</span>
                    <span class="chip" data-filter="Negative" style="border-color:#fecaca;color:#dc2626;">Negatif</span>
                </div>
            </div>
            <div class="panel-body">
                @if(count($newsData) > 0)
                <div class="news-list" id="newsList">
                    @foreach($newsData as $article)
                        @php
                            if ($article['sentiment'] === 'Positive') {
                                $bColor = '#16a34a'; $badgeBg = '#dcfce7'; $badgeText = '#15803d';
                                $scoreBg = '#f0fdf4'; $scoreBorder = '#bbf7d0'; $scoreColor = '#16a34a';
                            } elseif ($article['sentiment'] === 'Negative') {
                                $bColor = '#dc2626'; $badgeBg = '#fee2e2'; $badgeText = '#b91c1c';
                                $scoreBg = '#fef2f2'; $scoreBorder = '#fecaca'; $scoreColor = '#dc2626';
                            } else {
                                $bColor = '#94a3b8'; $badgeBg = '#f1f5f9'; $badgeText = '#475569';
                                $scoreBg = '#f8fafc'; $scoreBorder = '#e2e8f0'; $scoreColor = '#64748b';
                            }
                        @endphp
                        <div class="article-card" style="border-left-color:{{ $bColor }};" data-sentiment="{{ $article['sentiment'] }}">
                            <div class="article-source">
                                <i class="fa-regular fa-building"></i>
                                {{ $article['source'] }}
                            </div>
                            <a href="{{ $article['url'] }}" target="_blank" class="article-title" style="color:#0f172a;">
                                {{ $article['title'] }}
                            </a>
                            <div class="article-footer">
                                <span class="score-chip" style="background:{{ $scoreBg }};border-color:{{ $scoreBorder }};color:{{ $scoreColor }};">
                                    Indeks: {{ $article['score'] }} pts
                                </span>
                                <div style="display:flex;align-items:center;gap:6px;">
                                    <span class="sent-badge" style="background:{{ $badgeBg }};color:{{ $badgeText }};">
                                        {{ $article['sentiment'] }}
                                    </span>
                                    <a href="{{ $article['url'] }}" target="_blank"
                                       style="width:26px;height:26px;border-radius:50%;background:#f1f5f9;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;color:#64748b;font-size:.65rem;transition:all .2s;text-decoration:none;"
                                       onmouseover="this.style.background='#e0e7ff';this.style.color='#3d5fc0';"
                                       onmouseout="this.style.background='#f1f5f9';this.style.color='#64748b';">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                <div class="empty-state">
                    <i class="fa-regular fa-folder-open" style="font-size:2.5rem;"></i>
                    <div style="font-size:.9rem;font-weight:700;color:#374151;">Tidak ada artikel ditemukan</div>
                    <div style="font-size:.78rem;text-align:center;max-width:240px;">Coba pilih negara lain menggunakan kolom pencarian di atas.</div>
                </div>
                @endif
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Live clock ── */
    (function tick() {
        const el = document.getElementById('live-clock');
        if (el) el.innerHTML = `<i class="fa-regular fa-clock me-1"></i>${new Date().toLocaleTimeString('id-ID')}`;
        setTimeout(tick, 1000);
    })();

    /* ── Form loading state ── */
    document.getElementById('monitor-form')?.addEventListener('submit', () => {
        const btn  = document.getElementById('btn-analyze');
        const icon = document.getElementById('btn-icon');
        const text = document.getElementById('btn-text');
        if (btn) { btn.style.opacity = '.75'; btn.style.cursor = 'wait'; }
        if (icon) icon.className = 'spinner-border spinner-border-sm';
        if (text) text.textContent = 'Memuat...';
    });

    /* ── Donut chart ── */
    const ctx = document.getElementById('donutChart').getContext('2d');
    const pos = {{ $positive }}, neu = {{ $neutral }}, neg = {{ $negative }};
    const total = pos + neu + neg;

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Positif', 'Netral', 'Negatif'],
            datasets: [{
                data: total > 0 ? [pos, neu, neg] : [1, 1, 1],
                backgroundColor: ['#16a34a', '#94a3b8', '#dc2626'],
                borderColor: '#ffffff',
                borderWidth: 3,
                hoverBorderWidth: 4,
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            animation: { duration: 900, easing: 'easeOutQuart' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f2044',
                    titleColor: '#94a3b8',
                    bodyColor: '#fff',
                    padding: 10,
                    cornerRadius: 10,
                    borderColor: 'rgba(255,255,255,.08)',
                    borderWidth: 1,
                    titleFont: { size: 11, family: "'Inter',sans-serif" },
                    bodyFont: { size: 13, weight: 'bold', family: "'Inter',sans-serif" },
                    displayColors: true,
                    boxWidth: 8, boxHeight: 8, boxPadding: 4,
                    callbacks: {
                        label: ctx => {
                            const pct = total > 0 ? Math.round(ctx.raw / total * 100) : 0;
                            return `  ${ctx.label}: ${ctx.raw} artikel (${pct}%)`;
                        }
                    }
                }
            }
        }
    });

    /* ── Filter chips ── */
    const chips = document.querySelectorAll('.chip');
    const cards = document.querySelectorAll('.article-card');

    chips.forEach(chip => {
        chip.addEventListener('click', () => {
            chips.forEach(c => c.classList.remove('active'));
            chip.classList.add('active');
            const filter = chip.dataset.filter;
            cards.forEach(card => {
                const show = filter === 'all' || card.dataset.sentiment === filter;
                card.style.display = show ? '' : 'none';
            });
        });
    });

    /* ── Select2 untuk dropdown negara ── */
    let waitForJQ = setInterval(function () {
        if (typeof window.jQuery !== 'undefined') {
            clearInterval(waitForJQ);
            const $ = window.jQuery;
            if ($.fn.select2) {
                $('.select2-news').select2({
                    width: '100%',
                    theme: 'bootstrap-5'
                });
                // Submit form saat negara dipilih
                $('.select2-news').on('change', function() {
                    $('#monitor-form').submit();
                });
            }
        }
    }, 100);
});
</script>
@endsection