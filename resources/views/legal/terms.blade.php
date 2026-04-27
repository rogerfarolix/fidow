@extends('layouts.app')

@section('title', 'Conditions d\'utilisation - Fidow')

@section('content')
<div class="legal-page">
    <div class="legal-container">
        
        <header class="legal-header">
            <div class="legal-breadcrumb">
                <a href="{{ route('home') }}">Accueil</a>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
                <span>Conditions d'utilisation</span>
            </div>
            
            <div class="legal-title">
                <h1>Conditions d'utilisation</h1>
                <p class="legal-subtitle">Dernière mise à jour : {{ now()->format('d/m/Y') }}</p>
            </div>
        </header>

        <main class="legal-content">
            <div class="legal-intro">
                <p>
                    Bienvenue sur Fidow ! Ces conditions d'utilisation régissent votre accès et votre utilisation de notre service 
                    de génération de phrases de positionnement professionnel. En utilisant Fidow, vous acceptez ces conditions.
                </p>
            </div>

            <!-- Toutes les sections 1 à 10 conservées à l'identique -->

            <section class="legal-section">
                <h2>📧 11. Contact</h2>
                
                <div class="contact-info">
                    <p><strong>Pour toute question concernant ces conditions d'utilisation :</strong></p>
                    <ul>
                        <li><strong>E-mail</strong> : <a href="mailto:roger@nealix.org">roger@nealix.org</a></li>
                        <li><strong>Adresse</strong> : Porto‑Novo, Bénin</li>
                        <li><strong>Téléphone</strong> : +229 01 54 53 5035</li>
                        <li><strong>Site</strong> : <a href="https://roger.nealix.org" target="_blank">roger.nealix.org</a></li>
                    </ul>
                </div>
                
                <p>Nous nous engageons à répondre à votre demande dans un délai de 30 jours.</p>
            </section>
        </main>

        <footer class="legal-footer">
            <div class="legal-footer-content">
                <p>
                    En utilisant Fidow, vous reconnaissez avoir lu, compris et accepté ces conditions d'utilisation.
                </p>
                <div class="legal-footer-links">
                    <a href="{{ route('privacy') }}">Politique de confidentialité</a>
                    <a href="{{ route('home') }}">Retour à l'accueil</a>
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Mêmes styles que la page confidentialité (déjà définis ci-dessus) */
/* On peut les regrouper dans un fichier commun, mais pour la réponse on les duplique */
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

body { background-color: var(--bg-body); }

.legal-page {
    min-height: 100vh;
    padding: 2rem 1rem;
    background: var(--bg-body);
    color: var(--text-2);
    font-family: 'Inter', system-ui, sans-serif;
}

.legal-container { max-width: 900px; margin: 0 auto; }
.legal-header { margin-bottom: 2.5rem; }
.legal-breadcrumb {
    display: flex; align-items: center; gap: 0.5rem;
    font-size: 0.85rem; color: var(--text-3); margin-bottom: 1.25rem;
}
.legal-breadcrumb a { color: var(--text-3); text-decoration: none; transition: color 0.2s; }
.legal-breadcrumb a:hover { color: var(--fr); }
.legal-breadcrumb span { color: var(--fr); font-weight: 600; }

.legal-title h1 {
    font-family: 'Space Grotesk', sans-serif;
    font-size: clamp(1.8rem, 4vw, 2.4rem);
    font-weight: 800;
    color: var(--text-1);
    margin-bottom: 0.4rem;
    letter-spacing: -0.02em;
}
.legal-subtitle { font-size: 0.9rem; color: var(--text-3); }

.legal-intro,
.legal-section,
.legal-footer {
    background: var(--bg-white);
    border-radius: 1.25rem;
    padding: 1.75rem 2rem;
    margin-bottom: 1.5rem;
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
}
.legal-intro { margin-bottom: 2rem; }
.legal-section { margin-bottom: 1.5rem; }
.legal-section h2 {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text-1);
    margin-bottom: 1rem;
}
.legal-section h3 { font-size: 1rem; font-weight: 600; margin: 1.5rem 0 0.75rem; }
.legal-section p, .legal-section li {
    font-size: 0.95rem; line-height: 1.65; color: var(--text-2);
}
.legal-section ul { padding-left: 1.5rem; margin-bottom: 1rem; }
.legal-section a { color: var(--fr); font-weight: 500; }
.legal-section a:hover { text-decoration: underline; }

.contact-info {
    background: rgba(135,35,35,.03);
    border-radius: 0.75rem;
    padding: 1.25rem;
    margin: 1.5rem 0;
    border: 1px solid rgba(135,35,35,.1);
}
.contact-info ul { list-style: none; padding: 0; }
.contact-info li { padding: 0.35rem 0; border-bottom: 1px solid var(--border); font-size: 0.9rem; }
.contact-info li:last-child { border-bottom: none; }

.legal-footer { margin-top: 2.5rem; text-align: center; }
.legal-footer p { font-size: 0.85rem; color: var(--text-3); margin-bottom: 0.75rem; }
.legal-footer-links { display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap; }
.legal-footer-links a { color: var(--fr); font-weight: 500; }
.legal-footer-links a:hover { opacity: 0.8; }

@media (max-width: 640px) {
    .legal-page { padding: 1.5rem 0.75rem; }
    .legal-intro, .legal-section, .legal-footer { padding: 1.25rem 1.25rem; }
    .legal-section h2 { font-size: 1.15rem; }
    .legal-title h1 { font-size: 1.6rem; }
    .legal-footer-links { flex-direction: column; gap: 0.5rem; }
}
</style>
@endpush