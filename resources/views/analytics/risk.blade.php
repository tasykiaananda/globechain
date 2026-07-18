@extends('layouts.app')
@section('content')
<style>
    .main-content { overflow-y: auto !important; height: 100vh !important; }
    .content-inner { overflow: visible !important; height: auto !important; }

    :root {
        --rk-navy:   #0b1628;
        --rk-card:   #1a2d4e;
        --rk-card2:  #162240;
        --rk-border: rgba(79,125,219,0.18);
        --rk-accent: #4f7ddb;
        --rk-text:   #dce8f8;
        --rk-muted:  #8fadd4;
        --rk-green:  #34d399;
        --rk-yellow: #fbbf24;
        --rk-red:    #f87171;
        --rk-purple: #a78bfa;
    }

    .rk-page { background: var(--rk-navy); min-height: 100%; padding-bottom: 2rem; }

    /* Header */
    .rk-header {
        background: linear-gradient(135deg, #0f2044, #0d1e3d);
        border-bottom: 1px solid var(--rk-border);
        padding: 1rem 1.5rem;
        display: flex; justify-content: space-between; align-items: center;
        flex-wrap: wrap; gap: .75rem;
        margin: -1.25rem -1.5rem 1.5rem;
    }
    .rk-title { font-size: 1.05rem; font-weight: 700; color: #fff; letter-spacing: -.4px; }
    .rk-subtitle { font-size: .78rem; color: var(--rk-muted); margin-top: 2px; }

    .live-badge {
        display:flex; align-items:center; gap:.5rem;
        background: rgba(52,211,153,.12);
        border: 1px solid rgba(52,211,153,.25);
        border-radius: 999px; padding: 4px 12px;
        font-size: .68rem; font-weight: 600; color: var(--rk-green);
    }
    .pulse-dot { width:6px; height:6px; border-radius:50%; background:var(--rk-green); animation: pulse 1.5s infinite; }
    @keyframes pulse {
        0%  { box-shadow: 0 0 0 0 rgba(52,211,153,.7); }
        70% { box-shadow: 0 0 0 5px rgba(52,211,153,0); }
        100%{ box-shadow: 0 0 0 0 rgba(52,211,153,0); }
    }

    /* Standalone Search Row */
    .rk-search-row { margin-bottom: 1.25rem; }
    .rk-search-form {
        display: inline-flex; align-items: center; gap: 10px;
        background: linear-gradient(145deg, #1a2d4e, #162240);
        border: 1px solid var(--rk-border);
        border-radius: 999px;
        padding: 7px 7px 7px 18px;
        min-width: 380px;
        transition: all .3s ease;
    }
    .rk-search-form:focus-within {
        border-color: var(--rk-accent);
        box-shadow: 0 0 0 3px rgba(79,125,219,.2);
    }
    .rks-icon { color: var(--rk-accent); font-size: .9rem; flex-shrink: 0; }
    .rks-select {
        background: transparent; border: none; outline: none;
        color: var(--rk-text); font-size: .88rem; font-weight: 600;
        flex: 1; cursor: pointer; min-width: 200px;
    }
    .rks-select option { background: #1e2d4a; color: #fff; }
    .btn-analyze {
        background: linear-gradient(135deg, var(--rk-accent), #3d5fc0);
        border: none; border-radius: 999px; color: #fff; font-size: .75rem; font-weight: 600;
        padding: 7px 16px; cursor: pointer; transition: all .2s ease;
    }
    .btn-analyze:hover { filter: brightness(1.15); transform: scale(1.04); }

    /* Cards */
    .rk-card {
        background: linear-gradient(145deg, #1a2d4e, #162240);
        border: 1px solid var(--rk-border);
        border-radius: 16px; padding: 1.4rem;
        position: relative; overflow: hidden;
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .rk-card::before {
        content:''; position:absolute; inset:0; border-radius:16px;
        background: linear-gradient(135deg, rgba(79,125,219,.06) 0%, transparent 60%);
        pointer-events:none;
    }
    .rk-card:hover { transform:translateY(-3px); box-shadow:0 16px 40px rgba(0,0,0,.4), 0 0 0 1px rgba(79,125,219,.25); }

    /* Score card override */
    .score-card-low    { border-left:4px solid var(--rk-green) !important; }
    .score-card-medium { border-left:4px solid var(--rk-yellow) !important; }
    .score-card-high   { border-left:4px solid var(--rk-red) !important; }

    /* Breakdown cells */
    .bd-cell {
        background: rgba(255,255,255,.04);
        border: 1px solid var(--rk-border);
        border-radius: 12px; padding: 1rem;
    }
    .bd-cell .bd-weight {
        font-size:.62rem; font-weight:700; letter-spacing:1px;
        text-transform:uppercase; border-radius:6px; padding:2px 8px; display:inline-block;
    }
    .bd-cell .bd-title { font-size:.83rem; font-weight:700; color:var(--rk-text); margin:8px 0 4px; }
    .bd-cell .bd-score-row { display:flex; justify-content:space-between; align-items:baseline; margin-bottom:6px; }
    .bd-cell .bd-val  { font-size:1.3rem; font-weight:800; }
    .bd-cell .bd-max  { font-size:.7rem; color:var(--rk-muted); }
    .bd-cell .bd-bar  { height:5px; border-radius:3px; background: rgba(255,255,255,.08); overflow:hidden; }
    .bd-cell .bd-fill { height:100%; border-radius:3px; transition: width 1s ease; }

    /* Formula box */
    .formula-box {
        background: rgba(79,125,219,.08);
        border: 1px solid rgba(79,125,219,.2);
        border-radius: 10px; padding: 10px 14px; margin-top: 1rem;
    }
    .formula-box .fl { font-size:.62rem; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; color:var(--rk-muted); margin-bottom:4px; }
    .formula-box code { font-size:.75rem; color: var(--rk-accent2, #7ba7ff); font-weight:600; }

    .section-label {
        font-size:.62rem; font-weight:700; letter-spacing:1.4px; text-transform:uppercase;
        color:var(--rk-muted); margin: 1.25rem 0 .75rem;
        display:flex; align-items:center; gap:8px;
    }
    .section-label::after { content:''; flex:1; height:1px; background:var(--rk-border); }
</style>

<div class="rk-page">

    {{-- HEADER --}}
    <div class="rk-header">
        <div>
            <div class="rk-title">
                <i class="fa-solid fa-microchip me-2" style="color:var(--rk-accent);"></i>Risk Scoring Engine
            </div>
            <div class="rk-subtitle">
                <i class="fa-solid fa-location-dot me-1"></i>
                Weighted Risk Model &mdash; <strong style="color:#7ba7ff;">{{ $targetCountry }}</strong>
            </div>
        </div>
        <div class="live-badge">
            <span class="pulse-dot"></span>
            Node 10 Active
            <span style="opacity:.3">|</span>
            <span id="live-clock"><i class="fa-regular fa-clock me-1"></i>00:00:00</span>
        </div>
    </div>

    {{-- ===== STANDALONE SEARCH BAR ===== --}}
    <div class="rk-search-row">
        <label style="font-size:.7rem;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--rk-muted);margin-bottom:.5rem;display:block;">Pilih Negara untuk Dianalisis</label>
        <form id="monitor-form" action="{{ route('analytics.risk') }}" method="GET" class="rk-search-form">
            <div class="rks-icon"><i class="fa-solid fa-earth-americas"></i></div>
            <select name="country" class="rks-select">
                @php $list = $countriesList ?? []; $sel = request('country', $targetCountry ?? 'Indonesia'); @endphp
                @forelse($list as $c)
                    <option value="{{ $c }}" {{ $sel==$c?'selected':'' }}>{{ $c }}</option>
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
    <div class="mb-4 p-3" style="background:#2d1515;border:1px solid rgba(248,113,113,.3);border-radius:8px;color:#f87171;font-size:.83rem;">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
    </div>
    @endif

    @if(isset($riskData))
    @php
        $score  = $riskData['score'];
        $status = $riskData['status'];
        $lvlClass = $score >= 60 ? 'score-card-high' : ($score >= 35 ? 'score-card-medium' : 'score-card-low');
        $lvlColor = $score >= 60 ? 'var(--rk-red)' : ($score >= 35 ? 'var(--rk-yellow)' : 'var(--rk-green)');
        $lvlIcon  = $score >= 60 ? 'fa-triangle-exclamation' : ($score >= 35 ? 'fa-circle-exclamation' : 'fa-circle-check');
        $bw = $riskData['breakdown']['weather'];
        $bn = $riskData['breakdown']['news'];
        $bi = $riskData['breakdown']['inflation'];
        $bc = $riskData['breakdown']['currency'];
    @endphp

    <div class="section-label">Risk Score Result</div>

    <div class="row g-4">
        {{-- LEFT col --}}
        <div class="col-lg-5 d-flex flex-column gap-4">

            {{-- Score card --}}
            <div class="rk-card {{ $lvlClass }}" style="padding-left:1.6rem;">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span style="font-size:.68rem;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:var(--rk-muted);">CALCULATED FINAL SCORE</span>
                    <i class="fa-solid fa-calculator" style="color:var(--rk-accent);"></i>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <div style="font-size:4.8rem;font-weight:900;line-height:1;letter-spacing:-3px;color:{{ $lvlColor }};">
                        {{ $score }}
                    </div>
                    <div>
                        <div style="font-size:1.05rem;font-weight:700;color:#fff;">{{ $status }} Risk</div>
                        <div style="font-size:.78rem;color:{{ $lvlColor }};margin-top:4px;">
                            <i class="fa-solid {{ $lvlIcon }} me-1"></i>{{ $riskData['text'] }}
                        </div>
                        <div style="margin-top:12px;height:6px;background:rgba(255,255,255,.08);border-radius:4px;overflow:hidden;width:140px;">
                            <div style="height:100%;width:{{ $score }}%;background:{{ $lvlColor }};border-radius:4px;transition:width 1.2s ease;"></div>
                        </div>
                        <div style="font-size:.65rem;color:var(--rk-muted);margin-top:3px;">Score / 100</div>
                    </div>
                </div>
            </div>

            {{-- Radar Chart --}}
            <div class="rk-card flex-grow-1">
                <div style="font-size:.83rem;font-weight:700;color:#fff;margin-bottom:.25rem;">
                    <i class="fa-solid fa-spider me-2" style="color:var(--rk-muted);"></i>Risk Dimension Radar
                </div>
                <div style="font-size:.72rem;color:var(--rk-muted);margin-bottom:1rem;">Distribusi skor per parameter risiko</div>
                <div style="position:relative;height:240px;">
                    <canvas id="riskRadarChart"></canvas>
                </div>
            </div>
        </div>

        {{-- RIGHT col --}}
        <div class="col-lg-7">
            <div class="rk-card h-100">
                <div style="font-size:.83rem;font-weight:700;color:#fff;margin-bottom:.25rem;">
                    <i class="fa-solid fa-gears me-2" style="color:var(--rk-muted);"></i>Weighted Scoring Breakdown
                </div>
                <div style="font-size:.72rem;color:var(--rk-muted);margin-bottom:1.2rem;">Detail kalkulasi per dimensi risiko secara <em>real-time</em>.</div>

                <div class="row g-3">
                    {{-- Weather --}}
                    <div class="col-6">
                        <div class="bd-cell">
                            <span class="bd-weight" style="background:rgba(79,125,219,.15);color:#7ba7ff;">BOBOT 30%</span>
                            <i class="fa-solid fa-cloud-bolt float-end" style="color:#7ba7ff;margin-top:-20px;"></i>
                            <div class="bd-title">Weather Risk</div>
                            <div class="bd-score-row">
                                <span class="bd-val" style="color:#7ba7ff;">{{ $bw }}</span>
                                <span class="bd-max">/ 100 pts</span>
                            </div>
                            <div class="bd-bar"><div class="bd-fill" style="width:{{ $bw }}%;background:#4f7ddb;"></div></div>
                            <div style="font-size:.65rem;color:var(--rk-muted);margin-top:5px;">Weighted: <strong style="color:#7ba7ff;">{{ round($bw*0.3,1) }}</strong> pts</div>
                        </div>
                    </div>
                    {{-- News --}}
                    <div class="col-6">
                        <div class="bd-cell">
                            <span class="bd-weight" style="background:rgba(248,113,113,.12);color:var(--rk-red);">BOBOT 40%</span>
                            <i class="fa-solid fa-newspaper float-end" style="color:var(--rk-red);margin-top:-20px;"></i>
                            <div class="bd-title">News Sentiment Risk</div>
                            <div class="bd-score-row">
                                <span class="bd-val" style="color:var(--rk-red);">{{ $bn }}</span>
                                <span class="bd-max">/ 100 pts</span>
                            </div>
                            <div class="bd-bar"><div class="bd-fill" style="width:{{ $bn }}%;background:var(--rk-red);"></div></div>
                            <div style="font-size:.65rem;color:var(--rk-muted);margin-top:5px;">Weighted: <strong style="color:var(--rk-red);">{{ round($bn*0.4,1) }}</strong> pts</div>
                        </div>
                    </div>
                    {{-- Inflation --}}
                    <div class="col-6">
                        <div class="bd-cell">
                            <span class="bd-weight" style="background:rgba(251,191,36,.12);color:var(--rk-yellow);">BOBOT 20%</span>
                            <i class="fa-solid fa-arrow-trend-up float-end" style="color:var(--rk-yellow);margin-top:-20px;"></i>
                            <div class="bd-title">Inflation Risk</div>
                            <div class="bd-score-row">
                                <span class="bd-val" style="color:var(--rk-yellow);">{{ $bi }}</span>
                                <span class="bd-max">/ 100 pts</span>
                            </div>
                            <div class="bd-bar"><div class="bd-fill" style="width:{{ $bi }}%;background:var(--rk-yellow);"></div></div>
                            <div style="font-size:.65rem;color:var(--rk-muted);margin-top:5px;">Weighted: <strong style="color:var(--rk-yellow);">{{ round($bi*0.2,1) }}</strong> pts</div>
                        </div>
                    </div>
                    {{-- Currency --}}
                    <div class="col-6">
                        <div class="bd-cell">
                            <span class="bd-weight" style="background:rgba(52,211,153,.12);color:var(--rk-green);">BOBOT 10%</span>
                            <i class="fa-solid fa-coins float-end" style="color:var(--rk-green);margin-top:-20px;"></i>
                            <div class="bd-title">Currency Volatility Risk</div>
                            <div class="bd-score-row">
                                <span class="bd-val" style="color:var(--rk-green);">{{ $bc }}</span>
                                <span class="bd-max">/ 100 pts</span>
                            </div>
                            <div class="bd-bar"><div class="bd-fill" style="width:{{ $bc }}%;background:var(--rk-green);"></div></div>
                            <div style="font-size:.65rem;color:var(--rk-muted);margin-top:5px;">Weighted: <strong style="color:var(--rk-green);">{{ round($bc*0.1,1) }}</strong> pts</div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Clock
    function tick() {
        const el = document.getElementById('live-clock');
        if (el) el.innerHTML = `<i class="fa-regular fa-clock me-1"></i>${new Date().toLocaleTimeString('id-ID')}`;
    }
    setInterval(tick, 1000); tick();

    // Submit button
    const form = document.getElementById('monitor-form');
    if (form) form.addEventListener('submit', function () {
        document.getElementById('btn-icon').className = 'spinner-border spinner-border-sm me-1';
        document.getElementById('btn-text').innerText = 'Memuat…';
        document.getElementById('btn-monitor').disabled = true;
    });

    @if(isset($riskData))
    // Radar Chart
    const ctx = document.getElementById('riskRadarChart');
    if (ctx) {
        const scores = [{{ $riskData['breakdown']['weather'] }}, {{ $riskData['breakdown']['news'] }}, {{ $riskData['breakdown']['inflation'] }}, {{ $riskData['breakdown']['currency'] }}];
        new Chart(ctx.getContext('2d'), {
            type: 'radar',
            data: {
                labels: ['Weather\n(30%)', 'News Sentiment\n(40%)', 'Inflation\n(20%)', 'Currency\n(10%)'],
                datasets: [{
                    label: 'Risk Score',
                    data: scores,
                    backgroundColor: 'rgba(79,125,219,0.18)',
                    borderColor: '#4f7ddb',
                    borderWidth: 2.5,
                    pointBackgroundColor: scores.map(v => v >= 60 ? '#f87171' : '#4f7ddb'),
                    pointBorderColor: '#0b1628',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                scales: {
                    r: {
                        min: 0, max: 100,
                        angleLines: { color: 'rgba(79,125,219,0.15)' },
                        grid:       { color: 'rgba(79,125,219,0.12)' },
                        pointLabels: { font: { family: 'Inter', size: 11, weight: '600' }, color: '#8fadd4' },
                        ticks: { display: false, stepSize: 20 },
                        backgroundColor: 'rgba(79,125,219,0.03)'
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        borderColor: 'rgba(79,125,219,0.4)',
                        borderWidth: 1,
                        padding: 11,
                        bodyFont: { size: 13, weight: '700', family: 'Inter' },
                        displayColors: false,
                        cornerRadius: 10,
                        callbacks: { label: c => c.raw + ' pts — ' + (c.raw >= 60 ? '⚠ High' : c.raw >= 35 ? '~ Medium' : '✓ Low') }
                    }
                },
                animation: { duration: 1000, easing: 'easeOutQuart' }
            }
        });
    }
    @endif
});
</script>
@endsection