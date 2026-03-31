<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Fidow — Outils IA pour Elite Remote</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cabinet+Grotesk:wght@400;500;700;800;900&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap" rel="stylesheet">
<style>

/* ===== RESET & BASE ===== */
*,
*::before,
*::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

html {
    scroll-behavior: smooth;
}

body {
    font-family: 'DM Sans', sans-serif;
    background: #080606;
    color: #f4eded;
    min-height: 100vh;
    line-height: 1.5;
    overflow-x: hidden;
}

/* ===== VARIABLES (unifiées, utiles seulement) ===== */
:root {
    --bg: #080606;
    --card-bg: #0f0a0a;
    --surface: #170e0e;
    --accent: #872323;
    --accent-light: #a82b2b;
    --gold: #e8a030;
    --green: #2ef0a0;
    --text: #f4eded;
    --text-muted: #c8b8b8;
    --muted: #6b5757;
    --border: rgba(135, 35, 35, 0.2);
    --border-light: rgba(255, 255, 255, 0.05);
    --radius-card: 20px;
    --radius-sm: 12px;
}

/* ===== BACKGROUND EFFECTS (unifiés, plus légers) ===== */
.ambient {
    position: fixed;
    inset: 0;
    pointer-events: none;
    z-index: 0;
    background: radial-gradient(ellipse 70% 55% at 15% 0%, rgba(135, 35, 35, 0.14) 0%, transparent 65%),
                radial-gradient(ellipse 50% 40% at 85% 95%, rgba(135, 35, 35, 0.1) 0%, transparent 60%);
}

.noise {
    position: fixed;
    inset: 0;
    pointer-events: none;
    z-index: 0;
    opacity: 0.028;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
    background-size: 256px;
}

/* ===== UTILITIES ===== */
.wrap {
    position: relative;
    z-index: 1;
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 24px;
}

@media (max-width: 640px) {
    .wrap {
        padding: 0 16px;
    }
}

