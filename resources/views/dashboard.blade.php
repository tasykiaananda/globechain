@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column h-100" style="overflow:hidden;">

        <!-- 1. Header & Form Pencarian -->
        @include('partials.header')

        @if(isset($country))
            <!-- 2. Profil Negara (Blok 1) -->
            @include('partials.profile')

            <!-- 3. Metrics/Kartu Data (Blok 2) -->
            @include('partials.metrics')

            <!-- 4. Visuals/Grafik & Berita (Blok 3) -->
            @include('partials.visuals')
            
            <!-- 5. Modals (Detail Negara & Detail Cuaca) -->
            @include('partials.modals')
        @endif

    </div>

    <!-- SCRIPT SELECT2 + FAVORITES -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // SELECT2
        let waitForJQuery = setInterval(function () {
            if (typeof window.jQuery !== 'undefined') {
                clearInterval(waitForJQuery);
                const $ = window.jQuery;
                if ($.fn.select2) {
                    $('.select2-country').select2({ 
                        width: '100%',
                        theme: "bootstrap-5" 
                    });
                }
            }
        }, 100);

        // FAVORITES — populate 5th column in metrics
        try {
            const favs = JSON.parse(localStorage.getItem('globchain_favorites')) || [];
            const list = document.getElementById('fv-dash-list');
            if (!list || favs.length === 0) return;

            // Render with loading dots
            list.innerHTML = favs.map(name =>
                `<a href="#" class="fv-item" onclick="event.preventDefault();favGo('${name}')">
                    <span class="fv-dot ld"></span>
                    <span class="fv-nm">${name}</span>
                </a>`
            ).join('');

            // Fetch risk data
            const params = favs.map(c => `countries[]=${encodeURIComponent(c)}`).join('&');
            fetch(`/api/favorites/batch?${params}`)
                .then(r => r.json())
                .then(json => {
                    if (!json.success) return;
                    json.data.forEach((d, i) => {
                        const items = list.querySelectorAll('.fv-item');
                        if (!items[i]) return;
                        const rs = d.risk?.score ?? 0, rst = d.risk?.status ?? 'N/A';
                        const rc = rs >= 60 ? 'high' : rs >= 35 ? 'med' : 'low';
                        const dot = items[i].querySelector('.fv-dot');
                        if (dot) { dot.className = 'fv-dot ' + rc; }
                        // Add risk badge
                        let badge = items[i].querySelector('.fv-rk');
                        if (!badge) {
                            badge = document.createElement('span');
                            badge.className = 'fv-rk ' + rc;
                            items[i].appendChild(badge);
                        }
                        badge.textContent = rs;
                    });
                }).catch(() => {});
        } catch(e) {}
    });

    function favGo(name) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/country';
        const csrf = document.createElement('input');
        csrf.type = 'hidden'; csrf.name = '_token';
        csrf.value = document.querySelector('meta[name="csrf-token"]')?.content || '';
        form.appendChild(csrf);
        const input = document.createElement('input');
        input.type = 'hidden'; input.name = 'country'; input.value = name;
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
    </script>
@endsection