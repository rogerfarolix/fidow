<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Statistiques — Fidow</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cabinet+Grotesk:wght@400;700;800;900&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
:root{--bg:#080606;--s1:#0f0a0a;--s2:#170e0e;--accent:#872323;--gold:#e8a030;--green:#2ef0a0;--text:#f4eded;--text2:#c8b8b8;--muted:#6b5757;--border:rgba(135,35,35,.2);--border2:rgba(255,255,255,.05)}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text);min-height:100vh}
body::before{content:'';position:fixed;inset:0;background:radial-gradient(ellipse 70% 45% at 15% 0%,rgba(135,35,35,.12) 0%,transparent 65%);pointer-events:none;z-index:0}
.noise{position:fixed;inset:0;pointer-events:none;z-index:0;opacity:.025;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");background-size:256px}

/* NAV */
.fidow-nav{position:sticky;top:0;z-index:100;backdrop-filter:blur(24px);-webkit-backdrop-filter:blur(24px);background:rgba(8,6,6,.7);border-bottom:1px solid rgba(135,35,35,.12);padding:0 28px}
.nav-inner{max-width:1100px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;height:64px;gap:24px}
.nav-logo{display:flex;align-items:center;gap:10px;text-decoration:none}
.nav-logo img{height:30px;width:auto}
.nav-links a{color:var(--muted);text-decoration:none;font-size:13px;font-weight:500;padding:7px 13px;border-radius:8px;transition:all .2s}
.nav-links a:hover{color:var(--text);background:rgba(135,35,35,.1)}

.wrap{position:relative;z-index:1;max-width:1100px;margin:0 auto;padding:56px 28px 100px}
.page-header{margin-bottom:44px}
.page-tag{display:inline-block;background:rgba(135,35,35,.1);border:1px solid rgba(135,35,35,.22);border-radius:100px;padding:4px 14px;font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#d47070;margin-bottom:12px}
h1{font-family:'Cabinet Grotesk',sans-serif;font-size:clamp(28px,5vw,44px);font-weight:900;letter-spacing:-.03em;margin-bottom:6px}
.page-sub{color:var(--muted);font-size:15px}

/* KPIs */
.kpi-row{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:14px;margin-bottom:36px}
.kpi{background:var(--s1);border:1px solid var(--border);border-radius:16px;padding:24px 22px;position:relative;overflow:hidden;transition:border-color .25s}
.kpi::before{content:'';position:absolute;inset:0;opacity:0;transition:opacity .3s}
.kpi:hover{border-color:rgba(135,35,35,.4)}
.kpi:hover::before{opacity:1}
.kpi-num{font-family:'Cabinet Grotesk',sans-serif;font-size:40px;font-weight:900;display:block;line-height:1;margin-bottom:6px}
.kpi-lbl{font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:.07em}

/* GRID */
.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:18px}
.card{background:var(--s1);border:1px solid var(--border);border-radius:16px;padding:26px}
.card-full{grid-column:1/-1}
.card-title{font-family:'Cabinet Grotesk',sans-serif;font-size:15px;font-weight:800;margin-bottom:18px;display:flex;align-items:center;gap:8px;color:var(--text)}

/* BARS */
.bar-row{display:flex;align-items:center;gap:12px;margin-bottom:11px}
.bar-label{font-size:13px;color:var(--text);min-width:150px;max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.bar-track{flex:1;height:7px;background:var(--s2);border-radius:4px;overflow:hidden}
.bar-fill{height:100%;border-radius:4px;background:linear-gradient(90deg,var(--accent),#c43030);transition:width .9s ease}
.bar-fill-green{background:linear-gradient(90deg,var(--green),#1dd4a0)}
.bar-count{font-size:12px;color:var(--muted);min-width:36px;text-align:right}

/* DAY CHART */
.day-chart{display:flex;align-items:flex-end;gap:3px;height:80px;padding-top:8px}
.day-bar{flex:1;background:rgba(135,35,35,.3);border-radius:3px 3px 0 0;transition:background .2s;min-width:3px;position:relative;cursor:pointer}
.day-bar:hover{background:var(--accent)}
.day-bar[title]:hover::after{content:attr(title);position:absolute;bottom:calc(100% + 4px);left:50%;transform:translateX(-50%);background:var(--s2);border:1px solid var(--border);border-radius:6px;padding:3px 8px;font-size:11px;white-space:nowrap;color:var(--text);z-index:10;pointer-events:none}
.chart-axis{display:flex;justify-content:space-between;margin-top:6px}
.chart-axis span{font-size:11px;color:var(--muted)}

/* CHIPS */
.chip-list{display:flex;flex-wrap:wrap;gap:8px}
.chip{padding:7px 14px;background:var(--s2);border:1px solid var(--border2);border-radius:100px;font-size:13px;color:var(--muted);transition:border-color .2s}
.chip:hover{border-color:var(--border)}
.chip b{color:var(--text);font-weight:600}

@keyframes rise{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:none}}
.rise{animation:rise .7s cubic-bezier(.22,1,.36,1) both}
.rise-2{animation:rise .7s .1s cubic-bezier(.22,1,.36,1) both}

@media(max-width:640px){
    .grid-2{grid-template-columns:1fr}
    .bar-label{min-width:110px;max-width:110px}
    .kpi-row{grid-template-columns:1fr 1fr}
}
</style>
</head>
<body>
<div class="noise"></div>

<nav class="fidow-nav">
    <div class="nav-inner">
        <a href="{{ route('home') }}" class="nav-logo">
            <img src="{{ asset('assets/logo.png') }}" alt="Fidow">
        </a>
        <div class="nav-links" style="display:flex;gap:4px">
            <a href="{{ route('home') }}">Accueil</a>
            <a href="{{ route('positionnement') }}">Outils</a>
        </div>
    </div>
</nav>

<div class="wrap">
    <div class="page-header rise">
        <div class="page-tag">Données en temps réel</div>
        <h1>Statistiques publiques</h1>
        <p class="page-sub">Tableau de bord de l'utilisation des outils Fidow.</p>
    </div>

    {{-- KPIs --}}
    <div class="kpi-row rise">
        <div class="kpi">
            <span class="kpi-num" style="color:var(--green)">{{ number_format($uniqueUsers) }}</span>
            <div class="kpi-lbl">Utilisateurs uniques</div>
        </div>
        <div class="kpi">
            <span class="kpi-num" style="color:#d47070">{{ number_format($totalGenerations) }}</span>
            <div class="kpi-lbl">Phrases générées</div>
        </div>
        <div class="kpi">
            <span class="kpi-num" style="color:var(--gold)">{{ $retentionRate }}%</span>
            <div class="kpi-lbl">Taux de rétention</div>
        </div>
        <div class="kpi">
            <span class="kpi-num" style="color:#8ab4ff">{{ $usagesByTool->count() }}</span>
            <div class="kpi-lbl">Outils actifs</div>
        </div>
    </div>

    <div class="grid-2 rise-2">
        {{-- Usages par outil --}}
        <div class="card">
            <div class="card-title">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="#d47070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Usages par outil
            </div>
            @php $maxTool = $usagesByTool->max('total') ?: 1; @endphp
            @foreach($usagesByTool as $u)
            <div class="bar-row">
                <div class="bar-label">{{ ucfirst($u->tool_slug) }}</div>
                <div class="bar-track">
                    <div class="bar-fill" style="width:{{ ($u->total / $maxTool) * 100 }}%"></div>
                </div>
                <div class="bar-count">{{ $u->total }}</div>
            </div>
            @endforeach
        </div>

        {{-- Top métiers --}}
        <div class="card">
            <div class="card-title">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" stroke="#d47070" stroke-width="1.5"/><path d="M4 20c0-4 3.58-7 8-7s8 3 8 7" stroke="#d47070" stroke-width="1.5" stroke-linecap="round"/></svg>
                Top métiers
            </div>
            @php $maxMetier = $topMetiers->max('total') ?: 1; @endphp
            @foreach($topMetiers as $m)
            <div class="bar-row">
                <div class="bar-label">{{ $m->metier }}</div>
                <div class="bar-track">
                    <div class="bar-fill bar-fill-green" style="width:{{ ($m->total / $maxMetier) * 100 }}%"></div>
                </div>
                <div class="bar-count">{{ $m->total }}</div>
            </div>
            @endforeach
        </div>

        {{-- Activité 30j --}}
        <div class="card card-full">
            <div class="card-title">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12" stroke="#d47070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Activité — 30 derniers jours
            </div>
            @php $maxDay = $usagesPerDay->max('total') ?: 1; @endphp
            <div class="day-chart">
                @foreach($usagesPerDay as $d)
                <div class="day-bar"
                     style="height:{{ max(4, ($d->total / $maxDay) * 80) }}px"
                     title="{{ $d->day }} : {{ $d->total }} utilisations">
                </div>
                @endforeach
            </div>
            <div class="chart-axis">
                <span>{{ now()->subDays(30)->format('d M') }}</span>
                <span>Aujourd'hui</span>
            </div>
        </div>

        {{-- Tons préférés --}}
        <div class="card card-full">
            <div class="card-title">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z" stroke="#e8a030" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Tons les plus choisis
            </div>
            <div class="chip-list">
                @foreach($topTons as $t)
                <div class="chip"><b>{{ $t->ton }}</b> &nbsp;— {{ $t->total }}×</div>
                @endforeach
            </div>
        </div>
    </div>

    <div style="text-align:center;margin-top:8px">
        <a href="{{ route('positionnement') }}" style="color:var(--muted);font-size:13px;text-decoration:none;transition:color .2s" onmouseover="this.style.color='#f4eded'" onmouseout="this.style.color='var(--muted)'">← Retour aux outils</a>
    </div>
</div>
</body>
</html>
