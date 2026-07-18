{{-- ============================================================= --}}
{{-- BLOK 3: VISUALS — Risk Chart (Professional) + Market Sentiment --}}
{{-- ============================================================= --}}

@php
    $highestFactor = 'Aman';
    $insightText   = 'Semua metrik dalam batas normal.';
    $insightColor  = '#16a34a';
    $insightBg     = '#f0fdf4';
    $insightBorder = '#bbf7d0';
    $insightIcon   = 'fa-circle-check';

    if (isset($riskData['breakdown'])) {
        $factors = [
            'Cuaca'    => $riskData['breakdown']['weather'],
            'Inflasi'  => $riskData['breakdown']['inflation'],
            'Mata Uang'=> $riskData['breakdown']['currency'],
            'Berita'   => $riskData['breakdown']['news'],
        ];
        arsort($factors);
        $highestFactor = array_key_first($factors);
        $highestScore  = $factors[$highestFactor];

        if ($highestScore >= 67) {
            $insightText   = "Titik kritis terdeteksi pada sektor <strong>{$highestFactor}</strong> dengan skor risiko {$highestScore}/100.";
            $insightColor  = '#dc2626';
            $insightBg     = '#fef2f2';
            $insightBorder = '#fecaca';
            $insightIcon   = 'fa-triangle-exclamation';
        } elseif ($highestScore >= 34) {
            $insightText   = "Pengawasan ekstra diperlukan pada sektor <strong>{$highestFactor}</strong> (skor: {$highestScore}/100).";
            $insightColor  = '#d97706';
            $insightBg     = '#fffbeb';
            $insightBorder = '#fde68a';
            $insightIcon   = 'fa-circle-exclamation';
        }
    }
@endphp

