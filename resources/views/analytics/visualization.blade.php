@extends('layouts.app')

@section('content')
<style>
    /* ===== OVERRIDE: Jadikan halaman ini bisa di-scroll ===== */
    .main-content { overflow-y: auto !important; height: 100vh !important; }
    .content-inner { overflow: visible !important; height: auto !important; }

    /* ===== TEMA DARK NAVY SESUAI DASHBOARD ===== */
    :root {
        --viz-navy:   #0f172a;
        --viz-card:   #1e2d4a;
        --viz-card2:  #162240;
        --viz-border: rgba(79,125,219,0.18);
        --viz-accent: #4f7ddb;
        --viz-accent2:#7ba7ff;
        --viz-text:   #dce8f8;
        --viz-muted:  #8fadd4;
        --viz-green:  #34d399;
        --viz-yellow: #fbbf24;
        --viz-red:    #f87171;
        --viz-purple: #a78bfa;
    }

    .viz-page { background: #0b1628; min-height: 100%; padding-bottom: 2rem; }

    /* Header strip */
    .viz-header {
        background: linear-gradient(135deg, #0f2044 0%, #0d1e3d 100%);
        border-bottom: 1px solid var(--viz-border);
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin: -1.25rem -1.5rem 1.5rem;
    }
    .viz-title { font-size: 1.05rem; font-weight: 700; color: #fff; letter-spacing: -0.4px; }
    .viz-subtitle { font-size: 0.78rem; color: var(--viz-muted); margin-top: 2px; }

    /* Live badge */
    .live-badge {
        display: flex; align-items: center; gap: 0.5rem;
        background: rgba(52,211,153,0.12);
        border: 1px solid rgba(52,211,153,0.25);
        border-radius: 999px; padding: 4px 12px;
        font-size: 0.68rem; font-weight: 600; color: var(--viz-green);
    }
    .pulse-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--viz-green); animation: pulse 1.5s infinite; }
    @keyframes pulse {
        0%   { box-shadow: 0 0 0 0 rgba(52,211,153,0.7); }
        70%  { box-shadow: 0 0 0 5px rgba(52,211,153,0); }
        100% { box-shadow: 0 0 0 0 rgba(52,211,153,0); }
    }

    /* Search capsule */
    .search-capsule {
        background: rgba(255,255,255,0.05);
        border: 1px solid var(--viz-border);
        border-radius: 999px;
        padding: 4px 4px 4px 14px;
        display: flex; align-items: center; gap: 8px;
        width: 320px;
        transition: all 0.3s ease;
    }
    .search-capsule:focus-within {
        border-color: var(--viz-accent);
        box-shadow: 0 0 0 3px rgba(79,125,219,0.2);
    }
    .search-capsule select {
        background: transparent; border: none; outline: none;
        color: var(--viz-text); font-size: 0.83rem; font-weight: 500;
        flex: 1; cursor: pointer; padding: 2px 0;
    }
    .search-capsule select option { background: #1e2d4a; color: #fff; }
    .btn-analyze {
        background: linear-gradient(135deg, var(--viz-accent), #3d5fc0);
        border: none; border-radius: 999px;
        color: #fff; font-size: 0.75rem; font-weight: 600;
        padding: 6px 14px; cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-analyze:hover { filter: brightness(1.15); transform: scale(1.04); }

    /* Chart Cards */
    .chart-card {
        background: linear-gradient(145deg, #1a2d4e 0%, #162240 100%);
        border: 1px solid var(--viz-border);
        border-radius: 16px;
        padding: 1.4rem;
        display: flex; flex-direction: column;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        position: relative; overflow: hidden;
    }
    .chart-card::before {
        content: ''; position: absolute; inset: 0; border-radius: 16px;
        background: linear-gradient(135deg, rgba(79,125,219,0.06) 0%, transparent 60%);
        pointer-events: none;
    }
    .chart-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(0,0,0,0.4), 0 0 0 1px rgba(79,125,219,0.3);
    }

    .chart-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; }
    .chart-card-title { font-size: 0.9rem; font-weight: 700; color: #fff; letter-spacing: -0.2px; }
    .chart-card-sub { font-size: 0.72rem; color: var(--viz-muted); margin-top: 3px; }

    .card-icon {
        width: 36px; height: 36px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.9rem; flex-shrink: 0;
    }
    .icon-green  { background: rgba(52,211,153,0.15); color: var(--viz-green); }
    .icon-yellow { background: rgba(251,191,36,0.15);  color: var(--viz-yellow); }
    .icon-purple { background: rgba(167,139,250,0.15); color: var(--viz-purple); }
    .icon-red    { background: rgba(248,113,113,0.15); color: var(--viz-red); }

    .chart-area { position: relative; flex: 1; min-height: 230px; margin-top: 0.5rem; }

    /* Insight strip */
    .insight-strip {
        margin-top: 1rem;
        background: rgba(79,125,219,0.08);
        border: 1px solid rgba(79,125,219,0.15);
        border-radius: 8px; padding: 9px 13px;
        font-size: 0.73rem; color: var(--viz-muted);
        display: flex; align-items: center; gap: 8px;
    }
    .insight-strip i { color: var(--viz-yellow); flex-shrink: 0; }

    /* Stat badges di atas chart */
    .stat-row { display: flex; gap: 1rem; margin-bottom: 0.75rem; flex-wrap: wrap; }
    .stat-pill {
        background: rgba(255,255,255,0.06); border: 1px solid var(--viz-border);
        border-radius: 8px; padding: 5px 12px; font-size: 0.72rem;
    }
    .stat-pill .sp-label { color: var(--viz-muted); }
    .stat-pill .sp-val { font-weight: 700; color: #fff; }

    /* Section divider */
    .viz-section-label {
        font-size: 0.65rem; font-weight: 700; letter-spacing: 1.4px;
        text-transform: uppercase; color: var(--viz-muted);
        margin: 1.5rem 0 0.75rem;
        display: flex; align-items: center; gap: 8px;
    }
    .viz-section-label::after {
        content: ''; flex: 1; height: 1px; background: var(--viz-border);
    }

    /* ===== Standalone Search Row ===== */
    .viz-search-row { margin-bottom: 1.25rem; }
    .viz-search-form {
        display: inline-flex; align-items: center; gap: 10px;
        background: linear-gradient(145deg, #1a2d4e, #162240);
        border: 1px solid var(--viz-border);
        border-radius: 999px;
        padding: 7px 7px 7px 18px;
        min-width: 360px;
        transition: all .3s ease;
    }
    .viz-search-form:focus-within {
        border-color: var(--viz-accent);
        box-shadow: 0 0 0 3px rgba(79,125,219,.2);
    }
    .vsr-icon { color: var(--viz-accent); font-size: .9rem; flex-shrink: 0; }
    .vsr-select {
        background: transparent; border: none; outline: none;
        color: var(--viz-text); font-size: .88rem; font-weight: 600;
        flex: 1; cursor: pointer; min-width: 180px;
    }
    .vsr-select option { background: #1e2d4a; color: #fff; }
</style>

<div class="viz-page">

    {{-- ===== HEADER ===== --}}
    <div class="viz-header">
        <div>
            <div class="viz-title">
                <i class="fa-solid fa-chart-mixed me-2" style="color: var(--viz-accent);"></i>
                Data Visualization Dashboard
            </div>
            <div class="viz-subtitle">
                <i class="fa-solid fa-location-dot me-1"></i>
                Analitik makroekonomi & tren risiko historis &mdash;
                <strong style="color: var(--viz-accent2);">{{ $targetCountry }}</strong>
            </div>
        </div>

        <div class="live-badge">
                <span class="pulse-dot"></span>
                Node 10 Active
                <span style="opacity:.3">|</span>
                <span id="live-clock"><i class="fa-regular fa-clock me-1"></i>00:00:00</span>
            </div>
    </div>

    {{-- ===== SEARCH BAR ROW ===== --}}
    <div class="viz-search-row">
        <label style="font-size:.7rem;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--viz-muted);margin-bottom:.5rem;display:block;">Pilih Negara untuk Dianalisis</label>
        <form id="monitor-form" action="{{ route('analytics.visualization') }}" method="GET" class="viz-search-form">
            <div class="vsr-icon"><i class="fa-solid fa-earth-americas"></i></div>
            <select name="country" class="vsr-select">
                @php $list = $countriesList ?? []; @endphp
                @forelse($list as $c)
                    <option value="{{ $c }}" {{ $targetCountry == $c ? 'selected' : '' }}>{{ $c }}</option>
                @empty
                    <option value="Indonesia">Indonesia</option>
                @endforelse
            </select>
            <button type="submit" id="btn-monitor" class="btn-analyze">
                <i class="fa-solid fa-magnifying-glass-chart me-1" id="btn-icon"></i>
                <span id="btn-text">Analisis</span>
            </button>
        </form>
    </div>

    @if(session('error'))
    <div class="alert mb-4 py-2 px-3" style="background:#2d1515;border:1px solid rgba(248,113,113,0.3);border-radius:8px;color:#f87171;font-size:0.83rem;">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
    </div>
    @endif

    {{-- ===== SECTION LABEL ===== --}}
    <div class="viz-section-label">Economic Indicators</div>

    {{-- ===== GRID GRAFIK ===== --}}
    <div class="row g-4">

        {{-- 1. GDP Chart --}}
        <div class="col-lg-6 col-md-12">
            <div class="chart-card">
                <div class="chart-card-header">
                    <div>
                        <div class="chart-card-title">Gross Domestic Product (GDP)</div>
                        <div class="chart-card-sub">Kekuatan daya beli & kapasitas pasar (World Bank API)</div>
                    </div>
                    <div class="card-icon icon-green"><i class="fa-solid fa-money-bill-trend-up"></i></div>
                </div>
                <div class="stat-row" id="gdp-stats">
                    <div class="stat-pill"><div class="sp-label">Latest</div><div class="sp-val" id="gdp-latest">—</div></div>
                    <div class="stat-pill"><div class="sp-label">Peak</div><div class="sp-val" id="gdp-peak">—</div></div>
                    <div class="stat-pill"><div class="sp-label">Growth</div><div class="sp-val" id="gdp-growth">—</div></div>
                </div>
                <div class="chart-area"><canvas id="gdpChart"></canvas></div>
                <div class="insight-strip">
                    <i class="fa-solid fa-lightbulb"></i>
                    <span><strong style="color:#fff;">Insight:</strong> Pertumbuhan GDP berbanding lurus dengan kapasitas konsumsi pasar domestik negara terkait.</span>
                </div>
            </div>
        </div>

        {{-- 2. Inflation Chart --}}
        <div class="col-lg-6 col-md-12">
            <div class="chart-card">
                <div class="chart-card-header">
                    <div>
                        <div class="chart-card-title">Inflation Fluctuation Rate</div>
                        <div class="chart-card-sub">Risiko lonjakan biaya operasional & logistik (%)</div>
                    </div>
                    <div class="card-icon icon-yellow"><i class="fa-solid fa-arrow-trend-up"></i></div>
                </div>
                <div class="stat-row">
                    <div class="stat-pill"><div class="sp-label">Latest</div><div class="sp-val" id="inf-latest">—</div></div>
                    <div class="stat-pill"><div class="sp-label">Peak</div><div class="sp-val" id="inf-peak">—</div></div>
                    <div class="stat-pill"><div class="sp-label">Avg</div><div class="sp-val" id="inf-avg">—</div></div>
                </div>
                <div class="chart-area"><canvas id="inflationChart"></canvas></div>
                <div class="insight-strip">
                    <i class="fa-solid fa-lightbulb"></i>
                    <span><strong style="color:#fff;">Insight:</strong> Tren inflasi yang menanjak mengindikasikan membengkaknya biaya penyimpanan dan distribusi.</span>
                </div>
            </div>
        </div>

        <div class="viz-section-label col-12" style="margin-top:0.5rem;">Market & Risk Indicators</div>

        {{-- 3. Currency Chart --}}
        <div class="col-lg-6 col-md-12">
            <div class="chart-card">
                <div class="chart-card-header">
                    <div>
                        <div class="chart-card-title">Currency Volatility ({{ $chartData['currency']['code'] }} / USD)</div>
                        <div class="chart-card-sub">Pergerakan historis nilai tukar terhadap USD</div>
                    </div>
                    <div class="card-icon icon-purple"><i class="fa-solid fa-coins"></i></div>
                </div>
                <div class="stat-row">
                    <div class="stat-pill"><div class="sp-label">Latest</div><div class="sp-val" id="cur-latest">—</div></div>
                    <div class="stat-pill"><div class="sp-label">High</div><div class="sp-val" id="cur-high">—</div></div>
                    <div class="stat-pill"><div class="sp-label">Low</div><div class="sp-val" id="cur-low">—</div></div>
                </div>
                <div class="chart-area"><canvas id="currencyChart"></canvas></div>
                <div class="insight-strip">
                    <i class="fa-solid fa-lightbulb"></i>
                    <span><strong style="color:#fff;">Insight:</strong> Volatilitas tinggi mewajibkan langkah <em>hedging</em> (lindung nilai) sebelum melakukan impor.</span>
                </div>
            </div>
        </div>

        {{-- 4. Risk Index Chart --}}
        <div class="col-lg-6 col-md-12">
            <div class="chart-card">
                <div class="chart-card-header">
                    <div>
                        <div class="chart-card-title">Aggregated Risk Index Trend</div>
                        <div class="chart-card-sub">Akumulasi sentimen, cuaca & ekonomi (skala 0–100)</div>
                    </div>
                    <div class="card-icon icon-red"><i class="fa-solid fa-shield-halved"></i></div>
                </div>
                <div class="stat-row">
                    <div class="stat-pill"><div class="sp-label">Latest</div><div class="sp-val" id="risk-latest">—</div></div>
                    <div class="stat-pill"><div class="sp-label">Max</div><div class="sp-val" id="risk-max">—</div></div>
                    <div class="stat-pill"><div class="sp-label">Avg</div><div class="sp-val" id="risk-avg">—</div></div>
                </div>
                <div class="chart-area"><canvas id="riskChart"></canvas></div>
                <div class="insight-strip">
                    <i class="fa-solid fa-lightbulb"></i>
                    <span><strong style="color:#fff;">Insight:</strong> Skor di atas 60 menandakan <em>High Risk</em>. Perhatikan puncak untuk evaluasi rute alternatif.</span>
                </div>
            </div>
        </div>

    </div>{{-- end row --}}
</div>{{-- end viz-page --}}

{{-- ===== SCRIPT ===== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* Live clock */
    function updateClock() {
        const el = document.getElementById('live-clock');
        if (el) el.innerHTML = `<i class="fa-regular fa-clock me-1"></i>${new Date().toLocaleTimeString('id-ID')}`;
    }
    setInterval(updateClock, 1000); updateClock();

    /* Button loading */
    const form = document.getElementById('monitor-form');
    const btn  = document.getElementById('btn-monitor');
    if (form && btn) {
        form.addEventListener('submit', function () {
            document.getElementById('btn-icon').className = 'spinner-border spinner-border-sm me-1';
            document.getElementById('btn-text').innerText = 'Memproses…';
            btn.disabled = true;
        });
    }

    /* ===== GLOBAL CHART DEFAULTS ===== */
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#8fadd4';

    const GRID = {
        color: 'rgba(79,125,219,0.1)',
        borderDash: [4, 4],
        drawBorder: false
    };

    const TOOLTIP = {
        backgroundColor: '#0f172a',
        borderColor: 'rgba(79,125,219,0.4)',
        borderWidth: 1,
        padding: 12,
        titleFont: { size: 12, weight: '600', family: 'Inter' },
        bodyFont:  { size: 13, weight: '700', family: 'Inter' },
        cornerRadius: 10,
        displayColors: false,
        caretSize: 6
    };

    function grad(ctx, c1, c2, h=280) {
        const g = ctx.createLinearGradient(0, 0, 0, h);
        g.addColorStop(0, c1);
        g.addColorStop(1, c2);
        return g;
    }

    function fmt(n) {
        if (n >= 1e12) return (n/1e12).toFixed(2)+'T';
        if (n >= 1e9)  return (n/1e9).toFixed(2)+'B';
        if (n >= 1e6)  return (n/1e6).toFixed(2)+'M';
        return n?.toLocaleString('en-US') ?? '—';
    }

    const data = @json($chartData);

    /* ==============================
       1. GDP — Bar Chart
    ============================== */
    (function() {
        const d = data.gdp.data;
        const latest = d[d.length-1], peak = Math.max(...d);
        const growth = d.length > 1 ? (((d[d.length-1]/d[d.length-2])-1)*100).toFixed(1)+'%' : '—';
        document.getElementById('gdp-latest').textContent = fmt(latest);
        document.getElementById('gdp-peak').textContent   = fmt(peak);
        document.getElementById('gdp-growth').textContent = growth;

        const ctx = document.getElementById('gdpChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.gdp.labels,
                datasets: [{
                    label: 'GDP (USD)',
                    data: d,
                    backgroundColor: d.map((v,i,a) => v === Math.max(...a)
                        ? 'rgba(79,125,219,0.95)' : 'rgba(79,125,219,0.45)'),
                    hoverBackgroundColor: 'rgba(123,167,255,0.95)',
                    borderRadius: 7,
                    borderSkipped: 'bottom',
                    barPercentage: 0.62,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { ...TOOLTIP, callbacks: { label: c => '$ ' + c.raw.toLocaleString('en-US') } }
                },
                scales: {
                    y: { grid: GRID, border: { display: false }, ticks: { callback: v => fmt(v) } },
                    x: { grid: { display: false }, border: { display: false } }
                },
                animation: { duration: 900, easing: 'easeOutQuart' }
            }
        });
    })();

    /* ==============================
       2. Inflation — Line Area
    ============================== */
    (function() {
        const d = data.inflation.data;
        const latest = d[d.length-1], peak = Math.max(...d);
        const avg = (d.reduce((a,b)=>a+b,0)/d.length).toFixed(2);
        document.getElementById('inf-latest').textContent = latest?.toFixed(2)+'%';
        document.getElementById('inf-peak').textContent   = peak?.toFixed(2)+'%';
        document.getElementById('inf-avg').textContent    = avg+'%';

        const ctx = document.getElementById('inflationChart').getContext('2d');
        const bg  = grad(ctx, 'rgba(251,191,36,0.35)', 'rgba(251,191,36,0.0)');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.inflation.labels,
                datasets: [{
                    label: 'Inflation %',
                    data: d,
                    borderColor: '#fbbf24',
                    backgroundColor: bg,
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.42,
                    pointBackgroundColor: '#fbbf24',
                    pointBorderColor: '#0f172a',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { ...TOOLTIP, callbacks: { label: c => c.raw.toFixed(2)+'%' } }
                },
                scales: {
                    y: { grid: GRID, border: { display: false } },
                    x: { grid: { display: false }, border: { display: false } }
                },
                animation: { duration: 900, easing: 'easeOutQuart' }
            }
        });
    })();

    /* ==============================
       3. Currency — Area (purple)
    ============================== */
    (function() {
        const d = data.currency.data, code = data.currency.code;
        document.getElementById('cur-latest').textContent = d[d.length-1]?.toLocaleString('en-US');
        document.getElementById('cur-high').textContent   = Math.max(...d).toLocaleString('en-US');
        document.getElementById('cur-low').textContent    = Math.min(...d).toLocaleString('en-US');

        const ctx = document.getElementById('currencyChart').getContext('2d');
        const bg  = grad(ctx, 'rgba(167,139,250,0.4)', 'rgba(167,139,250,0.0)');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.currency.labels,
                datasets: [{
                    label: `${code} / USD`,
                    data: d,
                    borderColor: '#a78bfa',
                    backgroundColor: bg,
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.42,
                    pointRadius: 0,
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: '#a78bfa',
                    pointHoverBorderColor: '#0f172a',
                    pointHoverBorderWidth: 2,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { ...TOOLTIP, callbacks: { label: c => c.raw.toLocaleString('en-US') + ' ' + code } }
                },
                scales: {
                    y: { grid: GRID, border: { display: false }, ticks: { callback: v => v.toLocaleString('en-US') } },
                    x: { grid: { display: false }, border: { display: false } }
                },
                animation: { duration: 900, easing: 'easeOutQuart' }
            }
        });
    })();

    /* ==============================
       4. Risk Index — Line + Threshold
    ============================== */
    (function() {
        const d = data.risk.data;
        const latest = d[d.length-1], max = Math.max(...d);
        const avg = (d.reduce((a,b)=>a+b,0)/d.length).toFixed(1);
        document.getElementById('risk-latest').textContent = latest + ' pts';
        document.getElementById('risk-max').textContent    = max + ' pts';
        document.getElementById('risk-avg').textContent    = avg + ' pts';

        const ctx = document.getElementById('riskChart').getContext('2d');
        const bg  = grad(ctx, 'rgba(248,113,113,0.35)', 'rgba(248,113,113,0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.risk.labels,
                datasets: [
                    {
                        label: 'Risk Score',
                        data: d,
                        borderColor: '#f87171',
                        backgroundColor: bg,
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: d.map(v => v >= 60 ? '#f87171' : '#4f7ddb'),
                        pointBorderColor: '#0f172a',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 7
                    },
                    {
                        label: 'High-Risk Threshold',
                        data: Array(d.length).fill(60),
                        borderColor: 'rgba(251,191,36,0.5)',
                        borderWidth: 1.5,
                        borderDash: [6, 4],
                        pointRadius: 0,
                        fill: false,
                        tension: 0
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: { font: { size: 11 }, boxWidth: 20, padding: 12 }
                    },
                    tooltip: {
                        ...TOOLTIP,
                        callbacks: {
                            label: c => c.datasetIndex === 0
                                ? c.raw + ' Poin — ' + (c.raw >= 60 ? '⚠ High Risk' : '✓ Normal')
                                : 'Batas High Risk: 60'
                        }
                    }
                },
                scales: {
                    y: { min: 0, max: 100, grid: GRID, border: { display: false } },
                    x: { grid: { display: false }, border: { display: false } }
                },
                animation: { duration: 900, easing: 'easeOutQuart' }
            }
        });
    })();

});
</script>
@endsection