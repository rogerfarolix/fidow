@extends('layouts.app')

@section('title', 'Générateur de Phrase de Positionnement - Fidow')

@section('content')
<div x-data="positionnementApp()" x-init="init()" class="fpos-page">

    <!-- HERO -->
    <section class="fpos-hero">
        <div class="fpos-hero__bg" aria-hidden="true">
            <canvas id="positionnementCanvas"></canvas>
            <div class="fpos-ring fpos-ring--1"></div>
            <div class="fpos-ring fpos-ring--2"></div>
            <div class="fpos-ring fpos-ring--3"></div>
            <div class="fpos-blob fpos-blob--1"></div>
            <div class="fpos-blob fpos-blob--2"></div>
        </div>

        <div class="fpos-container">
            <div class="fpos-hero__content">

                <!-- Breadcrumb -->
                <nav class="fpos-breadcrumb" aria-label="Fil d'ariane">
                    <a href="{{ route('home') }}">Accueil</a>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span>Positionnement Pro</span>
                </nav>

                <!-- Badge -->
                <div class="fpos-badge">
                    <span class="fpos-badge__dot"></span>
                    Outil IA gratuit · Résultat en moins de 30 secondes
                </div>

                <!-- Title -->
                <h1 class="fpos-hero__title">
                    Trouve la phrase qui
                    <span>te vend vraiment</span>
                </h1>

                <p class="fpos-hero__subtitle">
                    Génère 3 phrases de positionnement nettes, crédibles et percutantes pour ton LinkedIn, ton portfolio, tes missions freelance ou tes candidatures remote.
                </p>

                <!-- Stats -->
                <div class="fpos-hero__stats">
                    <div class="fpos-mini-stat">
                        <strong>3</strong>
                        <span>phrases générées</span>
                    </div>
                    <div class="fpos-mini-stat">
                        <strong>30s</strong>
                        <span>en moyenne</span>
                    </div>
                    <div class="fpos-mini-stat">
                        <strong>100%</strong>
                        <span>gratuit</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN -->
    <section class="fpos-main">
        <div class="fpos-container">

            <!-- Stepper -->
            <div class="fpos-stepper-wrap">
                <div class="fpos-stepper">
                    <div class="fpos-step" :class="currentStep >= 1 ? 'is-active' : ''">
                        <div class="fpos-step__dot">1</div>
                        <div class="fpos-step__meta">
                            <span class="fpos-step__label">Étape 1</span>
                            <strong>Infos de base</strong>
                        </div>
                    </div>

                    <div class="fpos-step__line" :class="currentStep >= 2 ? 'is-active' : ''"></div>

                    <div class="fpos-step" :class="currentStep >= 2 ? 'is-active' : ''">
                        <div class="fpos-step__dot">2</div>
                        <div class="fpos-step__meta">
                            <span class="fpos-step__label">Étape 2</span>
                            <strong>Personnalisation</strong>
                        </div>
                    </div>

                    <div class="fpos-step__line" :class="currentStep >= 3 ? 'is-active' : ''"></div>

                    <div class="fpos-step" :class="currentStep >= 3 ? 'is-active' : ''">
                        <div class="fpos-step__dot">3</div>
                        <div class="fpos-step__meta">
                            <span class="fpos-step__label">Étape 3</span>
                            <strong>Résultats</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card -->
            <div class="fpos-card-shell">
                <div class="fpos-card-shell__bg" aria-hidden="true">
                    <svg viewBox="0 0 600 600" fill="none">
                        <circle cx="300" cy="300" r="220" stroke="rgba(135,35,35,0.05)" stroke-width="1"/>
                        <circle cx="300" cy="300" r="170" stroke="rgba(135,35,35,0.05)" stroke-width="1"/>
                        <circle cx="300" cy="300" r="120" stroke="rgba(135,35,35,0.04)" stroke-width="1"/>
                        <circle cx="300" cy="300" r="70" stroke="rgba(135,35,35,0.04)" stroke-width="1"/>
                        <line x1="300" y1="60" x2="300" y2="540" stroke="rgba(135,35,35,0.04)" stroke-width="1"/>
                        <line x1="60" y1="300" x2="540" y2="300" stroke="rgba(135,35,35,0.04)" stroke-width="1"/>
                    </svg>
                </div>

                <!-- STEP 1 -->
                <div
                    x-show="currentStep === 1"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="fpos-panel"
                >
                    <div class="fpos-panel__header">
                        <div>
                            <div class="fpos-eyebrow">Étape 1</div>
                            <h2>Commençons par l’essentiel</h2>
                            <p>Donne-nous les bases de ton profil pour générer un positionnement précis et crédible.</p>
                        </div>
                        <div class="fpos-panel__icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 21l-4.35-4.35"></path>
                                <circle cx="11" cy="11" r="6"></circle>
                            </svg>
                        </div>
                    </div>

                    <form @submit.prevent="nextStep()" class="fpos-form-grid">

                        <div class="fpos-field fpos-field--full">
                            <label>Ton métier ou compétence principale <span>*</span></label>
                            <div class="fpos-input-wrap">
                                <input
                                    type="text"
                                    x-model="form.metier"
                                    @input="updateMetierSuggestions()"
                                    placeholder="Ex : Développeur Full Stack, UX Designer, Product Manager..."
                                    required
                                >
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 21l-4.35-4.35"></path>
                                    <circle cx="11" cy="11" r="6"></circle>
                                </svg>
                            </div>

                            <div x-show="metierSuggestions.length > 0" class="fpos-suggestions">
                                <template x-for="suggestion in metierSuggestions" :key="suggestion">
                                    <button type="button" @click="form.metier = suggestion; metierSuggestions = []">
                                        <span x-text="suggestion"></span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div class="fpos-field fpos-field--full">
                            <label>Ton public cible <span>*</span></label>
                            <div class="fpos-input-wrap">
                                <input
                                    type="text"
                                    x-model="form.cible"
                                    @input="updateCibleSuggestions()"
                                    placeholder="Ex : Startups tech, PME, SaaS, entreprises en digitalisation..."
                                    required
                                >
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>

                            <div x-show="cibleSuggestions.length > 0" class="fpos-suggestions">
                                <template x-for="suggestion in cibleSuggestions" :key="suggestion">
                                    <button type="button" @click="form.cible = suggestion; cibleSuggestions = []">
                                        <span x-text="suggestion"></span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div class="fpos-field fpos-field--full">
                            <label>Le résultat concret que tu apportes <span>*</span></label>
                            <div class="fpos-textarea-wrap">
                                <textarea
                                    x-model="form.resultat"
                                    rows="4"
                                    placeholder="Ex : J’aide les startups à lancer leur produit plus vite, à réduire leurs coûts ou à améliorer leurs conversions..."
                                    required
                                ></textarea>
                            </div>
                        </div>

                        <div class="fpos-actions fpos-actions--end">
                            <button
                                type="submit"
                                :disabled="!form.metier || !form.cible || !form.resultat"
                                class="fpos-btn fpos-btn--primary"
                            >
                                Continuer
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4">
                                    <path d="M5 12h14"></path>
                                    <path d="M12 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- STEP 2 -->
                <div
                    x-show="currentStep === 2"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="fpos-panel"
                >
                    <div class="fpos-panel__header">
                        <div>
                            <div class="fpos-eyebrow">Étape 2</div>
                            <h2>Affinons ton positionnement</h2>
                            <p>Ajoute quelques détails pour obtenir un message encore plus aligné avec ton profil et ton style.</p>
                        </div>
                        <div class="fpos-panel__icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 20h16"></path>
                                <path d="M6 16l6-12 6 12"></path>
                            </svg>
                        </div>
                    </div>

                    <form @submit.prevent="generatePhrases()" class="fpos-form-grid">

                        <!-- Tags techno -->
                        <div class="fpos-field fpos-field--full">
                            <label>Technologies & outils <small>(optionnel)</small></label>

                            <div class="fpos-tags" x-show="form.technoTags.length > 0">
                                <template x-for="tag in form.technoTags" :key="tag">
                                    <span class="fpos-tag">
                                        <span x-text="tag"></span>
                                        <button type="button" @click="removeTag('techno', tag)">
                                            <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </span>
                                </template>
                            </div>

                            <div class="fpos-input-wrap">
                                <input
                                    type="text"
                                    @keyup.enter.prevent="addTag('techno', $event.target.value, $event)"
                                    @blur="addTag('techno', $event.target.value, $event)"
                                    placeholder="Ajoute une techno puis appuie sur Entrée..."
                                >
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 5v14"></path>
                                    <path d="M5 12h14"></path>
                                </svg>
                            </div>

                            <div class="fpos-quick-tags">
                                <button type="button" @click="addTag('techno', 'React')">React</button>
                                <button type="button" @click="addTag('techno', 'Vue.js')">Vue.js</button>
                                <button type="button" @click="addTag('techno', 'Figma')">Figma</button>
                                <button type="button" @click="addTag('techno', 'Python')">Python</button>
                                <button type="button" @click="addTag('techno', 'Laravel')">Laravel</button>
                            </div>
                        </div>

                        <!-- Niveau -->
                        <div class="fpos-field">
                            <label>Ton niveau d’expérience</label>
                            <div class="fpos-choice-grid fpos-choice-grid--4">
                                <template x-for="level in ['Débutant', 'Intermédiaire', 'Avancé', 'Expert']" :key="level">
                                    <button
                                        type="button"
                                        @click="form.niveau = level"
                                        :class="form.niveau === level ? 'is-selected' : ''"
                                        class="fpos-choice"
                                        x-text="level"
                                    ></button>
                                </template>
                            </div>
                        </div>

                        <!-- Ton -->
                        <div class="fpos-field">
                            <label>Ton souhaité</label>
                            <div class="fpos-choice-grid fpos-choice-grid--3">
                                <template x-for="tone in ['Professionnel', 'Amical', 'Direct', 'Créatif', 'Pédagogue', 'Résultat-oriented']" :key="tone">
                                    <button
                                        type="button"
                                        @click="form.ton = tone"
                                        :class="form.ton === tone ? 'is-selected' : ''"
                                        class="fpos-choice"
                                        x-text="tone"
                                    ></button>
                                </template>
                            </div>
                        </div>

                        <!-- Longueur -->
                        <div class="fpos-field fpos-field--full">
                            <label>Longueur souhaitée</label>
                            <div class="fpos-range">
                                <input type="range" x-model="form.longueur" min="1" max="3">
                                <div class="fpos-range__label" x-text="getLongueurLabel(form.longueur)"></div>
                            </div>
                        </div>

                        <div class="fpos-actions">
                            <button type="button" @click="previousStep()" class="fpos-btn fpos-btn--secondary">
                                Retour
                            </button>

                            <button type="submit" :disabled="loading" class="fpos-btn fpos-btn--primary">
                                <span x-show="!loading" class="fpos-btn__inner">
                                    Générer mes phrases
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4">
                                        <path d="M5 12h14"></path>
                                        <path d="M12 5l7 7-7 7"></path>
                                    </svg>
                                </span>

                                <span x-show="loading" class="fpos-btn__inner">
                                    <svg class="fpos-spinner" viewBox="0 0 24 24" fill="none">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity=".2"></circle>
                                        <path d="M22 12a10 10 0 0 0-10-10" stroke="currentColor" stroke-width="3" stroke-linecap="round"></path>
                                    </svg>
                                    Génération en cours...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- STEP 3 -->
                <div
                    x-show="currentStep === 3"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="fpos-panel"
                >
                    <div class="fpos-panel__header">
                        <div>
                            <div class="fpos-eyebrow">Étape 3</div>
                            <h2>Voici tes phrases de positionnement</h2>
                            <p>Choisis celle qui te représente le mieux, copie-la ou regénère pour explorer d’autres angles.</p>
                        </div>
                        <div class="fpos-panel__icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 11l3 3L22 4"></path>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                            </svg>
                        </div>
                    </div>

                    <div x-show="results.length > 0" class="fpos-results">
                        <template x-for="(phrase, index) in results" :key="index">
                            <article class="fpos-result-card">
                                <div class="fpos-result-card__head">
                                    <div class="fpos-result-card__index">
                                        <span x-text="index + 1"></span>
                                    </div>
                                    <div>
                                        <div class="fpos-result-card__eyebrow">Option <span x-text="index + 1"></span></div>
                                        <h3>Phrase de positionnement</h3>
                                    </div>
                                </div>

                                <p class="fpos-result-card__text" x-text="phrase"></p>

                                <div x-show="tips && tips[`tip_${getUsageName(index)}`]" class="fpos-tip-card">
                                    <div class="fpos-tip-card__icon">
                                        <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <strong>
                                            Conseil pour
                                            <span x-text="getUsageName(index) === 'linkedin' ? 'LinkedIn' : (getUsageName(index) === 'portfolio' ? 'Portfolio' : (getUsageName(index) === 'freelance' ? 'Freelance' : 'Candidature'))"></span>
                                        </strong>
                                        <p x-text="tips[`tip_${getUsageName(index)}`]"></p>
                                    </div>
                                </div>

                                <div class="fpos-result-card__actions">
                                    <button @click="copyPhrase(phrase)" class="fpos-icon-btn" title="Copier">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="9" y="9" width="13" height="13" rx="2"></rect>
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                        </svg>
                                        Copier
                                    </button>

                                    <button @click="selectPhrase(phrase)" class="fpos-icon-btn fpos-icon-btn--success" title="Choisir">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M9 12l2 2 4-4"></path>
                                            <circle cx="12" cy="12" r="9"></circle>
                                        </svg>
                                        Choisir
                                    </button>
                                </div>
                            </article>
                        </template>
                    </div>

                    <div class="fpos-results-footer">
                        <div class="fpos-actions">
                            <button @click="regeneratePhrases()" :disabled="loading" class="fpos-btn fpos-btn--secondary">
                                <span x-show="!loading">Regénérer</span>
                                <span x-show="loading">Regénération...</span>
                            </button>

                            <button @click="resetForm()" class="fpos-btn fpos-btn--ghost">
                                Recommencer
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Helper block -->
            <div class="fpos-helper-grid">
                <div class="fpos-helper-card">
                    <div class="fpos-helper-card__icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 20h9"></path>
                            <path d="M16.5 3.5a2.12 2.12 0 1 1 3 3L7 19l-4 1 1-4Z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3>Pour LinkedIn</h3>
                        <p>Choisis une version courte et mémorable qui dit clairement ce que tu fais et pour qui.</p>
                    </div>
                </div>

                <div class="fpos-helper-card">
                    <div class="fpos-helper-card__icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16v16H4z"></path>
                            <path d="M8 8h8"></path>
                            <path d="M8 12h8"></path>
                            <path d="M8 16h5"></path>
                        </svg>
                    </div>
                    <div>
                        <h3>Pour ton portfolio</h3>
                        <p>Tu peux prendre une version plus détaillée pour mieux expliquer ta valeur et ton angle.</p>
                    </div>
                </div>

                <div class="fpos-helper-card">
                    <div class="fpos-helper-card__icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                    <div>
                        <h3>Pour le freelance</h3>
                        <p>Mets en avant la transformation apportée au client, pas seulement la liste de tes compétences.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Toast -->
    <div
        x-show="copyNotification"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="fpos-toast"
    >
        <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
        </svg>
        <span>Phrase copiée avec succès</span>
    </div>