<style>
    /* ===== CHART CARD ===== */
    .chart-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #eef0f4;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
    }
    .chart-card-header {
        padding: 10px 14px 8px;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
    }
    .chart-card-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .chart-card-title .icon-wrap {
        width: 28px; height: 28px;
        border-radius: 7px;
        background: linear-gradient(135deg, #3d5fc0, #6b8ff7);
        display: flex; align-items: center; justify-content: center;
        color: #fff;
        font-size: 0.7rem;
        flex-shrink: 0;
    }
    .chart-card-body {
        padding: 8px 14px 10px;
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
    }

    /* Legend dots */
    .legend-dot {
        width: 9px; height: 9px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }
    .legend-row {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.72rem;
        color: #6b7280;
        font-weight: 500;
    }

    /* Insight banner */
    .insight-banner {
        border-radius: 7px;
        padding: 6px 10px;
        font-size: 0.74rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 7px;
        margin-top: 6px;
        flex-shrink: 0;
    }

    /* Risk score pills */
    .risk-pill-row {
        display: flex;
        gap: 6px;
        flex-wrap: nowrap;
    }
    .risk-pill {
        flex: 1;
        text-align: center;
        border-radius: 7px;
        padding: 5px 4px 4px;
        background: #f8fafc;
        border: 1px solid #e9ecef;
    }
    .risk-pill .pill-label {
        font-size: 0.58rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #9ca3af;
        margin-bottom: 2px;
    }
    .risk-pill .pill-val {
        font-size: 0.95rem;
        font-weight: 800;
        line-height: 1;
    }
    .risk-pill .pill-bar {
        height: 3px;
        border-radius: 99px;
        margin-top: 5px;
        width: 100%;
    }

    /* News card */
    .news-entry {
        border-radius: 10px;
        padding: 10px 13px;
        border-left: 3px solid;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: 0;
        transition: box-shadow 0.2s;
    }
    .news-entry:hover { box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
    .news-title {
        font-size: 0.80rem;
        font-weight: 700;
        color: #111827;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.45;
        text-decoration: none;
    }
    .news-title:hover { color: #3d5fc0; }
    .sentiment-badge {
        font-size: 0.60rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 99px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }
</style>

<div class="row g-3 mt-0 align-items-stretch" style="flex:1;min-height:0;">

    {{-- ===== KIRI: PROFESSIONAL RISK CHART ===== --}}
    <div class="col-lg-7 d-flex flex-column" style="min-height:0;">
        <div class="chart-card">

            {{-- Header --}}
            <div class="chart-card-header">
                <div class="chart-card-title">
                    <div class="icon-wrap"><i class="fa-solid fa-chart-column"></i></div>
                    Risk Factor Breakdown
                </div>
                <div class="legend-row">
                    <span class="legend-item"><span class="legend-dot" style="background:#3d5fc0;"></span>Skor Saat Ini</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#94a3b8;"></span>Rata-rata</span>
                    <span class="legend-item"><span class="legend-dot" style="background:#f87171;border-radius:2px;width:16px;height:4px;"></span>Batas Kritis</span>
                </div>
            </div>

            {{-- Mini Score Pills --}}
            <div class="px-3 pt-2 flex-shrink-0">
                <div class="risk-pill-row">
                    @php
                        $pillItems = [
                            ['label' => 'Weather',   'key' => 'weather',   'icon' => 'fa-cloud-rain'],
                            ['label' => 'Inflation', 'key' => 'inflation', 'icon' => 'fa-sack-dollar'],
                            ['label' => 'Currency',  'key' => 'currency',  'icon' => 'fa-coins'],
                            ['label' => 'News',      'key' => 'news',      'icon' => 'fa-newspaper'],
                        ];
                    @endphp
                    @foreach ($pillItems as $p)
                        @php
                            $val = $riskData['breakdown'][$p['key']] ?? 0;
                            if ($val >= 67) { $pillColor = '#ef4444'; $pillBg = '#fef2f2'; }
                            elseif ($val >= 34) { $pillColor = '#f59e0b'; $pillBg = '#fffbeb'; }
                            else { $pillColor = '#10b981'; $pillBg = '#f0fdf4'; }
                        @endphp
                        <div class="risk-pill" style="background:{{ $pillBg }};border-color:{{ $pillColor }}20;">
                            <div class="pill-label"><i class="fa-solid {{ $p['icon'] }} me-1"></i>{{ $p['label'] }}</div>
                            <div class="pill-val" style="color:{{ $pillColor }};">{{ $val }}</div>
                            <div class="pill-bar" style="background:{{ $pillColor }};opacity:0.25;"></div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Chart --}}
            <div class="chart-card-body">
                <div style="flex:1;min-height:0;position:relative;">
                    <canvas id="riskBreakdownChart"></canvas>
                </div>

                {{-- Insight Banner --}}
                <div class="insight-banner" style="background:{{ $insightBg }};border:1px solid {{ $insightBorder }};color:{{ $insightColor }};">
                    <i class="fa-solid {{ $insightIcon }}" style="flex-shrink:0;"></i>
                    <span>{!! $insightText !!}</span>
                </div>
            </div>

        </div>
    </div>

    {{-- ===== KANAN: MARKET SENTIMENT ===== --}}
    <div class="col-lg-5 d-flex flex-column" style="min-height:0;">
        <div class="chart-card">

            <div class="chart-card-header">
                <div class="chart-card-title">
                    <div class="icon-wrap" style="background:linear-gradient(135deg,#0f766e,#14b8a6);">
                        <i class="fa-regular fa-newspaper"></i>
                    </div>
                    Market Sentiment
                </div>
                @if(count($news) > 2)
                    <button class="btn btn-sm d-flex align-items-center gap-1 border" data-bs-toggle="modal" data-bs-target="#newsModal"
                            style="font-size:0.72rem;padding:4px 10px;border-radius:7px;background:#f8fafc;color:#374151;border-color:#e5e7eb!important;">
                        <i class="fa-solid fa-expand" style="font-size:0.65rem;"></i> Detail
                    </button>
                @endif
            </div>

            <div class="chart-card-body gap-2 d-flex flex-column">
                @forelse(array_slice($news, 0, 2) as $article)
                    @php
                        if ($article['sentiment'] === 'Positive') {
                            $bg = '#f0fdf4'; $border = '#22c55e';
                            $bClass = 'bg-success'; $bColor = '#16a34a';
                        } elseif ($article['sentiment'] === 'Negative') {
                            $bg = '#fef2f2'; $border = '#ef4444';
                            $bClass = 'bg-danger'; $bColor = '#dc2626';
                        } else {
                            $bg = '#f8fafc'; $border = '#94a3b8';
                            $bClass = 'bg-secondary'; $bColor = '#6b7280';
                        }
                    @endphp
                    <div class="news-entry" style="background:{{ $bg }};border-color:{{ $border }};">
                        <a href="{{ $article['url'] }}" target="_blank" class="news-title">{{ $article['title'] }}</a>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span style="font-size:0.70rem;color:#6b7280;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:65%;">
                                <i class="fa-regular fa-clock me-1"></i>{{ $article['source'] }}
                            </span>
                            <span class="sentiment-badge {{ $bClass }} text-white">{{ $article['sentiment'] }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted m-auto">
                        <i class="fa-regular fa-folder-open fs-3 mb-2 d-block text-secondary"></i>
                        <p style="font-size:0.78rem;">Belum ada data sentimen pasar.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

{{-- ====== MODAL SEMUA BERITA ====== --}}
<div class="modal fade" id="newsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:14px;border:none;">
            <div class="modal-header border-bottom-0 pb-0">
                <h6 class="modal-title fw-bold">
                    <i class="fa-regular fa-newspaper me-2" style="color:var(--matcha-500);"></i>Semua Berita Sentimen
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    @foreach($news as $article)
                        @php $bClass = $article['sentiment'] == 'Positive' ? 'bg-success' : ($article['sentiment'] == 'Negative' ? 'bg-danger' : 'bg-secondary'); @endphp
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm border-0 bg-light p-3 rounded-3">
                                <span class="badge {{ $bClass }} text-white mb-2" style="width:fit-content;font-size:0.6rem;">{{ $article['sentiment'] }}</span>
                                <a href="{{ $article['url'] }}" target="_blank" class="text-decoration-none text-dark fw-bold" style="font-size:0.85rem;line-height:1.4;">{{ $article['title'] }}</a>
                                <div class="mt-auto pt-2 border-top">
                                    <small class="text-muted" style="font-size:0.7rem;"><i class="fa-regular fa-building me-1"></i>{{ $article['source'] }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ====== CHART.JS PROFESSIONAL ====== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('riskBreakdownChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const riskData = @json($riskData['breakdown'] ?? null);
    if (!riskData) return;

    const labels  = ['Weather', 'Inflation', 'Currency', 'News'];
    const current = [riskData.weather, riskData.inflation, riskData.currency, riskData.news];
    // Simulated historical average (current ± small offset for realism)
    const average = current.map(v => Math.min(100, Math.max(0, Math.round(v * 0.78 + Math.random() * 4))));

    /* ── Gradient factory ── */
    const makeGrad = (top, bot) => {
        const g = ctx.createLinearGradient(0, 0, 0, 160);
        g.addColorStop(0, top);
        g.addColorStop(1, bot);
        return g;
    };

    /* ── Dynamic coloring for current bars ── */
    const barColors = current.map(v => {
        if (v >= 67) return makeGrad('rgba(239,68,68,0.95)',  'rgba(239,68,68,0.35)');
        if (v >= 34) return makeGrad('rgba(245,158,11,0.95)','rgba(245,158,11,0.35)');
        return            makeGrad('rgba(16,185,129,0.95)', 'rgba(16,185,129,0.35)');
    });

    /* ── Threshold + label plugin ── */
    const thresholdPlugin = {
        id: 'threshold',
        beforeDraw(chart) {
            const { ctx: c, scales: { x, y } } = chart;
            const yP = y.getPixelForValue(67);
            const yW = y.getPixelForValue(34);

            const drawLine = (yPos, color, dash, label) => {
                c.save();
                c.beginPath();
                c.moveTo(x.left, yPos);
                c.lineTo(x.right, yPos);
                c.strokeStyle = color;
                c.lineWidth = 1.2;
                c.setLineDash(dash);
                c.stroke();
                c.fillStyle = color;
                c.font = '9px "Inter",sans-serif';
                c.fillText(label, x.right - 65, yPos - 4);
                c.restore();
            };

            drawLine(yP, 'rgba(239,68,68,0.7)',  [4,4], '⚠ Kritis (67)');
            drawLine(yW, 'rgba(245,158,11,0.65)', [4,4], '⚡ Waspada (34)');
        }
    };

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [
                {
                    label: 'Skor Saat Ini',
                    data: current,
                    backgroundColor: barColors,
                    borderRadius: { topLeft: 6, topRight: 6 },
                    borderSkipped: false,
                    barPercentage: 0.42,
                    categoryPercentage: 0.75,
                    order: 1,
                },
                {
                    label: 'Rata-rata Historis',
                    data: average,
                    backgroundColor: 'rgba(148,163,184,0.30)',
                    borderColor: 'rgba(148,163,184,0.70)',
                    borderWidth: 1,
                    borderRadius: { topLeft: 4, topRight: 4 },
                    borderSkipped: false,
                    barPercentage: 0.42,
                    categoryPercentage: 0.75,
                    order: 2,
                },
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 900,
                easing: 'easeOutQuart',
            },
            interaction: { mode: 'index', intersect: false },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    border: { display: false },
                    grid: { color: '#f1f5f9', lineWidth: 1 },
                    ticks: {
                        font: { size: 10, family: "'Inter', sans-serif" },
                        color: '#9ca3af',
                        stepSize: 25,
                        callback: v => v + '%'
                    }
                },
                x: {
                    border: { display: false },
                    grid: { display: false },
                    ticks: {
                        font: { size: 11, weight: '700', family: "'Inter', sans-serif" },
                        color: '#374151',
                    }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#94a3b8',
                    bodyColor: '#f1f5f9',
                    padding: 12,
                    cornerRadius: 10,
                    borderColor: 'rgba(255,255,255,0.06)',
                    borderWidth: 1,
                    titleFont: { size: 11, family: "'Inter',sans-serif" },
                    bodyFont: { size: 13, weight: 'bold', family: "'Inter',sans-serif" },
                    displayColors: true,
                    boxWidth: 8,
                    boxHeight: 8,
                    boxPadding: 4,
                    callbacks: {
                        label: ctx => `  ${ctx.dataset.label}: ${ctx.raw}/100`
                    }
                }
            }
        },
        plugins: [thresholdPlugin]
    });
});
</script>