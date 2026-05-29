@extends('layouts.app')

@section('title', 'Documentation — Fidow')

@push('styles')
<style>
:root { --fr: #872323; --frd: #6b1c1c; }

/* ── LAYOUT ── */
.docs-wrap {
    display: flex; min-height: 100vh;
    max-width: 1280px; margin: 0 auto;
    padding: 2rem 1.5rem 5rem;
    gap: 2.5rem;
}
.docs-sidebar {
    flex-shrink: 0; width: 240px;
    position: sticky; top: 5rem;
    align-self: flex-start;
    max-height: calc(100vh - 7rem);
    overflow-y: auto;
}
.docs-sidebar::-webkit-scrollbar { width: 4px; }
.docs-sidebar::-webkit-scrollbar-thumb { background: rgba(135,35,35,.2); border-radius: 4px; }
.docs-content { flex: 1; min-width: 0; }

/* ── SIDEBAR ── */
.docs-nav-title {
    font-size: .7rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase;
    color: #9ca3af; padding: 0 .75rem .5rem; margin-bottom: .25rem;
}
.docs-nav-title:not(:first-child) { margin-top: 1.5rem; }
.docs-nav-link {
    display: block; padding: .45rem .75rem; border-radius: 8px;
    font-size: .85rem; color: #6b7280; text-decoration: none; font-weight: 500;
    transition: all .15s;
}
.docs-nav-link:hover { background: rgba(135,35,35,.06); color: var(--fr); }
.docs-nav-link.active { background: rgba(135,35,35,.1); color: var(--fr); font-weight: 700; }
html.dark .docs-nav-link { color: #9ca3af; }
html.dark .docs-nav-link:hover { background: rgba(135,35,35,.15); color: #f87171; }
html.dark .docs-nav-link.active { background: rgba(135,35,35,.2); color: #f87171; }

/* ── CONTENT ── */
.docs-section { margin-bottom: 4rem; scroll-margin-top: 6rem; }
.docs-h1 {
    font-family: 'Space Grotesk', sans-serif;
    font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 800;
    line-height: 1.1; letter-spacing: -.03em; color: #111; margin-bottom: 1rem;
}
html.dark .docs-h1 { color: #f3f4f6; }
.docs-h1 span {
    background: linear-gradient(135deg, var(--fr), #c04040);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.docs-badge {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .25rem .75rem; border-radius: 50px; font-size: .7rem; font-weight: 700;
    background: rgba(135,35,35,.08); color: var(--fr); border: 1px solid rgba(135,35,35,.15);
    margin-bottom: 1.5rem;
}
html.dark .docs-badge { background: rgba(135,35,35,.2); color: #f87171; }
.docs-lead { font-size: 1.05rem; line-height: 1.75; color: #6b7280; margin-bottom: 2rem; max-width: 70ch; }
html.dark .docs-lead { color: #9ca3af; }

.docs-h2 {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.4rem; font-weight: 700; color: #111;
    margin: 2.5rem 0 1rem; padding-bottom: .5rem;
    border-bottom: 1.5px solid rgba(135,35,35,.12);
}
html.dark .docs-h2 { color: #f3f4f6; border-bottom-color: rgba(255,255,255,.08); }
.docs-h3 { font-size: 1.05rem; font-weight: 700; color: #111; margin: 1.75rem 0 .6rem; }
html.dark .docs-h3 { color: #e5e7eb; }
.docs-p { font-size: .93rem; line-height: 1.8; color: #374151; margin-bottom: 1rem; }
html.dark .docs-p { color: #d1d5db; }
.docs-p a { color: var(--fr); text-decoration: underline; }
html.dark .docs-p a { color: #f87171; }

/* ── CODE BLOCKS ── */
.docs-code {
    background: #1e1e2e; border-radius: 12px; padding: 1.25rem 1.5rem;
    margin: 1.25rem 0; overflow-x: auto; font-family: 'Fira Code', 'Cascadia Code', monospace;
    font-size: .83rem; line-height: 1.75; color: #cdd6f4;
    border: 1px solid rgba(255,255,255,.06);
}
.docs-code .c  { color: #6272a4; }
.docs-code .k  { color: #bd93f9; }
.docs-code .s  { color: #f1fa8c; }
.docs-code .n  { color: #50fa7b; }
.docs-code .v  { color: #ff79c6; }
.docs-inline {
    display: inline-block; padding: .1em .45em; border-radius: 5px;
    background: rgba(135,35,35,.08); color: var(--fr);
    font-family: monospace; font-size: .85em; font-weight: 600;
}
html.dark .docs-inline { background: rgba(135,35,35,.25); color: #fca5a5; }

/* ── CARDS GRILLE ── */
.docs-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem; margin: 1.5rem 0; }
.docs-card {
    padding: 1.5rem; border-radius: 16px;
    background: #fff; border: 1.5px solid rgba(0,0,0,.07);
    box-shadow: 0 2px 12px rgba(0,0,0,.05); transition: all .2s;
}
html.dark .docs-card { background: #161619; border-color: rgba(255,255,255,.08); box-shadow: 0 2px 12px rgba(0,0,0,.4); }
.docs-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(135,35,35,.12); border-color: rgba(135,35,35,.25); }
.docs-card__icon {
    width: 40px; height: 40px; border-radius: 10px;
    background: rgba(135,35,35,.08); display: flex; align-items: center; justify-content: center;
    margin-bottom: 1rem; color: var(--fr);
}
html.dark .docs-card__icon { background: rgba(135,35,35,.2); color: #f87171; }
.docs-card__title { font-weight: 700; font-size: .9rem; color: #111; margin-bottom: .3rem; }
html.dark .docs-card__title { color: #f3f4f6; }
.docs-card__desc { font-size: .8rem; color: #9ca3af; line-height: 1.55; }

/* ── TABLE ── */
.docs-table { width: 100%; border-collapse: collapse; margin: 1.25rem 0; font-size: .85rem; }
.docs-table th { text-align: left; padding: .65rem 1rem; background: rgba(135,35,35,.06); font-weight: 700; color: #111; }
html.dark .docs-table th { background: rgba(135,35,35,.15); color: #f3f4f6; }
.docs-table td { padding: .6rem 1rem; border-bottom: 1px solid rgba(0,0,0,.06); color: #374151; }
html.dark .docs-table td { border-bottom-color: rgba(255,255,255,.05); color: #d1d5db; }
.docs-table tr:hover td { background: rgba(135,35,35,.03); }
html.dark .docs-table tr:hover td { background: rgba(135,35,35,.07); }

/* ── CALLOUT ── */
.docs-callout {
    display: flex; gap: .75rem; padding: 1rem 1.25rem; border-radius: 12px;
    margin: 1.25rem 0;
}
.docs-callout--info { background: rgba(59,130,246,.07); border-left: 3px solid #3b82f6; }
.docs-callout--warn { background: rgba(245,158,11,.07); border-left: 3px solid #f59e0b; }
.docs-callout--ok   { background: rgba(34,197,94,.07); border-left: 3px solid #22c55e; }
html.dark .docs-callout--info { background: rgba(59,130,246,.12); }
html.dark .docs-callout--warn { background: rgba(245,158,11,.12); }
html.dark .docs-callout--ok   { background: rgba(34,197,94,.12); }
.docs-callout svg { flex-shrink: 0; margin-top: 1px; }
.docs-callout p { font-size: .875rem; line-height: 1.65; color: #374151; margin: 0; }
html.dark .docs-callout p { color: #d1d5db; }

/* ── MOBILE ── */
@media (max-width: 768px) {
    .docs-wrap { flex-direction: column; padding: 1.5rem 1rem 4rem; }
    .docs-sidebar { display: none; }
}
</style>
@endpush

@section('content')
<div class="docs-wrap">

    <!-- ── SIDEBAR ── -->
    <nav class="docs-sidebar" aria-label="Navigation documentation">
        <div class="docs-nav-title">Démarrage</div>
        <a href="#intro"       class="docs-nav-link active">Introduction</a>
        <a href="#install"     class="docs-nav-link">Installation</a>
        <a href="#config"      class="docs-nav-link">Configuration</a>

        <div class="docs-nav-title">Outils</div>
        <a href="#positionnement" class="docs-nav-link">Positionnement Pro</a>
        <a href="#remotedigest"   class="docs-nav-link">RemoteDigest</a>
        <a href="#avis"           class="docs-nav-link">Système d'Avis</a>

        <div class="docs-nav-title">Scraping</div>
        <a href="#sources"   class="docs-nav-link">Sources d'offres</a>
        <a href="#rapidapi"  class="docs-nav-link">RapidAPI</a>
        <a href="#commandes" class="docs-nav-link">Commandes Artisan</a>

        <div class="docs-nav-title">IA</div>
        <a href="#llm"      class="docs-nav-link">Providers LLM</a>
        <a href="#fallback" class="docs-nav-link">Fallback automatique</a>

        <div class="docs-nav-title">Déploiement</div>
        <a href="#env"    class="docs-nav-link">Variables .env</a>
        <a href="#cron"   class="docs-nav-link">Tâches planifiées</a>
        <a href="#queues" class="docs-nav-link">Queues</a>
    </nav>

    <!-- ── CONTENU ── -->
    <div class="docs-content">

        <!-- Introduction -->
        <section id="intro" class="docs-section">
            <div class="docs-badge">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                v1.0 · Laravel 11
            </div>
            <h1 class="docs-h1">Documentation <span>Fidow</span></h1>
            <p class="docs-lead">
                Fidow est une suite d'outils gratuits pour les professionnels du travail remote —
                générateur de positionnement IA, digest d'offres d'emploi personnalisé, système d'avis,
                et tableau de bord d'administration complet.
            </p>

            <div class="docs-cards">
                <div class="docs-card">
                    <div class="docs-card__icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <div class="docs-card__title">Positionnement Pro</div>
                    <div class="docs-card__desc">Génère ta phrase de positionnement avec l'IA en quelques secondes</div>
                </div>
                <div class="docs-card">
                    <div class="docs-card__icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="docs-card__title">RemoteDigest</div>
                    <div class="docs-card__desc">Reçois chaque jour les meilleures offres remote correspondant à ton profil</div>
                </div>
                <div class="docs-card">
                    <div class="docs-card__icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    </div>
                    <div class="docs-card__title">Multi-LLM</div>
                    <div class="docs-card__desc">Groq, Mistral, Google AI, Cloudflare, Cerebras — fallback automatique</div>
                </div>
            </div>
        </section>

        <!-- Installation -->
        <section id="install" class="docs-section">
            <h2 class="docs-h2">Installation</h2>
            <p class="docs-p">Prérequis : <strong>PHP 8.2+</strong>, <strong>Composer</strong>, <strong>Node.js 18+</strong>, <strong>PostgreSQL</strong> (ou MySQL), <strong>Python 3.10+</strong> (pour le scraper headless).</p>

            <h3 class="docs-h3">1. Cloner et installer les dépendances</h3>
            <div class="docs-code"><span class="c"># Cloner le repo</span>
git clone https://github.com/rogerfarolx/fidow.git
cd fidow

<span class="c"># Dépendances PHP</span>
composer install

<span class="c"># Dépendances JS</span>
npm install && npm run build

<span class="c"># Environnement</span>
cp .env.example .env
php artisan key:generate</div>

            <h3 class="docs-h3">2. Base de données</h3>
            <div class="docs-code">php artisan migrate
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=LlmConfigurationSeeder</div>

            <h3 class="docs-h3">3. Environnement Python (scraper headless)</h3>
            <div class="docs-code">cd python_scrapers
python3 -m venv venv
source venv/bin/activate
pip install scrapling playwright
playwright install chromium
cd ..</div>

            <div class="docs-callout docs-callout--info">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                <p>Le scraper Python est utilisé uniquement pour LinkedIn, Indeed et d'autres sources avec anti-bot. Les sources API publiques (Remotive, RemoteOK, RSS) fonctionnent sans Python.</p>
            </div>
        </section>

        <!-- Configuration -->
        <section id="config" class="docs-section">
            <h2 class="docs-h2">Configuration</h2>
            <p class="docs-p">Modifie le fichier <span class="docs-inline">.env</span> à la racine du projet. Les variables importantes :</p>

            <table class="docs-table">
                <thead><tr><th>Variable</th><th>Description</th><th>Exemple</th></tr></thead>
                <tbody>
                    <tr><td><span class="docs-inline">APP_URL</span></td><td>URL publique de l'app</td><td>https://fidow.nealix.org</td></tr>
                    <tr><td><span class="docs-inline">DB_CONNECTION</span></td><td>Driver BDD (pgsql / mysql)</td><td>pgsql</td></tr>
                    <tr><td><span class="docs-inline">QUEUE_CONNECTION</span></td><td>Driver de queue</td><td>database</td></tr>
                    <tr><td><span class="docs-inline">RAPIDAPI_KEY</span></td><td>Clé RapidAPI (toutes APIs)</td><td>abc123...</td></tr>
                    <tr><td><span class="docs-inline">GROQ_API_KEY</span></td><td>Clé Groq (LLM)</td><td>gsk_...</td></tr>
                    <tr><td><span class="docs-inline">SCRAPING_PROXIES</span></td><td>Proxies CSV pour le scraper Python</td><td>ip:port,ip:port</td></tr>
                </tbody>
            </table>
        </section>

        <!-- Positionnement -->
        <section id="positionnement" class="docs-section">
            <h2 class="docs-h2">Outil — Positionnement Pro</h2>
            <p class="docs-p">
                Le générateur de positionnement crée une phrase d'accroche professionnelle personnalisée via IA.
                Il prend en compte le métier, les technologies, le niveau d'expérience, la cible et les spécialisations.
            </p>
            <h3 class="docs-h3">Fonctionnement</h3>
            <p class="docs-p">
                L'utilisateur remplit un formulaire → la requête passe par <span class="docs-inline">DynamicAIService</span>
                qui sélectionne le meilleur provider LLM disponible → génère la phrase → sauvegarde dans
                <span class="docs-inline">positioning_generations</span> → l'utilisateur peut retenir les phrases favorites.
            </p>
            <div class="docs-callout docs-callout--ok">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <p>Rate limit : 5 requêtes par minute par IP. Configurable via le middleware throttle Laravel.</p>
            </div>
        </section>

        <!-- RemoteDigest -->
        <section id="remotedigest" class="docs-section">
            <h2 class="docs-h2">Outil — RemoteDigest</h2>
            <p class="docs-p">
                RemoteDigest agrège des offres d'emploi remote depuis +18 sources, déduplique et envoie
                un digest email quotidien personnalisé selon les préférences de l'abonné.
            </p>
            <h3 class="docs-h3">Flux de données</h3>
            <div class="docs-code"><span class="c"># 1. Scraping (dispatche les jobs en queue)</span>
php artisan digest:scrape

<span class="c"># 2. Envoi des digests (déclenché par le scheduler)</span>
php artisan digest:send

<span class="c"># 3. Purge des offres expirées (> 14 jours)</span>
php artisan digest:purge

<span class="c"># 4. Enrichissement salarial (optionnel, RapidAPI)</span>
php artisan digest:enrich-salary --limit=50</div>
        </section>

        <!-- Sources d'offres -->
        <section id="sources" class="docs-section">
            <h2 class="docs-h2">Sources d'offres d'emploi</h2>
            <p class="docs-p">Le scraper utilise 3 types de sources, toutes gérées par <span class="docs-inline">MultiSourceScraperService</span> :</p>

            <table class="docs-table">
                <thead><tr><th>Source</th><th>Type</th><th>Coût</th><th>Fiabilité</th></tr></thead>
                <tbody>
                    <tr><td>Remotive</td><td>API JSON</td><td>Gratuit</td><td>Très haute</td></tr>
                    <tr><td>RemoteOK</td><td>API JSON</td><td>Gratuit</td><td>Très haute</td></tr>
                    <tr><td>WorkingNomads</td><td>API JSON</td><td>Gratuit</td><td>Haute</td></tr>
                    <tr><td>WeWorkRemotely</td><td>RSS</td><td>Gratuit</td><td>Haute</td></tr>
                    <tr><td>Jobicy</td><td>RSS</td><td>Gratuit</td><td>Haute</td></tr>
                    <tr><td>Jobspresso</td><td>RSS</td><td>Gratuit</td><td>Haute</td></tr>
                    <tr><td>LinkedIn (Python)</td><td>Headless/Scrapling</td><td>Gratuit</td><td>Variable (anti-bot)</td></tr>
                    <tr><td>Indeed (Python)</td><td>Headless/Scrapling</td><td>Gratuit</td><td>Variable</td></tr>
                    <tr><td>Wellfound, FlexJobs…</td><td>Headless/Scrapling</td><td>Gratuit</td><td>Variable</td></tr>
                    <tr><td><strong>LinkedIn API</strong></td><td>RapidAPI</td><td>~100 req/mois</td><td>Très haute</td></tr>
                    <tr><td><strong>LI Data Scraper</strong></td><td>RapidAPI</td><td>Plan gratuit</td><td>Très haute</td></tr>
                    <tr><td><strong>WebSearch ATS</strong></td><td>RapidAPI</td><td>~100 req/mois</td><td>Haute</td></tr>
                </tbody>
            </table>
        </section>

        <!-- RapidAPI -->
        <section id="rapidapi" class="docs-section">
            <h2 class="docs-h2">Intégration RapidAPI</h2>
            <p class="docs-p">
                Fidow intègre 4 APIs RapidAPI pour enrichir les sources de jobs. Une seule clé
                <span class="docs-inline">RAPIDAPI_KEY</span> suffit pour toutes.
            </p>

            <div class="docs-callout docs-callout--warn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <p>Les plans gratuits ont des limites mensuelles (50–200 req/mois). Planifier le scraping à une fréquence raisonnable pour rester dans les quotas.</p>
            </div>

            <table class="docs-table">
                <thead><tr><th>API</th><th>Host RapidAPI</th><th>Usage dans Fidow</th></tr></thead>
                <tbody>
                    <tr><td>Real-Time LinkedIn Scraper</td><td><span class="docs-inline">linkedin-data-api.p.rapidapi.com</span></td><td>Offres LinkedIn par mots-clés</td></tr>
                    <tr><td>LI Data Scraper</td><td><span class="docs-inline">li-data-scraper.p.rapidapi.com</span></td><td>LinkedIn complémentaire</td></tr>
                    <tr><td>Real-Time Web Search</td><td><span class="docs-inline">real-time-web-search.p.rapidapi.com</span></td><td>Jobs sur Greenhouse/Lever/Ashby</td></tr>
                    <tr><td>Job Salary Data</td><td><span class="docs-inline">job-salary-data.p.rapidapi.com</span></td><td>Enrichissement salarial Glassdoor</td></tr>
                </tbody>
            </table>
        </section>

        <!-- Commandes Artisan -->
        <section id="commandes" class="docs-section">
            <h2 class="docs-h2">Commandes Artisan</h2>
            <div class="docs-code"><span class="c"># Scraping — dispatche les sources en queue</span>
php artisan digest:scrape
php artisan digest:scrape --source=linkedin_api   <span class="c"># source spécifique</span>

<span class="c"># Envoi des digests email</span>
php artisan digest:send

<span class="c"># Purge des offres expirées (> 14 jours)</span>
php artisan digest:purge

<span class="c"># Enrichissement salarial via RapidAPI</span>
php artisan digest:enrich-salary
php artisan digest:enrich-salary --limit=100</div>
        </section>

        <!-- LLM -->
        <section id="llm" class="docs-section">
            <h2 class="docs-h2">Providers LLM</h2>
            <p class="docs-p">
                Fidow supporte plusieurs providers IA via l'interface d'administration.
                Chaque provider peut être activé/désactivé, priorisé, et testé directement depuis le dashboard.
            </p>

            <div class="docs-cards">
                <div class="docs-card">
                    <div class="docs-card__title">Groq</div>
                    <div class="docs-card__desc">Très rapide (Llama 3, Mixtral). Recommandé en premier provider.</div>
                </div>
                <div class="docs-card">
                    <div class="docs-card__title">Mistral AI</div>
                    <div class="docs-card__desc">Mistral Large / Small. Excellent pour le français.</div>
                </div>
                <div class="docs-card">
                    <div class="docs-card__title">Google AI</div>
                    <div class="docs-card__desc">Gemini 1.5 Flash / Pro. Très généreux en tokens.</div>
                </div>
                <div class="docs-card">
                    <div class="docs-card__title">Cloudflare AI</div>
                    <div class="docs-card__desc">Workers AI. Plan gratuit conséquent.</div>
                </div>
                <div class="docs-card">
                    <div class="docs-card__title">Cerebras</div>
                    <div class="docs-card__desc">Inférence ultra-rapide. Alternative à Groq.</div>
                </div>
            </div>
        </section>

        <!-- Fallback -->
        <section id="fallback" class="docs-section">
            <h2 class="docs-h2">Fallback automatique LLM</h2>
            <p class="docs-p">
                <span class="docs-inline">DynamicAIService</span> tente les providers dans l'ordre de priorité défini
                en admin. Si un provider échoue (quota, erreur réseau), le suivant est essayé automatiquement.
                Les stats (taux de succès, nombre d'appels) sont loggées par provider.
            </p>
            <div class="docs-callout docs-callout--ok">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <p>Conseil : placer Groq en priorité 1, Mistral en 2, Google AI en 3. Ainsi, si Groq est temporairement indisponible, la génération se fait sans interruption.</p>
            </div>
        </section>

        <!-- Variables .env -->
        <section id="env" class="docs-section">
            <h2 class="docs-h2">Variables d'environnement</h2>
            <div class="docs-code"><span class="c"># Application</span>
<span class="v">APP_NAME</span>=Fidow
<span class="v">APP_URL</span>=https://fidow.nealix.org

<span class="c"># Base de données</span>
<span class="v">DB_CONNECTION</span>=pgsql
<span class="v">DB_DATABASE</span>=fidow_nealix_bd

<span class="c"># Queue</span>
<span class="v">QUEUE_CONNECTION</span>=database

<span class="c"># LLM</span>
<span class="v">GROQ_API_KEY</span>=gsk_...
<span class="v">MISTRAL_API_KEY</span>=...
<span class="v">GOOGLE_AI_API_KEY</span>=...
<span class="v">CLOUDFLARE_API_KEY</span>=...
<span class="v">CEREBRAS_API_KEY</span>=...

<span class="c"># RapidAPI</span>
<span class="v">RAPIDAPI_KEY</span>=...
<span class="v">RAPIDAPI_LINKEDIN_KEYWORDS</span>=remote developer,remote designer

<span class="c"># Scraping</span>
<span class="v">SCRAPING_PROXIES</span>=ip:port,ip:port</div>
        </section>

        <!-- Cron -->
        <section id="cron" class="docs-section">
            <h2 class="docs-h2">Tâches planifiées (Cron)</h2>
            <p class="docs-p">Ajoute cette ligne à ton <span class="docs-inline">crontab -e</span> sur le serveur :</p>
            <div class="docs-code">* * * * * cd /chemin/vers/fidow && php artisan schedule:run >> /dev/null 2>&1</div>
            <p class="docs-p">Le scheduler Laravel exécute ensuite :</p>
            <table class="docs-table">
                <thead><tr><th>Tâche</th><th>Fréquence</th></tr></thead>
                <tbody>
                    <tr><td><span class="docs-inline">digest:scrape</span></td><td>Toutes les 6 heures</td></tr>
                    <tr><td><span class="docs-inline">digest:send</span></td><td>Chaque jour à l'heure configurée</td></tr>
                    <tr><td><span class="docs-inline">digest:purge</span></td><td>Chaque nuit à 3h00</td></tr>
                </tbody>
            </table>
        </section>

        <!-- Queues -->
        <section id="queues" class="docs-section">
            <h2 class="docs-h2">Queues (Workers)</h2>
            <p class="docs-p">Le scraping est asynchrone — chaque source est dispatchée en tant que job Laravel Queue pour ne pas bloquer le serveur. En production avec Supervisor :</p>
            <div class="docs-code"><span class="c"># supervisorctl</span>
[program:fidow-worker]
command=php /chemin/vers/fidow/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
numprocs=2</div>
        </section>

    </div>
</div>

@push('scripts')
<script>
// Surlignage du lien actif selon le scroll
const sections = document.querySelectorAll('.docs-section');
const links = document.querySelectorAll('.docs-nav-link');
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            links.forEach(l => l.classList.remove('active'));
            const active = document.querySelector(`.docs-nav-link[href="#${entry.target.id}"]`);
            if (active) active.classList.add('active');
        }
    });
}, { rootMargin: '-20% 0px -70% 0px' });
sections.forEach(s => observer.observe(s));
</script>
@endpush
@endsection