</div>

<script>
function positionnementApp() {
    return {
        currentStep: 1,
        loading: false,
        copyNotification: false,
        generationId: null,

        form: {
            metier: '',
            cible: '',
            resultat: '',
            techno: '',
            technoTags: [],
            niveau: '',
            ton: 'Professionnel',
            longueur: 2,
            approche: '',
            extra: '',
            usages: 'LinkedIn'
        },

        metierSuggestions: [],
        cibleSuggestions: [],
        results: [],
        tips: {},

        metierOptions: [],
        cibleOptions: [],

        init() {
            this.$nextTick(() => {
                const firstInput = this.$el.querySelector('input');
                if (firstInput) firstInput.focus();
            });

            this.initCanvas();
            this.loadAutocompleteData();
        },

        async loadAutocompleteData() {
            try {
                // Charger les données d'autocomplétion
                const response = await fetch('{{ asset("js/autocomplete-data.js") }}');
                const scriptText = await response.text();

                // Exécuter le script pour obtenir les données
                eval(scriptText);

                // Récupérer les données depuis la variable globale
                if (typeof autocompleteData !== 'undefined') {
                    this.metierOptions = autocompleteData.metiers;
                    this.cibleOptions = autocompleteData.cibles;
                }
            } catch (error) {
                console.log('Impossible de charger les données d\'autocomplétion, utilisation des données par défaut');
                // Données de secours
                this.metierOptions = [
                    'Développeur Full Stack', 'UX Designer', 'Product Manager', 'Data Scientist',
                    'DevOps Engineer', 'Marketing Digital', 'Business Analyst', 'Consultant IT',
                    'Chef de Projet', 'Architecte Cloud', 'Développeur Web', 'Designer Graphique',
                    'Développeur Mobile', 'Développeur Frontend', 'Développeur Backend'
                ];
                this.cibleOptions = [
                    'Startups', 'PME', 'Grands comptes', 'Entreprises du CAC 40', 'Multinationales',
                    'Agences digitales', 'Freelances', 'Indépendants', 'Clients B2B', 'Clients B2C',
                    'Secteur santé', 'Secteur éducation', 'Secteur finance', 'Secteur retail', 'Secteur public'
                ];
            }
        },

        initCanvas() {
            const canvas = document.getElementById('positionnementCanvas');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            let w, h;

            const resize = () => {
                w = canvas.width = canvas.offsetWidth;
                h = canvas.height = canvas.offsetHeight;
            };

            resize();
            window.addEventListener('resize', resize);

            const render = () => {
                ctx.clearRect(0, 0, w, h);

                const cx = w / 2;
                const cy = h / 2;
                const t = Date.now() * 0.00035;

                for (let arm = 0; arm < 3; arm++) {
                    ctx.beginPath();
                    for (let i = 0; i < 380; i++) {
                        const angle = 0.055 * i + t + (arm * Math.PI * 2 / 3);
                        const radius = 0.7 * i;
                        if (radius > Math.min(w, h) * 0.48) break;

                        const x = cx + radius * Math.cos(angle);
                        const y = cy + radius * Math.sin(angle) * 0.42;

                        if (i === 0) ctx.moveTo(x, y);
                        else ctx.lineTo(x, y);
                    }

                    ctx.strokeStyle = 'rgba(135,35,35,0.08)';
                    ctx.lineWidth = 1;
                    ctx.stroke();
                }

                for (let i = 0; i < 12; i++) {
                    const a = (i / 12) * Math.PI * 2 + t * 0.8;
                    const r = 150 + Math.sin(t * 1.4 + i) * 35;
                    const x = cx + r * Math.cos(a);
                    const y = cy + r * Math.sin(a) * 0.42;

                    ctx.beginPath();
                    ctx.arc(x, y, 1.8, 0, Math.PI * 2);
                    ctx.fillStyle = 'rgba(135,35,35,0.17)';
                    ctx.fill();
                }

                requestAnimationFrame(render);
            };

            render();
        },

        updateMetierSuggestions() {
            const value = this.form.metier.toLowerCase();
            if (value.length < 2) {
                this.metierSuggestions = [];
                return;
            }

            this.metierSuggestions = this.metierOptions.filter(option =>
                option.toLowerCase().includes(value)
            ).slice(0, 5);
        },

        updateCibleSuggestions() {
            const value = this.form.cible.toLowerCase();
            if (value.length < 2) {
                this.cibleSuggestions = [];
                return;
            }

            this.cibleSuggestions = this.cibleOptions.filter(option =>
                option.toLowerCase().includes(value)
            ).slice(0, 5);
        },

        addTag(type, value, evt = null) {
            if (!value || value.trim() === '') return;

            const tag = value.trim();
            if (type === 'techno' && !this.form.technoTags.includes(tag)) {
                this.form.technoTags.push(tag);
                this.form.techno = this.form.technoTags.join(', ');
            }

            if (evt && evt.target) {
                evt.target.value = '';
            }
        },

        removeTag(type, tag) {
            if (type === 'techno') {
                this.form.technoTags = this.form.technoTags.filter(t => t !== tag);
                this.form.techno = this.form.technoTags.join(', ');
            }
        },

        getLongueurLabel(value) {
            const labels = {
                1: 'Très courte (10-18 mots)',
                2: 'Équilibrée (20-30 mots)',
                3: 'Détaillée (30-45 mots)'
            };
            return labels[value] || labels[2];
        },

        getUsageName(index) {
            const names = ['linkedin', 'portfolio', 'freelance'];
            return names[index] || 'linkedin';
        },

        nextStep() {
            this.currentStep++;
        },

        previousStep() {
            this.currentStep--;
        },

        async generatePhrases() {
            this.loading = true;

            try {
                const response = await fetch('{{ route("generer") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(this.form)
                });

                const data = await response.json();

                if (data.error) {
                    alert(data.error);
                    return;
                }

                this.results = [data.p1, data.p2, data.p3];
                this.tips = {
                    tip_linkedin: data.tip_linkedin,
                    tip_portfolio: data.tip_portfolio,
                    tip_freelance: data.tip_freelance,
                    tip_candidature: data.tip_candidature
                };
                this.generationId = data.generation_id;

                this.currentStep = 3;

            } catch (error) {
                console.error('Error:', error);
                alert('Une erreur est survenue. Veuillez réessayer.');
            } finally {
                this.loading = false;
            }
        },

        async regeneratePhrases() {
            this.form.regen = true;
            await this.generatePhrases();
        },

        async copyPhrase(phrase) {
            try {
                await navigator.clipboard.writeText(phrase);
                this.showCopyNotification();
            } catch (error) {
                console.error('Error copying text: ', error);
            }
        },

        showCopyNotification() {
            this.copyNotification = true;
            setTimeout(() => {
                this.copyNotification = false;
            }, 2000);
        },

        async selectPhrase(phrase) {
            if (!this.generationId) return;

            try {
                await fetch(`{{ route("generation.retenir", ":id") }}`.replace(':id', this.generationId), {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ phrase: phrase })
                });

                alert('Excellent choix ! Cette phrase a été sauvegardée.');
            } catch (error) {
                console.error('Error:', error);
            }
        },

        resetForm() {
            this.currentStep = 1;
            this.form = {
                metier: '',
                cible: '',
                resultat: '',
                techno: '',
                technoTags: [],
                niveau: '',
                ton: 'Professionnel',
                longueur: 2,
                approche: '',
                extra: '',
                usages: 'LinkedIn'
            };
            this.results = [];
            this.tips = {};
            this.generationId = null;
        }
    }
}
</script>
@endsection