/* ===== ANIMATIONS ===== */
@keyframes rise {
    from {
        opacity: 0;
        transform: translateY(24px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.rise {
    animation: rise 0.7s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
}

.rise-delay-1 {
    animation: rise 0.7s 0.1s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
    opacity: 0;
    animation-fill-mode: forwards;
}

.rise-delay-2 {
    animation: rise 0.7s 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
    opacity: 0;
    animation-fill-mode: forwards;
}

@keyframes pulse-dot {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.25; }
}

@keyframes shimmer {
    0% { background-position: 0%; }
    100% { background-position: 200%; }
}

/* ===== TYPOGRAPHY & GRADIENT ===== */
.grad {
    background: linear-gradient(90deg, #e05555 0%, #872323 40%, #e07050 100%);
    background-size: 200%;
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    animation: shimmer 5s linear infinite;
}

.section-tag {
    display: inline-block;
    background: rgba(135, 35, 35, 0.12);
    border: 1px solid rgba(135, 35, 35, 0.25);
    border-radius: 100px;
    padding: 5px 14px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #d47070;
    margin-bottom: 16px;
}

.section-title {
    font-family: 'Cabinet Grotesk', sans-serif;
    font-size: clamp(1.8rem, 5vw, 2.8rem);
    font-weight: 900;
    letter-spacing: -0.02em;
    line-height: 1.2;
    margin-bottom: 12px;
}

.section-sub {
    color: var(--muted);
    font-size: 0.95rem;
    line-height: 1.6;
    max-width: 560px;
    margin-left: auto;
    margin-right: auto;
}

/* ===== NAVIGATION ===== */
.fidow-nav {
    position: sticky;
    top: 0;
    z-index: 100;
    backdrop-filter: blur(20px);
    background: rgba(8, 6, 6, 0.75);
    border-bottom: 1px solid rgba(135, 35, 35, 0.15);
    padding: 0 16px;
}

.nav-inner {
    max-width: 1180px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 66px;
    gap: 16px;
}

.nav-logo {
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    flex-shrink: 0;
}

.nav-logo img {
    height: 32px;
    width: auto;
}

.nav-logo-text {
    font-family: 'Cabinet Grotesk', sans-serif;
    font-size: 1.2rem;
    font-weight: 900;
    color: var(--text);
}

.nav-links {
    display: flex;
    gap: 4px;
}

.nav-links a {
    color: var(--muted);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    padding: 6px 12px;
    border-radius: 8px;
    transition: all 0.2s;
}

.nav-links a:hover,
.nav-links a.active {
    color: var(--text);
    background: rgba(135, 35, 35, 0.1);
}

.nav-cta {
    background: linear-gradient(135deg, var(--accent) 0%, #6b1a1a 100%);
    border: none;
    border-radius: 10px;
    padding: 8px 18px;
    color: white;
    font-family: 'Cabinet Grotesk', sans-serif;
    font-weight: 800;
    font-size: 0.8rem;
    cursor: pointer;
    text-decoration: none;
    box-shadow: 0 4px 14px rgba(135, 35, 35, 0.3);
    transition: transform 0.2s, box-shadow 0.2s;
    white-space: nowrap;
}

.nav-cta:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(135, 35, 35, 0.45);
}

.nav-badge {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 100px;
    padding: 4px 12px;
    font-size: 0.7rem;
    color: var(--muted);
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.live-dot {
    width: 7px;
    height: 7px;
    background: var(--green);
    border-radius: 50%;
    box-shadow: 0 0 6px var(--green);
    animation: pulse-dot 2s infinite;
}

/* ===== BUTTONS ===== */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, var(--accent) 0%, #6b1a1a 100%);
    border: none;
    border-radius: 12px;
    padding: 12px 26px;
    font-family: 'Cabinet Grotesk', sans-serif;
    font-weight: 800;
    font-size: 0.85rem;
    color: white;
    cursor: pointer;
    text-decoration: none;
    box-shadow: 0 6px 18px rgba(135, 35, 35, 0.35);
    transition: all 0.2s;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(135, 35, 35, 0.5);
}

.btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: transparent;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 12px 22px;
    font-size: 0.85rem;
    color: var(--muted);
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-ghost:hover {
    border-color: rgba(135, 35, 35, 0.5);
    color: var(--text);
}

/* ===== HERO SECTION ===== */
.hero-section {
    padding: 80px 0 60px;
    text-align: center;
    position: relative;
}

.hero-glow {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: min(700px, 90%);
    height: 380px;
    pointer-events: none;
    background: radial-gradient(ellipse at 50% 0%, rgba(135, 35, 35, 0.2) 0%, transparent 70%);
}

.hero-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(135, 35, 35, 0.1);
    border: 1px solid rgba(135, 35, 35, 0.3);
    border-radius: 100px;
    padding: 5px 16px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #d47070;
    margin-bottom: 28px;
}

.hero-h1 {
    font-family: 'Cabinet Grotesk', sans-serif;
    font-size: clamp(2.4rem, 8vw, 4.8rem);
    font-weight: 900;
    line-height: 1.05;
    letter-spacing: -0.03em;
    margin-bottom: 20px;
}

.hero-sub {
    color: var(--muted);
    font-size: 1rem;
    line-height: 1.7;
    max-width: 520px;
    margin: 0 auto 36px;
    padding: 0 8px;
}

.hero-actions {
    display: flex;
    gap: 14px;
    justify-content: center;
    flex-wrap: wrap;
}

/* ===== STATS GRID ===== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 16px;
    max-width: 680px;
    margin: 52px auto 0;
}

.stat-box {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 24px 12px;
    text-align: center;
    transition: border-color 0.2s;
}

.stat-box:hover {
    border-color: rgba(135, 35, 35, 0.45);
}

.stat-num {
    font-family: 'Cabinet Grotesk', sans-serif;
    font-size: 2.4rem;
    font-weight: 900;
    line-height: 1;
    display: block;
    margin-bottom: 8px;
}

.stat-lbl {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--muted);
}

/* ===== TRUST BAR ===== */
.trust-bar {
    padding: 20px 16px;
    border-top: 1px solid rgba(135, 35, 35, 0.08);
    border-bottom: 1px solid rgba(135, 35, 35, 0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 28px;
    flex-wrap: wrap;
    margin: 0 0 70px;
}

.trust-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--muted);
}

/* ===== TOOLS SECTION ===== */
.tools-section {
    padding: 50px 0 80px;
}

.tools-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
    margin-top: 32px;
}

.tool-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 24px;
    padding: 28px;
    text-decoration: none;
    display: block;
    transition: all 0.28s;
    position: relative;
}

.tool-card:hover {
    border-color: rgba(135, 35, 35, 0.5);
    transform: translateY(-5px);
    box-shadow: 0 20px 35px rgba(0, 0, 0, 0.3);
}

