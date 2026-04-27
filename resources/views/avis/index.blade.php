@extends('layouts.app')
@section('title', 'Avis des utilisateurs - Fidow')

@section('content')
<div class="fav-page">

    <div class="fav-bg" aria-hidden="true">
        <canvas id="avisCanvas"></canvas>
        <div class="fav-ring fav-ring--1"></div>
        <div class="fav-ring fav-ring--2"></div>
        <div class="fav-blob fav-blob--1"></div>
        <div class="fav-blob fav-blob--2"></div>
    </div>

    <div class="fav-container">

        {{-- HEADER --}}
        <header class="fav-header" data-reveal>
            <nav class="fav-breadcrumb">
                <a href="{{ route('home') }}">Accueil</a>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
                <span>Témoignages</span>
            </nav>
            <div class="fav-badge">
                <span class="fav-badge__dot"></span>
                Avis vérifiés · Communauté Fidow
            </div>
            <h1 class="fav-header__title">
                Ce qu'ils disent de <span>Fidow</span>
            </h1>
            <p class="fav-header__sub">
                Des retours authentiques de professionnels qui utilisent nos outils pour développer leur carrière remote.
            </p>
        </header>

        {{-- KPI ROW --}}
        <div class="fav-kpi-row" data-reveal data-reveal-delay="1">
            <div class="fav-kpi fav-kpi--primary">
                <div class="fav-kpi__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                </div>
                <div>
                    <div class="fav-kpi__num" data-count="{{ $avis->count() }}">0</div>
                    <div class="fav-kpi__lbl">Avis publiés</div>
                </div>
            </div>
            <div class="fav-kpi">
                <div class="fav-kpi__icon fav-kpi__icon--amber">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
                <div>
                    <div class="fav-kpi__num fav-kpi__num--amber">{{ number_format($avis->avg('note'), 1) }}</div>
                    <div class="fav-kpi__lbl">Note moyenne</div>
                </div>
            </div>
            <div class="fav-kpi">
                <div class="fav-kpi__icon fav-kpi__icon--green">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
                </div>
                <div>
                    <div class="fav-kpi__num fav-kpi__num--green">{{ $avis->where('note', '>=', 4)->count() }}</div>
                    <div class="fav-kpi__lbl">Avis très positifs</div>
                </div>
            </div>
            <div class="fav-kpi--action">
                <a href="{{ route('avis.create') }}" class="fav-btn-cta">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5"/><path d="M17.5 2.5a2.12 2.12 0 0 1 3 3L12 14l-4 1 1-4Z"/></svg>
                    Laisser mon avis
                </a>
                <p class="fav-cta-note">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Modéré avant publication
                </p>
            </div>
        </div>

        {{-- RATING OVERVIEW --}}
        @php
            $avg = $avis->avg('note') ?: 0;
            $fullStars = floor($avg);
            $hasHalf = ($avg - $fullStars) >= 0.5;
        @endphp
        @if($avis->count() > 0)
        <div class="fav-rating-overview" data-reveal>
            <div class="fav-rating-big">
                <div class="fav-rating-big__num">{{ number_format($avg, 1) }}</div>
                <div class="fav-rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="{{ $i <= $fullStars ? '#f59e0b' : 'none' }}" stroke="#f59e0b" stroke-width="1.5">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    @endfor
                </div>
                <div class="fav-rating-big__lbl">sur {{ $avis->count() }} avis</div>
            </div>
            <div class="fav-rating-breakdown">
                @for($star = 5; $star >= 1; $star--)
                    @php
                        $cnt = $avis->where('note', $star)->count();
                        $pct = $avis->count() > 0 ? ($cnt / $avis->count()) * 100 : 0;
                    @endphp
                    <div class="fav-star-row">
                        <span class="fav-star-row__lbl">{{ $star }}</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="#f59e0b" stroke="#f59e0b" stroke-width="1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <div class="fav-star-row__track">
                            <div class="fav-star-row__fill" data-width="{{ $pct }}" style="width:0"></div>
                        </div>
                        <span class="fav-star-row__count">{{ $cnt }}</span>
                    </div>
                @endfor
            </div>
        </div>
        @endif

        {{-- AVIS GRID --}}
        @if($avis->count() > 0)
        <div class="fav-grid" data-reveal>
            @foreach($avis as $i => $avi)
            <article class="fav-card {{ $i === 0 ? 'fav-card--feat' : '' }}" style="--d:{{ ($i % 6) * 60 }}ms">

                @if($i === 0)
                    <div class="fav-card__bigquote" aria-hidden="true">&ldquo;</div>
                @endif

                <div class="fav-card__stars">
                    @for($s = 1; $s <= 5; $s++)
                        <svg width="{{ $i === 0 ? 18 : 15 }}" height="{{ $i === 0 ? 18 : 15 }}" viewBox="0 0 24 24"
                             fill="{{ $s <= $avi->note ? '#f59e0b' : 'none' }}"
                             stroke="{{ $s <= $avi->note ? '#f59e0b' : '#d1d5db' }}" stroke-width="1.5">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    @endfor
                    @if($avi->note >= 5)
                        <span class="fav-card__top-badge">★ Top avis</span>
                    @endif
                </div>

                <p class="fav-card__text">&ldquo;{{ Str::limit($avi->commentaire, $i === 0 ? 300 : 200) }}&rdquo;</p>

                <div class="fav-card__footer">
                    @php
                        $colors = [
                            ['#872323','#c04040'],['#1e3a5f','#2d6a9f'],['#1a5c3a','#2d8a5a'],
                            ['#5b21b6','#7c3aed'],['#d97706','#b45309'],['#0e7490','#0891b2']
                        ];
                        $c = $colors[$i % count($colors)];
                    @endphp
                    <div class="fav-card__av" style="background:linear-gradient(135deg,{{ $c[0] }},{{ $c[1] }})">
                        {{ strtoupper(substr($avi->nom, 0, 1)) }}
                    </div>
                    <div class="fav-card__meta">
                        <strong>{{ $avi->nom }}</strong>
                        <span>{{ $avi->created_at->format('d M Y') }}</span>
                    </div>
                    @if($avi->user)
                        <div class="fav-card__badge-verified">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Vérifié
                        </div>
                    @endif
                </div>

            </article>
            @endforeach
        </div>

        <div class="fav-pagination" data-reveal>
            {{ $avis->links() }}
        </div>

        @else
        <div class="fav-empty" data-reveal>
            <div class="fav-empty__icon">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <h3>Aucun avis pour le moment</h3>
            <p>Sois le premier à partager ton expérience avec la communauté Fidow.</p>
            <a href="{{ route('avis.create') }}" class="fav-btn-cta fav-btn-cta--lg">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5"/><path d="M17.5 2.5a2.12 2.12 0 0 1 3 3L12 14l-4 1 1-4Z"/></svg>
                Laisser le premier avis
            </a>
        </div>
        @endif

        <div class="fav-footer-nav" data-reveal>
            <a href="{{ route('home') }}" class="fav-nav-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                Accueil
            </a>
            <a href="{{ route('positionnement') }}" class="fav-nav-link fav-nav-link--primary">
                Essayer un outil
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
/* ─────────────── SHARED BG / PAGE ─────────────── */
:root{--f-red:#872323;--f-ease:cubic-bezier(.16,1,.3,1);}
[data-reveal]{opacity:0;transform:translateY(26px);transition:opacity .65s var(--f-ease),transform .65s var(--f-ease)}
[data-reveal].is-visible{opacity:1;transform:translateY(0)}
[data-reveal-delay="1"]{transition-delay:.1s}

.fav-page{min-height:100vh;background:#fff;position:relative;overflow:hidden;padding-bottom:4rem;}

.fav-bg{position:fixed;inset:0;pointer-events:none;z-index:0;}
#avisCanvas{position:absolute;inset:0;width:100%;height:100%;}
.fav-ring{position:absolute;border-radius:50%;border:1px solid rgba(135,35,35,.06);left:50%;top:38%;transform:translate(-50%,-50%);animation:favRingPulse 10s ease-in-out infinite;}
.fav-ring--1{width:880px;height:880px;}
.fav-ring--2{width:560px;height:560px;animation-delay:3s;border-color:rgba(135,35,35,.04);}
@keyframes favRingPulse{0%,100%{transform:translate(-50%,-50%) scale(1);opacity:.5}50%{transform:translate(-50%,-50%) scale(1.04);opacity:1}}
.fav-blob{position:absolute;border-radius:50%;filter:blur(100px);pointer-events:none;}
.fav-blob--1{width:480px;height:260px;background:radial-gradient(ellipse,rgba(135,35,35,.09) 0%,transparent 70%);top:-50px;left:50%;transform:translateX(-50%);}
.fav-blob--2{width:320px;height:320px;background:radial-gradient(circle,rgba(135,35,35,.06) 0%,transparent 70%);bottom:8%;right:-60px;}

.fav-container{position:relative;z-index:2;max-width:1180px;margin:0 auto;padding:0 1.5rem;}

/* ─── HEADER ─── */
.fav-header{text-align:center;padding:4.5rem 0 2rem;}
.fav-breadcrumb{display:inline-flex;align-items:center;gap:.4rem;font-size:.88rem;color:#9ca3af;margin-bottom:1.1rem;}
.fav-breadcrumb a{color:#6b7280;text-decoration:none;transition:color .2s;}
.fav-breadcrumb a:hover{color:var(--f-red);}
.fav-breadcrumb span{color:var(--f-red);font-weight:700;}
.fav-badge{display:inline-flex;align-items:center;gap:.5rem;padding:.42rem .9rem;border-radius:999px;background:rgba(135,35,35,.07);border:1px solid rgba(135,35,35,.14);color:var(--f-red);font-size:.78rem;font-weight:700;margin-bottom:1.1rem;}
.fav-badge__dot{width:7px;height:7px;border-radius:50%;background:var(--f-red);box-shadow:0 0 0 4px rgba(135,35,35,.12);animation:favDot 2s ease-in-out infinite;}
@keyframes favDot{0%,100%{box-shadow:0 0 0 4px rgba(135,35,35,.12)}50%{box-shadow:0 0 0 8px rgba(135,35,35,.04)}}
.fav-header__title{font-family:'Space Grotesk',sans-serif;font-size:clamp(2.4rem,5vw,4rem);font-weight:800;letter-spacing:-.05em;line-height:1.02;color:#111;margin:0 0 .8rem;}
.fav-header__title span{background:linear-gradient(135deg,var(--f-red),#c04040);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.fav-header__sub{color:#6b7280;font-size:1.05rem;line-height:1.75;max-width:60ch;margin:0 auto;}

/* ─── KPI ─── */
.fav-kpi-row{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:1rem;margin:0 0 1.5rem;}
.fav-kpi{display:flex;align-items:center;gap:1rem;background:#fff;border:1px solid rgba(17,17,17,.07);border-radius:22px;padding:1.35rem 1.25rem;box-shadow:0 8px 28px rgba(0,0,0,.05);transition:transform .3s var(--f-ease),box-shadow .3s;}
.fav-kpi:hover{transform:translateY(-4px);box-shadow:0 18px 45px rgba(0,0,0,.09);}
.fav-kpi--primary{border-color:rgba(135,35,35,.15);box-shadow:0 8px 32px rgba(135,35,35,.1);}
.fav-kpi--action{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:.7rem;}
.fav-kpi__icon{width:52px;height:52px;border-radius:16px;background:rgba(135,35,35,.08);color:var(--f-red);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.fav-kpi__icon--amber{background:rgba(245,158,11,.08);color:#d97706;}
.fav-kpi__icon--green{background:rgba(16,185,129,.08);color:#059669;}
.fav-kpi__num{font-family:'Space Grotesk',sans-serif;font-size:2rem;font-weight:900;line-height:1;margin-bottom:.25rem;color:var(--f-red);}
.fav-kpi__num--amber{color:#d97706;}
.fav-kpi__num--green{color:#059669;}
.fav-kpi__lbl{font-size:.82rem;color:#9ca3af;font-weight:600;}

/* ─── CTA btn ─── */
.fav-btn-cta{display:inline-flex;align-items:center;gap:.6rem;padding:.9rem 1.5rem;background:var(--f-red);color:#fff;border-radius:14px;font-weight:800;font-size:.95rem;text-decoration:none;box-shadow:0 8px 28px rgba(135,35,35,.22);transition:.25s var(--f-ease);}
.fav-btn-cta:hover{background:#6f1c1c;transform:translateY(-2px);box-shadow:0 14px 38px rgba(135,35,35,.3);}
.fav-btn-cta--lg{padding:1rem 2rem;font-size:1.05rem;}
.fav-cta-note{display:flex;align-items:center;gap:.35rem;font-size:.75rem;color:#9ca3af;}

/* ─── RATING OVERVIEW ─── */
.fav-rating-overview{display:flex;align-items:center;gap:3rem;background:#fff;border:1px solid rgba(17,17,17,.07);border-radius:24px;padding:2rem 2.5rem;box-shadow:0 8px 32px rgba(0,0,0,.05);margin-bottom:1.5rem;}
.fav-rating-big{text-align:center;flex-shrink:0;}
.fav-rating-big__num{font-family:'Space Grotesk',sans-serif;font-size:4rem;font-weight:900;line-height:1;color:#111;margin-bottom:.4rem;}
.fav-rating-stars{display:flex;gap:3px;justify-content:center;margin-bottom:.4rem;}
.fav-rating-big__lbl{font-size:.82rem;color:#9ca3af;}
.fav-rating-breakdown{flex:1;display:flex;flex-direction:column;gap:.55rem;}
.fav-star-row{display:grid;grid-template-columns:18px 16px 1fr 32px;align-items:center;gap:.6rem;}
.fav-star-row__lbl{font-size:.85rem;font-weight:700;color:#374151;text-align:right;}
.fav-star-row__track{height:8px;background:#f3f4f6;border-radius:999px;overflow:hidden;}
.fav-star-row__fill{height:100%;background:linear-gradient(90deg,#f59e0b,#fbbf24);border-radius:999px;transition:width .9s var(--f-ease);}
.fav-star-row__count{font-size:.8rem;color:#9ca3af;font-family:'Space Grotesk',sans-serif;font-weight:700;}

/* ─── GRID ─── */
.fav-grid{columns:3 300px;column-gap:1rem;gap:1rem;margin-bottom:1.5rem;}
.fav-card{break-inside:avoid;margin-bottom:1rem;background:#fff;border:1px solid rgba(17,17,17,.07);border-radius:22px;padding:1.5rem;box-shadow:0 6px 24px rgba(0,0,0,.05);transition:transform .3s var(--f-ease),box-shadow .3s;position:relative;overflow:hidden;transition-delay:var(--d,0ms);}
.fav-card:hover{transform:translateY(-4px);box-shadow:0 16px 44px rgba(0,0,0,.1);}
.fav-card--feat{background:linear-gradient(135deg,#fdf8f8,#fff8f5);border-color:rgba(135,35,35,.14);box-shadow:0 12px 40px rgba(135,35,35,.1);}
.fav-card__bigquote{position:absolute;top:-10px;right:20px;font-size:8rem;line-height:1;color:rgba(135,35,35,.07);font-family:Georgia,serif;pointer-events:none;user-select:none;}
.fav-card__stars{display:flex;align-items:center;gap:3px;margin-bottom:.9rem;}
.fav-card__top-badge{margin-left:.6rem;font-size:.7rem;font-weight:800;color:#d97706;background:rgba(245,158,11,.1);padding:.2rem .55rem;border-radius:999px;}
.fav-card__text{font-size:.92rem;line-height:1.75;color:#374151;margin-bottom:1.2rem;}
.fav-card__footer{display:flex;align-items:center;gap:.75rem;padding-top:1rem;border-top:1px solid rgba(17,17,17,.06);}
.fav-card__av{width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.95rem;font-weight:900;color:#fff;flex-shrink:0;}
.fav-card__meta{flex:1;}
.fav-card__meta strong{display:block;font-size:.88rem;font-weight:800;color:#111;}
.fav-card__meta span{font-size:.78rem;color:#9ca3af;}
.fav-card__badge-verified{display:flex;align-items:center;gap:.3rem;font-size:.72rem;font-weight:700;color:#059669;background:rgba(16,185,129,.08);padding:.3rem .65rem;border-radius:999px;}

/* ─── PAGINATION ─── */
.fav-pagination{display:flex;justify-content:center;margin-top:.5rem;}

/* ─── EMPTY ─── */
.fav-empty{text-align:center;padding:5rem 1rem;background:#fff;border:1px solid rgba(17,17,17,.07);border-radius:24px;box-shadow:0 8px 32px rgba(0,0,0,.05);margin-bottom:1.5rem;}
.fav-empty__icon{width:72px;height:72px;border-radius:20px;background:rgba(135,35,35,.07);color:var(--f-red);display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;}
.fav-empty h3{font-family:'Space Grotesk',sans-serif;font-size:1.5rem;font-weight:800;color:#111;margin-bottom:.6rem;}
.fav-empty p{color:#6b7280;margin-bottom:1.5rem;}

/* ─── FOOTER NAV ─── */
.fav-footer-nav{display:flex;align-items:center;justify-content:center;gap:1rem;margin-top:2.5rem;flex-wrap:wrap;}
.fav-nav-link{display:inline-flex;align-items:center;gap:.5rem;padding:.8rem 1.3rem;border-radius:12px;text-decoration:none;font-weight:700;font-size:.9rem;border:1px solid rgba(17,17,17,.08);color:#6b7280;background:#fff;transition:.25s var(--f-ease);}
.fav-nav-link:hover{border-color:rgba(135,35,35,.2);color:var(--f-red);}
.fav-nav-link--primary{background:var(--f-red);color:#fff;border-color:var(--f-red);box-shadow:0 8px 28px rgba(135,35,35,.22);}
.fav-nav-link--primary:hover{background:#6f1c1c;transform:translateY(-2px);}
.fav-nav-link--primary svg{transition:transform .25s var(--f-ease);}
.fav-nav-link--primary:hover svg{transform:translateX(4px);}

/* ─── RESPONSIVE ─── */
@media(max-width:1024px){.fav-kpi-row{grid-template-columns:repeat(2,1fr);}.fav-rating-overview{flex-direction:column;gap:1.5rem;}.fav-grid{columns:2 260px;}}
@media(max-width:640px){.fav-kpi-row{grid-template-columns:1fr;}.fav-grid{columns:1;}}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ease = el => { el.classList.add('is-visible'); };
    const obs = new IntersectionObserver(entries => { entries.forEach(e => { if(e.isIntersecting){ ease(e.target); obs.unobserve(e.target); } }); }, {threshold:0.08});
    document.querySelectorAll('[data-reveal]').forEach(el => obs.observe(el));

    // Canvas
    const canvas = document.getElementById('avisCanvas');
    if(canvas){
        const ctx = canvas.getContext('2d');
        let W, H;
        const resize = () => { W = canvas.width = window.innerWidth; H = canvas.height = window.innerHeight; };
        resize(); window.addEventListener('resize', resize);
        // Floating quote marks
        const quotes = Array.from({length:8},(_,i)=>({x:Math.random()*0.9+.05, y:Math.random()*0.7+.05, size:14+Math.random()*22, speed:0.15+Math.random()*0.2, phase:i*0.9}));
        const draw = () => {
            ctx.clearRect(0,0,W,H);
            const t = Date.now()*0.001;
            quotes.forEach(q => {
                const y = q.y*H + Math.sin(t*q.speed+q.phase)*18;
                ctx.font = `${q.size}px Georgia,serif`;
                ctx.fillStyle = `rgba(135,35,35,${0.03+Math.sin(t*0.4+q.phase)*0.01})`;
                ctx.fillText('\u201C', q.x*W, y);
            });
            requestAnimationFrame(draw);
        };
        draw();
    }

    // Count-up
    const counted = new Set();
    const cobs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if(!e.isIntersecting||counted.has(e.target)) return;
            counted.add(e.target);
            const target = parseInt(e.target.dataset.count)||0;
            if(!target) return;
            const start = Date.now(), dur = 1400;
            const tick = () => {
                const p = Math.min((Date.now()-start)/dur,1);
                const v = 1-Math.pow(1-p,3);
                e.target.textContent = Math.round(v*target).toLocaleString('fr-FR');
                if(p<1) requestAnimationFrame(tick);
            };
            tick();
        });
    },{threshold:0.4});
    document.querySelectorAll('[data-count]').forEach(el => cobs.observe(el));

    // Bars (rating breakdown)
    const bobs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if(!e.isIntersecting) return;
            e.target.querySelectorAll('.fav-star-row__fill').forEach((b,i) => {
                setTimeout(()=>{ b.style.width = b.dataset.width+'%'; }, i*80);
            });
        });
    },{threshold:0.2});
    document.querySelectorAll('.fav-rating-overview').forEach(el => bobs.observe(el));
});
</script>
@endpush