@push('styles')
<style>
:root{
    --f-red:#872323;
    --f-red-dark:#6f1c1c;
    --f-red-soft:rgba(135,35,35,.08);
    --f-red-line:rgba(135,35,35,.14);
    --f-bg:#ffffff;
    --f-bg-soft:#fafafa;
    --f-text:#111111;
    --f-muted:#6b7280;
    --f-border:rgba(17,17,17,.08);
    --f-shadow:0 20px 60px rgba(0,0,0,.07);
    --f-radius:24px;
    --f-ease:cubic-bezier(.16,1,.3,1);
}

.fpos-page{
    min-height:100vh;
    background:linear-gradient(180deg,#fff 0%,#fafafa 100%);
    color:var(--f-text);
}

.fpos-container{
    width:min(1180px,calc(100% - 2rem));
    margin:0 auto;
}

.fpos-hero{
    position:relative;
    overflow:hidden;
    padding:5.5rem 0 3rem;
    background:#fff;
}

.fpos-hero__bg{
    position:absolute;
    inset:0;
    pointer-events:none;
    overflow:hidden;
}

#positionnementCanvas{
    position:absolute;
    inset:0;
    width:100%;
    height:100%;
}

.fpos-ring{
    position:absolute;
    inset:auto;
    left:50%;
    top:45%;
    border-radius:999px;
    transform:translate(-50%,-50%);
    border:1px solid rgba(135,35,35,.08);
    animation:fposRing 9s ease-in-out infinite;
}
.fpos-ring--1{width:720px;height:720px;}
.fpos-ring--2{width:520px;height:520px;animation-delay:1.2s;}
.fpos-ring--3{width:320px;height:320px;animation-delay:2.1s;}

