@extends('layouts.app')

@section('title', 'Statistiques - Fidow')

@section('content')
<div class="fst-page">

    <!-- BG deco -->
    <div class="fst-bg" aria-hidden="true">
        <canvas id="statCanvas"></canvas>
        <div class="fst-ring fst-ring--1"></div>
        <div class="fst-ring fst-ring--2"></div>
        <div class="fst-blob fst-blob--1"></div>
        <div class="fst-blob fst-blob--2"></div>
    </div>

    <div class="fst-container">

        <!-- HEADER -->
        <header class="fst-header" data-reveal>

            <nav class="fst-breadcrumb">
                <a href="{{ route('home') }}">Accueil</a>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
                <span>Statistiques</span>
            </nav>

            <div class="fst-badge">
                <span class="fst-badge__dot"></span>
                Données en temps réel
            </div>

            <h1 class="fst-header__title">
                Tableau de bord
                <span>public</span>
            </h1>
            <p class="fst-header__sub">
                Utilisation transparente de la suite Fidow — données anonymisées, mises à jour à chaque visite.
            </p>
        </header>

        <!-- KPI ROW -->
        <div class="fst-kpi-row" data-reveal data-reveal-delay="1">

            <div class="fst-kpi fst-kpi--primary">
                <div class="fst-kpi__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div>
                    <div class="fst-kpi__num" data-count="{{ $uniqueUsers }}">0</div>
                    <div class="fst-kpi__lbl">Utilisateurs uniques</div>
                </div>
            </div>

            <div class="fst-kpi">
                <div class="fst-kpi__icon fst-kpi__icon--red">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                </div>
                <div>
                    <div class="fst-kpi__num fst-kpi__num--red" data-count="{{ $totalGenerations }}">0</div>
                    <div class="fst-kpi__lbl">Phrases générées</div>
                </div>
            </div>

            <div class="fst-kpi">
                <div class="fst-kpi__icon fst-kpi__icon--amber">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                    </svg>
                </div>
                <div>
                    <div class="fst-kpi__num fst-kpi__num--amber">{{ $retentionRate }}%</div>
                    <div class="fst-kpi__lbl">Taux de rétention</div>
                </div>
            </div>

            <div class="fst-kpi">
                <div class="fst-kpi__icon fst-kpi__icon--blue">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="2" y="3" width="20" height="14" rx="2"/>
                        <path d="M8 21h8M12 17v4"/>
                    </svg>
                </div>
                <div>
                    <div class="fst-kpi__num fst-kpi__num--blue">{{ $usagesByTool->count() }}</div>
                    <div class="fst-kpi__lbl">Outils actifs</div>
                </div>
            </div>

        </div>

        <!-- GRID -->
        <div class="fst-grid">

            <!-- Usages par outil -->
            <div class="fst-card" data-reveal>
                <div class="fst-card__head">
                    <div class="fst-card__icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                        </svg>
                    </div>
                    <div>
                        <div class="fst-eyebrow">Répartition</div>
                        <h2>Usages par outil</h2>
                    </div>
                </div>

                @php $maxTool = $usagesByTool->max('total') ?: 1; @endphp

                <div class="fst-bars">
                    @foreach($usagesByTool as $i => $u)
                    <div class="fst-bar-row" style="--delay:{{ $i * 80 }}ms">
                        <div class="fst-bar-label">{{ ucfirst($u->tool_slug) }}</div>
                        <div class="fst-bar-track">
                            <div class="fst-bar-fill fst-bar-fill--red"
                                 style="--w:{{ ($u->total / $maxTool) * 100 }}%;width:0"
                                 data-width="{{ ($u->total / $maxTool) * 100 }}">
                            </div>
                        </div>
                        <div class="fst-bar-count">{{ number_format($u->total) }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Top métiers -->
            <div class="fst-card" data-reveal data-reveal-delay="1">
                <div class="fst-card__head">
                    <div class="fst-card__icon fst-card__icon--green">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M4 20c0-4 3.58-7 8-7s8 3 8 7"/>
                        </svg>
                    </div>
                    <div>
                        <div class="fst-eyebrow">Profils</div>
                        <h2>Top métiers</h2>
                    </div>
                </div>

                @php $maxMetier = $topMetiers->max('total') ?: 1; @endphp

                <div class="fst-bars">
                    @foreach($topMetiers as $i => $m)
                    <div class="fst-bar-row" style="--delay:{{ $i * 80 }}ms">
                        <div class="fst-bar-label">{{ $m->metier }}</div>
                        <div class="fst-bar-track">
                            <div class="fst-bar-fill fst-bar-fill--green"
                                 data-width="{{ ($m->total / $maxMetier) * 100 }}"
                                 style="width:0">
                            </div>
                        </div>
                        <div class="fst-bar-count">{{ number_format($m->total) }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Activité 30 jours — full width -->
            <div class="fst-card fst-card--full" data-reveal>
                <div class="fst-card__head">
                    <div class="fst-card__icon fst-card__icon--blue">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                        </svg>
                    </div>
                    <div>
                        <div class="fst-eyebrow">Tendance</div>
                        <h2>Activité — 30 derniers jours</h2>
                    </div>
                </div>

                @php $maxDay = $usagesPerDay->max('total') ?: 1; @endphp

                <div class="fst-chart">
                    <div class="fst-chart__grid" aria-hidden="true">
                        <span></span><span></span><span></span><span></span>
                    </div>
                    <div class="fst-chart__bars">
                        @foreach($usagesPerDay as $i => $d)
                        <div class="fst-chart__bar-wrap" title="{{ $d->day }} : {{ $d->total }} utilisation(s)">
                            <div class="fst-chart__bar"
                                 data-height="{{ max(2, ($d->total / $maxDay) * 100) }}"
                                 style="height:2%">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="fst-chart__axis">
                        <span>{{ now()->subDays(30)->format('d M') }}</span>
                        <span>Aujourd'hui</span>
                    </div>
                </div>

                <!-- Metric row under chart -->
                <div class="fst-chart__metrics">
                    @php
                        $totalLast7  = $usagesPerDay->take(-7)->sum('total');
                        $totalPrev7  = $usagesPerDay->slice(-14, 7)->sum('total');
                        $delta       = $totalPrev7 > 0 ? round((($totalLast7 - $totalPrev7) / $totalPrev7) * 100) : 0;
                    @endphp
                    <div class="fst-chart__metric">
                        <strong>{{ number_format($totalLast7) }}</strong>
                        <span>7 derniers jours</span>
                    </div>
                    <div class="fst-chart__metric">
                        <strong class="{{ $delta >= 0 ? 'fst-up' : 'fst-down' }}">
                            {{ $delta >= 0 ? '+' : '' }}{{ $delta }}%
                        </strong>
                        <span>vs semaine précédente</span>
                    </div>
                    <div class="fst-chart__metric">
                        <strong>{{ number_format($usagesPerDay->sum('total')) }}</strong>
                        <span>Total 30 jours</span>
                    </div>
                </div>
            </div>

            <!-- Tons préférés -->
            <div class="fst-card fst-card--full" data-reveal>
                <div class="fst-card__head">
                    <div class="fst-card__icon fst-card__icon--amber">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="fst-eyebrow">Préférences</div>
                        <h2>Tons les plus choisis</h2>
                    </div>
                </div>

                @php $maxTon = $topTons->max('total') ?: 1; @endphp

                <div class="fst-tons-grid">
                    @foreach($topTons as $i => $t)
                    <div class="fst-ton-card" style="--delay:{{ $i * 60 }}ms">
                        <div class="fst-ton-card__top">
                            <span class="fst-ton-card__rank">#{{ $i + 1 }}</span>
                            <span class="fst-ton-card__name">{{ $t->ton }}</span>
                        </div>
                        <div class="fst-ton-card__bar-track">
                            <div class="fst-ton-card__bar-fill"
                                 data-width="{{ ($t->total / $maxTon) * 100 }}"
                                 style="width:0">
                            </div>
                        </div>
                        <div class="fst-ton-card__count">{{ number_format($t->total) }} <small>utilisations</small></div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- FOOTER NAV -->
        <div class="fst-footer-nav" data-reveal>
            <a href="{{ route('home') }}" class="fst-nav-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 5l-7 7 7 7"/>
                </svg>
                Accueil
            </a>
            <a href="{{ route('positionnement') }}" class="fst-nav-link fst-nav-link--primary">
                Essayer un outil
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
:root{
    --f-red:#872323;
    --f-red-rgb:135,35,35;
    --f-ease:cubic-bezier(.16,1,.3,1);
}

[data-reveal]{opacity:0;transform:translateY(26px);transition:opacity .65s var(--f-ease),transform .65s var(--f-ease)}
[data-reveal].is-visible{opacity:1;transform:translateY(0)}
[data-reveal-delay="1"]{transition-delay:.1s}
[data-reveal-delay="2"]{transition-delay:.2s}

/* ── PAGE ─────────────────────────────────── */
.fst-page{
    min-height:100vh;
    background:#fff;
    position:relative;
    overflow:hidden;
    padding-bottom:4rem;
}

/* ── BG ───────────────────────────────────── */
.fst-bg{
    position:fixed;
    inset:0;
    pointer-events:none;
    z-index:0;
}
#statCanvas{
    position:absolute;
    inset:0;
    width:100%;
    height:100%;
}
.fst-ring{
    position:absolute;
    border-radius:50%;
    border:1px solid rgba(135,35,35,.07);
    left:50%;top:40%;
    transform:translate(-50%,-50%);
    animation:fstRingPulse 10s ease-in-out infinite;
}
.fst-ring--1{width:900px;height:900px;}
.fst-ring--2{width:600px;height:600px;animation-delay:2s;border-color:rgba(135,35,35,.05);}
@keyframes fstRingPulse{
    0%,100%{transform:translate(-50%,-50%) scale(1);opacity:.5}
    50%{transform:translate(-50%,-50%) scale(1.03);opacity:1}
}
.fst-blob{
    position:absolute;
    border-radius:50%;
    filter:blur(100px);
    pointer-events:none;
}
.fst-blob--1{
    width:500px;height:280px;
    background:radial-gradient(ellipse,rgba(135,35,35,.09) 0%,transparent 70%);
    top:-60px;left:50%;transform:translateX(-50%);
}
.fst-blob--2{
    width:340px;height:340px;
    background:radial-gradient(circle,rgba(135,35,35,.06) 0%,transparent 70%);
    bottom:5%;right:-60px;
}

/* ── CONTAINER ────────────────────────────── */
.fst-container{
    position:relative;
    z-index:2;
    max-width:1180px;
    margin:0 auto;
    padding:0 1.5rem;
}

/* ── HEADER ───────────────────────────────── */
.fst-header{
    text-align:center;
    padding:4.5rem 0 2rem;
}
.fst-breadcrumb{
    display:inline-flex;align-items:center;gap:.4rem;
    font-size:.88rem;color:#9ca3af;margin-bottom:1.1rem;
}
.fst-breadcrumb a{
    color:#6b7280;text-decoration:none;
    transition:color .2s;
}
.fst-breadcrumb a:hover{color:var(--f-red);}
.fst-breadcrumb span{color:var(--f-red);font-weight:700;}

.fst-badge{
    display:inline-flex;align-items:center;gap:.5rem;
    padding:.42rem .9rem;border-radius:999px;
    background:rgba(135,35,35,.07);
    border:1px solid rgba(135,35,35,.14);
    color:var(--f-red);font-size:.78rem;font-weight:700;
    margin-bottom:1.1rem;
}
.fst-badge__dot{
    width:7px;height:7px;border-radius:50%;
    background:var(--f-red);
    box-shadow:0 0 0 4px rgba(135,35,35,.12);
    animation:fstDotPulse 2s ease-in-out infinite;
}
@keyframes fstDotPulse{
    0%,100%{box-shadow:0 0 0 4px rgba(135,35,35,.12)}
    50%{box-shadow:0 0 0 8px rgba(135,35,35,.04)}
}

.fst-header__title{
    font-family:'Space Grotesk',sans-serif;
    font-size:clamp(2.4rem,5vw,4rem);
    font-weight:800;letter-spacing:-.05em;
    line-height:1.02;color:#111;margin:0 0 .8rem;
}
.fst-header__title span{
    background:linear-gradient(135deg,var(--f-red),#c04040);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.fst-header__sub{
    color:#6b7280;font-size:1.05rem;
    line-height:1.75;max-width:60ch;margin:0 auto;
}

/* ── KPI ROW ──────────────────────────────── */
.fst-kpi-row{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:1rem;
    margin:0 0 1.5rem;
}
.fst-kpi{
    display:flex;align-items:center;gap:1rem;
    background:#fff;
    border:1px solid rgba(17,17,17,.07);
    border-radius:22px;
    padding:1.35rem 1.25rem;
    box-shadow:0 8px 28px rgba(0,0,0,.05);
    transition:transform .3s var(--f-ease),box-shadow .3s;
}
.fst-kpi:hover{transform:translateY(-4px);box-shadow:0 18px 45px rgba(0,0,0,.09);}
.fst-kpi--primary{
    border-color:rgba(135,35,35,.15);
    box-shadow:0 8px 32px rgba(135,35,35,.1);
}

.fst-kpi__icon{
    width:52px;height:52px;border-radius:16px;
    background:rgba(135,35,35,.08);
    color:var(--f-red);
    display:flex;align-items:center;justify-content:center;
    flex-shrink:0;
}
.fst-kpi__icon--red{background:rgba(220,38,38,.08);color:#dc2626;}
.fst-kpi__icon--amber{background:rgba(245,158,11,.08);color:#d97706;}
.fst-kpi__icon--blue{background:rgba(59,130,246,.08);color:#3b82f6;}
.fst-kpi__icon--green{background:rgba(16,185,129,.08);color:#059669;}

.fst-kpi__num{
    font-family:'Space Grotesk',sans-serif;
    font-size:2rem;font-weight:900;
    line-height:1;margin-bottom:.25rem;
    color:var(--f-red);
}
.fst-kpi__num--red{color:#dc2626;}
.fst-kpi__num--amber{color:#d97706;}
.fst-kpi__num--blue{color:#3b82f6;}
.fst-kpi__lbl{font-size:.82rem;color:#9ca3af;font-weight:600;}

/* ── GRID ─────────────────────────────────── */
.fst-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:1rem;
}
.fst-card{
    background:#fff;
    border:1px solid rgba(17,17,17,.07);
    border-radius:24px;
    padding:1.75rem;
    box-shadow:0 8px 32px rgba(0,0,0,.05);
    transition:box-shadow .3s,transform .3s var(--f-ease);
}
.fst-card:hover{box-shadow:0 18px 50px rgba(0,0,0,.09);transform:translateY(-2px);}
.fst-card--full{grid-column:1/-1;}

.fst-card__head{
    display:flex;align-items:flex-start;gap:1rem;
    margin-bottom:1.5rem;
}
.fst-card__icon{
    width:46px;height:46px;border-radius:14px;
    background:rgba(135,35,35,.07);
    color:var(--f-red);
    display:flex;align-items:center;justify-content:center;
    flex-shrink:0;
}
.fst-card__icon--green{background:rgba(16,185,129,.08);color:#059669;}
.fst-card__icon--amber{background:rgba(245,158,11,.08);color:#d97706;}
.fst-card__icon--blue{background:rgba(59,130,246,.08);color:#3b82f6;}

.fst-card__head h2{
    font-family:'Space Grotesk',sans-serif;
    font-size:1.2rem;font-weight:800;
    letter-spacing:-.03em;color:#111;margin:0;
}

.fst-eyebrow{
    font-size:.7rem;font-weight:800;
    letter-spacing:.14em;text-transform:uppercase;
    color:var(--f-red);margin-bottom:.2rem;
}

/* ── BARS ─────────────────────────────────── */
.fst-bars{display:flex;flex-direction:column;gap:.85rem;}
.fst-bar-row{display:grid;grid-template-columns:120px 1fr 46px;align-items:center;gap:.75rem;}
.fst-bar-label{font-size:.84rem;font-weight:700;color:#374151;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.fst-bar-track{height:9px;background:#f3f4f6;border-radius:999px;overflow:hidden;}
.fst-bar-fill{
    height:100%;border-radius:999px;
    transition:width .8s var(--f-ease);
}
.fst-bar-fill--red{background:linear-gradient(90deg,var(--f-red),#c04040);}
.fst-bar-fill--green{background:linear-gradient(90deg,#059669,#34d399);}
.fst-bar-count{font-size:.82rem;font-weight:800;color:#6b7280;text-align:right;font-family:'Space Grotesk',sans-serif;}

/* ── CHART ────────────────────────────────── */
.fst-chart{
    position:relative;
    height:180px;
    margin-bottom:1rem;
    display:flex;
    flex-direction:column;
}
.fst-chart__grid{
    position:absolute;
    inset:0;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    pointer-events:none;
}
.fst-chart__grid span{
    width:100%;
    height:1px;
    background:rgba(17,17,17,.05);
}
.fst-chart__bars{
    display:flex;
    align-items:flex-end;
    gap:3px;
    height:160px;
    padding-bottom:1px;
    flex:1;
}
.fst-chart__bar-wrap{
    flex:1;
    display:flex;
    align-items:flex-end;
    height:100%;
    cursor:pointer;
}
.fst-chart__bar{
    width:100%;
    background:linear-gradient(180deg,var(--f-red) 0%,rgba(135,35,35,.35) 100%);
    border-radius:4px 4px 2px 2px;
    transition:height .8s var(--f-ease),opacity .2s;
}
.fst-chart__bar:hover{
    opacity:.75;
}
.fst-chart__axis{
    display:flex;
    justify-content:space-between;
    font-size:.75rem;
    color:#9ca3af;
    padding:0 2px;
    margin-top:.45rem;
}
.fst-chart__metrics{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:.75rem;
    margin-top:1rem;
    padding-top:1.25rem;
    border-top:1px solid rgba(17,17,17,.06);
}
.fst-chart__metric{text-align:center;}
.fst-chart__metric strong{
    display:block;
    font-family:'Space Grotesk',sans-serif;
    font-size:1.55rem;font-weight:900;
    color:#111;margin-bottom:.2rem;
}
.fst-chart__metric span{font-size:.8rem;color:#9ca3af;}
.fst-up{color:#059669 !important;}
.fst-down{color:#dc2626 !important;}

/* ── TONS GRID ────────────────────────────── */
.fst-tons-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
    gap:.85rem;
}
.fst-ton-card{
    background:#fafafa;
    border:1px solid rgba(17,17,17,.07);
    border-radius:18px;
    padding:1.1rem 1rem;
    transition:.25s var(--f-ease);
}
.fst-ton-card:hover{
    background:#fff;
    border-color:rgba(135,35,35,.15);
    box-shadow:0 8px 24px rgba(135,35,35,.07);
    transform:translateY(-2px);
}
.fst-ton-card__top{
    display:flex;align-items:center;gap:.65rem;
    margin-bottom:.75rem;
}
.fst-ton-card__rank{
    font-size:.7rem;font-weight:800;
    color:rgba(135,35,35,.45);
    letter-spacing:.08em;
}
.fst-ton-card__name{
    font-size:.95rem;font-weight:800;color:#111;
}
.fst-ton-card__bar-track{
    height:7px;background:#ece9e9;
    border-radius:999px;overflow:hidden;
    margin-bottom:.6rem;
}
.fst-ton-card__bar-fill{
    height:100%;border-radius:999px;
    background:linear-gradient(90deg,var(--f-red),#c04040);
    transition:width .8s var(--f-ease);
}
.fst-ton-card__count{
    font-family:'Space Grotesk',sans-serif;
    font-size:1.15rem;font-weight:800;
    color:var(--f-red);
}
.fst-ton-card__count small{
    font-size:.75rem;color:#9ca3af;font-weight:500;
}

/* ── FOOTER NAV ───────────────────────────── */
.fst-footer-nav{
    display:flex;align-items:center;justify-content:center;
    gap:1rem;margin-top:2.5rem;flex-wrap:wrap;
}
.fst-nav-link{
    display:inline-flex;align-items:center;gap:.5rem;
    padding:.8rem 1.3rem;border-radius:12px;
    text-decoration:none;font-weight:700;font-size:.9rem;
    border:1px solid rgba(17,17,17,.08);
    color:#6b7280;background:#fff;
    transition:.25s var(--f-ease);
}
.fst-nav-link:hover{border-color:rgba(135,35,35,.2);color:var(--f-red);}
.fst-nav-link--primary{
    background:var(--f-red);color:#fff;border-color:var(--f-red);
    box-shadow:0 8px 28px rgba(135,35,35,.22);
}
.fst-nav-link--primary:hover{background:#6f1c1c;transform:translateY(-2px);}
.fst-nav-link--primary svg{transition:transform .25s var(--f-ease);}
.fst-nav-link--primary:hover svg{transform:translateX(4px);}

/* ── RESPONSIVE ───────────────────────────── */
@media(max-width:1024px){
    .fst-kpi-row{grid-template-columns:repeat(2,1fr);}
    .fst-grid{grid-template-columns:1fr;}
    .fst-card--full{grid-column:1;}
}
@media(max-width:640px){
    .fst-kpi-row{grid-template-columns:1fr;}
    .fst-bar-row{grid-template-columns:90px 1fr 36px;}
    .fst-bar-label{font-size:.78rem;}
    .fst-chart__metrics{grid-template-columns:1fr;}
    .fst-tons-grid{grid-template-columns:1fr 1fr;}
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    /* ── Scroll reveal ── */
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('is-visible');
                obs.unobserve(e.target);
            }
        });
    }, { threshold: 0.08 });
    document.querySelectorAll('[data-reveal]').forEach(el => obs.observe(el));

    /* ── Animated canvas background ── */
    const canvas = document.getElementById('statCanvas');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        let W, H;
        const resize = () => {
            W = canvas.width = window.innerWidth;
            H = canvas.height = window.innerHeight;
        };
        resize();
        window.addEventListener('resize', resize);

        const draw = () => {
            ctx.clearRect(0, 0, W, H);
            const cx = W / 2, cy = H * 0.38;
            const t = Date.now() * 0.0003;

            /* 2 spiral arms */
            for (let arm = 0; arm < 2; arm++) {
                ctx.beginPath();
                for (let i = 0; i < 400; i++) {
                    const angle = 0.045 * i + t + arm * Math.PI;
                    const r = 0.65 * i;
                    if (r > Math.min(W, H) * 0.55) break;
                    const x = cx + r * Math.cos(angle);
                    const y = cy + r * Math.sin(angle) * 0.38;
                    i === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
                }
                ctx.strokeStyle = 'rgba(135,35,35,0.06)';
                ctx.lineWidth = 1;
                ctx.stroke();
            }

            /* Orbiting dots */
            for (let i = 0; i < 8; i++) {
                const a = (i / 8) * Math.PI * 2 + t * 0.7;
                const r = 140 + Math.sin(t + i) * 30;
                ctx.beginPath();
                ctx.arc(cx + r * Math.cos(a), cy + r * Math.sin(a) * 0.38, 1.8, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(135,35,35,0.15)';
                ctx.fill();
            }

            requestAnimationFrame(draw);
        };
        draw();
    }

    /* ── Count-up ── */
    const counted = new Set();
    const countObs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (!e.isIntersecting || counted.has(e.target)) return;
            counted.add(e.target);
            const target = parseInt(e.target.dataset.count) || 0;
            if (!target) return;
            const start = Date.now(), dur = 1600;
            const tick = () => {
                const p = Math.min((Date.now() - start) / dur, 1);
                const eased = 1 - Math.pow(1 - p, 3);
                e.target.textContent = Math.round(eased * target).toLocaleString('fr-FR');
                if (p < 1) requestAnimationFrame(tick);
            };
            tick();
        });
    }, { threshold: 0.4 });
    document.querySelectorAll('[data-count]').forEach(el => countObs.observe(el));

    /* ── Animate bars on scroll ── */
    const barObs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (!e.isIntersecting) return;
            e.target.querySelectorAll('.fst-bar-fill').forEach((bar, i) => {
                setTimeout(() => {
                    bar.style.width = bar.dataset.width + '%';
                }, i * 90);
            });
            e.target.querySelectorAll('.fst-ton-card__bar-fill').forEach((bar, i) => {
                setTimeout(() => {
                    bar.style.width = bar.dataset.width + '%';
                }, i * 70);
            });
        });
    }, { threshold: 0.15 });
    document.querySelectorAll('.fst-card').forEach(card => barObs.observe(card));

    /* ── Animate chart bars ── */
    const chartObs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (!e.isIntersecting) return;
            e.target.querySelectorAll('.fst-chart__bar').forEach((bar, i) => {
                setTimeout(() => {
                    bar.style.height = bar.dataset.height + '%';
                }, i * 25);
            });
            chartObs.unobserve(e.target);
        });
    }, { threshold: 0.2 });
    document.querySelectorAll('.fst-chart').forEach(el => chartObs.observe(el));
});
</script>
@endpush