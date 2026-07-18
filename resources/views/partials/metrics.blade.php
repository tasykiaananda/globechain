<!-- BLOK 2: CORE INTELLIGENCE METRICS (4 PILAR + FAVORIT) -->
<style>
    .fv-col{background:linear-gradient(145deg,#0f2044,#162240);border:1px solid rgba(79,125,219,.18);border-radius:12px;padding:10px;height:100%;display:flex;flex-direction:column}
    .fv-hdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:6px}
    .fv-ttl{font-size:.6rem;font-weight:800;text-transform:uppercase;letter-spacing:.8px;color:#8fadd4;display:flex;align-items:center;gap:4px}
    .fv-ttl i{color:#fbbf24;font-size:.55rem}
    .fv-lnk{font-size:.52rem;color:#4f7ddb;text-decoration:none;font-weight:700}.fv-lnk:hover{color:#7ba7ff}
    .fv-list{flex:1;overflow-y:auto;max-height:80px;scrollbar-width:thin;scrollbar-color:rgba(79,125,219,.2) transparent}
    .fv-list::-webkit-scrollbar{width:3px}.fv-list::-webkit-scrollbar-thumb{background:rgba(79,125,219,.25);border-radius:3px}
    .fv-item{display:flex;align-items:center;gap:6px;padding:4px 6px;border-radius:6px;cursor:pointer;transition:all .15s;text-decoration:none;margin-bottom:2px}
    .fv-item:hover{background:rgba(79,125,219,.1)}
    .fv-dot{width:6px;height:6px;border-radius:50%;flex-shrink:0}
    .fv-dot.low{background:#34d399}.fv-dot.med{background:#fbbf24}.fv-dot.high{background:#f87171}.fv-dot.ld{background:#4f7ddb;animation:fvP 1s infinite}
    @keyframes fvP{0%,100%{opacity:.3}50%{opacity:1}}
    .fv-nm{font-size:.68rem;font-weight:700;color:#dce8f8;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;flex:1}
    .fv-rk{font-size:.52rem;font-weight:700;padding:1px 5px;border-radius:3px;white-space:nowrap}
    .fv-rk.low{background:rgba(52,211,153,.12);color:#34d399}.fv-rk.med{background:rgba(251,191,36,.12);color:#fbbf24}.fv-rk.high{background:rgba(248,113,113,.12);color:#f87171}
    .fv-empty{text-align:center;color:#8fadd4;font-size:.6rem;padding:8px 0}
</style>
<div class="row g-2 mb-2 flex-shrink-0">
    <!-- Peta Risiko (Scoring Engine) -->
    <div style="flex:0 0 20%;max-width:20%">
        <div class="card-corporate p-3 h-100" style="background-color: {{ $riskData['bg'] ?? 'var(--matcha-50)' }}; border: 1px solid {{ $riskData['border'] ?? 'var(--matcha-500)' }};">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-uppercase fw-bold text-dark" style="font-size: 0.70rem;">Total Risk Score</span>
                <i class="fa-solid fa-shield-halved text-{{ $riskData['color'] ?? 'success' }} fs-6"></i>
            </div>
            <h3 class="fw-bold text-dark mb-0">
                {{ $riskData['score'] ?? '0' }} 
                <span class="fs-6 text-muted fw-normal">/ {{ $riskData['status'] ?? 'N/A' }}</span>
            </h3>
            <p class="mt-1 mb-0 text-{{ $riskData['color'] ?? 'success' }}" style="font-size: 0.75rem; font-weight: 600;">
                <i class="fa-solid {{ $riskData['icon'] ?? 'fa-check-circle' }} me-1"></i> {{ $riskData['text'] ?? '--' }}
            </p>
        </div>
    </div>

    <!-- Ekonomi (World Bank) -->
    <div style="flex:0 0 20%;max-width:20%">
        <div class="card-corporate p-3 h-100" style="background: white;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-uppercase text-muted fw-bold" style="font-size: 0.70rem;">Economy (World Bank)</span>
                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 rounded-pill" data-bs-toggle="modal" data-bs-target="#economyDetailModal" style="font-size: 0.7rem;">
                    <i class="fa-solid fa-expand"></i> Detail
                </button>
            </div>
            <h3 class="fw-bold text-dark mb-0">
                {{ $economy['inflation'] ?? '--' }}<span style="font-size: 1rem;">%</span> 
                <span class="fs-6 text-muted fw-normal">Inflasi</span>
            </h3>
            <p class="text-muted mt-1 mb-0" style="font-size: 0.75rem;">
                <i class="fa-solid fa-sack-dollar me-1"></i> GDP: {{ $economy['gdp'] ?? '--' }}
            </p>
        </div>
    </div>

    <!-- Cuaca (Open-Meteo) -->
    <div style="flex:0 0 20%;max-width:20%">
        <div class="card-corporate p-3 h-100" style="background: white;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-uppercase text-muted fw-bold" style="font-size: 0.70rem;">Weather (Open-Meteo)</span>
                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 rounded-pill" data-bs-toggle="modal" data-bs-target="#weatherDetailModal" style="font-size: 0.7rem;">
                    <i class="fa-solid fa-expand"></i> Detail
                </button>
            </div>
            <h3 class="fw-bold text-dark mb-0">
                {{ isset($weather['current']['temperature_2m']) ? $weather['current']['temperature_2m'] : '--' }}<span style="font-size: 1rem;">°C</span>
            </h3>
            <p class="text-muted mt-1 mb-0" style="font-size: 0.75rem;">
                <i class="fa-solid fa-wind me-1"></i> Angin: {{ isset($weather['current']['wind_speed_10m']) ? $weather['current']['wind_speed_10m'] . ' km/h' : '--' }}
            </p>
        </div>
    </div>

    <!-- Kurs (ExchangeRate) -->
    <div style="flex:0 0 20%;max-width:20%">
        <div class="card-corporate p-3 h-100" style="background: white;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="text-uppercase text-muted fw-bold" style="font-size: 0.70rem;">Currency Impact</span>
                <i class="fa-solid fa-coins text-secondary fs-6"></i>
            </div>
            <h3 class="fw-bold text-dark mb-0">
                {{ $exchangeRate ?? '--' }}
            </h3>
            <p class="text-muted mt-1 mb-0" style="font-size: 0.75rem;">
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
                <div class="fv-empty"><i class="fa-regular fa-star" style="display:block;font-size:1rem;margin-bottom:4px;color:rgba(251,191,36,.2)"></i>Belum ada favorit</div>
            </div>
        </div>
    </div>
</div>