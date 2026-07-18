@extends('layouts.app')

@section('content')
<style>
/* ===== CURRENCY PAGE STYLES ===== */
.currency-page { display:flex; flex-direction:column; height:100%; overflow:hidden; }

/* Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    flex-shrink: 0;
    margin-bottom: 14px;
    gap: 12px;
    animation: slideDown 0.4s ease-out;
}
@keyframes slideDown {
    from { opacity:0; transform:translateY(-10px); }
    to   { opacity:1; transform:translateY(0); }
}
.page-title { font-size:1.25rem; font-weight:800; color:#0f172a; letter-spacing:-0.5px; margin:0; }
.page-subtitle { font-size:0.82rem; color:#64748b; margin:2px 0 0; }

/* Live badge */
.live-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #ecfdf5;
    border: 1px solid #6ee7b7;
    border-radius: 99px;
    padding: 3px 10px;
    font-size: 0.68rem;
    font-weight: 700;
    color: #059669;
}
.pulse-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #10b981;
    animation: livePulse 1.5s infinite;
}
@keyframes livePulse {
    0%   { box-shadow: 0 0 0 0 rgba(16,185,129,0.7); }
    70%  { box-shadow: 0 0 0 5px rgba(16,185,129,0); }
    100% { box-shadow: 0 0 0 0 rgba(16,185,129,0); }
}

/* Search capsule — identik dengan dashboard */
.search-capsule {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 99px;
    display: flex;
    align-items: center;
    padding: 4px 4px 4px 12px;
    gap: 6px;
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
    border: none;
    border-radius: 99px;
    padding: 0 18px;
    height: 34px;
    font-size: 0.75rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    white-space: nowrap;
}
.btn-analyze:hover {
    filter: brightness(0.85);
    color: #ffffff !important;
    transform: scale(1.05);
}
.btn-analyze:active { transform: scale(0.95); }

/* Stat cards row */
.stat-row { display: flex; gap: 12px; flex-shrink: 0; margin-bottom: 14px; }
.stat-card {
    flex: 1;
    background: #fff;
    border-radius: 12px;
    padding: 14px 16px;
    border: 1px solid #eef0f6;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    display: flex;
    align-items: center;
    gap: 12px;
    transition: box-shadow 0.2s, transform 0.2s;
}
.stat-card:hover { box-shadow: 0 6px 20px rgba(61,95,192,0.10); transform: translateY(-2px); }
.stat-icon {
    width: 40px; height: 40px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}
