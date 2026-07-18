@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />

<style>
.geo-page { display:flex; flex-direction:column; height:100%; overflow:hidden; }

@keyframes slideDown { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }

/* Header */
.geo-header {
    display:flex; justify-content:space-between; align-items:center;
    flex-shrink:0; margin-bottom:12px; animation:slideDown .4s ease-out;
}
.live-badge {
    display:inline-flex; align-items:center; gap:6px;
    background:#ecfdf5; border:1px solid #6ee7b7;
    border-radius:99px; padding:3px 10px;
    font-size:.68rem; font-weight:700; color:#059669;
}
.pulse-dot { width:6px;height:6px;border-radius:50%;background:#10b981;animation:livePulse 1.5s infinite; }
@keyframes livePulse {
    0%{box-shadow:0 0 0 0 rgba(16,185,129,.7)}
    70%{box-shadow:0 0 0 5px rgba(16,185,129,0)}
    100%{box-shadow:0 0 0 0 rgba(16,185,129,0)}
}

/* Stat pills row */
.stat-pills { display:flex; gap:10px; flex-shrink:0; margin-bottom:10px; }
.stat-pill {
    display:flex; align-items:center; gap:8px;
    background:#fff; border-radius:10px; padding:8px 14px;
    border:1px solid #eef0f6; box-shadow:0 1px 4px rgba(0,0,0,.04);
    font-size:.75rem;
}
.stat-pill .sp-icon {
    width:28px;height:28px;border-radius:7px;
    display:flex;align-items:center;justify-content:center;
    font-size:.72rem;color:#fff;flex-shrink:0;
}
.stat-pill .sp-val { font-weight:800;color:#0f172a;font-size:.88rem; }
.stat-pill .sp-lbl { color:#94a3b8;font-size:.65rem;text-transform:uppercase;letter-spacing:.5px; }

/* Map wrapper */
.map-wrapper {
    flex:1; position:relative; border-radius:14px;
    overflow:hidden; border:1px solid #e2e8f0;
    box-shadow:0 4px 20px rgba(0,0,0,.08);
    min-height:0;
}
#geospatialMap { width:100%; height:100%; }

/* Floating search */
.map-search {
    position:absolute; top:16px; left:56px; z-index:1000;
    width:300px;
    background:rgba(255,255,255,.96); backdrop-filter:blur(12px);
    border-radius:10px; border:1px solid rgba(255,255,255,.9);
    box-shadow:0 6px 20px rgba(0,0,0,.12);
    display:flex; align-items:center; padding:6px 6px 6px 12px; gap:6px;
}
.map-search input {
    flex:1; border:none; background:transparent; outline:none;
    font-size:.82rem; font-weight:600; color:#1e293b;
}
.map-search input::placeholder { color:#94a3b8; font-weight:400; }
.map-search-btn {
    background:linear-gradient(135deg,#3d5fc0,#2a45a0);
    color:#fff; border:none; border-radius:7px;
    padding:5px 12px; font-size:.72rem; font-weight:700;
    cursor:pointer; transition:all .2s; white-space:nowrap;
}
.map-search-btn:hover { filter:brightness(1.1); }

/* Floating control panel */
.map-controls {
    position:absolute; top:16px; right:16px; z-index:1000;
    background:rgba(255,255,255,.96); backdrop-filter:blur(12px);
    border-radius:12px; border:1px solid rgba(255,255,255,.9);
    box-shadow:0 6px 20px rgba(0,0,0,.12);
    padding:12px 14px; width:200px;
}
.ctrl-title {
    font-size:.72rem; font-weight:700; color:#374151;
    text-transform:uppercase; letter-spacing:.7px;
    border-bottom:1px solid #f1f5f9; padding-bottom:8px; margin-bottom:10px;
    display:flex; align-items:center; gap:6px;
}
.ctrl-item {
    display:flex; align-items:center; justify-content:space-between;
    margin-bottom:8px;
}
.ctrl-item:last-child { margin-bottom:0; }
.ctrl-label { font-size:.76rem; font-weight:600; color:#374151; display:flex; align-items:center; gap:5px; }
.ctrl-dot { width:8px;height:8px;border-radius:50%; }

/* Custom toggle switch */
.toggle { position:relative;display:inline-block;width:34px;height:18px; }
.toggle input { opacity:0;width:0;height:0; }
.toggle-slider {
    position:absolute;inset:0;border-radius:18px;
    background:#e2e8f0; cursor:pointer; transition:.3s;
}
.toggle-slider:before {
    content:'';position:absolute;width:14px;height:14px;
    left:2px;top:2px;border-radius:50%;background:#fff;
    transition:.3s;box-shadow:0 1px 3px rgba(0,0,0,.2);
}
.toggle input:checked + .toggle-slider { background:#3d5fc0; }
.toggle input:checked + .toggle-slider:before { transform:translateX(16px); }

/* Floating stat bottom-left */
.map-stat-bar {
    position:absolute; bottom:16px; left:16px; z-index:1000;
    display:flex; gap:8px;
}
.map-stat-chip {
    background:rgba(255,255,255,.94); backdrop-filter:blur(8px);
    border-radius:8px; border:1px solid rgba(255,255,255,.8);
    box-shadow:0 2px 10px rgba(0,0,0,.1);
    padding:6px 12px; font-size:.72rem; font-weight:700; color:#0f172a;
    display:flex; align-items:center; gap:5px;
}

/* Radar pulse */
.radar-pulse {
    width:44px; height:44px;
    background:rgba(239,68,68,.15);
    border:2px solid rgba(239,68,68,.7);
    border-radius:50%;
    animation:radarAnim 1.5s infinite ease-out;
}
@keyframes radarAnim {
    0%{transform:scale(.3);opacity:1}
    100%{transform:scale(1.6);opacity:0}
}

/* Leaflet popup override */
.leaflet-popup-content-wrapper {
    border-radius:12px !important;
    box-shadow:0 8px 25px rgba(0,0,0,.15) !important;
    border:none !important;
    padding:0 !important;
}
.leaflet-popup-content { margin:0 !important; }
.leaflet-popup-tip { background:#fff !important; }
.custom-popup { padding:14px 16px; min-width:180px; }
.custom-popup .cp-title { font-size:.9rem;font-weight:800;color:#0f172a;margin-bottom:6px; }
.custom-popup .cp-row { display:flex;justify-content:space-between;font-size:.75rem;color:#64748b;margin-bottom:3px; }
.custom-popup .cp-row strong { color:#0f172a; }
.custom-popup .cp-badge {
    display:inline-block;margin-top:8px;padding:3px 10px;border-radius:99px;
    font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.4px;
}
</style>

<div class="geo-page">

    {{-- Header --}}
    <div class="geo-header">
        <div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:3px;">
                <h1 style="font-size:1.2rem;font-weight:800;color:#0f172a;letter-spacing:-.5px;margin:0;">
                    Geospatial Intelligence
                </h1>
                <div class="live-badge">
                    <span class="pulse-dot"></span>
                    Live Monitoring
                    <span style="opacity:.3;">|</span>
                    <span id="live-clock"><i class="fa-regular fa-clock me-1"></i>--:--:--</span>
                </div>
            </div>
            <p style="font-size:.8rem;color:#64748b;margin:0;">
                <i class="fa-solid fa-satellite-dish me-1" style="color:#3d5fc0;"></i>
                Pemantauan real-time pelabuhan global &amp; anomali cuaca berbasis koordinat satelit.
            </p>
        </div>

        {{-- Legend --}}
        <div style="display:flex;gap:10px;align-items:center;flex-shrink:0;">
            <div style="display:flex;align-items:center;gap:5px;font-size:.72rem;color:#64748b;font-weight:600;">
                <span style="width:10px;height:10px;border-radius:50%;background:#3b82f6;border:2px solid #fff;box-shadow:0 0 5px rgba(59,130,246,.5);display:inline-block;"></span>
                Port
            </div>
            <div style="display:flex;align-items:center;gap:5px;font-size:.72rem;color:#64748b;font-weight:600;">
                <span style="width:10px;height:10px;border-radius:50%;background:#ef4444;display:inline-block;opacity:.7;"></span>
                Weather Sensor
            </div>
            <div style="display:flex;align-items:center;gap:5px;font-size:.72rem;color:#64748b;font-weight:600;">
                <span style="width:10px;height:10px;border-radius:50%;background:#3d5fc0;display:inline-block;"></span>
                Cluster
            </div>
        </div>
    </div>

    {{-- Stat pills --}}
    <div class="stat-pills">
        <div class="stat-pill">
            <div class="sp-icon" style="background:linear-gradient(135deg,#3d5fc0,#6b8ff7);">
                <i class="fa-solid fa-anchor"></i>
            </div>
            <div>
                <div class="sp-val" id="portCount">—</div>
                <div class="sp-lbl">Pelabuhan Aktif</div>
            </div>
        </div>
        <div class="stat-pill">
            <div class="sp-icon" style="background:linear-gradient(135deg,#dc2626,#f87171);">
                <i class="fa-solid fa-cloud-bolt"></i>
            </div>
            <div>
                <div class="sp-val" id="countryCount">—</div>
                <div class="sp-lbl">Sensor Cuaca</div>
            </div>
        </div>
        <div class="stat-pill">
            <div class="sp-icon" style="background:linear-gradient(135deg,#0f766e,#14b8a6);">
                <i class="fa-solid fa-earth-asia"></i>
            </div>
            <div>
                <div class="sp-val">Real-Time</div>
                <div class="sp-lbl">Data Source</div>
            </div>
        </div>
        <div class="stat-pill" style="margin-left:auto;">
            <div class="sp-icon" style="background:linear-gradient(135deg,#7c3aed,#a78bfa);">
                <i class="fa-solid fa-crosshairs"></i>
            </div>
            <div>
                <div class="sp-val" id="zoomLevel">4</div>
                <div class="sp-lbl">Zoom Level</div>
            </div>
        </div>
    </div>

    {{-- Map --}}
    <div class="map-wrapper">
        <div id="geospatialMap"></div>

        {{-- Floating search --}}
        <div class="map-search">
            <i class="fa-solid fa-magnifying-glass" style="color:#3d5fc0;font-size:.82rem;flex-shrink:0;"></i>
            <input type="text" id="mapSearchInput" placeholder="Cari pelabuhan atau negara...">
            <button class="map-search-btn" id="searchBtn">
                <i class="fa-solid fa-search me-1" id="searchIcon"></i>Cari
            </button>
        </div>

        {{-- Floating layer controls --}}
        <div class="map-controls">
            <div class="ctrl-title">
                <i class="fa-solid fa-layer-group" style="color:#3d5fc0;"></i> Map Layers
            </div>
            <div class="ctrl-item">
                <span class="ctrl-label">
                    <span class="ctrl-dot" style="background:#3b82f6;"></span>
                    Port Clusters
                </span>
                <label class="toggle">
                    <input type="checkbox" id="togglePorts" checked>
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="ctrl-item">
                <span class="ctrl-label">
                    <span class="ctrl-dot" style="background:#ef4444;"></span>
                    Weather Sensors
                </span>
                <label class="toggle">
                    <input type="checkbox" id="toggleWeather" checked>
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </div>

        {{-- Bottom stat bar --}}
        <div class="map-stat-bar">
            <div class="map-stat-chip">
                <i class="fa-solid fa-location-dot" style="color:#3d5fc0;"></i>
                <span id="coordDisplay">Hover pada peta</span>
            </div>
        </div>
    </div>

</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Live clock ── */
    (function tick() {
        const el = document.getElementById('live-clock');
        if (el) el.innerHTML = `<i class="fa-regular fa-clock me-1"></i>${new Date().toLocaleTimeString('id-ID')}`;
        setTimeout(tick, 1000);
    })();

    /* ── Map init ── */
    const map = L.map('geospatialMap', {
        center: [2.5, 112.5], zoom: 4,
        zoomControl: false,
        attributionControl: true
    });

    L.control.zoom({ position: 'bottomright' }).addTo(map);

    /* Clean dark-accent tile */
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        attribution: '© <a href="https://openstreetmap.org">OSM</a> © <a href="https://carto.com">CARTO</a>',
        maxZoom: 19
    }).addTo(map);

    /* Zoom level stat */
    map.on('zoomend', () => {
        const el = document.getElementById('zoomLevel');
        if (el) el.textContent = map.getZoom();
    });

    /* Coordinate display */
    map.on('mousemove', (e) => {
        const el = document.getElementById('coordDisplay');
        if (el) el.textContent = `${e.latlng.lat.toFixed(4)}, ${e.latlng.lng.toFixed(4)}`;
    });

    /* ── Layers ── */
    const weatherLayer = L.layerGroup().addTo(map);
    const portCluster  = L.markerClusterGroup({
        maxClusterRadius: 50,
        iconCreateFunction: cluster => L.divIcon({
            html: `<div style="background:linear-gradient(135deg,#3d5fc0,#2a45a0);color:#fff;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:50%;font-weight:800;font-size:.75rem;border:2px solid #fff;box-shadow:0 2px 8px rgba(61,95,192,.4);">${cluster.getChildCount()}</div>`,
            className: '',
            iconSize: L.point(32, 32)
        })
    });
    map.addLayer(portCluster);

    const portIcon = L.divIcon({
        className: '',
        html: `<div style="background:#3b82f6;width:12px;height:12px;border-radius:50%;border:2px solid #fff;box-shadow:0 0 6px rgba(59,130,246,.5);"></div>`,
        iconSize: [12, 12], iconAnchor: [6, 6]
    });

    /* ── Port data ── */
    let realPorts = [], portMarkers = {};

    fetch('/api/ports')
        .then(r => r.json())
        .then(data => {
            realPorts = data;
            document.getElementById('portCount').textContent = data.length.toLocaleString('id-ID');

            data.forEach(port => {
                if (!port.lat || !port.lng) return;
                const marker = L.marker([port.lat, port.lng], { icon: portIcon });
                portMarkers[port.code] = marker;
                marker.bindPopup(`
                    <div class="custom-popup">
                        <div class="cp-title"><i class="fa-solid fa-anchor" style="color:#3d5fc0;margin-right:5px;font-size:.8rem;"></i>${port.name}</div>
                        <div class="cp-row"><span>Negara</span><strong>${port.country_name}</strong></div>
                        <div class="cp-row"><span>Kode</span><strong>${port.code}</strong></div>
                        <span class="cp-badge" style="background:#dcfce7;color:#15803d;">● Operational</span>
                    </div>`, { maxWidth: 220 });
                portCluster.addLayer(marker);
            });
        });

    /* ── Weather sensors ── */
    const radarIcon = L.divIcon({ className: 'radar-pulse', iconSize: [44, 44], iconAnchor: [22, 22] });

    fetch('/api/countries')
        .then(r => r.json())
        .then(countries => {
            document.getElementById('countryCount').textContent = countries.length;

            countries.forEach(country => {
                const sensor = L.circleMarker([country.lat, country.lng], {
                    radius: 5, fillColor: '#ef4444', color: '#fff',
                    weight: 1.5, fillOpacity: 0.6
                }).bindPopup(`<div class="custom-popup"><div class="cp-title">${country.name}</div><p style="font-size:.75rem;color:#64748b;margin:4px 0 0;">Klik untuk memuat data cuaca...</p></div>`, { maxWidth: 200 });

                sensor.on('click', function () {
                    fetch(`/api/weather/live?lat=${country.lat}&lng=${country.lng}`)
                        .then(r => r.json())
                        .then(data => {
                            const cur  = data.current || {};
                            const temp = cur.temperature_2m ?? '--';
                            const wind = cur.wind_speed_10m ?? '--';
                            const code = cur.weather_code ?? 0;

                            let risk = 'Low', badgeBg = '#dcfce7', badgeColor = '#15803d';
                            let condition = 'Cerah / Berawan';
                            let icon = 'fa-cloud-sun';

                            if ([95,96,99].includes(code) || wind > 60) {
                                risk = 'High'; badgeBg = '#fee2e2'; badgeColor = '#b91c1c';
                                condition = 'Peringatan Badai'; icon = 'fa-cloud-bolt';
                                L.marker([country.lat, country.lng], { icon: radarIcon }).addTo(weatherLayer);
                            } else if ([61,63,65,80,81,82].includes(code) || wind > 40) {
                                risk = 'Medium'; badgeBg = '#fef9c3'; badgeColor = '#a16207';
                                condition = 'Hujan / Angin Kencang'; icon = 'fa-cloud-showers-heavy';
                            }

                            sensor.setPopupContent(`
                                <div class="custom-popup">
                                    <div class="cp-title"><i class="fa-solid ${icon}" style="margin-right:5px;"></i>${country.name}</div>
                                    <div class="cp-row"><span>Kondisi</span><strong>${condition}</strong></div>
                                    <div class="cp-row"><span>Suhu</span><strong>${temp}°C</strong></div>
                                    <div class="cp-row"><span>Angin</span><strong>${wind} km/h</strong></div>
                                    <span class="cp-badge" style="background:${badgeBg};color:${badgeColor};">Storm Risk: ${risk}</span>
                                </div>`);
                        });
                });

                sensor.addTo(weatherLayer);
            });
        });

    /* ── Search ── */
    function levenshtein(a, b) {
        const m = [], al = a.length, bl = b.length;
        for (let i = 0; i <= bl; i++) m[i] = [i];
        for (let j = 0; j <= al; j++) m[0][j] = j;
        for (let i = 1; i <= bl; i++)
            for (let j = 1; j <= al; j++)
                m[i][j] = b[i-1] === a[j-1] ? m[i-1][j-1]
                    : Math.min(m[i-1][j-1]+1, m[i][j-1]+1, m[i-1][j]+1);
        return m[bl][al];
    }

    function doSearch() {
        const q = document.getElementById('mapSearchInput').value.toLowerCase().trim();
        if (!q) return;
        let best = null, minDist = 999;

        realPorts.forEach(p => {
            const n = (p.name||'').toLowerCase();
            const c = (p.country_name||'').toLowerCase();
            const k = (p.code||'').toLowerCase();
            if (n.includes(q) || c.includes(q) || k.includes(q)) { best = p; minDist = 0; return; }
            if (q.length >= 4 && minDist > 0) {
                const d = Math.min(levenshtein(q, n.substring(0,q.length)), levenshtein(q, c.substring(0,q.length)));
                if (d <= 2 && d < minDist) { minDist = d; best = p; }
            }
        });

        if (best) {
            map.flyTo([best.lat, best.lng], 13, { animate:true, duration:1.8 });
            setTimeout(() => {
                const mk = portMarkers[best.code];
                if (mk) portCluster.zoomToShowLayer(mk, () => mk.openPopup());
            }, 1900);
        } else {
            const inp = document.getElementById('mapSearchInput');
            inp.value = '';
            inp.placeholder = '⚠ Tidak ditemukan!';
            inp.style.color = '#ef4444';
            setTimeout(() => { inp.placeholder = 'Cari pelabuhan atau negara...'; inp.style.color = ''; }, 2000);
        }
    }

    document.getElementById('searchBtn').addEventListener('click', doSearch);
    document.getElementById('mapSearchInput').addEventListener('keypress', e => { if (e.key === 'Enter') { e.preventDefault(); doSearch(); } });

    /* ── Toggles ── */
    document.getElementById('togglePorts').addEventListener('change', e =>
        e.target.checked ? map.addLayer(portCluster) : map.removeLayer(portCluster));
    document.getElementById('toggleWeather').addEventListener('change', e =>
        e.target.checked ? map.addLayer(weatherLayer) : map.removeLayer(weatherLayer));
});
</script>
@endsection