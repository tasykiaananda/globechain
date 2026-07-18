@extends('layouts.app')
@section('content')
<style>
.main-content{overflow-y:auto!important;height:100vh!important}
.content-inner{overflow:visible!important;height:auto!important}
:root{--fn:#0b1628;--fc:#1a2d4e;--fb:rgba(79,125,219,.18);--fa:#4f7ddb;--ft:#dce8f8;--fm:#8fadd4;--fg:#34d399;--fy:#fbbf24;--fr:#f87171}
.fp{background:var(--fn);min-height:100%;padding-bottom:2rem}
.fp-hdr{background:linear-gradient(135deg,#0f2044,#0d1e3d);border-bottom:1px solid var(--fb);padding:1rem 1.5rem;margin:-1.25rem -1.5rem 1rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.5rem}
.fp-t{font-size:1.05rem;font-weight:800;color:#fff}.fp-s{font-size:.74rem;color:var(--fm);margin-top:2px}
.fp-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(79,125,219,.12);border:1px solid rgba(79,125,219,.25);border-radius:999px;padding:4px 12px;font-size:.65rem;font-weight:700;color:#7ba7ff}
/* Card */
.fc{background:linear-gradient(145deg,#1a2d4e,#162240);border:1px solid var(--fb);border-radius:14px;padding:1.25rem;position:relative;overflow:hidden}
.fc::before{content:'';position:absolute;inset:0;border-radius:14px;background:linear-gradient(135deg,rgba(79,125,219,.04),transparent 50%);pointer-events:none}
.fc-lb{font-size:.58rem;font-weight:800;letter-spacing:1.4px;text-transform:uppercase;color:var(--fm);margin-bottom:.75rem;display:flex;align-items:center;gap:6px}
.fc-lb::after{content:'';flex:1;height:1px;background:var(--fb)}
/* Add row */
.f-add{display:flex;gap:10px;margin-bottom:1rem}
.f-sel{flex:1;background:rgba(255,255,255,.04);border:1px solid var(--fb);border-radius:10px;padding:10px 14px;font-size:.85rem;font-weight:600;color:var(--ft);outline:none;cursor:pointer;transition:all .2s}
.f-sel:focus{border-color:var(--fa);box-shadow:0 0 0 3px rgba(79,125,219,.15)}
.f-sel option{background:#1e2d4a;color:#fff}
.f-btn{border:none;border-radius:10px;background:linear-gradient(135deg,var(--fa),#3d5fc0);color:#fff;font-size:.78rem;font-weight:700;padding:10px 20px;cursor:pointer;transition:all .2s;white-space:nowrap}
.f-btn:hover{filter:brightness(1.1);transform:translateY(-1px)}
/* Country cards */
.fv-card{background:rgba(255,255,255,.03);border:1px solid var(--fb);border-radius:12px;padding:14px;margin-bottom:10px;transition:all .25s}
.fv-card:hover{background:rgba(79,125,219,.06);border-color:rgba(79,125,219,.3);transform:translateX(3px)}
.fv-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px}
.fv-name-row{display:flex;align-items:center;gap:10px;cursor:pointer}
.fv-icon{width:38px;height:38px;border-radius:10px;background:rgba(79,125,219,.12);display:flex;align-items:center;justify-content:center;color:var(--fa);font-size:.85rem;flex-shrink:0}
.fv-name{font-size:.9rem;font-weight:700;color:#fff}
.fv-sub{font-size:.62rem;color:var(--fm);font-weight:500;margin-top:1px}
.fv-actions{display:flex;gap:6px}
.fv-btn{border:none;border-radius:8px;padding:5px 12px;font-size:.68rem;font-weight:600;cursor:pointer;transition:all .2s}
.fv-btn-m{background:rgba(52,211,153,.1);color:var(--fg)}.fv-btn-m:hover{background:rgba(52,211,153,.22)}
.fv-btn-d{background:rgba(248,113,113,.08);color:var(--fr)}.fv-btn-d:hover{background:rgba(248,113,113,.2)}
/* Data grid */
.fv-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:8px}
.fv-cell{background:rgba(0,0,0,.15);border:1px solid rgba(79,125,219,.08);border-radius:8px;padding:8px 10px;text-align:center}
.fv-cell-label{font-size:.5rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--fm);margin-bottom:3px}
.fv-cell-val{font-size:.78rem;font-weight:800;color:#fff}
.fv-cell-extra{font-size:.55rem;color:var(--fm);margin-top:1px;font-weight:500}
/* Risk badge */
.rk-badge{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:6px;font-size:.58rem;font-weight:700}
.rk-low{background:rgba(52,211,153,.12);color:var(--fg)}.rk-med{background:rgba(251,191,36,.12);color:var(--fy)}.rk-high{background:rgba(248,113,113,.12);color:var(--fr)}
/* Empty */
.fv-empty{text-align:center;color:var(--fm);padding:2.5rem 1rem;font-size:.82rem}
.fv-empty i{font-size:2rem;display:block;margin-bottom:10px;color:rgba(251,191,36,.2)}
/* Quick actions */
.qa-btn{width:100%;border:none;border-radius:10px;padding:12px;font-size:.78rem;font-weight:700;cursor:pointer;transition:all .2s;margin-bottom:8px}
.qa-mon{background:rgba(52,211,153,.1);color:var(--fg)}.qa-mon:hover{background:rgba(52,211,153,.2)}
.qa-del{background:rgba(248,113,113,.08);color:var(--fr)}.qa-del:hover{background:rgba(248,113,113,.18)}
.qa-cmp{background:rgba(79,125,219,.1);color:var(--fa)}.qa-cmp:hover{background:rgba(79,125,219,.2)}
/* Stats */
.st-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:.75rem}
.st-box{background:rgba(0,0,0,.15);border:1px solid var(--fb);border-radius:10px;padding:10px;text-align:center}
.st-lb{font-size:.52rem;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--fm)}
.st-val{font-size:1.3rem;font-weight:900;color:#fff;margin-top:2px}
/* Tip */
.f-tip{margin-top:.75rem;padding:8px 12px;background:rgba(79,125,219,.06);border:1px solid rgba(79,125,219,.1);border-radius:8px;font-size:.65rem;color:var(--fm);display:flex;align-items:center;gap:6px}
.f-tip i{color:var(--fy);flex-shrink:0}
/* Loading skeleton */
.fv-skel{height:12px;background:rgba(79,125,219,.1);border-radius:4px;animation:pulse 1.5s infinite}
@keyframes pulse{0%,100%{opacity:.4}50%{opacity:.8}}
@keyframes fadeIn{from{opacity:0;transform:translateY(4px)}to{opacity:1;transform:none}}
.fade-in{animation:fadeIn .3s ease both}
@media(max-width:768px){.fv-grid{grid-template-columns:repeat(3,1fr)}}
</style>

<div class="fp">
<div class="fp-hdr">
    <div>
        <div class="fp-t"><i class="fa-solid fa-star me-2" style="color:var(--fy)"></i>Favorite Monitoring List</div>
        <div class="fp-s"><i class="fa-solid fa-bookmark me-1"></i>Simpan dan pantau negara-negara yang menjadi prioritas rantai pasok Anda</div>
    </div>
    <div class="fp-badge"><i class="fa-solid fa-bookmark"></i><span id="fav-counter">0</span> negara tersimpan</div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="fc">
            <div class="fc-lb"><i class="fa-solid fa-plus-circle" style="color:var(--fa)"></i> Tambah Negara Favorit</div>
            <div class="f-add">
                <select id="fav-select" class="f-sel">
                    @foreach($countriesList as $c)<option value="{{$c}}">{{$c}}</option>@endforeach
                </select>
                <button class="f-btn" onclick="addFav()"><i class="fa-solid fa-plus me-1"></i>Tambah</button>
            </div>

            <div class="fc-lb"><i class="fa-solid fa-list" style="color:var(--fa)"></i> Daftar Negara Favorit</div>
            <div id="fav-list"></div>

            <div class="f-tip"><i class="fa-solid fa-lightbulb"></i>Data favorit disimpan di browser. Klik nama negara untuk langsung monitor di Dashboard.</div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="fc" style="margin-bottom:12px">
            <div class="fc-lb"><i class="fa-solid fa-bolt" style="color:var(--fy)"></i> Quick Actions</div>
            <button class="qa-btn qa-mon" onclick="monitorFirst()"><i class="fa-solid fa-satellite-dish me-2"></i>Monitor Negara Pertama</button>
            <button class="qa-btn qa-cmp" onclick="location.href='/tools/comparison'"><i class="fa-solid fa-scale-balanced me-2"></i>Buka Comparison Engine</button>
            <button class="qa-btn qa-del" onclick="clearAll()"><i class="fa-solid fa-trash-can me-2"></i>Hapus Semua Favorit</button>
        </div>
        <div class="fc">
            <div class="fc-lb"><i class="fa-solid fa-chart-pie" style="color:var(--fa)"></i> Statistik</div>
            <div class="st-grid">
                <div class="st-box"><div class="st-lb">Total Favorit</div><div class="st-val" id="st-total">0</div></div>
                <div class="st-box"><div class="st-lb">API Status</div><div class="st-val" style="font-size:.82rem;color:var(--fg)" id="st-status">Loading...</div></div>
                <div class="st-box"><div class="st-lb">Avg Risk</div><div class="st-val" id="st-risk" style="font-size:1.1rem">—</div></div>
                <div class="st-box"><div class="st-lb">Last Sync</div><div class="st-val" style="font-size:.72rem;color:var(--fm)" id="st-time">—</div></div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
const FK='globchain_favorites';
function getFavs(){try{return JSON.parse(localStorage.getItem(FK))||[];}catch{return[];}}
function saveFavs(l){localStorage.setItem(FK,JSON.stringify(l));}

function addFav(){
    const n=document.getElementById('fav-select').value;
    let f=getFavs();
    if(f.includes(n)){alert(n+' sudah ada di favorit!');return;}
    f.push(n);saveFavs(f);renderFavs();
}
function removeFav(n){saveFavs(getFavs().filter(x=>x!==n));renderFavs();}
function clearAll(){if(!confirm('Hapus semua negara favorit?'))return;saveFavs([]);renderFavs();}
function monitorFirst(){const f=getFavs();if(!f.length){alert('Belum ada favorit!');return;}goTo(f[0]);}

function goTo(name){
    const form=document.createElement('form');form.method='POST';form.action='/country';
    const c=document.createElement('input');c.type='hidden';c.name='_token';c.value=document.querySelector('meta[name="csrf-token"]')?.content||'{{ csrf_token() }}';form.appendChild(c);
    const i=document.createElement('input');i.type='hidden';i.name='country';i.value=name;form.appendChild(i);
    document.body.appendChild(form);form.submit();
}

function renderFavs(){
    const list=document.getElementById('fav-list'),favs=getFavs();
    document.getElementById('fav-counter').textContent=favs.length;
    document.getElementById('st-total').textContent=favs.length;

    if(!favs.length){
        list.innerHTML='<div class="fv-empty"><i class="fa-regular fa-star"></i>Belum ada negara favorit.<br>Tambahkan negara dari dropdown di atas.</div>';
        document.getElementById('st-status').textContent='Idle';
        document.getElementById('st-status').style.color='var(--fm)';
        document.getElementById('st-risk').textContent='—';
        document.getElementById('st-time').textContent='—';
        return;
    }

    // Render skeleton cards
    list.innerHTML=favs.map((name,i)=>`
    <div class="fv-card fade-in" style="animation-delay:${i*0.05}s" id="fc-${i}">
        <div class="fv-top">
            <div class="fv-name-row" onclick="goTo('${name}')">
                <div class="fv-icon"><i class="fa-solid fa-earth-americas"></i></div>
                <div><div class="fv-name">${name}</div><div class="fv-sub" id="fsub-${i}">Memuat data intelijen...</div></div>
            </div>
            <div class="fv-actions">
                <button class="fv-btn fv-btn-m" onclick="goTo('${name}')"><i class="fa-solid fa-arrow-right me-1"></i>Monitor</button>
                <button class="fv-btn fv-btn-d" onclick="removeFav('${name}')"><i class="fa-solid fa-trash-can"></i></button>
            </div>
        </div>
        <div class="fv-grid" id="fgrid-${i}">
            <div class="fv-cell"><div class="fv-cell-label">GDP</div><div class="fv-skel" style="width:70%;margin:4px auto"></div></div>
            <div class="fv-cell"><div class="fv-cell-label">Inflasi</div><div class="fv-skel" style="width:50%;margin:4px auto"></div></div>
            <div class="fv-cell"><div class="fv-cell-label">Risk</div><div class="fv-skel" style="width:60%;margin:4px auto"></div></div>
            <div class="fv-cell"><div class="fv-cell-label">Suhu</div><div class="fv-skel" style="width:45%;margin:4px auto"></div></div>
            <div class="fv-cell"><div class="fv-cell-label">Mata Uang</div><div class="fv-skel" style="width:65%;margin:4px auto"></div></div>
        </div>
    </div>`).join('');

    loadData(favs);
}

async function loadData(favs){
    document.getElementById('st-status').textContent='Syncing...';
    document.getElementById('st-status').style.color='var(--fy)';

    try{
        const params=favs.map(c=>`countries[]=${encodeURIComponent(c)}`).join('&');
        const res=await fetch(`/api/favorites/batch?${params}`);
        const json=await res.json();
        if(!json.success) throw new Error(json.message);

        let totalRisk=0,riskCount=0;

        json.data.forEach((d,i)=>{
            const sub=document.getElementById('fsub-'+i);
            const grid=document.getElementById('fgrid-'+i);
            if(!sub||!grid) return;

            const rs=d.risk?.score??0, rst=d.risk?.status??'N/A';
            const rc=rs>=60?'rk-high':rs>=35?'rk-med':'rk-low';
            totalRisk+=rs; riskCount++;

            sub.innerHTML=`<span class="rk-badge ${rc}"><i class="fa-solid fa-shield-halved"></i>Risk: ${rs} (${rst})</span>`;

            grid.innerHTML=`
                <div class="fv-cell"><div class="fv-cell-label">GDP</div><div class="fv-cell-val">${d.gdp}</div><div class="fv-cell-extra">Produk Domestik Bruto</div></div>
                <div class="fv-cell"><div class="fv-cell-label">Inflasi</div><div class="fv-cell-val" style="color:${parseFloat(d.inflation)>5?'var(--fr)':parseFloat(d.inflation)>3?'var(--fy)':'var(--fg)'}">${d.inflation}%</div><div class="fv-cell-extra">Consumer Price Index</div></div>
                <div class="fv-cell"><div class="fv-cell-label">Risk Score</div><div class="fv-cell-val" style="color:${rs>=60?'var(--fr)':rs>=35?'var(--fy)':'var(--fg)'}">${rs}<span style="font-size:.55rem;color:var(--fm)"> /100</span></div><div class="fv-cell-extra">${rst}</div></div>
                <div class="fv-cell"><div class="fv-cell-label">Suhu</div><div class="fv-cell-val">${d.weather}</div><div class="fv-cell-extra">Angin: ${d.wind}</div></div>
                <div class="fv-cell"><div class="fv-cell-label">Kurs / USD</div><div class="fv-cell-val">${d.currency}</div><div class="fv-cell-extra">${d.currCode}</div></div>
            `;
        });

        document.getElementById('st-status').textContent='Synced ✓';
        document.getElementById('st-status').style.color='var(--fg)';
        document.getElementById('st-risk').textContent=riskCount?Math.round(totalRisk/riskCount):'—';
        document.getElementById('st-risk').style.color=riskCount?(totalRisk/riskCount>=60?'var(--fr)':totalRisk/riskCount>=35?'var(--fy)':'var(--fg)'):'var(--fm)';
        document.getElementById('st-time').textContent=new Date().toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'});

    }catch(e){
        document.getElementById('st-status').textContent='Error';
        document.getElementById('st-status').style.color='var(--fr)';
    }
}

document.addEventListener('DOMContentLoaded',renderFavs);
</script>
@endsection