.tool-card.soon {
    opacity: 0.7;
    pointer-events: none;
}

.tool-status {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.65rem;
    font-weight: 800;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    border: 1px solid;
    border-radius: 100px;
    padding: 4px 12px;
    margin-bottom: 20px;
}

.status-live {
    background: rgba(46, 240, 160, 0.08);
    border-color: rgba(46, 240, 160, 0.3);
    color: var(--green);
}

.status-soon {
    background: rgba(232, 160, 48, 0.08);
    border-color: rgba(232, 160, 48, 0.25);
    color: var(--gold);
}

.tool-icon {
    width: 52px;
    height: 52px;
    background: rgba(135, 35, 35, 0.12);
    border: 1px solid rgba(135, 35, 35, 0.2);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.tool-name {
    font-family: 'Cabinet Grotesk', sans-serif;
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--text);
    margin-bottom: 8px;
}

.tool-desc {
    color: var(--muted);
    font-size: 0.85rem;
    line-height: 1.6;
    margin-bottom: 22px;
}

.tool-cta {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 600;
    font-size: 0.8rem;
    color: #d47070;
    transition: gap 0.2s;
}

.tool-card:hover .tool-cta {
    gap: 10px;
}

.tool-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 18px;
}

.tool-chip {
    background: var(--surface);
    border: 1px solid var(--border-light);
    border-radius: 100px;
    padding: 4px 12px;
    font-size: 0.7rem;
    color: var(--muted);
}

/* ===== COMMUNITY SECTION ===== */
.community-section {
    padding: 0 0 80px;
}

.community-box {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 32px;
    padding: 60px 28px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.community-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 500px;
    height: 200px;
    background: radial-gradient(ellipse at 50% 0%, rgba(135, 35, 35, 0.18) 0%, transparent 70%);
    pointer-events: none;
}

.community-box h2 {
    font-family: 'Cabinet Grotesk', sans-serif;
    font-size: clamp(1.8rem, 5vw, 2.5rem);
    font-weight: 900;
    margin-bottom: 18px;
    position: relative;
}

.community-box p {
    color: var(--muted);
    font-size: 0.95rem;
    max-width: 480px;
    margin: 0 auto 32px;
    position: relative;
}

/* ===== FOOTER ===== */
.fidow-footer {
    border-top: 1px solid rgba(135, 35, 35, 0.12);
    padding: 24px 20px;
    position: relative;
    z-index: 1;
}

.footer-inner {
    max-width: 1180px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
}

.footer-copy {
    font-size: 0.75rem;
    color: var(--muted);
}

.footer-links {
    display: flex;
    gap: 24px;
}

.footer-links a {
    font-size: 0.75rem;
    color: var(--muted);
    text-decoration: none;
    transition: color 0.2s;
}

.footer-links a:hover {
    color: var(--text);
}

/* ===== RESPONSIVE REFINEMENTS ===== */
@media (max-width: 768px) {
    .nav-inner {
        gap: 10px;
    }
    .nav-links {
        display: none;
    }
    .nav-badge span:not(.live-dot) {
        display: none;
    }
    .nav-badge {
        padding: 4px 8px;
    }
    .hero-section {
        padding: 50px 0 40px;
    }
    .trust-bar {
        margin-bottom: 40px;
        gap: 18px;
    }
    .tools-section {
        padding: 30px 0 60px;
    }
    .community-box {
        padding: 44px 20px;
    }
    .stats-grid {
        gap: 12px;
    }
}

@media (max-width: 480px) {
    .hero-actions {
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }
    .btn-primary, .btn-ghost {
        width: 100%;
        justify-content: center;
    }
    .tool-card {
        padding: 20px;
    }
    .trust-item {
        font-size: 0.7rem;
    }
    .footer-inner {
        flex-direction: column;
        text-align: center;
    }
    .stats-grid {
        grid-template-columns: 1fr;
        max-width: 280px;
    }
}