@keyframes fposRing{
    0%,100%{transform:translate(-50%,-50%) scale(1);opacity:.55}
    50%{transform:translate(-50%,-50%) scale(1.04);opacity:1}
}

.fpos-blob{
    position:absolute;
    border-radius:999px;
    filter:blur(90px);
}
.fpos-blob--1{
    width:380px;height:380px;
    background:radial-gradient(circle,rgba(135,35,35,.12) 0%,transparent 70%);
    top:-60px;left:-80px;
}
.fpos-blob--2{
    width:320px;height:320px;
    background:radial-gradient(circle,rgba(135,35,35,.07) 0%,transparent 70%);
    right:-70px;bottom:20px;
}

.fpos-hero__content{
    position:relative;
    z-index:2;
    max-width:840px;
    margin:0 auto;
    text-align:center;
}

.fpos-breadcrumb{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:.45rem;
    color:#9ca3af;
    font-size:.9rem;
    margin-bottom:1.15rem;
}
.fpos-breadcrumb a{
    color:#6b7280;
    text-decoration:none;
    transition:.2s ease;
}
.fpos-breadcrumb a:hover{color:var(--f-red);}
.fpos-breadcrumb span{color:var(--f-red);font-weight:600;}

.fpos-badge{
    display:inline-flex;
    align-items:center;
    gap:.55rem;
    padding:.5rem .95rem;
    border-radius:999px;
    background:rgba(135,35,35,.07);
    border:1px solid rgba(135,35,35,.15);
    color:var(--f-red);
    font-size:.82rem;
    font-weight:700;
    margin-bottom:1.35rem;
}
.fpos-badge__dot{
    width:7px;height:7px;border-radius:50%;
    background:var(--f-red);
    box-shadow:0 0 0 4px rgba(135,35,35,.12);
    animation:fposPulse 2s ease-in-out infinite;
}
@keyframes fposPulse{
    0%,100%{box-shadow:0 0 0 4px rgba(135,35,35,.12)}
    50%{box-shadow:0 0 0 8px rgba(135,35,35,.04)}
}

