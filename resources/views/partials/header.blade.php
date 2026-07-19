<!-- KUMPULAN CSS UNTUK ANIMASI & INTERAKSI -->
<style>
    /* Efek Kapsul Pencarian */
    .search-capsule {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #ffffff;
        border: 1px solid var(--cream-300);
        box-shadow: 0 2px 8px rgba(10,22,40,0.04);
    }
    
    .search-capsule:hover, .search-capsule:focus-within {
        border-color: var(--navy-accent);
        box-shadow: 0 6px 20px rgba(79,125,219,0.12);
        transform: translateY(-2px);
    }

    /* Efek Tombol Monitor */
    .btn-monitor {
        transition: all 0.2s ease-in-out;
        color: #ffffff !important;
        background: linear-gradient(135deg, var(--navy-600), var(--navy-accent)) !important;
    }
    .btn-monitor:hover {
        filter: brightness(1.1);
        color: #ffffff !important;
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(79,125,219,0.3);
    }
    .btn-monitor:active {
        transform: scale(0.95);
    }

    /* Animasi denyut untuk indikator server */
    .pulse-dot {
        animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(52,211,153,0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 4px rgba(52,211,153,0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(52,211,153,0); }
    }

    /* Dashboard title */
    .dash-title {
        color: var(--navy-800);
        letter-spacing: -0.5px;
    }
    .dash-subtitle {
        color: var(--corporate-gray);
        font-size: 0.85rem;
    }

    /* Status badge */
    .status-badge-pill {
        background: rgba(52,211,153,0.08);
        border: 1px solid rgba(52,211,153,0.15);
        font-size: 0.65rem;
    }
    .status-badge-pill span {
        color: var(--accent-emerald);
    }
</style>

<!-- HEADER & FORM PENCARIAN -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-2 flex-shrink-0 gap-2" style="animation: fadeInDown 0.5s ease-out;">
    
    <!-- Judul & Sub-judul -->
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h4 class="mb-0 fw-bold dash-title">Global Country Dashboard</h4>
            
            <!-- Badge Status & Live Clock -->
            <div class="d-flex align-items-center status-badge-pill rounded-pill px-2 py-1 gap-2 shadow-sm">
                <span class="d-flex align-items-center fw-bold">
                    <span class="rounded-circle me-1 pulse-dot" style="width: 6px; height: 6px; background: var(--accent-emerald);"></span>
                    Node 10
                </span>
                <span style="color:var(--accent-emerald);opacity:.25">|</span>
                <span class="fw-bold" id="live-clock" style="color:var(--accent-emerald);">
                    <i class="fa-regular fa-clock me-1"></i> 00:00:00
                </span>
            </div>
        </div>
        <p class="dash-subtitle mb-0"><i class="fa-solid fa-satellite-dish me-1"></i>Pusat komando pemantauan risiko rantai pasok global.</p>
    </div>

    <!-- Form Pencarian (Interactive Capsule) -->
    <div class="d-flex align-items-center">
        <form id="monitor-form" action="{{ route('country.search') }}" method="POST" class="search-capsule d-flex align-items-center p-1 rounded-pill" style="width: 360px;">
            @csrf
            
            <div class="ps-3 pe-2 text-muted flex-shrink-0">
                <i class="fa-solid fa-earth-americas" style="font-size: 0.9rem; color: var(--navy-accent);"></i>
            </div>

            <div class="flex-grow-1 px-1" style="min-width: 0;">
                <select name="country" class="form-select select2-country border-0 bg-transparent shadow-none p-0" style="width: 100%; cursor: pointer; font-size: 0.85rem; font-weight: 600; color: var(--navy-800);">
                    @php
                        $selected = request('country', isset($country) ? ($country['names']['common'] ?? 'Indonesia') : 'Indonesia');
                        $list = $countriesList ?? []; 
                    @endphp
                    
                    @forelse($list as $c)
                        <option value="{{ $c }}" {{ $selected == $c ? 'selected' : '' }}>
                            {{ $c }}
                        </option>
                    @empty
                        <option value="Indonesia">Indonesia</option>
                    @endforelse
                </select>
            </div>
            
            <!-- Tombol Search -->
            <button type="submit" id="btn-monitor" class="btn btn-monitor fw-bold d-flex align-items-center justify-content-center rounded-pill px-3 flex-shrink-0 border-0 shadow-sm" style="height: 34px;">
                <i class="fa-solid fa-magnifying-glass me-1" id="btn-icon" style="font-size: 0.75rem;"></i>
                <span id="btn-text" style="font-size: 0.75rem;">Monitor</span>
            </button>
        </form>
    </div>
</div>

<!-- ALERT ERROR MODERN -->
@if(session('error'))
    <div class="alert alert-danger mb-4 border-0 shadow-sm d-flex align-items-center py-2 px-3" style="background-color: #fef2f2; border-left: 4px solid #ef4444 !important; border-radius: 8px; color: #991b1b; animation: fadeIn 0.4s ease-out;">
        <i class="fa-solid fa-triangle-exclamation me-3 fs-5"></i>
        <div>
            <strong style="font-size: 0.85rem;">Peringatan Sistem:</strong> 
            <span style="font-size: 0.85rem;">{{ session('error') }}</span>
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.7rem;"></button>
    </div>
@endif

<!-- SCRIPT UNTUK INTERAKSI -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. LIVE CLOCK ENGINE
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            document.getElementById('live-clock').innerHTML = `<i class="fa-regular fa-clock me-1"></i> ${timeString}`;
        }
        setInterval(updateClock, 1000);
        updateClock(); 

        // 2. LOADING STATE BUTTON
        const form = document.getElementById('monitor-form');
        const btn = document.getElementById('btn-monitor');
        const btnText = document.getElementById('btn-text');
        const btnIcon = document.getElementById('btn-icon');

        form.addEventListener('submit', function() {
            btn.classList.add('disabled');
            btn.style.opacity = '0.8';
            btn.style.cursor = 'wait';
            
            btnIcon.className = 'spinner-border spinner-border-sm me-1';
            btnText.innerText = 'Analyzing...';
        });

    });
</script>