@extends('layouts.app')
@section('content')
<style>
.main-content{overflow-y:auto!important;height:100vh!important}
.content-inner{overflow:visible!important;height:auto!important}
:root{--cn:#0b1628;--cc:#1a2d4e;--cb:rgba(79,125,219,.18);--ca:#4f7ddb;--ct:#dce8f8;--cm:#8fadd4;--cg:#34d399;--cy:#fbbf24;--cr:#f87171;--cp:#a78bfa}
.cp{background:var(--cn);min-height:100%;padding-bottom:2rem}
.cp-hdr{background:linear-gradient(135deg,#0f2044,#0d1e3d);border-bottom:1px solid var(--cb);padding:1rem 1.5rem;margin:-1.25rem -1.5rem 1rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.5rem}
.cp-htl{font-size:1.05rem;font-weight:800;color:#fff}
.cp-hsub{font-size:.74rem;color:var(--cm);margin-top:2px}
.cp-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(79,125,219,.12);border:1px solid rgba(79,125,219,.25);border-radius:999px;padding:4px 12px;font-size:.65rem;font-weight:700;color:#7ba7ff}
/* Selector */
.sel-wrap{background:linear-gradient(145deg,#1a2d4e,#162240);border:1px solid var(--cb);border-radius:14px;padding:1rem;margin-bottom:1rem;display:flex;align-items:center;gap:12px;flex-wrap:wrap}
.sel-bx{flex:1;min-width:150px;background:rgba(255,255,255,.04);border:1px solid var(--cb);border-radius:10px;padding:10px 14px}
.sel-bx label{font-size:.55rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--cm);display:block;margin-bottom:4px}
.sel-bx select{width:100%;background:transparent;border:none;outline:none;color:#fff;font-size:.9rem;font-weight:700;cursor:pointer}
.sel-bx select option{background:#1e2d4a;color:#fff}
.vs-b{width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#ef4444,#f97316);display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:900;color:#fff;box-shadow:0 4px 14px rgba(239,68,68,.3);flex-shrink:0}
.btn-go{padding:10px 28px;border:none;border-radius:10px;background:linear-gradient(135deg,var(--ca),#3d5fc0);color:#fff;font-size:.82rem;font-weight:700;cursor:pointer;transition:all .2s;white-space:nowrap}
.btn-go:hover{filter:brightness(1.1);transform:translateY(-1px)}
.btn-go:disabled{opacity:.5;cursor:wait;transform:none}
/* Cards */
.gc{background:linear-gradient(145deg,#1a2d4e,#162240);border:1px solid var(--cb);border-radius:14px;padding:1rem;position:relative;overflow:hidden;height:100%}
.gc::before{content:'';position:absolute;inset:0;border-radius:14px;background:linear-gradient(135deg,rgba(79,125,219,.04),transparent 50%);pointer-events:none}
.gc-t{font-size:.7rem;font-weight:800;color:#fff;margin-bottom:.6rem;display:flex;align-items:center;gap:6px}
.gc-t i{color:var(--ca);font-size:.65rem}
.gc-sub{font-size:.58rem;color:var(--cm);font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:.5rem}
/* Chart containers */
.ch-area{position:relative;height:180px}
.ch-sm{position:relative;height:140px}
/* GDP Big numbers */
.gdp-row{display:flex;gap:1rem;margin-bottom:.75rem}
.gdp-box{flex:1;text-align:center}
.gdp-flag{font-size:.6rem;color:var(--cm);font-weight:600;margin-bottom:2px}
.gdp-val{font-size:1.4rem;font-weight:900;color:#fff}
.gdp-val.gdp-a{color:var(--ca)}.gdp-val.gdp-b{color:var(--cy)}
/* Risk gauge */
.rk-row{display:flex;gap:8px;margin-bottom:.5rem}
.rk-box{flex:1;background:rgba(255,255,255,.03);border:1px solid var(--cb);border-radius:8px;padding:8px;text-align:center}
.rk-score{font-size:1.6rem;font-weight:900;line-height:1}
.rk-label{font-size:.55rem;color:var(--cm);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-top:4px}
.rk-status{font-size:.6rem;font-weight:700;margin-top:2px}
/* Table */
.mk-tbl{width:100%;border-collapse:collapse;font-size:.72rem}
.mk-tbl th{text-align:left;color:var(--cm);font-weight:700;padding:6px 8px;border-bottom:1px solid var(--cb);font-size:.6rem;text-transform:uppercase;letter-spacing:.5px}
.mk-tbl td{padding:6px 8px;color:var(--ct);border-bottom:1px solid rgba(79,125,219,.06);font-weight:600}
.mk-tbl tr:hover td{background:rgba(79,125,219,.04)}
.mk-tbl .better{color:var(--cg)}
/* Bottom bar */
.bot-bar{display:flex;gap:10px;justify-content:center;margin-top:1rem;flex-wrap:wrap}
.btn-pdf{padding:10px 24px;border:none;border-radius:10px;background:linear-gradient(135deg,#0f2044,#162240);border:1px solid var(--cb);color:var(--ct);font-size:.78rem;font-weight:700;cursor:pointer;transition:all .2s}
.btn-pdf:hover{background:var(--ca);color:#fff}
.btn-detail{padding:10px 24px;border:none;border-radius:10px;background:linear-gradient(135deg,var(--ca),#3d5fc0);color:#fff;font-size:.78rem;font-weight:700;cursor:pointer;transition:all .2s}
.btn-detail:hover{filter:brightness(1.1)}
/* Loading */
.ld-overlay{position:absolute;inset:0;background:rgba(11,22,40,.85);display:flex;align-items:center;justify-content:center;border-radius:14px;z-index:5}
.empty-st{text-align:center;color:var(--cm);padding:2rem .5rem;font-size:.78rem}
.empty-st i{font-size:1.5rem;display:block;margin-bottom:8px;color:rgba(79,125,219,.25)}
@keyframes fadeIn{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:none}}
.fade-in{animation:fadeIn .4s ease both}
</style>

<div class="cp">
<div class="cp-hdr">
    <div>
        <div class="cp-htl"><i class="fa-solid fa-scale-balanced me-2" style="color:var(--ca)"></i>Analisis Perbandingan: <span id="hdr-a">Jerman</span> vs. <span id="hdr-b">Australia</span></div>
        <div class="cp-hsub"><i class="fa-solid fa-chart-column me-1"></i>Bandingkan dua negara secara komprehensif — GDP, Inflasi, Risiko</div>
    </div>
    <div class="cp-badge"><i class="fa-solid fa-database"></i>Real-time Multi-API Analysis</div>
</div>

{{-- SELECTOR --}}
<div class="sel-wrap">
    <div class="sel-bx"><label><i class="fa-solid fa-flag me-1"></i>Negara Pertama</label>
        <select id="cmp-a">@foreach($countriesList as $c)<option value="{{$c}}" {{$c=='Germany'?'selected':''}}>{{$c}}</option>@endforeach</select>
    </div>
    <div class="vs-b">VS</div>
    <div class="sel-bx"><label><i class="fa-solid fa-flag me-1"></i>Negara Kedua</label>
        <select id="cmp-b">@foreach($countriesList as $c)<option value="{{$c}}" {{$c=='Australia'?'selected':''}}>{{$c}}</option>@endforeach</select>
    </div>
    <button id="btn-cmp" class="btn-go" onclick="runCompare()"><i class="fa-solid fa-bolt me-1"></i>Bandingkan</button>
</div>

{{-- ROW 1: GDP, Inflasi, Risk Score, Weather+Currency --}}
<div class="row g-3 mb-3" id="row1">
    <div class="col-lg-3"><div class="gc" id="card-gdp">
        <div class="gc-t"><i class="fa-solid fa-money-bill-trend-up"></i>PDB (GDP) Komprehensif</div>
        <div class="gdp-row"><div class="gdp-box"><div class="gdp-flag" id="gdp-la">—</div><div class="gdp-val gdp-a" id="gdp-va">—</div></div><div class="gdp-box"><div class="gdp-flag" id="gdp-lb">—</div><div class="gdp-val gdp-b" id="gdp-vb">—</div></div></div>
        <div class="ch-sm"><canvas id="chGdp"></canvas></div>
    </div></div>
    <div class="col-lg-3"><div class="gc" id="card-inf">
        <div class="gc-t"><i class="fa-solid fa-arrow-trend-up"></i>Inflasi & Suku Bunga</div>
        <div class="gc-sub">Annual Inflation (%)</div>
        <div class="ch-area"><canvas id="chInf"></canvas></div>
    </div></div>
    <div class="col-lg-3"><div class="gc" id="card-risk">
        <div class="gc-t"><i class="fa-solid fa-shield-halved"></i>Skor Risiko Negara</div>
        <div class="gc-sub">Country Risk Score</div>
        <div class="rk-row">
            <div class="rk-box"><div class="rk-score" id="rk-sa" style="color:var(--cg)">—</div><div class="rk-label" id="rk-la">—</div><div class="rk-status" id="rk-sta">—</div></div>
            <div class="rk-box"><div class="rk-score" id="rk-sb" style="color:var(--cy)">—</div><div class="rk-label" id="rk-lb">—</div><div class="rk-status" id="rk-stb">—</div></div>
        </div>
        <div class="ch-sm"><canvas id="chRisk"></canvas></div>
    </div></div>
    <div class="col-lg-3"><div class="gc" id="card-wx">
        <div class="gc-t"><i class="fa-solid fa-cloud-sun"></i>Cuaca & Iklim</div>
        <div class="rk-row">
            <div class="rk-box"><div class="rk-score" id="wx-ta" style="color:var(--ca);font-size:1.1rem">—</div><div class="rk-label" id="wx-la">—</div></div>
            <div class="rk-box"><div class="rk-score" id="wx-tb" style="color:var(--cy);font-size:1.1rem">—</div><div class="rk-label" id="wx-lb">—</div></div>
        </div>
        <div class="gc-t" style="margin-top:.5rem"><i class="fa-solid fa-coins"></i>Mata Uang & Nilai Tukar</div>
        <div class="rk-row">
            <div class="rk-box"><div class="rk-score" id="cur-va" style="color:var(--ca);font-size:.9rem">—</div><div class="rk-label" id="cur-la">—</div></div>
            <div class="rk-box"><div class="rk-score" id="cur-vb" style="color:var(--cy);font-size:.9rem">—</div><div class="rk-label" id="cur-lb">—</div></div>
        </div>
        <div class="gc-t" style="margin-top:.5rem"><i class="fa-solid fa-wind"></i>Wind Speed</div>
        <div class="rk-row">
            <div class="rk-box"><div class="rk-score" id="wn-va" style="color:var(--ca);font-size:.9rem">—</div><div class="rk-label" id="wn-la">—</div></div>
            <div class="rk-box"><div class="rk-score" id="wn-vb" style="color:var(--cy);font-size:.9rem">—</div><div class="rk-label" id="wn-lb">—</div></div>
        </div>
    </div></div>
</div>

{{-- ROW 2: Risk Breakdown, Table, Radar, Summary --}}
<div class="row g-3 mb-3" id="row2">
    <div class="col-lg-3"><div class="gc">
        <div class="gc-t"><i class="fa-solid fa-chart-bar"></i>Risk Breakdown (per Dimensi)</div>
        <div class="ch-area"><canvas id="chBreak"></canvas></div>
    </div></div>
    <div class="col-lg-3"><div class="gc">
        <div class="gc-t"><i class="fa-solid fa-table"></i>Indeks Makroekonomi Lainnya</div>
        <table class="mk-tbl" id="mk-tbl">
            <thead><tr><th>Indeks</th><th id="th-a">A</th><th id="th-b">B</th></tr></thead>
            <tbody id="mk-body"><tr><td colspan="3" class="empty-st"><i class="fa-solid fa-table"></i>Menunggu perbandingan...</td></tr></tbody>
        </table>
    </div></div>
    <div class="col-lg-3"><div class="gc">
        <div class="gc-t"><i class="fa-solid fa-spider"></i>Radar Risk Overlay</div>
        <div class="ch-area"><canvas id="chRadar"></canvas></div>
        <div style="display:flex;gap:1rem;justify-content:center;margin-top:6px">
            <span style="font-size:.6rem;color:var(--cm);display:flex;align-items:center;gap:4px"><span style="width:8px;height:8px;border-radius:50%;background:var(--ca)"></span><span id="leg-a">A</span></span>
            <span style="font-size:.6rem;color:var(--cm);display:flex;align-items:center;gap:4px"><span style="width:8px;height:8px;border-radius:50%;background:var(--cy)"></span><span id="leg-b">B</span></span>
        </div>
    </div></div>
    <div class="col-lg-3"><div class="gc">
        <div class="gc-t"><i class="fa-solid fa-gauge-high"></i>Quick Summary</div>
        <div id="sum-area"><div class="empty-st"><i class="fa-solid fa-chart-pie"></i>Menunggu perbandingan...</div></div>
    </div></div>
</div>

{{-- BOTTOM --}}
<div class="bot-bar">
    <button class="btn-pdf" onclick="window.print()"><i class="fa-solid fa-file-pdf me-1"></i>Unduh Laporan Komprehensif (PDF)</button>
    <button class="btn-detail" onclick="runCompare()"><i class="fa-solid fa-rotate me-1"></i>Refresh Perbandingan</button>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let charts = {};
const cA = '#4f7ddb', cB = '#fbbf24';

function destroyChart(k){if(charts[k]){charts[k].destroy();delete charts[k];}}
function mkChart(id,cfg){destroyChart(id);charts[id]=new Chart(document.getElementById(id),cfg);return charts[id];}

const baseOpts = {responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false},tooltip:{backgroundColor:'#0f172a',borderColor:'rgba(79,125,219,.4)',borderWidth:1,padding:10,cornerRadius:8,bodyFont:{size:12,weight:'700',family:'Inter'}}},animation:{duration:600,easing:'easeOutQuart'}};
const scaleOpts = {x:{grid:{color:'rgba(79,125,219,.06)'},ticks:{color:'#8fadd4',font:{size:9,weight:'600'}}},y:{grid:{color:'rgba(79,125,219,.08)'},ticks:{color:'#8fadd4',font:{size:9,weight:'600'}}}};

async function runCompare(){
    const a=document.getElementById('cmp-a').value, b=document.getElementById('cmp-b').value;
    const btn=document.getElementById('btn-cmp');
    if(a===b){alert('Pilih dua negara yang berbeda!');return;}
    btn.disabled=true;btn.innerHTML='<span class="spinner-border spinner-border-sm me-1"></span>Loading...';

    try{
        const res=await fetch(`/api/compare/dual?countryA=${encodeURIComponent(a)}&countryB=${encodeURIComponent(b)}`);
        const json=await res.json();
        if(!json.success) throw new Error(json.message);
        render(json.data);
    }catch(e){alert('Error: '+e.message);}
    finally{btn.disabled=false;btn.innerHTML='<i class="fa-solid fa-bolt me-1"></i>Bandingkan';}
}

function render(d){
    const A=d.countryA, B=d.countryB, an=d.analysis;
    // Header
    document.getElementById('hdr-a').textContent=A.country;
    document.getElementById('hdr-b').textContent=B.country;

    // GDP
    document.getElementById('gdp-la').textContent=A.country;
    document.getElementById('gdp-lb').textContent=B.country;
    document.getElementById('gdp-va').textContent=A.gdp;
    document.getElementById('gdp-vb').textContent=B.gdp;
    mkChart('chGdp',{type:'bar',data:{labels:[A.country,B.country],datasets:[{data:[parseGdp(A.gdp),parseGdp(B.gdp)],backgroundColor:[cA+'cc',cB+'cc'],borderRadius:6,borderSkipped:false,barPercentage:.6}]},options:{...baseOpts,scales:{...scaleOpts,y:{...scaleOpts.y,ticks:{...scaleOpts.y.ticks,callback:v=>'$'+v+'T'}}}}});

    // Inflation
    const infA=parseFloat(A.inflation)||0, infB=parseFloat(B.inflation)||0;
    mkChart('chInf',{type:'bar',data:{labels:[A.country,B.country],datasets:[{label:'Inflation %',data:[infA,infB],backgroundColor:[cA+'cc',cB+'cc'],borderRadius:6,barPercentage:.5}]},options:{...baseOpts,indexAxis:'y',scales:{x:{grid:{color:'rgba(79,125,219,.08)'},ticks:{color:'#8fadd4',font:{size:9},callback:v=>v+'%'}},y:{grid:{display:false},ticks:{color:'#fff',font:{size:11,weight:'700'}}}}}});

    // Risk
    const rA=A.risk, rB=B.risk;
    document.getElementById('rk-sa').textContent=rA.score;
    document.getElementById('rk-sb').textContent=rB.score;
    document.getElementById('rk-la').textContent=A.country;
    document.getElementById('rk-lb').textContent=B.country;
    const rc=s=>s>=60?'var(--cr)':s>=35?'var(--cy)':'var(--cg)';
    document.getElementById('rk-sa').style.color=rc(rA.score);
    document.getElementById('rk-sb').style.color=rc(rB.score);
    document.getElementById('rk-sta').innerHTML=`<span style="color:${rc(rA.score)}">${rA.status}</span>`;
    document.getElementById('rk-stb').innerHTML=`<span style="color:${rc(rB.score)}">${rB.status}</span>`;
    mkChart('chRisk',{type:'bar',data:{labels:[A.country,B.country],datasets:[{data:[rA.score,rB.score],backgroundColor:[rc(rA.score).replace('var(--cr)','#f87171').replace('var(--cy)','#fbbf24').replace('var(--cg)','#34d399'),rc(rB.score).replace('var(--cr)','#f87171').replace('var(--cy)','#fbbf24').replace('var(--cg)','#34d399')],borderRadius:6,barPercentage:.5}]},options:{...baseOpts,scales:{...scaleOpts,y:{...scaleOpts.y,max:100}}}});

    // Weather & Currency
    document.getElementById('wx-ta').textContent=A.weather;
    document.getElementById('wx-tb').textContent=B.weather;
    document.getElementById('wx-la').textContent=A.country;
    document.getElementById('wx-lb').textContent=B.country;
    document.getElementById('cur-va').textContent=A.currency+' '+A.currCode;
    document.getElementById('cur-vb').textContent=B.currency+' '+B.currCode;
    document.getElementById('cur-la').textContent=A.country;
    document.getElementById('cur-lb').textContent=B.country;
    document.getElementById('wn-va').textContent=A.wind;
    document.getElementById('wn-vb').textContent=B.wind;
    document.getElementById('wn-la').textContent=A.country;
    document.getElementById('wn-lb').textContent=B.country;

    // Breakdown
    const bdA=rA.breakdown, bdB=rB.breakdown;
    mkChart('chBreak',{type:'bar',data:{labels:['Weather','News','Inflation','Currency'],datasets:[{label:A.country,data:[bdA.weather,bdA.news,bdA.inflation,bdA.currency],backgroundColor:cA+'aa',borderRadius:4,barPercentage:.4},{label:B.country,data:[bdB.weather,bdB.news,bdB.inflation,bdB.currency],backgroundColor:cB+'aa',borderRadius:4,barPercentage:.4}]},options:{...baseOpts,plugins:{...baseOpts.plugins,legend:{display:true,labels:{color:'#8fadd4',font:{size:9,weight:'600'},boxWidth:8,boxHeight:8}}},scales:{...scaleOpts,y:{...scaleOpts.y,max:100}}}});

    // Table
    document.getElementById('th-a').textContent=A.country;
    document.getElementById('th-b').textContent=B.country;
    const rows=[
        ['GDP',A.gdp,B.gdp,'text'],
        ['Inflation',A.inflation+'%',B.inflation+'%','lower',parseFloat(A.inflation),parseFloat(B.inflation)],
        ['Risk Score',rA.score+' pts',rB.score+' pts','lower',rA.score,rB.score],
        ['Temperature',A.weather,B.weather,'text'],
        ['Currency/USD',A.currency+' '+A.currCode,B.currency+' '+B.currCode,'text'],
        ['Wind Speed',A.wind,B.wind,'text']
    ];
    document.getElementById('mk-body').innerHTML=rows.map(r=>{
        let ca='',cb='';
        if(r[3]==='lower'&&!isNaN(r[4])&&!isNaN(r[5])){if(r[4]<r[5])ca='better';else if(r[5]<r[4])cb='better';}
        return `<tr><td style="color:#fff;font-weight:700">${r[0]}</td><td class="${ca}">${r[1]}</td><td class="${cb}">${r[2]}</td></tr>`;
    }).join('');

    // Radar
    document.getElementById('leg-a').textContent=A.country;
    document.getElementById('leg-b').textContent=B.country;
    mkChart('chRadar',{type:'radar',data:{labels:['Weather (30%)','News (40%)','Inflation (20%)','Currency (10%)'],datasets:[{label:A.country,data:[bdA.weather,bdA.news,bdA.inflation,bdA.currency],backgroundColor:'rgba(79,125,219,.18)',borderColor:cA,borderWidth:2,pointBackgroundColor:cA,pointRadius:4},{label:B.country,data:[bdB.weather,bdB.news,bdB.inflation,bdB.currency],backgroundColor:'rgba(251,191,36,.12)',borderColor:cB,borderWidth:2,pointBackgroundColor:cB,pointRadius:4}]},options:{responsive:true,maintainAspectRatio:false,scales:{r:{min:0,max:100,angleLines:{color:'rgba(79,125,219,.1)'},grid:{color:'rgba(79,125,219,.08)'},pointLabels:{font:{size:9,weight:'600'},color:'#8fadd4'},ticks:{display:false}}},plugins:{legend:{display:false},tooltip:baseOpts.plugins.tooltip},animation:baseOpts.animation}});

    // Summary
    document.getElementById('sum-area').innerHTML=`
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
        <div class="rk-box"><div class="rk-label">Selisih Risk</div><div class="rk-score" style="color:${an.risk_difference>20?'var(--cr)':'var(--cg)'}; font-size:1.3rem">${an.risk_difference} <span style="font-size:.6rem">pts</span></div></div>
        <div class="rk-box"><div class="rk-label">Negara Lebih Aman</div><div style="font-size:.85rem;font-weight:800;color:var(--cg);margin-top:4px">${an.safer_country}</div></div>
        <div class="rk-box"><div class="rk-label">${A.country}</div><div class="rk-score" style="color:${rc(rA.score)};font-size:1.3rem">${rA.score}</div><div class="rk-status" style="color:${rc(rA.score)}">${rA.status}</div></div>
        <div class="rk-box"><div class="rk-label">${B.country}</div><div class="rk-score" style="color:${rc(rB.score)};font-size:1.3rem">${rB.score}</div><div class="rk-status" style="color:${rc(rB.score)}">${rB.status}</div></div>
    </div>
    ${an.better_inflation?`<div style="margin-top:8px;padding:8px 10px;background:rgba(52,211,153,.08);border:1px solid rgba(52,211,153,.15);border-radius:8px;font-size:.68rem;color:var(--cg);font-weight:600"><i class="fa-solid fa-check-circle me-1"></i>Inflasi lebih stabil: <strong>${an.better_inflation}</strong></div>`:''}`;
}

function parseGdp(v){
    if(typeof v!=='string')return 0;
    const n=parseFloat(v.replace(/[^0-9.]/g,''));
    if(v.includes('T'))return n;if(v.includes('B'))return n/1000;if(v.includes('M'))return n/1000000;return n;
}

// Auto-run on load
document.addEventListener('DOMContentLoaded',()=>runCompare());
</script>
@endsection
