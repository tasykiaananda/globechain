@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column h-100">

        <div class="d-flex justify-content-between align-items-end mb-3 flex-shrink-0">
            <div>
                <h3 class="mb-1 fw-bold text-dark">Global Country Dashboard</h3>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">Pemantauan rantai pasok dan skor risiko secara real-time.</p>
            </div>
        
            <div class="d-flex gap-2 align-items-center">
                <span class="text-muted fw-bold" style="font-size: 0.85rem;">PILIH NEGARA:</span>
                <div class="input-group" style="width: 360px;">
                    <select name="country" class="form-select select2-country">
                        @foreach($countries as $countryName)
                            <option value="{{ $countryName }}" {{ $selectedCountry === $countryName ? 'selected' : '' }}>
                                {{ $countryName }}
                            </option>
                        @endforeach
                    </select>
                    <button id="btn-monitor" class="btn text-white fw-bold" style="background-color: var(--matcha-500);">
                        <i class="fa-solid fa-magnifying-glass me-1"></i> Pantau
                    </button>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3 flex-shrink-0">
            <div class="col-md-3">
                <div class="card-corporate p-3 h-100 border-start border-4"
                    style="border-color: var(--matcha-500) !important;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="text-uppercase text-muted fw-bold" style="font-size: 0.70rem;">Total Risk Score</span>
                        <i class="fa-solid fa-shield-halved text-matcha fs-6"></i>
                    </div>
                    <h2 class="fw-bold text-dark mb-0">22 <span class="fs-6 text-muted fw-normal">/ Low</span></h2>
                    <p class="text-success mt-1 mb-0" style="font-size: 0.70rem; font-weight: 600;">
                        <i class="fa-solid fa-check-circle me-1"></i> Aman untuk logistik
                    </p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-corporate p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="text-uppercase text-muted fw-bold" style="font-size: 0.70rem;">Current Weather</span>
                        <i class="fa-solid fa-cloud-rain text-secondary fs-6"></i>
                    </div>
                    <h2 id="weather-temp" class="fw-bold text-dark mb-0">--°C</h2>
                    <p class="text-muted mt-1 mb-0" style="font-size: 0.70rem;">
                        Data dari <span class="fw-bold">Open-Meteo</span>
                    </p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-corporate p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="text-uppercase text-muted fw-bold" style="font-size: 0.70rem;">Inflation Rate</span>
                        <i class="fa-solid fa-arrow-trend-up text-secondary fs-6"></i>
                    </div>
                    <h2 id="inflation-rate" class="fw-bold text-dark mb-0">--%</h2>
                    <p class="text-muted mt-1 mb-0" style="font-size: 0.70rem;">
                        <i class="fa-solid fa-circle-check text-success me-1"></i> World Bank Data
                    </p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-corporate p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="text-uppercase text-muted fw-bold" style="font-size: 0.70rem;">Currency & Region</span>
                        <i class="fa-solid fa-coins text-secondary fs-6"></i>
                    </div>
                    <h2 id="currency-code" class="fw-bold text-dark mb-0">--</h2>
                    <p class="text-muted mt-1 mb-0" style="font-size: 0.70rem; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                        Wilayah: <span id="region-text" class="fw-bold">--</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-3 flex-grow-1 pb-1">
            <div class="col-md-8 h-100">
                <div class="card-corporate p-4 h-100 d-flex flex-column">
                    <h6 class="fw-bold mb-3 text-dark"><i class="fa-solid fa-chart-area me-2 text-matcha"></i> Risk &
                        Inflation Trends</h6>
                    <div class="bg-light rounded d-flex align-items-center justify-content-center flex-grow-1"
                        style="border: 1px dashed #cbd5e1; min-height: 150px;">
                        <span class="text-muted" style="font-size: 0.85rem;"><i class="fa-solid fa-code me-2"></i>Area ini
                            akan diisi grafik Chart.js</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4 h-100">
                <div class="card-corporate p-4 h-100 d-flex flex-column overflow-hidden">
                    <h6 class="fw-bold mb-3 text-dark"><i class="fa-solid fa-brain me-2 text-matcha"></i> News Sentiment
                        Analysis</h6>
                    <div class="flex-grow-1 overflow-auto pe-2" style="scrollbar-width: thin;">
                        <div class="p-3 mb-3 rounded" style="background-color: #fff1f2; border-left: 4px solid #ef4444;">
                            <p class="mb-1 fw-bold text-dark" style="font-size: 0.80rem;">"Inflation increases due to port
                                delays"</p>
                            <span class="badge bg-danger text-white">Negative (3)</span>
                        </div>
                        <div class="p-3 rounded"
                            style="background-color: var(--matcha-50); border-left: 4px solid var(--matcha-500);">
                            <p class="mb-1 fw-bold text-dark" style="font-size: 0.80rem;">"Logistics profit stable this
                                quarter"</p>
                            <span class="badge bg-matcha">Positive (2)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        
        let waitForJQuery = setInterval(function () {
            if (typeof window.jQuery !== 'undefined') {
                clearInterval(waitForJQuery);
                jalankanDashboard();
            }
        }, 100);

        function jalankanDashboard() {
            const $ = window.jQuery;

            function loadCountryData(countryName) {
                if (!countryName) return;

                // Membuat elemen lingkaran loading Bootstrap 5 kecil (Spinner) berwarna Matcha/Success
                const spinner = '<div class="spinner-border spinner-border-sm text-success" role="status"></div>';
                
                // Suntikkan lingkaran loading ke dalam masing-masing kartu indikator
                $('#weather-temp').html(spinner);
                $('#inflation-rate').html(spinner);
                $('#currency-code').html(spinner);
                $('#region-text').html(spinner);

                $.ajax({
                    url: '/country-detail',
                    type: 'GET',
                    data: { country: countryName },
                    success: function(response) {
                        // Ganti lingkaran loading dengan data asli yang berhasil ditarik dari API
                        $('#weather-temp').text(response.temperature !== '--' ? response.temperature + '°C' : '--°C');
                        $('#inflation-rate').text(response.inflation_rate !== 'N/A' ? response.inflation_rate + '%' : 'N/A%');
                        $('#currency-code').text(response.currency_code);
                        $('#region-text').text(response.region);

                        console.log("=== DEBUG REPORT ===");
                        console.log("Status Koneksi Server API Negara:", response.debug_info.country_api);
                        console.log("Kode ISO yang digunakan ke World Bank:", response.debug_info.iso_used);
                    },
                    error: function(xhr) {
                        console.error("AJAX ERROR:", xhr);
                        $('#weather-temp').text('Error');
                        $('#inflation-rate').text('Error');
                        $('#currency-code').text('Error');
                        $('#region-text').text('Error');
                    }
                });
            }

            if ($.fn.select2) {
                $('.select2-country').select2({ width: 'resolve' });
            }

            let initialCountry = $('.select2-country').val();
            loadCountryData(initialCountry);

            $('#btn-monitor').on('click', function(e) {
                e.preventDefault();
                let selectedCountry = $('.select2-country').val();
                loadCountryData(selectedCountry);
            });
        }
    });
    </script>
@endsection