.fpos-hero__title{
    font-family:'Space Grotesk',sans-serif;
    font-size:clamp(2.4rem,6vw,5rem);
    line-height:1.02;
    letter-spacing:-.05em;
    font-weight:800;
    margin:0 0 1rem;
    color:#111;
}
.fpos-hero__title span{
    background:linear-gradient(135deg,var(--f-red),#c04040);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    background-clip:text;
}
.fpos-hero__subtitle{
    max-width:720px;
    margin:0 auto 1.75rem;
    font-size:1.05rem;
    line-height:1.8;
    color:var(--f-muted);
}
.fpos-hero__stats{
    display:flex;
    justify-content:center;
    gap:1rem;
    flex-wrap:wrap;
}
.fpos-mini-stat{
    min-width:140px;
    padding:1rem 1.1rem;
    border-radius:18px;
    background:rgba(255,255,255,.75);
    backdrop-filter:blur(10px);
    border:1px solid rgba(17,17,17,.06);
    box-shadow:0 8px 30px rgba(0,0,0,.05);
}
.fpos-mini-stat strong{
    display:block;
    font-family:'Space Grotesk',sans-serif;
    font-size:1.55rem;
    line-height:1;
    color:var(--f-red);
    margin-bottom:.25rem;
}
.fpos-mini-stat span{
    font-size:.82rem;
    color:#6b7280;
}

.fpos-main{
    padding:1rem 0 5rem;
}

.fpos-stepper-wrap{
    margin:0 auto 2rem;
    max-width:980px;
}
.fpos-stepper{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:1rem;
    flex-wrap:wrap;
}
.fpos-step{
    display:flex;
    align-items:center;
    gap:.8rem;
    opacity:.55;
    transition:.25s var(--f-ease);
}
.fpos-step.is-active{opacity:1;}
.fpos-step__dot{
    width:48px;height:48px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    background:#e5e7eb;color:#6b7280;
    font-weight:800;
    transition:.25s var(--f-ease);
}
.fpos-step.is-active .fpos-step__dot{
    background:var(--f-red);
    color:#fff;
    box-shadow:0 8px 24px rgba(135,35,35,.22);
}
.fpos-step__meta{
    display:flex;
    flex-direction:column;
    line-height:1.15;
}
.fpos-step__label{
    font-size:.72rem;
    text-transform:uppercase;
    letter-spacing:.12em;
    color:#9ca3af;
    font-weight:700;
}
.fpos-step__meta strong{
    font-size:.95rem;
    color:#111;
}
.fpos-step__line{
    width:72px;height:1px;
    background:#e5e7eb;
    border-radius:999px;
    transition:.25s var(--f-ease);
}
.fpos-step__line.is-active{
    background:var(--f-red);
}

.fpos-card-shell{
    position:relative;
    overflow:hidden;
    background:#fff;
    border:1px solid var(--f-border);
    border-radius:30px;
    box-shadow:var(--f-shadow);
    max-width:980px;
    margin:0 auto;
}
.fpos-card-shell__bg{
    position:absolute;
    top:-90px;
    right:-90px;
    width:360px;
    height:360px;
    opacity:.9;
    animation:fposSpin 50s linear infinite;
    pointer-events:none;
}
.fpos-card-shell__bg svg{width:100%;height:100%;}
@keyframes fposSpin{
    from{transform:rotate(0deg)}
    to{transform:rotate(360deg)}
}

.fpos-panel{
    position:relative;
    z-index:2;
    padding:2rem;
}
.fpos-panel__header{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:1rem;
    margin-bottom:2rem;
}
.fpos-panel__header h2{
    font-family:'Space Grotesk',sans-serif;
    font-size:2rem;
    line-height:1.05;
    letter-spacing:-.04em;
    margin:0 0 .5rem;
    color:#111;
}
.fpos-panel__header p{
    margin:0;
    color:var(--f-muted);
    line-height:1.7;
    max-width:58ch;
}
.fpos-eyebrow{
    display:inline-block;
    font-size:.75rem;
    font-weight:800;
    letter-spacing:.14em;
    text-transform:uppercase;
    color:var(--f-red);
    margin-bottom:.55rem;
}
.fpos-panel__icon{
    width:52px;height:52px;
    border-radius:16px;
    background:rgba(135,35,35,.08);
    color:var(--f-red);
    display:flex;align-items:center;justify-content:center;
    flex-shrink:0;
}

.fpos-form-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:1.25rem;
}
.fpos-field{display:flex;flex-direction:column;gap:.55rem;}
.fpos-field--full{grid-column:1/-1;}

