@extends('layouts.app')

@section('title', 'Politique de confidentialité - Fidow')

@section('content')
<div class="legal-page">
    <div class="legal-container">
        
        <header class="legal-header">
            <div class="legal-breadcrumb">
                <a href="{{ route('home') }}">Accueil</a>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
                <span>Politique de confidentialité</span>
            </div>
            
            <div class="legal-title">
                <h1>Politique de confidentialité</h1>
                <p class="legal-subtitle">Dernière mise à jour : {{ now()->format('d/m/Y') }}</p>
            </div>
        </header>

        <main class="legal-content">
            <div class="legal-intro">
                <p>
                    Chez Fidow, nous nous engageons à protéger votre vie privée et à garantir la sécurité de vos données personnelles. 
                    Cette politique de confidentialité explique comment nous collectons, utilisons et protégeons vos informations lorsque vous utilisez notre service.
                </p>
            </div>

            <section class="legal-section">
                <h2>📋 1. Données collectées</h2>
                
                <h3>1.1 Données personnelles fournies</h3>
                <p>Lors de votre utilisation de Fidow, nous pouvons collecter les informations suivantes :</p>
                <ul>
                    <li><strong>Adresse e-mail</strong> : lors de la création d'un compte ou de la soumission d'avis</li>
                    <li><strong>Nom et prénom</strong> : pour personnaliser votre expérience et les avis</li>
                    <li><strong>Informations professionnelles</strong> : métier, niveau d'expérience, technologies</li>
                    <li><strong>Contenu généré</strong> : phrases de positionnement que vous créez</li>
                </ul>

                <h3>1.2 Données techniques collectées automatiquement</h3>
                <p>Nous collectons également certaines données techniques pour améliorer notre service :</p>
                <ul>
                    <li><strong>Adresse IP</strong> : pour des raisons de sécurité et d'analyse</li>
                    <li><strong>Type de navigateur et appareil</strong> : pour optimiser l'expérience utilisateur</li>
                    <li><strong>Données d'utilisation</strong> : pages visitées, temps passé, fonctionnalités utilisées</li>
                    <li><strong>Cookies</strong> : pour améliorer votre expérience de navigation</li>
                </ul>
            </section>

            <!-- les autres sections restent identiques au contenu précédent -->

            <section class="legal-section">
                <h2>📧 8. Contact</h2>
                
                <div class="contact-info">
                    <p><strong>Pour toute question concernant cette politique de confidentialité :</strong></p>
                    <ul>
                        <li><strong>E-mail</strong> : <a href="mailto:roger@nealix.org">roger@nealix.org</a></li>
                        <li><strong>Adresse</strong> : Porto‑Novo, Bénin</li>
                        <li><strong>Téléphone</strong> : +229 01 54 53 5035</li>
                        <li><strong>Site web</strong> : <a href="https://roger.nealix.org" target="_blank">roger.nealix.org</a></li>
                    </ul>
                </div>
                
                <p>Nous nous engageons à répondre à votre demande dans un délai de 30 jours.</p>
            </section>
        </main>

        <footer class="legal-footer">
            <div class="legal-footer-content">
                <p>
                    Cette politique de confidentialité s'applique à tous les utilisateurs de Fidow 
                    et à l'ensemble de nos services en ligne.
                </p>
                <div class="legal-footer-links">
                    <a href="{{ route('terms') }}">Conditions d'utilisation</a>
                    <a href="{{ route('home') }}">Retour à l'accueil</a>
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ─────────────────────────────────────────
   LEGAL PAGES STYLES – Intégrées au thème Fidow
   Teintes douces, cohérent avec le reste du site
───────────────────────────────────────── */
:root {
    --fr:    #872323;
    --bg-body: #fef7f7;
    --bg-white: #fff9f9;
    --text-1: #111;
    --text-2: #374151;
    --text-3: #6b7280;
    --border: rgba(0,0,0,.07);
    --shadow: 0 2px 12px rgba(0,0,0,.05);
}

body {
    background-color: var(--bg-body);
}

.legal-page {
    min-height: 100vh;
    padding: 2rem 1rem;
    background: var(--bg-body);
    color: var(--text-2);
    font-family: 'Inter', system-ui, sans-serif;
}

.legal-container {
    max-width: 900px;
    margin: 0 auto;
}

.legal-header {
    margin-bottom: 2.5rem;
}

.legal-breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    color: var(--text-3);
    margin-bottom: 1.25rem;
}
.legal-breadcrumb a {
    color: var(--text-3);
    text-decoration: none;
    transition: color 0.2s;
}
.legal-breadcrumb a:hover { color: var(--fr); }
.legal-breadcrumb span {
    color: var(--fr);
    font-weight: 600;
}

.legal-title h1 {
    font-family: 'Space Grotesk', sans-serif;
    font-size: clamp(1.8rem, 4vw, 2.4rem);
    font-weight: 800;
    color: var(--text-1);
    margin-bottom: 0.4rem;
    letter-spacing: -0.02em;
}

.legal-subtitle {
    font-size: 0.9rem;
    color: var(--text-3);
    font-weight: 500;
}

.legal-intro {
    background: var(--bg-white);
    border-radius: 1.25rem;
    padding: 1.75rem 2rem;
    margin-bottom: 2rem;
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
}

.legal-intro p {
    font-size: 1.05rem;
    line-height: 1.7;
    color: var(--text-2);
    margin: 0;
}

.legal-section {
    background: var(--bg-white);
    border-radius: 1.25rem;
    padding: 1.75rem 2rem;
    margin-bottom: 1.5rem;
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
}

.legal-section h2 {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text-1);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.legal-section h3 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-1);
    margin: 1.5rem 0 0.75rem;
}

.legal-section p,
.legal-section li {
    font-size: 0.95rem;
    line-height: 1.65;
    color: var(--text-2);
    margin-bottom: 0.75rem;
}

.legal-section ul {
    padding-left: 1.5rem;
    margin-bottom: 1rem;
}
.legal-section li {
    margin-bottom: 0.3rem;
}

.legal-section a {
    color: var(--fr);
    text-decoration: none;
    font-weight: 500;
}
.legal-section a:hover { text-decoration: underline; }

.contact-info {
    background: rgba(135,35,35,.03);
    border-radius: 0.75rem;
    padding: 1.25rem;
    margin: 1.5rem 0;
    border: 1px solid rgba(135,35,35,.1);
}
.contact-info ul {
    list-style: none;
    padding-left: 0;
    margin: 0;
}
.contact-info li {
    padding: 0.35rem 0;
    border-bottom: 1px solid var(--border);
    font-size: 0.9rem;
}
.contact-info li:last-child { border-bottom: none; }

.legal-footer {
    background: var(--bg-white);
    border-radius: 1.25rem;
    padding: 1.75rem 2rem;
    margin-top: 2.5rem;
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    text-align: center;
}
.legal-footer p {
    font-size: 0.85rem;
    color: var(--text-3);
    margin-bottom: 0.75rem;
}
.legal-footer-links {
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
}
.legal-footer-links a {
    color: var(--fr);
    font-weight: 500;
    transition: opacity 0.2s;
}
.legal-footer-links a:hover { opacity: 0.8; }

@media (max-width: 640px) {
    .legal-page { padding: 1.5rem 0.75rem; }
    .legal-intro,
    .legal-section,
    .legal-footer { padding: 1.25rem 1.25rem; }
    .legal-section h2 { font-size: 1.15rem; }
    .legal-title h1 { font-size: 1.6rem; }
    .legal-footer-links { flex-direction: column; gap: 0.5rem; }
}
</style>
@endpush