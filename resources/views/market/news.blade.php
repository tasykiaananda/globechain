@extends('layouts.app')

@section('content')
<style>
/* ===== NEWS & SENTIMENT PAGE (Full Dark Navy Theme) ===== */
.news-page { display:flex; flex-direction:column; height:100%; overflow-y:auto; background: #0b1628; padding-bottom: 2rem; }

:root {
    --fn: #0b1628; /* Background */
    --fc: #1a2d4e; /* Card */
    --fb: rgba(79,125,219,0.18); /* Border */
    --fa: #4f7ddb; /* Accent */
    --ft: #dce8f8; /* Text bright */
    --fm: #8fadd4; /* Text muted */
    --fg: #34d399; /* Green */
    --fy: #fbbf24; /* Yellow */
    --fr: #f87171; /* Red */
}

@keyframes slideDown {
    from { opacity:0; transform:translateY(-8px); }
    to   { opacity:1; transform:translateY(0); }
}

/* Header Container */
.news-header-container {
    background: linear-gradient(135deg, #0f2044, #0d1e3d);
    border-bottom: 1px solid var(--fb);
    padding: 1rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1rem;
    margin-left: -1rem;
    margin-right: -1rem;
    margin-top: -1rem;
}

/* Live badge */
.live-badge {
    display:inline-flex; align-items:center; gap:6px;
    background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.25);
    border-radius:99px; padding:4px 12px;
    font-size:0.65rem; font-weight:700; color:var(--fg);
}
.pulse-dot {
    width:6px; height:6px; border-radius:50%; background:var(--fg);
    animation:livePulse 1.5s infinite;
}
@keyframes livePulse {
    0%   { box-shadow:0 0 0 0 rgba(52,211,153,.7); }
    70%  { box-shadow:0 0 0 5px rgba(52,211,153,0); }
    100% { box-shadow:0 0 0 0 rgba(52,211,153,0); }
}

/* Search capsule */
.search-capsule {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: rgba(255,255,255,0.04);
    border: 1px solid var(--fb);
    border-radius: 99px;
    display: flex; align-items: center;
    padding: 4px 4px 4px 12px; gap: 6px;
    width: 360px;
    flex-shrink: 0;
}
.search-capsule:hover,
.search-capsule:focus-within {
    border-color: var(--fa);
    box-shadow: 0 0 0 3px rgba(79,125,219,0.15);
}
.btn-analyze {
    transition: all 0.2s ease-in-out;
    background: linear-gradient(135deg, var(--fa), #3d5fc0);
    color: #ffffff !important;
    border: none; border-radius: 99px;
    padding: 0 18px; height: 34px;
    font-size: 0.75rem; font-weight: 700;
    display: flex; align-items: center; gap: 6px;
    cursor: pointer; white-space: nowrap;
}
.btn-analyze:hover {
    filter: brightness(1.1);
    transform: translateY(-1px);
}

/* Select2 overrides for dark theme */
.select2-container--bootstrap-5 .select2-selection {
    background-color: transparent !important;
    border: none !important;
    color: var(--ft) !important;
}
.select2-container--bootstrap-5 .select2-selection__rendered {
    color: var(--ft) !important;
    font-weight: 600;
}
.select2-dropdown {
    background-color: #1e2d4a !important;
    border: 1px solid var(--fb) !important;
}
.select2-results__option {
    color: var(--ft) !important;
}
.select2-results__option--highlighted {
    background-color: var(--fa) !important;
    color: white !important;
}

/* Base Card Style */
.base-card {
    background: linear-gradient(145deg, #1a2d4e, #162240);
    border: 1px solid var(--fb);
    position: relative;
    overflow: hidden;
}
.base-card::before {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(79,125,219,.04), transparent 50%);
    pointer-events: none;
}

/* Stat cards */
.stat-row { display:flex; gap:12px; flex-shrink:0; margin-bottom:14px; padding: 0 1rem; }
.stat-card {
    flex:1; border-radius:14px;
    padding:12px 16px; 
    display:flex; align-items:center; gap:12px;
    transition:box-shadow .2s, transform .2s;
}
.stat-card:hover { border-color:rgba(79,125,219,.3); transform:translateX(2px); }
.stat-icon {
    width:40px; height:40px; border-radius:10px;
    display:flex; align-items:center; justify-content:center;
    font-size:1rem; flex-shrink:0;
}
.stat-label { font-size:.58rem; font-weight:800; text-transform:uppercase; letter-spacing:1.2px; color:var(--fm); margin-bottom:3px; }
.stat-value { font-size:1.15rem; font-weight:800; color:#fff; letter-spacing:-.5px; line-height:1; }
.stat-sub   { font-size:.7rem; color:var(--fm); margin-top:3px; }

/* Progress bar mini */
.mini-progress {
    height:4px; border-radius:99px;
    background:rgba(0,0,0,0.2); margin-top:6px; overflow:hidden;
}
.mini-progress-fill { height:100%; border-radius:99px; transition:width .8s ease; }

/* Main grid */
.main-grid {
    flex:1; display:grid;
    grid-template-columns:300px 1fr;
    gap:14px;
    min-height:420px;
    padding: 0 1rem;
}

/* Panel */
.panel-card {
    border-radius:14px;
    display:flex; flex-direction:column;
    min-height:0;
}
.panel-header {
    padding:12px 16px 10px; border-bottom:1px solid var(--fb);
    display:flex; justify-content:space-between;
    align-items:center; flex-shrink:0;
}
.panel-title {
    font-size:.88rem; font-weight:800; color:var(--ft);
    display:flex; align-items:center; gap:8px; text-transform:uppercase; letter-spacing:0.5px;
}
.panel-icon {
    width:28px; height:28px; border-radius:7px; background: rgba(79,125,219,.12);
    display:flex; align-items:center; justify-content:center;
    font-size:.72rem; color:var(--fa); flex-shrink:0;
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
.donut-center .dc-val { font-size:1.3rem; font-weight:800; color:#fff; line-height:1; }
.donut-center .dc-lbl { font-size:.60rem; font-weight:700; color:var(--fm); text-transform:uppercase; letter-spacing:.5px; }

/* Sentiment legend */
.sent-legend { display:flex; flex-direction:column; gap:6px; flex-shrink:0; }
.sent-item { display:flex; align-items:center; gap:8px; }
.sent-dot { width:10px; height:10px; border-radius:3px; flex-shrink:0; }
.sent-info { flex:1; }
.sent-name { font-size:.72rem; font-weight:700; color:var(--ft); }
.sent-count { font-size:.68rem; color:var(--fm); }
.sent-pct { font-size:.78rem; font-weight:800; margin-left:auto; }

/* News list scroll */
.news-list {
    flex:1; overflow-y:auto; display:flex;
    flex-direction:column; gap:8px;
    padding-right:4px;
    min-height:0;
}
.news-list::-webkit-scrollbar { width:4px; }
.news-list::-webkit-scrollbar-thumb { background:rgba(79,125,219,0.3); border-radius:99px; }
.news-list::-webkit-scrollbar-thumb:hover { background:var(--fa); }

/* News article card */
.article-card {
    background:rgba(255,255,255,0.03); border-radius:10px;
    border:1px solid var(--fb);
    border-left:3px solid;
    padding:10px 14px;
    display:flex; flex-direction:column;
    gap:6px;
    transition:box-shadow .2s, transform .2s;
    flex-shrink:0;
    text-decoration:none;
}
.article-card:hover {
    background:rgba(79,125,219,.06);
    border-color:rgba(79,125,219,.3);
    transform:translateX(3px);
}
.article-source {
    font-size:.65rem; font-weight:700;
    text-transform:uppercase; letter-spacing:.5px; color:var(--fm);
    display:flex; align-items:center; gap:5px;
}
.article-title {
    font-size:.85rem; font-weight:700; color:#fff;
    line-height:1.45;
    display:-webkit-box; -webkit-line-clamp:2;
    -webkit-box-orient:vertical; overflow:hidden;
}
.article-title:hover { color:var(--fa); }
.article-footer {
    display:flex; justify-content:space-between;
    align-items:center; margin-top:2px;
}
.score-chip {
    font-size:.67rem; font-weight:700;
    padding:2px 8px; border-radius:99px;
}
.sent-badge {
    font-size:.62rem; font-weight:700;
    padding:2px 9px; border-radius:99px;
    text-transform:uppercase; letter-spacing:.4px;
}

/* Filter chips */
.filter-chips { display:flex; gap:6px; flex-wrap:wrap; }
.chip {
    font-size:.70rem; font-weight:700; padding:4px 12px;
    border-radius:99px; cursor:pointer; border:1px solid rgba(255,255,255,0.1);
    background:rgba(0,0,0,0.15); color:var(--fm); transition:all .2s; user-select:none;
}
.chip:hover { border-color:var(--fa); color:var(--fa); background:rgba(79,125,219,.06); }
.chip.active { background:linear-gradient(135deg,var(--fa),#3d5fc0); color:#fff; border-color:transparent; }

/* Empty state */
.empty-state {
    flex:1; display:flex; flex-direction:column;
    align-items:center; justify-content:center;
    gap:10px; color:var(--fm); padding:30px;
}
</style>

@php
    $posPct = $totalNews > 0 ? round(($positive / $totalNews) * 100) : 0;
    $neuPct = $totalNews > 0 ? round(($neutral  / $totalNews) * 100) : 0;
    $negPct = $totalNews > 0 ? round(($negative / $totalNews) * 100) : 0;

    /* Dominant sentiment */
    $dom = 'Netral'; $domColor = 'var(--fm)';
    if ($positive >= $negative && $positive >= $neutral) { $dom = 'Positif'; $domColor = 'var(--fg)'; }
    elseif ($negative >= $positive && $negative >= $neutral) { $dom = 'Negatif'; $domColor = 'var(--fr)'; }
@endphp

<div class="news-page" style="animation:slideDown .4s ease-out;">

    {{-- ===== HEADER ===== --}}
    <div class="news-header-container">
        <div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <h1 style="font-size:1.05rem;font-weight:800;color:#fff;margin:0;">News &amp; Market Sentiment</h1>
                <div class="live-badge">
                    <span class="pulse-dot"></span>
                    Sentiment Engine Active
                    <span style="opacity:.3;color:var(--fm);">|</span>
                    <span id="live-clock"><i class="fa-regular fa-clock me-1"></i>--:--:--</span>
                </div>
            </div>
            <p style="font-size:.74rem;color:var(--fm);margin:0;">
                <i class="fa-solid fa-chart-pie me-1"></i>Pemantauan sentimen berita ekonomi &amp; rantai pasok secara real-time untuk <strong style="color:var(--ft);">{{ $selectedCountry }}</strong>.
            </p>
        </div>

        <form id="monitor-form" action="{{ route('market.news') }}" method="GET" class="search-capsule">
            @csrf
            <div class="ps-3 pe-2 flex-shrink-0">
                <i class="fa-solid fa-earth-americas" style="font-size: 0.9rem; color: var(--fa);"></i>
            </div>
            <div class="flex-grow-1 px-1" style="min-width: 0;">
                <select name="country" class="form-select select2-news border-0 bg-transparent shadow-none p-0"
                        style="width: 100%; cursor: pointer; font-size: 0.85rem; font-weight: 700; color: var(--ft);">
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
        <div class="stat-card base-card">
            <div class="stat-icon" style="background:rgba(79,125,219,.12); color:var(--fa);">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <div>
                <div class="stat-label">Total Artikel</div>
                <div class="stat-value">{{ $totalNews }}</div>
                <div class="stat-sub">artikel diproses</div>
            </div>
        </div>

        <div class="stat-card base-card">
            <div class="stat-icon" style="background:rgba(52,211,153,.12); color:var(--fg);">
                <i class="fa-solid fa-arrow-trend-up"></i>
            </div>
            <div style="flex:1;">
                <div style="display:flex;justify-content:space-between;align-items:baseline;">
                    <div class="stat-label">Positif</div>
                    <span style="font-size:.75rem;font-weight:800;color:var(--fg);">{{ $posPct }}%</span>
                </div>
                <div class="stat-value" style="color:var(--fg);">{{ $positive }}</div>
                <div class="mini-progress">
                    <div class="mini-progress-fill" style="width:{{ $posPct }}%;background:var(--fg);"></div>
                </div>
            </div>
        </div>

        <div class="stat-card base-card">
            <div class="stat-icon" style="background:rgba(255,255,255,.05); color:var(--fm);">
                <i class="fa-solid fa-minus"></i>
            </div>
            <div style="flex:1;">
                <div style="display:flex;justify-content:space-between;align-items:baseline;">
                    <div class="stat-label">Netral</div>
                    <span style="font-size:.75rem;font-weight:800;color:var(--fm);">{{ $neuPct }}%</span>
                </div>
                <div class="stat-value" style="color:var(--ft);">{{ $neutral }}</div>
                <div class="mini-progress">
                    <div class="mini-progress-fill" style="width:{{ $neuPct }}%;background:var(--fm);"></div>
                </div>
            </div>
        </div>

        <div class="stat-card base-card">
            <div class="stat-icon" style="background:rgba(248,113,113,.12); color:var(--fr);">
                <i class="fa-solid fa-arrow-trend-down"></i>
            </div>
            <div style="flex:1;">
                <div style="display:flex;justify-content:space-between;align-items:baseline;">
                    <div class="stat-label">Negatif</div>
                    <span style="font-size:.75rem;font-weight:800;color:var(--fr);">{{ $negPct }}%</span>
                </div>
                <div class="stat-value" style="color:var(--fr);">{{ $negative }}</div>
                <div class="mini-progress">
                    <div class="mini-progress-fill" style="width:{{ $negPct }}%;background:var(--fr);"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MAIN GRID ===== --}}
    <div class="main-grid">

        {{-- LEFT: Sentiment Overview Panel --}}
        <div class="panel-card base-card">
            <div class="panel-header">
                <div class="panel-title">
                    <div class="panel-icon" style="color:var(--fy); background:rgba(251,191,36,.12);">
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
                        <div class="sent-dot" style="background:var(--fg);"></div>
                        <div class="sent-info">
                            <div class="sent-name">Positif</div>
                            <div class="mini-progress" style="margin-top:4px;">
                                <div class="mini-progress-fill" style="width:{{ $posPct }}%;background:var(--fg);"></div>
                            </div>
                        </div>
                        <span class="sent-pct" style="color:var(--fg);">{{ $posPct }}%</span>
                    </div>
                    <div class="sent-item">
                        <div class="sent-dot" style="background:var(--fm);"></div>
                        <div class="sent-info">
                            <div class="sent-name">Netral</div>
                            <div class="mini-progress" style="margin-top:4px;">
                                <div class="mini-progress-fill" style="width:{{ $neuPct }}%;background:var(--fm);"></div>
                            </div>
                        </div>
                        <span class="sent-pct" style="color:var(--ft);">{{ $neuPct }}%</span>
                    </div>
                    <div class="sent-item">
                        <div class="sent-dot" style="background:var(--fr);"></div>
                        <div class="sent-info">
                            <div class="sent-name">Negatif</div>
                            <div class="mini-progress" style="margin-top:4px;">
                                <div class="mini-progress-fill" style="width:{{ $negPct }}%;background:var(--fr);"></div>
                            </div>
                        </div>
                        <span class="sent-pct" style="color:var(--fr);">{{ $negPct }}%</span>
                    </div>
                </div>

                {{-- Dominant insight --}}
                <div style="margin-top:14px;">
                    <div style="background:rgba(0,0,0,0.15);border-radius:10px;padding:12px;border:1px solid rgba(79,125,219,.08);">
                        <div style="font-size:.58rem;font-weight:800;text-transform:uppercase;letter-spacing:.6px;color:var(--fm);margin-bottom:5px;">Dominan Pasar</div>
                        <div style="font-size:1rem;font-weight:800;color:{{ $domColor }};">
                            <i class="fa-solid {{ $dom === 'Positif' ? 'fa-circle-check' : ($dom === 'Negatif' ? 'fa-circle-exclamation' : 'fa-circle-minus') }} me-1"></i>
                            {{ $dom }}
                        </div>
                        <div style="font-size:.72rem;color:var(--fm);font-weight:500;margin-top:3px;">
                            {{ $dom === 'Positif' ? 'Kondisi rantai pasok kondusif' : ($dom === 'Negatif' ? 'Perlu pemantauan risiko operasional' : 'Situasi berimbang, monitor berkala') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Article List --}}
        <div class="panel-card base-card">
            <div class="panel-header">
                <div class="panel-title">
                    <div class="panel-icon">
                        <i class="fa-solid fa-list-ul"></i>
                    </div>
                    Daftar Artikel
                    <span style="font-size:.72rem;color:var(--fm);font-weight:500;text-transform:none;letter-spacing:normal;">— {{ $totalNews }} ditemukan</span>
                </div>
                {{-- Filter chips --}}
                <div class="filter-chips" id="filterChips">
                    <span class="chip active" data-filter="all">Semua</span>
                    <span class="chip" data-filter="Positive">Positif</span>
                    <span class="chip" data-filter="Neutral">Netral</span>
                    <span class="chip" data-filter="Negative">Negatif</span>
                </div>
            </div>
            <div class="panel-body">
                @if(count($newsData) > 0)
                <div class="news-list" id="newsList">
                    @foreach($newsData as $article)
                        @php
                            if ($article['sentiment'] === 'Positive') {
                                $bColor = 'var(--fg)'; $badgeBg = 'rgba(52,211,153,0.12)'; $badgeText = 'var(--fg)';
                                $scoreBg = 'rgba(52,211,153,0.05)'; $scoreBorder = 'rgba(52,211,153,0.2)'; $scoreColor = 'var(--fg)';
                            } elseif ($article['sentiment'] === 'Negative') {
                                $bColor = 'var(--fr)'; $badgeBg = 'rgba(248,113,113,0.12)'; $badgeText = 'var(--fr)';
                                $scoreBg = 'rgba(248,113,113,0.05)'; $scoreBorder = 'rgba(248,113,113,0.2)'; $scoreColor = 'var(--fr)';
                            } else {
                                $bColor = 'var(--fm)'; $badgeBg = 'rgba(255,255,255,0.05)'; $badgeText = 'var(--ft)';
                                $scoreBg = 'rgba(0,0,0,0.2)'; $scoreBorder = 'rgba(255,255,255,0.1)'; $scoreColor = 'var(--fm)';
                            }
                        @endphp
                        <div class="article-card" style="border-left-color:{{ $bColor }};" data-sentiment="{{ $article['sentiment'] }}">
                            <div class="article-source">
                                <i class="fa-regular fa-building"></i>
                                {{ $article['source'] }}
                            </div>
                            <a href="{{ $article['url'] }}" target="_blank" class="article-title">
                                {{ $article['title'] }}
                            </a>
                            <div class="article-footer">
                                <span class="score-chip" style="background:{{ $scoreBg }};border:1px solid {{ $scoreBorder }};color:{{ $scoreColor }};">
                                    Indeks: {{ $article['score'] }} pts
                                </span>
                                <div style="display:flex;align-items:center;gap:6px;">
                                    <span class="sent-badge" style="background:{{ $badgeBg }};color:{{ $badgeText }};">
                                        {{ $article['sentiment'] }}
                                    </span>
                                    <a href="{{ $article['url'] }}" target="_blank"
                                       style="width:26px;height:26px;border-radius:6px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;color:var(--fm);font-size:.65rem;transition:all .2s;text-decoration:none;"
                                       onmouseover="this.style.background='rgba(79,125,219,0.15)';this.style.color='var(--fa)';"
                                       onmouseout="this.style.background='rgba(255,255,255,0.05)';this.style.color='var(--fm)';">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                <div class="empty-state">
                    <i class="fa-regular fa-folder-open" style="font-size:2.5rem; color:var(--fb);"></i>
                    <div style="font-size:.9rem;font-weight:700;color:var(--ft);">Tidak ada artikel ditemukan</div>
                    <div style="font-size:.78rem;text-align:center;max-width:240px;color:var(--fm);">Coba pilih negara lain menggunakan kolom pencarian di atas.</div>
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
                backgroundColor: ['#34d399', '#8fadd4', '#f87171'],
                borderColor: '#1a2d4e',
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
                    backgroundColor: '#0a1628', 
                    titleColor: '#8fadd4',
                    bodyColor: '#ffffff',
                    padding: 10,
                    cornerRadius: 10,
                    borderColor: 'rgba(79,125,219,.2)',
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