.fpos-field label{
    font-size:.9rem;
    font-weight:700;
    color:#1f2937;
}
.fpos-field label span{color:#dc2626;}
.fpos-field label small{
    color:#9ca3af;
    font-weight:600;
    font-size:.8rem;
}

.fpos-input-wrap,
.fpos-textarea-wrap{
    position:relative;
}
.fpos-input-wrap input,
.fpos-textarea-wrap textarea{
    width:100%;
    border:1px solid rgba(17,17,17,.09);
    background:#fff;
    border-radius:16px;
    padding:1rem 1rem 1rem 1rem;
    font-size:.97rem;
    color:#111;
    outline:none;
    transition:.25s var(--f-ease);
    box-shadow:0 2px 8px rgba(0,0,0,.02);
}
.fpos-input-wrap input{
    padding-right:3rem;
}
.fpos-input-wrap svg{
    position:absolute;
    right:1rem;
    top:50%;
    transform:translateY(-50%);
    color:#b3b8c2;
}
.fpos-textarea-wrap textarea{
    resize:none;
    min-height:120px;
}
.fpos-input-wrap input:focus,
.fpos-textarea-wrap textarea:focus{
    border-color:rgba(135,35,35,.3);
    box-shadow:0 0 0 4px rgba(135,35,35,.08);
}

.fpos-suggestions{
    display:flex;
    flex-wrap:wrap;
    gap:.55rem;
}
.fpos-suggestions button,
.fpos-quick-tags button{
    border:none;
    background:#f4f4f5;
    color:#4b5563;
    padding:.5rem .8rem;
    border-radius:999px;
    font-size:.82rem;
    font-weight:600;
    cursor:pointer;
    transition:.2s ease;
}
.fpos-suggestions button:hover,
.fpos-quick-tags button:hover{
    background:rgba(135,35,35,.09);
    color:var(--f-red);
}

.fpos-tags{
    display:flex;
    flex-wrap:wrap;
    gap:.55rem;
}
.fpos-tag{
    display:inline-flex;
    align-items:center;
    gap:.35rem;
    padding:.5rem .8rem;
    border-radius:999px;
    background:rgba(135,35,35,.08);
    color:var(--f-red);
    font-size:.82rem;
    font-weight:700;
}
.fpos-tag button{
    border:none;
    background:none;
    color:inherit;
    display:flex;
    align-items:center;
    cursor:pointer;
}

.fpos-quick-tags{
    display:flex;
    flex-wrap:wrap;
    gap:.55rem;
}

.fpos-choice-grid{
    display:grid;
    gap:.75rem;
}
.fpos-choice-grid--4{grid-template-columns:repeat(4,minmax(0,1fr));}
.fpos-choice-grid--3{grid-template-columns:repeat(3,minmax(0,1fr));}

.fpos-choice{
    border:1px solid rgba(17,17,17,.08);
    background:#fafafa;
    color:#374151;
    border-radius:14px;
    padding:.9rem .8rem;
    font-size:.9rem;
    font-weight:700;
    cursor:pointer;
    transition:.25s var(--f-ease);
}
.fpos-choice:hover{
    border-color:rgba(135,35,35,.25);
    color:var(--f-red);
    background:#fff;
}
.fpos-choice.is-selected{
    background:var(--f-red);
    color:#fff;
    border-color:var(--f-red);
    box-shadow:0 10px 24px rgba(135,35,35,.24);
}

.fpos-range{
    display:flex;
    align-items:center;
    gap:1rem;
    padding:1rem 1rem;
    border:1px solid rgba(17,17,17,.08);
    border-radius:16px;
    background:#fafafa;
}
.fpos-range input[type="range"]{
    flex:1;
    accent-color:var(--f-red);
}
.fpos-range__label{
    min-width:220px;
    text-align:center;
    color:var(--f-red);
    font-weight:700;
    font-size:.88rem;
}

.fpos-actions{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:1rem;
    margin-top:.5rem;
    grid-column:1/-1;
}
.fpos-actions--end{
    justify-content:flex-end;
}

.fpos-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:.55rem;
    border:none;
    text-decoration:none;
    cursor:pointer;
    border-radius:14px;
    padding:.95rem 1.3rem;
    font-size:.92rem;
    font-weight:800;
    transition:.25s var(--f-ease);
}
.fpos-btn:disabled{
    opacity:.55;
    cursor:not-allowed;
}
.fpos-btn--primary{
    background:var(--f-red);
    color:#fff;
    box-shadow:0 10px 28px rgba(135,35,35,.22);
}
.fpos-btn--primary:hover:not(:disabled){
    background:var(--f-red-dark);
    transform:translateY(-2px);
}
.fpos-btn--secondary{
    background:#efefef;
    color:#374151;
}
.fpos-btn--secondary:hover{
    background:#e5e7eb;
}
.fpos-btn--ghost{
    background:#fff;
    color:#374151;
    border:1px solid rgba(17,17,17,.08);
}
.fpos-btn--ghost:hover{
    border-color:rgba(135,35,35,.2);
    color:var(--f-red);
}
.fpos-btn__inner{
    display:inline-flex;
    align-items:center;
    gap:.55rem;
}
.fpos-spinner{
    width:18px;
    height:18px;
    animation:fposSpin 1s linear infinite;
}

