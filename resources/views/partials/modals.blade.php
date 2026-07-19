<!-- MODAL DETAIL LENGKAP NEGARA -->
<div class="modal fade" id="countryDetailModal" tabindex="-1" aria-labelledby="countryDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; box-shadow: 0 20px 60px rgba(10,22,40,0.2) !important;">
            <div class="modal-header border-bottom-0" style="border-top-left-radius: 14px; border-top-right-radius: 14px; background: linear-gradient(135deg, var(--cream-100), var(--cream-50));">
                <h5 class="modal-title fw-bold" id="countryDetailModalLabel" style="color: var(--navy-800);">
                    <i class="fa-solid fa-book-atlas me-2" style="color: var(--navy-accent);"></i> Detail Ekstensif Negara
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <div class="row g-4">
                    <!-- Kolom Kiri: Geografi & Demografi Lanjutan -->
                    <div class="col-md-6">
                        <h6 class="fw-bold border-bottom pb-2 mb-3" style="color: var(--navy-accent); border-color: var(--cream-300) !important;">
                            <i class="fa-solid fa-map-location-dot me-2"></i> Geografi & Wilayah
                        </h6>
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <tr>
                                    <td style="color: var(--corporate-gray);">Nama Resmi</td>
                                    <td class="fw-bold text-end" style="color: var(--navy-800);">{{ $country['names']['official'] ?? '--' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: var(--corporate-gray);">Benua (Region)</td>
                                    <td class="fw-bold text-end" style="color: var(--navy-800);">{{ $country['region'] ?? '--' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: var(--corporate-gray);">Sub-Region</td>
                                    <td class="fw-bold text-end" style="color: var(--navy-800);">{{ $country['subregion'] ?? '--' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: var(--corporate-gray);">Luas Wilayah</td>
                                    <td class="fw-bold text-end" style="color: var(--navy-800);">{{ isset($country['area']['kilometers']) ? number_format($country['area']['kilometers']) . ' km²' : '--' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: var(--corporate-gray);">Sistem Pemerintahan</td>
                                    <td class="fw-bold text-end" style="color: var(--navy-800);">{{ $country['government_type'] ?? '--' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: var(--corporate-gray);">Koordinat (Lat / Lng)</td>
                                    <td class="fw-bold text-end" style="color: var(--navy-800);">
                                        {{ $country['coordinates']['lat'] ?? '--' }} / {{ $country['coordinates']['lng'] ?? '--' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Kolom Kanan: Ekonomi, Komunikasi & Organisasi -->
                    <div class="col-md-6">
                        <h6 class="fw-bold border-bottom pb-2 mb-3" style="color: var(--navy-accent); border-color: var(--cream-300) !important;">
                            <i class="fa-solid fa-circle-info me-2"></i> Informasi Umum
                        </h6>
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <tr>
                                    <td style="color: var(--corporate-gray);" class="w-50">Mata Uang Lengkap</td>
                                    <td class="fw-bold text-end" style="color: var(--navy-800);">{{ $country['currencies'][0]['name'] ?? '--' }} ({{ $country['currencies'][0]['code'] ?? '' }})</td>
                                </tr>
                                <tr>
                                    <td style="color: var(--corporate-gray);">Bahasa Utama</td>
                                    <td class="fw-bold text-end" style="color: var(--navy-800);">{{ $country['languages'][0]['name'] ?? '--' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: var(--corporate-gray);">Kode Telepon (Prefix)</td>
                                    <td class="fw-bold text-end" style="color: var(--navy-800);">{{ isset($country['calling_codes'][0]) ? '+' . $country['calling_codes'][0] : '--' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: var(--corporate-gray);">Domain Internet (TLD)</td>
                                    <td class="fw-bold text-end" style="color: var(--navy-800);">{{ $country['tlds'][0] ?? '--' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: var(--corporate-gray);">Zona Waktu</td>
                                    <td class="fw-bold text-end" style="color: var(--navy-800);">{{ $country['timezones'][0] ?? '--' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($weather['current']))
@php
    // Logika Penerjemah Kode Cuaca (WMO) untuk Supply Chain
    $wmo = $weather['current']['weather_code'] ?? 0;
    $stormRisk = 'Rendah (Aman untuk Logistik)';
    $badgeColor = 'success';
    $condition = 'Cerah / Berawan';

    if ($wmo >= 95) { 
        $stormRisk = 'SANGAT TINGGI (Bahaya Logistik)';
        $badgeColor = 'danger';
        $condition = 'Badai Petir & Petir Kilat';
    } elseif ($wmo >= 80) { 
        $stormRisk = 'Sedang (Waspada Pelabuhan)';
        $badgeColor = 'warning';
        $condition = 'Hujan Deras / Hujan Badai';
    } elseif ($wmo >= 51) {
        $condition = 'Gerimis / Hujan Ringan';
    } elseif ($wmo == 45 || $wmo == 48) {
        $condition = 'Kabut (Visibilitas Rendah)';
    }
@endphp

<!-- MODAL DETAIL CUACA LOGISTIK -->
<div class="modal fade" id="weatherDetailModal" tabindex="-1" aria-labelledby="weatherDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; box-shadow: 0 20px 60px rgba(10,22,40,0.2) !important;">
            <div class="modal-header border-bottom-0" style="border-top-left-radius: 14px; border-top-right-radius: 14px; background: linear-gradient(135deg, var(--cream-100), var(--cream-50));">
                <h5 class="modal-title fw-bold" id="weatherDetailModalLabel" style="color: var(--navy-800);">
                    <i class="fa-solid fa-cloud-bolt me-2" style="color: var(--navy-accent);"></i> Parameter Cuaca Logistik
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <div class="alert alert-{{ $badgeColor }} d-flex align-items-center mb-4 border-0 shadow-sm">
                    <i class="fa-solid fa-triangle-exclamation fs-3 me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-0">Risiko Badai & Operasional:</h6>
                        <span>{{ $stormRisk }} ({{ $condition }})</span>
                    </div>
                </div>

                <table class="table table-hover table-borderless">
                    <tbody>
                        <tr>
                            <td style="color: var(--corporate-gray);"><i class="fa-solid fa-temperature-half me-2 w-20px"></i>Suhu Aktual</td>
                            <td class="fw-bold text-end" style="color: var(--navy-800);">{{ $weather['current']['temperature_2m'] ?? '--' }} °C</td>
                        </tr>
                        <tr>
                            <td style="color: var(--corporate-gray);"><i class="fa-solid fa-person-rays me-2 w-20px"></i>Terasa Seperti</td>
                            <td class="fw-bold text-end" style="color: var(--navy-800);">{{ $weather['current']['apparent_temperature'] ?? '--' }} °C</td>
                        </tr>
                        <tr>
                            <td style="color: var(--corporate-gray);"><i class="fa-solid fa-droplet me-2 w-20px"></i>Kelembapan</td>
                            <td class="fw-bold text-end" style="color: var(--navy-800);">{{ $weather['current']['relative_humidity_2m'] ?? '--' }} %</td>
                        </tr>
                        <tr>
                            <td style="color: var(--corporate-gray);"><i class="fa-solid fa-cloud-showers-heavy me-2 w-20px"></i>Curah Hujan</td>
                            <td class="fw-bold text-end" style="color: var(--navy-800);">{{ $weather['current']['precipitation'] ?? '--' }} mm</td>
                        </tr>
                        <tr class="border-top">
                            <td style="color: var(--corporate-gray);" class="pt-3"><i class="fa-solid fa-wind me-2 w-20px"></i>Kec. Angin</td>
                            <td class="fw-bold text-end pt-3" style="color: var(--navy-800);">{{ $weather['current']['wind_speed_10m'] ?? '--' }} km/h</td>
                        </tr>
                        <tr>
                            <td style="color: var(--corporate-gray);"><i class="fa-solid fa-tornado me-2 w-20px"></i>Hembusan (Gusts)</td>
                            <td class="fw-bold text-end text-danger">{{ $weather['current']['wind_gusts_10m'] ?? '--' }} km/h</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

@if(isset($economy))
<!-- MODAL DETAIL EKONOMI WORLD BANK -->
<div class="modal fade" id="economyDetailModal" tabindex="-1" aria-labelledby="economyDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; box-shadow: 0 20px 60px rgba(10,22,40,0.2) !important;">
            <div class="modal-header border-bottom-0" style="border-top-left-radius: 14px; border-top-right-radius: 14px; background: linear-gradient(135deg, var(--cream-100), var(--cream-50));">
                <h5 class="modal-title fw-bold" id="economyDetailModalLabel" style="color: var(--navy-800);">
                    <i class="fa-solid fa-landmark me-2" style="color: var(--navy-accent);"></i> Detail Ekonomi Makro
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <!-- Penjelasan mengapa kadang data kosong -->
                <div class="alert d-flex align-items-center mb-4 border-0 shadow-sm" style="font-size: 0.85rem; background: rgba(79,125,219,0.06); border: 1px solid rgba(79,125,219,0.1) !important; color: var(--navy-600);">
                    <i class="fa-solid fa-circle-info fs-4 me-3" style="color: var(--navy-accent);"></i>
                    <div>
                        Data ditarik langsung dari indikator tahunan <strong>World Bank</strong>. Nilai "--" menunjukkan negara bersangkutan belum merilis data resminya untuk metrik tersebut.
                    </div>
                </div>

                <table class="table table-hover table-borderless">
                    <tbody>
                        <tr>
                            <td style="color: var(--corporate-gray);"><i class="fa-solid fa-users me-2 w-20px"></i>Total Populasi (WB)</td>
                            <td class="fw-bold text-end" style="color: var(--navy-800);">{{ $economy['population'] ?? '--' }} Jiwa</td>
                        </tr>
                        <tr>
                            <td style="color: var(--corporate-gray);"><i class="fa-solid fa-money-bill-trend-up me-2 w-20px"></i>Tingkat Inflasi</td>
                            <td class="fw-bold text-end" style="color: #ef4444;">{{ $economy['inflation'] ?? '--' }} %</td>
                        </tr>
                        <tr class="border-top">
                            <td style="color: var(--corporate-gray);" class="pt-3"><i class="fa-solid fa-sack-dollar me-2 w-20px"></i>Total GDP</td>
                            <td class="fw-bold text-end pt-3" style="color: var(--navy-800);">{{ $economy['gdp'] ?? '--' }}</td>
                        </tr>
                        <tr>
                            <td style="color: var(--corporate-gray);"><i class="fa-solid fa-ship me-2 w-20px"></i>Total Ekspor</td>
                            <td class="fw-bold text-end" style="color: var(--accent-emerald);">{{ $economy['exports'] ?? '--' }}</td>
                        </tr>
                        <tr>
                            <td style="color: var(--corporate-gray);"><i class="fa-solid fa-plane-arrival me-2 w-20px"></i>Total Impor</td>
                            <td class="fw-bold text-end" style="color: var(--accent-gold);">{{ $economy['imports'] ?? '--' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif