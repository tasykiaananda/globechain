<!-- BLOK 1: PROFIL NEGARA (COMPACT BANNER) -->
<div class="card-corporate p-2 mb-2 flex-shrink-0" style="border-left: 4px solid var(--navy-accent); background: linear-gradient(135deg, #ffffff 0%, var(--cream-50) 100%); box-shadow: 0 2px 12px rgba(10,22,40,0.06);">
    <div class="row align-items-center">
        <!-- Sisi Kiri: Identitas -->
        <div class="col-md-6 d-flex align-items-center gap-3">
            @if(isset($country['flag']['url_png']))
                <img src="{{ $country['flag']['url_png'] }}" width="70" class="rounded shadow-sm" alt="Flag" style="border: 2px solid var(--cream-300);">
            @else
                <div class="rounded d-flex justify-content-center align-items-center" style="width: 70px; height: 46px; background: var(--cream-200); border: 1px solid var(--cream-300);">
                    <i class="fa-solid fa-flag" style="color: var(--navy-accent);"></i>
                </div>
            @endif
            <div>
                <h4 class="fw-bold mb-1" style="letter-spacing: -0.5px; color: var(--navy-800);">{{ $country['names']['common'] ?? 'N/A' }}</h4>
                <div class="d-flex gap-2">
                    <span class="badge border" style="background: var(--cream-100); color: var(--navy-600); border-color: var(--cream-300) !important; font-weight: 600;"><i class="fa-solid fa-building-columns me-1"></i> {{ $country['capitals'][0]['name'] ?? ($country['capitals'][0] ?? 'N/A') }}</span>
                    <span class="badge border" style="background: var(--cream-100); color: var(--navy-600); border-color: var(--cream-300) !important; font-weight: 600;"><i class="fa-solid fa-earth-americas me-1"></i> {{ $country['region'] ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
        
        <!-- Sisi Kanan: Demografi Ringkas & TOMBOL MODAL -->
        <div class="col-md-6 d-flex justify-content-end align-items-center gap-4 text-end">
            <div>
                <p class="mb-0" style="font-size: 0.70rem; text-transform: uppercase; font-weight: 700; color: var(--corporate-gray);">Populasi</p>
                <h6 class="fw-bold mb-0" style="color: var(--navy-800);">{{ isset($country['population']) ? number_format($country['population']) : '--' }}</h6>
            </div>
            <div>
                <p class="mb-0" style="font-size: 0.70rem; text-transform: uppercase; font-weight: 700; color: var(--corporate-gray);">Mata Uang</p>
                <h6 class="fw-bold mb-0" style="color: var(--navy-800);">{{ $country['currencies'][0]['code'] ?? '--' }}</h6>
            </div>
            <div>
                <p class="mb-0" style="font-size: 0.70rem; text-transform: uppercase; font-weight: 700; color: var(--corporate-gray);">Kode Negara</p>
                <h6 class="fw-bold mb-0" style="color: var(--navy-800);">{{ $country['codes']['alpha_2'] ?? '--' }}</h6>
            </div>
            
            <!-- Tombol untuk memicu Modal -->
            <div class="border-start ps-3 ms-2" style="border-color: var(--cream-300) !important;">
                <button type="button" class="btn btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#countryDetailModal"
                    style="background: linear-gradient(135deg, var(--navy-700), var(--navy-accent)); color: #fff; border: none; font-size: 0.78rem; font-weight: 600;">
                    <i class="fa-solid fa-list-ul me-1"></i> Detail
                </button>
            </div>
        </div>
    </div>
</div>