/* small tablets landscape */
@media (min-width: 769px) and (max-width: 1024px) {
    .tools-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
</head>
<body>
<div class="ambient"></div>
<div class="noise"></div>

<nav class="fidow-nav">
    <div class="nav-inner">
        <a href="{{ route('home') }}" class="nav-logo">
            <img src="{{ asset('assets/logo.png') }}" alt="Fidow">
        </a>
        <div class="nav-links">
            <a href="{{ route('home') }}">Accueil</a>
            <a href="{{ route('stats') }}">Stats</a>
            {{-- DROPDOWN OUTILS --}}
            <div class="nav-tools" style="position:relative">
                <button class="nav-tools-btn" id="toolsBtn" onclick="toggleToolsDropdown()" style="color:var(--muted);font-size:13px;font-weight:500;padding:7px 13px;border-radius:8px;transition:all .2s;cursor:pointer;background:none;border:none;font-family:inherit;display:flex;align-items:center;gap:5px">
                    Outils
                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <div id="toolsDropdown" style="position:absolute;top:calc(100% + 8px);right:0;background:var(--s1);border:1px solid var(--border);border-radius:12px;padding:6px;min-width:200px;box-shadow:0 8px 32px rgba(0,0,0,.4);opacity:0;pointer-events:none;transform:translateY(-6px);transition:all .18s;z-index:200">
                    <a href="{{ route('positionnement') }}" style="display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;color:var(--muted);text-decoration:none;font-size:13px;transition:all .15s" onmouseover="this.style.background='rgba(135,35,35,.1)';this.style.color='var(--text)'" onmouseout="this.style.background='';this.style.color='var(--muted)'">
                        <div style="width:28px;height:28px;border-radius:7px;background:rgba(135,35,35,.1);display:grid;place-items:center;flex-shrink:0">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="#d47070" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </div>
                        Positionnement IA
                    </a>
                    <a href="{{ route('profil') }}" style="display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;color:var(--muted);text-decoration:none;font-size:13px;transition:all .15s" onmouseover="this.style.background='rgba(59,130,246,.08)';this.style.color='var(--text)'" onmouseout="this.style.background='';this.style.color='var(--muted)'">
                        <div style="width:28px;height:28px;border-radius:7px;background:rgba(59,130,246,.1);display:grid;place-items:center;flex-shrink:0">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" stroke="#7bb3ff" stroke-width="1.5"/><path d="M4 20c0-4 3.58-7 8-7s8 3 8 7" stroke="#7bb3ff" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </div>
                        Photo de Profil IA
                    </a>
                    <a href="{{ route('banniere') }}" style="display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;color:var(--muted);text-decoration:none;font-size:13px;transition:all .15s" onmouseover="this.style.background='rgba(232,160,48,.08)';this.style.color='var(--text)'" onmouseout="this.style.background='';this.style.color='var(--muted)'">
                        <div style="width:28px;height:28px;border-radius:7px;background:rgba(232,160,48,.1);display:grid;place-items:center;flex-shrink:0">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="10" rx="2" stroke="#e8a030" stroke-width="1.5"/><path d="M7 11h10M7 14h6" stroke="#e8a030" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </div>
                        Bannière Pro IA
                    </a>
                </div>
            </div>
        </div>
        <span style="font-size:12px;color:var(--muted);background:var(--s1);border:1px solid var(--border);border-radius:100px;padding:4px 12px">
            <span class="live-dot"></span>&nbsp;IA active
        </span>
    </div>
</nav>

<main>
    <div class="wrap">
        <section class="hero-section">
            <div class="hero-glow"></div>
            <div class="hero-pill rise">
                <span class="live-dot"></span>
                Plateforme IA — Elite Remote
            </div>
            <h1 class="hero-h1 rise">
                Tes outils IA<br>
                <span class="grad">au quotidien</span>
            </h1>
            <p class="hero-sub rise-delay-1">
                Fidow regroupe les outils d'intelligence artificielle conçus pour les freelances et développeurs africains qui passent au niveau supérieur.
            </p>
            <div class="hero-actions rise-delay-1">
                <a href="{{ route('positionnement') }}" class="btn-primary">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Essayer un outil
                </a>
                <a href="{{ route('stats') }}" class="btn-ghost">Voir les stats</a>
            </div>

            <div class="stats-grid rise-delay-2">
                <div class="stat-box">
                    <span class="stat-num" style="color:var(--green)">{{ number_format($totalUsages) }}</span>
                    <div class="stat-lbl">Utilisations</div>
                </div>
                <div class="stat-box">
                    <span class="stat-num" style="color:#d47070">{{ number_format($totalGenerations) }}</span>
                    <div class="stat-lbl">Phrases générées</div>
                </div>
                <div class="stat-box">
                    <span class="stat-num" style="color:var(--gold)">100%</span>
                    <div class="stat-lbl">Gratuit</div>
                </div>
            </div>
        </section>
    </div>

    <div class="trust-bar">
        <div class="trust-item">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="#2ef0a0" stroke-width="1.5"/></svg>
            Sécurisé & privé
        </div>
        <div class="trust-item">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="#d47070" stroke-width="1.5"/></svg>
            IA Llama 3.3 70B
        </div>
        <div class="trust-item">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="var(--gold)" stroke-width="1.5"/><path d="M12 6v6l4 2" stroke="var(--gold)" stroke-width="1.5"/></svg>
            Génération &lt; 5s
        </div>
        <div class="trust-item">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="#8ab4ff" stroke-width="1.5"/><circle cx="9" cy="7" r="4" stroke="#8ab4ff" stroke-width="1.5"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="#8ab4ff" stroke-width="1.5"/></svg>
            Communauté Elite Remote
        </div>
    </div>

{{-- CARTES OUTILS (à insérer dans la page d'accueil, hors de la vue positionnement) --}}
<section style="position:relative;z-index:1;max-width:960px;margin:0 auto;padding:0 24px 80px">

    <div style="text-align:center;margin-bottom:32px">
        <div style="display:inline-block;background:rgba(135,35,35,.1);border:1px solid rgba(135,35,35,.22);border-radius:100px;padding:4px 14px;font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#d47070;margin-bottom:12px">Boîte à outils</div>
        <h2 style="font-family:'Cabinet Grotesk',sans-serif;font-size:clamp(22px,4vw,36px);font-weight:900;letter-spacing:-.03em;margin-bottom:8px">Construis ton image de marque</h2>
        <p style="color:var(--muted);font-size:14px;max-width:480px;margin:0 auto;line-height:1.6">Trois outils complémentaires pour te positionner, te montrer et te démarquer.</p>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px">

        {{-- Carte Positionnement --}}
        <a href="{{ route('positionnement') }}" style="text-decoration:none;display:block;background:var(--s1);border:1px solid var(--border);border-radius:20px;padding:28px;transition:all .22s;position:relative;overflow:hidden" onmouseover="this.style.transform='translateY(-3px)';this.style.borderColor='rgba(135,35,35,.45)';this.style.boxShadow='0 12px 36px rgba(0,0,0,.25)'" onmouseout="this.style.transform='';this.style.borderColor='rgba(135,35,35,.2)';this.style.boxShadow=''">
            <div style="width:42px;height:42px;border-radius:12px;background:rgba(135,35,35,.12);border:1px solid rgba(135,35,35,.22);display:grid;place-items:center;margin-bottom:16px">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="#d47070" stroke-width="1.5" stroke-linecap="round"/></svg>
            </div>
            <div style="font-family:'Cabinet Grotesk',sans-serif;font-size:17px;font-weight:900;color:var(--text);margin-bottom:6px">Positionnement IA</div>
            <div style="font-size:13px;color:var(--muted);line-height:1.6;margin-bottom:16px">Génère 3 phrases de positionnement percutantes pour LinkedIn, ton portfolio et tes candidatures.</div>
            <div style="display:flex;align-items:center;gap:6px;font-size:12px;font-weight:600;color:#d47070">
                Générer ma phrase
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div style="position:absolute;top:16px;right:16px;font-size:9px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;background:rgba(135,35,35,.1);border:1px solid rgba(135,35,35,.22);border-radius:100px;padding:3px 9px;color:#d47070">IA générative</div>
        </a>

        {{-- Carte Photo de Profil --}}
        <a href="{{ route('profil') }}" style="text-decoration:none;display:block;background:var(--s1);border:1px solid rgba(59,130,246,.15);border-radius:20px;padding:28px;transition:all .22s;position:relative;overflow:hidden" onmouseover="this.style.transform='translateY(-3px)';this.style.borderColor='rgba(59,130,246,.4)';this.style.boxShadow='0 12px 36px rgba(0,0,0,.25)'" onmouseout="this.style.transform='';this.style.borderColor='rgba(59,130,246,.15)';this.style.boxShadow=''">
            <div style="width:42px;height:42px;border-radius:12px;background:rgba(59,130,246,.1);border:1px solid rgba(59,130,246,.2);display:grid;place-items:center;margin-bottom:16px">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" stroke="#7bb3ff" stroke-width="1.5"/><path d="M4 20c0-4 3.58-7 8-7s8 3 8 7" stroke="#7bb3ff" stroke-width="1.5" stroke-linecap="round"/></svg>
            </div>
            <div style="font-family:'Cabinet Grotesk',sans-serif;font-size:17px;font-weight:900;color:var(--text);margin-bottom:6px">Photo de Profil IA</div>
            <div style="font-size:13px;color:var(--muted);line-height:1.6;margin-bottom:16px">Prompts ultra-précis pour générer une photo de profil pro avec Gemini ou Midjourney.</div>
            <div style="display:flex;align-items:center;gap:6px;font-size:12px;font-weight:600;color:#7bb3ff">
                Obtenir mon prompt
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div style="position:absolute;top:16px;right:16px;font-size:9px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;background:rgba(59,130,246,.08);border:1px solid rgba(59,130,246,.2);border-radius:100px;padding:3px 9px;color:#7bb3ff">Prompt IA</div>
        </a>

        {{-- Carte Bannière --}}
        <a href="{{ route('banniere') }}" style="text-decoration:none;display:block;background:var(--s1);border:1px solid rgba(232,160,48,.15);border-radius:20px;padding:28px;transition:all .22s;position:relative;overflow:hidden" onmouseover="this.style.transform='translateY(-3px)';this.style.borderColor='rgba(232,160,48,.4)';this.style.boxShadow='0 12px 36px rgba(0,0,0,.25)'" onmouseout="this.style.transform='';this.style.borderColor='rgba(232,160,48,.15)';this.style.boxShadow=''">
            <div style="width:42px;height:42px;border-radius:12px;background:rgba(232,160,48,.1);border:1px solid rgba(232,160,48,.2);display:grid;place-items:center;margin-bottom:16px">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="10" rx="2" stroke="#e8a030" stroke-width="1.5"/><path d="M7 11h10M7 14h6" stroke="#e8a030" stroke-width="1.5" stroke-linecap="round"/></svg>
            </div>
            <div style="font-family:'Cabinet Grotesk',sans-serif;font-size:17px;font-weight:900;color:var(--text);margin-bottom:6px">Bannière Pro IA</div>
            <div style="font-size:13px;color:var(--muted);line-height:1.6;margin-bottom:16px">Prompts de bannières LinkedIn/Facebook premium aux couleurs de ta marque. Tu ajoutes juste ton texte dans Canva.</div>
            <div style="display:flex;align-items:center;gap:6px;font-size:12px;font-weight:600;color:var(--gold)">
                Créer ma bannière
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div style="position:absolute;top:16px;right:16px;font-size:9px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;background:rgba(232,160,48,.08);border:1px solid rgba(232,160,48,.2);border-radius:100px;padding:3px 9px;color:var(--gold)">Prompt IA</div>
        </a>

    </div>
</section>

    <div class="wrap community-section">
        <div class="community-box">
            <h2>Fait pour la communauté<br><span class="grad">Elite Remote</span></h2>
            <p>Fidow est construit par et pour les professionnels du numérique africains qui veulent accélérer leur carrière. Tous les outils sont 100 % gratuits.</p>
            <a href="{{ route('positionnement') }}" class="btn-primary">Commencer maintenant →</a>
        </div>
    </div>
</main>

<footer class="fidow-footer">
    <div class="footer-inner">
        <span class="footer-copy">© {{ date('Y') }} Fidow — Elite Remote</span>
        <div class="footer-links">
            <a href="{{ route('stats') }}">Stats</a>
            <a href="{{ route('positionnement') }}">Outils</a>
            <a href="{{ route('admin.login') }}">Admin</a>
        </div>
    </div>
</footer>

<script>
function toggleToolsDropdown() {
    const dd = document.getElementById('toolsDropdown');
    const isOpen = dd.style.opacity === '1';
    dd.style.opacity = isOpen ? '0' : '1';
    dd.style.pointerEvents = isOpen ? 'none' : 'all';
    dd.style.transform = isOpen ? 'translateY(-6px)' : 'none';
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('.nav-tools')) {
        const dd = document.getElementById('toolsDropdown');
        if (dd) {
            dd.style.opacity = '0';
            dd.style.pointerEvents = 'none';
            dd.style.transform = 'translateY(-6px)';
        }
    }
});
</script>
</body>
</html>