.stat-label { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #94a3b8; margin-bottom: 3px; }
.stat-value { font-size: 1.15rem; font-weight: 800; color: #0f172a; letter-spacing: -0.5px; line-height: 1; }
.stat-sub { font-size: 0.7rem; color: #94a3b8; margin-top: 3px; }

/* Main grid */
.main-grid {
    flex: 1;
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 14px;
    min-height: 0;
}

/* Panel cards */
.panel-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #eef0f6;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    min-height: 0;
}
.panel-header {
    padding: 14px 18px 12px;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-shrink: 0;
}
.panel-title {
    font-size: 0.88rem;
    font-weight: 700;
    color: #111827;
    display: flex;
    align-items: center;
    gap: 8px;
}
.panel-icon {
    width: 28px; height: 28px;
    border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.72rem;
    color: #fff;
    flex-shrink: 0;
}
.panel-body {
    padding: 14px 18px;
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 0;
}

/* Rate snapshot badge */
.rate-snapshot {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    text-align: right;
}
.rate-label { font-size: 0.62rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #94a3b8; }
.rate-value { font-size: 1.3rem; font-weight: 800; color: #0f2044; letter-spacing: -0.5px; line-height: 1.1; margin-top: 2px; }
.rate-currency { font-size: 0.72rem; color: #64748b; margin-top: 2px; }

/* Converter styles */
.conv-label { font-size: 0.70rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #94a3b8; margin-bottom: 6px; }
.conv-input {
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 1rem;
    font-weight: 800;
    color: #0f172a;
    background: #f8fafc;
    width: 100%;
    text-align: right;
    outline: none;
    transition: border-color 0.2s;
}
.conv-input:focus { border-color: #3d5fc0; background: #fff; box-shadow: 0 0 0 3px rgba(61,95,192,0.10); }
.conv-select {
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 9px 12px;
    font-size: 0.88rem;
    font-weight: 700;
    color: #0f172a;
    background: #f8fafc;
    width: 100%;
    outline: none;
    cursor: pointer;
    transition: border-color 0.2s;
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='%2364748b'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    padding-right: 30px;
}
.conv-select:focus { border-color: #3d5fc0; background-color: #fff; }
.swap-btn {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: #f1f5f9;
    border: 1.5px solid #e2e8f0;
    color: #64748b;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.8rem;
    flex-shrink: 0;
}
.swap-btn:hover { background: #e2e8f0; color: #3d5fc0; transform: rotate(180deg); }

.result-box {
    border-radius: 12px;
    padding: 16px;
    text-align: center;
    background: linear-gradient(135deg, #0f2044 0%, #1a3575 100%);
    border: none;
    flex-shrink: 0;
}
.result-label { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: rgba(255,255,255,0.5); margin-bottom: 6px; }
.result-value { font-size: 1.45rem; font-weight: 800; color: #fff; letter-spacing: -0.5px; line-height: 1; }
.result-sub { font-size: 0.7rem; color: rgba(255,255,255,0.45); margin-top: 5px; }

/* Insight strip */
.insight-strip {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 7px 12px;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 500;
    flex-shrink: 0;
    margin-bottom: 10px;
    background: #f0f4ff;
    border: 1px solid #c7d8ff;
    color: #3d5fc0;
}
</style>

<div class="currency-page">

    {{-- ===== HEADER ===== --}}
    <div class="page-header">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h1 class="page-title">Currency Impact</h1>
                <div class="live-badge">
                    <span class="pulse-dot"></span>
                    API Active
                    <span style="opacity:0.3;">|</span>
                    <span id="live-clock"><i class="fa-regular fa-clock me-1"></i>--:--:--</span>
                </div>
            </div>
            <p class="page-subtitle"><i class="fa-solid fa-money-bill-transfer me-1"></i>Pemantauan fluktuasi nilai tukar &amp; kalkulator estimasi logistik secara real-time.</p>
        </div>

        <form id="monitor-form" action="{{ route('market.currency') }}" method="GET" class="search-capsule">
            @csrf
            <div class="ps-3 pe-2 flex-shrink-0">
                <i class="fa-solid fa-earth-americas" style="font-size: 0.9rem; color: var(--matcha-500, #3d5fc0);"></i>
            </div>
            <div class="flex-grow-1 px-1" style="min-width: 0;">
                <select name="country" class="form-select select2-currency border-0 bg-transparent shadow-none p-0"
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
                <i class="fa-solid fa-coins" style="color:#fff;"></i>
            </div>
            <div>
                <div class="stat-label">Mata Uang</div>
                <div class="stat-value">{{ $currencyCode }}</div>
                <div class="stat-sub">{{ $selectedCountry }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#0f766e,#14b8a6);">
                <i class="fa-solid fa-dollar-sign" style="color:#fff;"></i>
            </div>
            <div>
                <div class="stat-label">Live Rate (1 USD)</div>
                <div class="stat-value" style="font-size:1rem;">{{ $rate }}</div>
                <div class="stat-sub">{{ $currencyCode }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#7c3aed,#a78bfa);">
                <i class="fa-solid fa-arrow-trend-up" style="color:#fff;"></i>
            </div>
            <div>
                <div class="stat-label">Tren 10 Hari</div>
                <div class="stat-value" id="trendValue">--</div>
                <div class="stat-sub">vs awal periode</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#d97706,#fbbf24);">
                <i class="fa-solid fa-chart-simple" style="color:#fff;"></i>
            </div>
            <div>
                <div class="stat-label">Volatilitas</div>
                <div class="stat-value" id="volatilityValue">--</div>
                <div class="stat-sub">std. deviasi</div>
            </div>
        </div>

    </div>

    {{-- ===== MAIN GRID: CHART + CONVERTER ===== --}}
    <div class="main-grid">

        {{-- Chart Panel --}}
        <div class="panel-card">
            <div class="panel-header">
                <div class="panel-title">
                    <div class="panel-icon" style="background:linear-gradient(135deg,#3d5fc0,#6b8ff7);">
                        <i class="fa-solid fa-chart-area"></i>
                    </div>
                    Market Exchange Trends
                    <span style="font-size:0.72rem;color:#94a3b8;font-weight:500;">— 10 hari terakhir</span>
                </div>
                <div class="rate-snapshot">
                    <div class="rate-label">Live Rate (Base USD)</div>
                    <div class="rate-value">{{ $rate }}</div>
                    <div class="rate-currency">{{ $currencyCode }} / USD</div>
                </div>
            </div>
            <div class="panel-body">
                <div class="insight-strip">
                    <i class="fa-solid fa-circle-info" style="flex-shrink:0;"></i>
                    <span>Menampilkan fluktuasi historis <strong>{{ $currencyCode }}</strong> terhadap USD selama 10 hari terakhir. Nilai dibangkitkan dari kurs real-time dengan variasi ±1.5%.</span>
                </div>
                <div style="flex:1;min-height:0;position:relative;">
                    <canvas id="currencyChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Converter Panel --}}
        <div class="panel-card">
            <div class="panel-header">
                <div class="panel-title">
                    <div class="panel-icon" style="background:linear-gradient(135deg,#0f766e,#14b8a6);">
                        <i class="fa-solid fa-calculator"></i>
                    </div>
                    Smart Converter
                </div>
            </div>
            <div class="panel-body" style="gap:12px;">
                <div>
                    <div class="conv-label">Jumlah Pembayaran</div>
                    <input type="number" id="calcAmount" class="conv-input" value="1000" placeholder="0">
                </div>

                <div style="display:grid;grid-template-columns:1fr auto 1fr;gap:8px;align-items:flex-end;">
                    <div>
                        <div class="conv-label">Dari</div>
                        <select id="calcFrom" class="conv-select"></select>
                    </div>
                    <button class="swap-btn" id="swapBtn" type="button" title="Tukar">
                        <i class="fa-solid fa-right-left"></i>
                    </button>
                    <div>
                        <div class="conv-label">Ke</div>
                        <select id="calcTo" class="conv-select"></select>
                    </div>
                </div>

                {{-- Rate info --}}
                <div style="background:#f8fafc;border-radius:8px;padding:8px 12px;border:1px solid #e9ecef;">
                    <div style="font-size:0.68rem;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:3px;">Kurs Aktif</div>
                    <div id="rateInfo" style="font-size:0.82rem;font-weight:600;color:#374151;">Memuat...</div>
                </div>

                {{-- Result --}}
                <div class="result-box mt-auto">
                    <div class="result-label">Estimasi Hasil Konversi</div>
                    <div class="result-value" id="calcResult">0.00</div>
                    <div class="result-sub" id="calcResultSub">USD → {{ $currencyCode }}</div>
                </div>

                <p style="font-size:0.68rem;color:#94a3b8;text-align:center;margin:0;">
                    <i class="fa-solid fa-shield-halved me-1"></i>Powered by Open Exchange Rates API
                </p>
            </div>
        </div>

    </div>
</div>

{{-- ===== SCRIPTS ===== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── 1. Live Clock ── */
    (function tick() {
        const el = document.getElementById('live-clock');
        if (el) el.innerHTML = `<i class="fa-regular fa-clock me-1"></i>${new Date().toLocaleTimeString('id-ID')}`;
        setTimeout(tick, 1000);
    })();

    /* ── 2. Loading state on form submit ── */
    const form = document.getElementById('monitor-form');
    if (form) {
        form.addEventListener('submit', () => {
            const btn = document.getElementById('btn-analyze');
            const icon = document.getElementById('btn-icon');
            const text = document.getElementById('btn-text');
            btn.style.opacity = '0.75';
            btn.style.cursor = 'wait';
            icon.className = 'spinner-border spinner-border-sm';
            text.textContent = 'Memuat...';
        });
    }

    /* ── 3. Chart.js — Professional Gradient Line ── */
    const labels     = {!! json_encode($chartLabels) !!};
    const dataPoints = {!! json_encode($chartData) !!};

    /* Compute trend & volatility for stat cards */
    if (dataPoints.length >= 2) {
        const first = dataPoints[0], last = dataPoints[dataPoints.length - 1];
        const pct = ((last - first) / first * 100).toFixed(2);
        const trendEl = document.getElementById('trendValue');
        trendEl.textContent = (pct >= 0 ? '+' : '') + pct + '%';
        trendEl.style.color = pct >= 0 ? '#10b981' : '#ef4444';

        /* Std dev */
        const mean = dataPoints.reduce((a,b) => a+b, 0) / dataPoints.length;
        const stdDev = Math.sqrt(dataPoints.reduce((s,x) => s + Math.pow(x-mean,2), 0) / dataPoints.length);
        document.getElementById('volatilityValue').textContent = stdDev.toFixed(1);
    }

    const ctx = document.getElementById('currencyChart').getContext('2d');

    /* Gradient fill */
    const gradFill = ctx.createLinearGradient(0, 0, 0, 200);
    gradFill.addColorStop(0, 'rgba(61,95,192,0.22)');
    gradFill.addColorStop(0.6, 'rgba(61,95,192,0.06)');
    gradFill.addColorStop(1, 'rgba(61,95,192,0.0)');

    /* Annotation plugin – draw min/max lines */
    const minMaxPlugin = {
        id: 'minMaxLines',
        beforeDraw(chart) {
            if (!chart.data.datasets[0]?.data?.length) return;
            const { ctx: c, scales: { x, y }, data } = chart;
            const vals = data.datasets[0].data;
            const max = Math.max(...vals), min = Math.min(...vals);
            const yMax = y.getPixelForValue(max), yMin = y.getPixelForValue(min);

            const drawLine = (yP, color, label) => {
                c.save();
                c.beginPath();
                c.moveTo(x.left, yP);
                c.lineTo(x.right, yP);
                c.strokeStyle = color;
                c.lineWidth = 1;
                c.setLineDash([5, 5]);
                c.stroke();
                c.fillStyle = color;
                c.font = '9px "Inter", sans-serif';
                c.fillText(label, x.right - 45, yP - 4);
                c.restore();
            };
            drawLine(yMax, 'rgba(16,185,129,0.7)',  '▲ Max');
            drawLine(yMin, 'rgba(239,68,68,0.7)',   '▼ Min');
        }
    };

    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: `Kurs ${!! json_encode($currencyCode) !!} / USD`,
                data: dataPoints,
                borderColor: '#3d5fc0',
                backgroundColor: gradFill,
                borderWidth: 2.5,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#3d5fc0',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 7,
                pointHoverBackgroundColor: '#3d5fc0',
                pointHoverBorderColor: '#fff',
                fill: true,
                tension: 0.45,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 900, easing: 'easeOutQuart' },
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f2044',
                    titleColor: '#94a3b8',
                    bodyColor: '#fff',
                    padding: 12,
                    cornerRadius: 10,
                    borderColor: 'rgba(255,255,255,0.08)',
                    borderWidth: 1,
                    titleFont: { size: 11, family: "'Inter',sans-serif" },
                    bodyFont: { size: 13, weight: 'bold', family: "'Inter',sans-serif" },
                    displayColors: false,
                    callbacks: {
                        label: ctx => `  Kurs: ${ctx.raw.toLocaleString('id-ID')} {{ $currencyCode }}`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    border: { display: false },
                    grid: { color: '#f1f5f9', lineWidth: 1 },
                    ticks: {
                        font: { family: "'Inter',sans-serif", size: 10 },
                        color: '#94a3b8',
                        callback: v => v.toLocaleString('id-ID')
                    }
                },
                x: {
                    border: { display: false },
                    grid: { display: false },
                    ticks: { font: { family: "'Inter',sans-serif", size: 10, weight: '600' }, color: '#64748b' }
                }
            }
        },
        plugins: [minMaxPlugin]
    });

    /* ── 4. Smart Converter ── */
    const targetCode = "{{ $currencyCode }}";
    let rates = {};

    fetch('https://open.er-api.com/v6/latest/USD')
        .then(r => r.json())
        .then(data => {
            rates = data.rates;
            const fromSel = document.getElementById('calcFrom');
            const toSel   = document.getElementById('calcTo');
            const popular = ['USD','EUR','GBP','JPY','CNY','SGD','IDR','AUD', targetCode];
            [...new Set(popular)].forEach(c => {
                if (rates[c]) {
                    fromSel.innerHTML += `<option value="${c}">${c}</option>`;
                    toSel.innerHTML   += `<option value="${c}">${c}</option>`;
                }
            });
            fromSel.value = 'USD';
            toSel.value   = targetCode;
            calc();
        })
        .catch(() => {
            document.getElementById('rateInfo').textContent = 'Gagal memuat kurs.';
        });

    function calc() {
        const amount = parseFloat(document.getElementById('calcAmount').value) || 0;
        const from   = document.getElementById('calcFrom').value;
        const to     = document.getElementById('calcTo').value;
        if (!rates[from] || !rates[to]) return;
        const result = (amount / rates[from]) * rates[to];
        const fmt = n => new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(n);
        document.getElementById('calcResult').textContent = fmt(result) + ' ' + to;
        document.getElementById('calcResultSub').textContent = `${amount.toLocaleString('en-US')} ${from} → ${to}`;
        const unit = (1 / rates[from]) * rates[to];
        document.getElementById('rateInfo').textContent = `1 ${from} = ${fmt(unit)} ${to}`;
    }

    document.getElementById('calcAmount').addEventListener('input', calc);
    document.getElementById('calcFrom').addEventListener('change', calc);
    document.getElementById('calcTo').addEventListener('change', calc);

    /* Swap button */
    document.getElementById('swapBtn').addEventListener('click', () => {
        const f = document.getElementById('calcFrom');
        const t = document.getElementById('calcTo');
        [f.value, t.value] = [t.value, f.value];
        calc();
    });

    /* ── Select2 untuk dropdown negara ── */
    let waitForJQ = setInterval(function () {
        if (typeof window.jQuery !== 'undefined') {
            clearInterval(waitForJQ);
            const $ = window.jQuery;
            if ($.fn.select2) {
                $('.select2-currency').select2({
                    width: '100%',
                    theme: 'bootstrap-5'
                });
                $('.select2-currency').on('change', function () {
                    $('#monitor-form').submit();
                });
            }
        }
    }, 100);
});
</script>
@endsection