.fpos-results{
    display:grid;
    gap:1rem;
}
.fpos-result-card{
    border:1px solid rgba(17,17,17,.08);
    border-radius:22px;
    padding:1.5rem;
    background:linear-gradient(180deg,#fff 0%,#fcfcfc 100%);
    box-shadow:0 8px 28px rgba(0,0,0,.04);
    transition:.25s var(--f-ease);
}
.fpos-result-card:hover{
    transform:translateY(-3px);
    border-color:rgba(135,35,35,.18);
    box-shadow:0 18px 40px rgba(135,35,35,.08);
}
.fpos-result-card__head{
    display:flex;
    align-items:center;
    gap:1rem;
    margin-bottom:1rem;
}
.fpos-result-card__index{
    width:46px;height:46px;border-radius:14px;
    background:rgba(135,35,35,.08);
    color:var(--f-red);
    display:flex;align-items:center;justify-content:center;
    font-weight:800;
    font-family:'Space Grotesk',sans-serif;
}
.fpos-result-card__eyebrow{
    font-size:.72rem;
    text-transform:uppercase;
    letter-spacing:.12em;
    color:#9ca3af;
    font-weight:700;
    margin-bottom:.18rem;
}
.fpos-result-card__head h3{
    margin:0;
    font-size:1rem;
    color:#111;
    font-weight:800;
}
.fpos-result-card__text{
    font-size:1.05rem;
    line-height:1.8;
    color:#111;
    margin:0 0 1rem;
}

.fpos-tip-card{
    display:flex;
    align-items:flex-start;
    gap:.85rem;
    padding:1rem;
    border-radius:16px;
    background:#f8fbff;
    border:1px solid #dbeafe;
    margin-bottom:1rem;
}
.fpos-tip-card__icon{
    width:36px;height:36px;border-radius:12px;
    background:#dbeafe;
    color:#2563eb;
    display:flex;align-items:center;justify-content:center;
    flex-shrink:0;
}
.fpos-tip-card strong{
    display:block;
    color:#1e3a8a;
    font-size:.9rem;
    margin-bottom:.3rem;
}
.fpos-tip-card p{
    margin:0;
    color:#2563eb;
    font-size:.86rem;
    line-height:1.7;
}

.fpos-result-card__actions{
    display:flex;
    gap:.75rem;
    flex-wrap:wrap;
}
.fpos-icon-btn{
    display:inline-flex;
    align-items:center;
    gap:.45rem;
    padding:.78rem 1rem;
    border:none;
    border-radius:12px;
    background:#f3f4f6;
    color:#374151;
    font-weight:700;
    cursor:pointer;
    transition:.2s ease;
}
.fpos-icon-btn:hover{
    background:rgba(135,35,35,.08);
    color:var(--f-red);
}
.fpos-icon-btn--success:hover{
    background:rgba(16,185,129,.12);
    color:#059669;
}

.fpos-results-footer{
    margin-top:1.5rem;
}

.fpos-helper-grid{
    margin-top:1.75rem;
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    gap:1rem;
}
.fpos-helper-card{
    display:flex;
    align-items:flex-start;
    gap:.9rem;
    padding:1.2rem;
    border-radius:20px;
    background:#fff;
    border:1px solid rgba(17,17,17,.07);
    box-shadow:0 8px 24px rgba(0,0,0,.04);
}
.fpos-helper-card__icon{
    width:42px;height:42px;border-radius:14px;
    background:rgba(135,35,35,.08);
    color:var(--f-red);
    display:flex;align-items:center;justify-content:center;
    flex-shrink:0;
}
.fpos-helper-card h3{
    margin:0 0 .35rem;
    font-size:1rem;
    font-weight:800;
    color:#111;
}
.fpos-helper-card p{
    margin:0;
    color:#6b7280;
    font-size:.88rem;
    line-height:1.7;
}

.fpos-toast{
    position:fixed;
    right:1.25rem;
    bottom:1.25rem;
    z-index:60;
    display:flex;
    align-items:center;
    gap:.55rem;
    background:#059669;
    color:#fff;
    padding:.95rem 1.1rem;
    border-radius:14px;
    box-shadow:0 20px 50px rgba(5,150,105,.28);
    font-weight:700;
}

@media (max-width: 1024px){
    .fpos-form-grid{
        grid-template-columns:1fr;
    }
    .fpos-choice-grid--4,
    .fpos-choice-grid--3,
    .fpos-helper-grid{
        grid-template-columns:1fr 1fr;
    }
}

@media (max-width: 768px){
    .fpos-hero{
        padding:4.5rem 0 2rem;
    }
    .fpos-stepper{
        align-items:flex-start;
        justify-content:flex-start;
        flex-direction:column;
    }
    .fpos-step__line{
        width:1px;
        height:28px;
        margin-left:24px;
    }
    .fpos-panel{
        padding:1.25rem;
    }
    .fpos-panel__header{
        flex-direction:column;
    }
    .fpos-choice-grid--4,
    .fpos-choice-grid--3,
    .fpos-helper-grid{
        grid-template-columns:1fr;
    }
    .fpos-range{
        flex-direction:column;
        align-items:stretch;
    }
    .fpos-range__label{
        min-width:0;
    }
    .fpos-actions{
        flex-direction:column;
        align-items:stretch;
    }
    .fpos-actions--end{
        align-items:stretch;
    }
    .fpos-hero__stats{
        flex-direction:column;
        align-items:stretch;
    }
    .fpos-mini-stat{
        min-width:0;
    }
}
</style>
@endpush
