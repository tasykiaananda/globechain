<!-- BLOK 2: CORE INTELLIGENCE METRICS (4 PILAR + FAVORIT) -->
<style>
    /* ── METRIC CARDS DARK NAVY ── */
    .metric-card {
        border-radius: 12px;
        padding: 14px 16px;
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(10,22,40,0.12);
    }
    .metric-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        border-radius: 12px 12px 0 0;
    }
    .metric-card-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .metric-card-value {
        font-size: 1.6rem;
        font-weight: 800;
        line-height: 1.15;
        margin-bottom: 2px;
    }
    .metric-card-sub {
        font-size: 0.7rem;
        font-weight: 500;
    }

    /* Risk card special */
    .mc-risk {
        background: linear-gradient(145deg, var(--navy-700), var(--navy-800));
        border: 1px solid rgba(79,125,219,0.15);
        box-shadow: 0 2px 12px rgba(10,22,40,0.15);
    }
    .mc-risk::before { background: var(--navy-accent); }
    .mc-risk .metric-card-label { color: var(--sidebar-text); }
    .mc-risk .metric-card-value { color: #fff; }
    .mc-risk .metric-card-sub { color: var(--sidebar-text); }

    /* Standard metric cards */
    .mc-std {
        background: linear-gradient(145deg, #ffffff, var(--cream-50));
        border: 1px solid var(--cream-300);
        box-shadow: 0 2px 8px rgba(10,22,40,0.04);
    }
    .mc-std .metric-card-label { color: var(--corporate-gray); }
    .mc-std .metric-card-value { color: var(--navy-800); }
    .mc-std .metric-card-sub { color: var(--corporate-gray); }

    .mc-economy::before { background: linear-gradient(90deg, var(--accent-gold), #e8c170); }
    .mc-weather::before { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
    .mc-currency::before { background: linear-gradient(90deg, var(--accent-emerald), #6ee7b7); }

    /* Detail mini-button */
    .mc-detail-btn {
        font-size: 0.65rem;
        padding: 2px 10px;
        border-radius: 20px;
        font-weight: 600;
        border: 1px solid var(--cream-300);
        background: var(--cream-100);
        color: var(--navy-600);
        cursor: pointer;
        transition: all 0.15s;
    }
    .mc-detail-btn:hover {
        background: var(--navy-accent);
        color: #fff;
        border-color: var(--navy-accent);
    }

    /* ── FAVORITE COLUMN ── */
    .fv-col{background:linear-gradient(145deg, var(--navy-700), var(--navy-800));border:1px solid rgba(79,125,219,.12);border-radius:12px;padding:10px;height:100%;display:flex;flex-direction:column}
    .fv-col::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--accent-gold),#e8c170);border-radius:12px 12px 0 0}
    .fv-col{position:relative;overflow:hidden}
    .fv-hdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;margin-top:4px}
    .fv-ttl{font-size:.6rem;font-weight:800;text-transform:uppercase;letter-spacing:.8px;color:#8fadd4;display:flex;align-items:center;gap:4px}
    .fv-ttl i{color:var(--accent-gold);font-size:.55rem}
    .fv-lnk{font-size:.52rem;color:var(--navy-accent);text-decoration:none;font-weight:700}.fv-lnk:hover{color:#7ba7ff}
    .fv-list{flex:1;overflow-y:auto;max-height:80px;scrollbar-width:thin;scrollbar-color:rgba(79,125,219,.2) transparent}
    .fv-list::-webkit-scrollbar{width:3px}.fv-list::-webkit-scrollbar-thumb{background:rgba(79,125,219,.25);border-radius:3px}
    .fv-item{display:flex;align-items:center;gap:6px;padding:4px 6px;border-radius:6px;cursor:pointer;transition:all .15s;text-decoration:none;margin-bottom:2px}
    .fv-item:hover{background:rgba(79,125,219,.1)}
    .fv-dot{width:6px;height:6px;border-radius:50%;flex-shrink:0}
    .fv-dot.low{background:#34d399}.fv-dot.med{background:#fbbf24}.fv-dot.high{background:#f87171}.fv-dot.ld{background:var(--navy-accent);animation:fvP 1s infinite}
    @keyframes fvP{0%,100%{opacity:.3}50%{opacity:1}}
    .fv-nm{font-size:.68rem;font-weight:700;color:#dce8f8;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;flex:1}
    .fv-rk{font-size:.52rem;font-weight:700;padding:1px 5px;border-radius:3px;white-space:nowrap}
    .fv-rk.low{background:rgba(52,211,153,.12);color:#34d399}.fv-rk.med{background:rgba(251,191,36,.12);color:#fbbf24}.fv-rk.high{background:rgba(248,113,113,.12);color:#f87171}
    .fv-empty{text-align:center;color:#8fadd4;font-size:.6rem;padding:8px 0}
</style>
<div class="row g-2 mb-2 flex-shrink-0">
    <!-- Peta Risiko (Scoring Engine) -->
    <div style="flex:0 0 20%;max-width:20%">
        @php
            $riskCardColor = ($riskData['score'] ?? 0) >= 60 ? '#f87171' : (($riskData['score'] ?? 0) >= 35 ? '#fbbf24' : '#34d399');
        @endphp
        <div class="metric-card mc-risk">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="metric-card-label">Total Risk Score</span>
                <i class="fa-solid fa-shield-halved fs-6" style="color: {{ $riskCardColor }};"></i>
            </div>
            <div class="metric-card-value" style="color: {{ $riskCardColor }};">
                {{ $riskData['score'] ?? '0' }} 
                <span style="font-size: 0.85rem; font-weight: 500; color: var(--sidebar-text);">/ {{ $riskData['status'] ?? 'N/A' }}</span>
            </div>
            <p class="mt-1 mb-0 metric-card-sub" style="color: {{ $riskCardColor }}; font-weight: 600;">
                <i class="fa-solid {{ $riskData['icon'] ?? 'fa-check-circle' }} me-1"></i> {{ $riskData['text'] ?? '--' }}
            </p>
        </div>
    </div>

    <!-- Ekonomi (World Bank) -->
    <div style="flex:0 0 20%;max-width:20%">
        <div class="metric-card mc-std mc-economy">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="metric-card-label">Economy (World Bank)</span>
                <button type="button" class="mc-detail-btn" data-bs-toggle="modal" data-bs-target="#economyDetailModal">
                    <i class="fa-solid fa-expand me-1"></i>Detail
                </button>
            </div>
            <div class="metric-card-value">
                {{ $economy['inflation'] ?? '--' }}<span style="font-size: 0.85rem;">%</span>
                <span style="font-size: 0.7rem; font-weight: 500; color: var(--corporate-gray);"> Inflasi</span>
            </div>
            <p class="mt-1 mb-0 metric-card-sub">
                <i class="fa-solid fa-sack-dollar me-1"></i> GDP: {{ $economy['gdp'] ?? '--' }}
            </p>
        </div>
    </div>

    <!-- Cuaca (Open-Meteo) -->
    <div style="flex:0 0 20%;max-width:20%">
        <div class="metric-card mc-std mc-weather">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="metric-card-label">Weather (Open-Meteo)</span>
                <button type="button" class="mc-detail-btn" data-bs-toggle="modal" data-bs-target="#weatherDetailModal">
                    <i class="fa-solid fa-expand me-1"></i>Detail
                </button>
            </div>
            <div class="metric-card-value">
                {{ isset($weather['current']['temperature_2m']) ? $weather['current']['temperature_2m'] : '--' }}<span style="font-size: 0.85rem;">°C</span>
            </div>
            <p class="mt-1 mb-0 metric-card-sub">
                <i class="fa-solid fa-wind me-1"></i> Angin: {{ isset($weather['current']['wind_speed_10m']) ? $weather['current']['wind_speed_10m'] . ' km/h' : '--' }}
            </p>
        </div>
    </div>

    <!-- Kurs (ExchangeRate) -->
    <div style="flex:0 0 20%;max-width:20%">
        <div class="metric-card mc-std mc-currency">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="metric-card-label">Currency Impact</span>
                <i class="fa-solid fa-coins" style="font-size: 0.9rem; color: var(--accent-emerald);"></i>
            </div>
            <div class="metric-card-value">
                {{ $exchangeRate ?? '--' }}
            </div>
            <p class="mt-1 mb-0 metric-card-sub">
                <i class="fa-solid fa-money-bill-transfer me-1"></i> {{ $country['currencies'][0]['code'] ?? 'N/A' }} thd 1 USD
            </p>
        </div>
    </div>

    <!-- Favorite Monitoring (5th column) -->
    <div style="flex:0 0 20%;max-width:20%">
        <div class="fv-col">
            <div class="fv-hdr">
                <span class="fv-ttl"><i class="fa-solid fa-star"></i>Favorit</span>
                <a href="{{ route('tools.favorites') }}" class="fv-lnk">Kelola <i class="fa-solid fa-arrow-right" style="font-size:.45rem"></i></a>
            </div>
            <div class="fv-list" id="fv-dash-list">
                <div class="fv-empty"><i class="fa-regular fa-star" style="display:block;font-size:1rem;margin-bottom:4px;color:rgba(212,168,83,.2)"></i>Belum ada favorit</div>
            </div>
        </div>
    </div>
</div>