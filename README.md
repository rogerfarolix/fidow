# Fidow — Suite d'outils pour professionnels remote

![Laravel](https://img.shields.io/badge/Laravel-11.31-red?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat&logo=php)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.4-38B2AC?style=flat&logo=tailwindcss)
![Vite](https://img.shields.io/badge/Vite-6.0-646CFF?style=flat&logo=vite)
![Python](https://img.shields.io/badge/Python-3.10+-3776AB?style=flat&logo=python)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-compatible-336791?style=flat&logo=postgresql)

> Gratuit · Sans inscription · Toujours disponible
> 🌍 **[fidow.nealix.org](https://fidow.nealix.org)**

Fidow est une plateforme web open-source qui regroupe une suite d'outils pratiques pour les professionnels du travail à distance : générateur de positionnement IA, digest d'offres remote personnalisé, système d'avis, et tableau de bord d'administration complet.

---

## Fonctionnalités

### Générateur de Positionnement Professionnel

- Génère une phrase d'accroche professionnelle personnalisée via IA
- Paramètres : métier, technologies, niveau, cible, spécialisation, ton
- Support multi-providers IA avec **fallback automatique** (Groq → Mistral → Google AI → Cloudflare → Cerebras)
- Historique des générations, possibilité de retenir les phrases favorites
- Rate limit : 5 req/min par IP

### RemoteDigest — Digest d'offres remote

- Agrégation depuis **+18 sources** : Remotive, RemoteOK, WorkingNomads, WeWorkRemotely, Jobicy, LinkedIn, Indeed, Wellfound, FlexJobs, MissionFreelance, 404Works, Jobbers, Freenest…
- **Intégration RapidAPI** : Real-Time LinkedIn Scraper, LI Data Scraper, Real-Time Web Search (Greenhouse/Lever/Ashby)
- Déduplication automatique par fingerprint MD5 (titre + société + URL)
- Abonnement personnalisé : domaine, type de contrat, niveau, salaire min
- Envoi quotidien par email, digest HTML complet avec tracking de clics
- Enrichissement salarial via Job Salary Data (Glassdoor) — commande dédiée

### Système d'Avis

- Soumission d'avis avec validation anti-spam (throttle : 3 req/min)
- Modération admin : approbation / rejet
- Affichage public des avis validés

### Administration

- Dashboard avec statistiques en temps réel
- Gestion dynamique des providers LLM (priorité, activation, test de connectivité)
- Monitoring par provider : taux de succès, nombre d'appels, dernière utilisation
- Gestion des abonnés RemoteDigest et des job listings scrapés

---

## Stack technique

| Couche | Technologie |
| ------ | ----------- |
| Framework | Laravel 11.31 |
| PHP | 8.2+ |
| Base de données | PostgreSQL (MySQL compatible) |
| Queue | Laravel Queues (database driver) |
| CSS | TailwindCSS 3.4 + animations CSS custom |
| JS | Alpine.js 3, Axios |
| Build | Vite 6 |
| Scraping headless | Python 3.10 + Scrapling + Playwright |
| Email | Laravel Mail (SMTP configurable) |
| Providers LLM | Groq, Mistral, Google AI, Cloudflare Workers AI, Cerebras |

---

## Installation

### Prérequis

- PHP 8.2+, Composer
- Node.js 18+
- PostgreSQL ou MySQL
- Python 3.10+ (pour le scraper headless — optionnel)

### 1. Cloner et installer

```bash
git clone https://github.com/rogerfarolx/fidow.git
cd fidow

composer install
npm install && npm run build

cp .env.example .env
php artisan key:generate
```

### 2. Base de données

```bash
# Configurer .env (DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD)
php artisan migrate
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=LlmConfigurationSeeder
```

### 3. Python — scraper headless (optionnel)

Requis uniquement pour les sources LinkedIn, Indeed, Wellfound et consorts :

```bash
cd python_scrapers
python3 -m venv venv
source venv/bin/activate
pip install scrapling playwright
playwright install chromium
cd ..
```

### 4. Lancer en développement

```bash
php artisan serve
php artisan queue:work   # dans un autre terminal
```

---

## Variables d'environnement

```env
# Application
APP_URL=https://fidow.nealix.org
APP_LOCALE=fr

# Base de données
DB_CONNECTION=pgsql
DB_DATABASE=fidow_nealix_bd

# Queue
QUEUE_CONNECTION=database

# Providers LLM (au moins un requis pour le positionnement)
GROQ_API_KEY=gsk_...
MISTRAL_API_KEY=...
GOOGLE_AI_API_KEY=...
CLOUDFLARE_API_KEY=...
CLOUDFLARE_ACCOUNT_ID=...
CEREBRAS_API_KEY=...

# RapidAPI — une seule clé pour toutes les APIs souscrites
# → https://rapidapi.com/developer/apps
RAPIDAPI_KEY=...
RAPIDAPI_LINKEDIN_KEYWORDS="remote developer,remote designer,remote data scientist,remote marketing,remote product manager,remote devops"
RAPIDAPI_WEBSEARCH_QUERIES="remote developer engineer jobs site:greenhouse.io OR site:lever.co|remote designer ux ui jobs site:greenhouse.io OR site:lever.co"

# Scraping proxies (optionnel)
SCRAPING_PROXIES=ip:port,ip:port
```

---

## Commandes Artisan

```bash
# Scraping — dispatche chaque source en queue
php artisan digest:scrape
php artisan digest:scrape --source=linkedin_api   # source unique

# Envoi des digests email du jour
php artisan digest:send

# Purge des offres expirées (> 14 jours)
php artisan digest:purge

# Enrichissement salarial via Glassdoor (RapidAPI)
php artisan digest:enrich-salary --limit=50
```

---

## Tâches planifiées (Cron)

Ajouter au crontab :

```cron
* * * * * cd /var/www/fidow && php artisan schedule:run >> /dev/null 2>&1
```

| Tâche | Fréquence |
| ----- | --------- |
| `digest:scrape` | Toutes les 6 heures |
| `digest:send` | Chaque jour (heure configurable) |
| `digest:purge` | Chaque nuit à 3h00 |

---

## Sources d'offres

| Source | Type | Coût |
| ------ | ---- | ---- |
| Remotive | API JSON | Gratuit |
| RemoteOK | API JSON | Gratuit |
| WorkingNomads | API JSON | Gratuit |
| WeWorkRemotely | RSS | Gratuit |
| Jobicy | RSS | Gratuit |
| Jobspresso | RSS | Gratuit |
| LinkedIn, Indeed, Wellfound, FlexJobs | Python/Scrapling | Gratuit (anti-bot) |
| MissionFreelance, 404Works, Jobbers, Freenest | Python/Scrapling | Gratuit |
| **LinkedIn API** (RapidAPI) | API REST | ~100 req/mois gratuit |
| **LI Data Scraper** (RapidAPI) | API REST | Plan gratuit |
| **WebSearch ATS** – Greenhouse/Lever/Ashby | API REST | ~100 req/mois gratuit |

---

## Structure du projet

```text
fidow/
├── app/
│   ├── Console/Commands/
│   │   ├── ScrapeJobsCommand.php          # digest:scrape
│   │   ├── SendDailyDigestCommand.php     # digest:send
│   │   ├── PurgeOldJobsCommand.php        # digest:purge
│   │   └── EnrichJobSalaryCommand.php     # digest:enrich-salary
│   ├── Http/Controllers/
│   ├── Jobs/
│   │   ├── ScrapeSourceJob.php            # Job queue par source (3 retries)
│   │   └── SendDigestEmailJob.php
│   ├── Models/
│   │   ├── JobListing.php                 # fingerprint, scopes, accessors
│   │   ├── DigestSubscriber.php
│   │   ├── LlmConfiguration.php
│   │   └── PositioningGeneration.php
│   └── Services/
│       ├── MultiSourceScraperService.php  # Scraping + RapidAPI + enrichissement
│       └── DynamicAIService.php           # Sélection et fallback LLM
├── python_scrapers/
│   └── main.py                            # Scrapling headless (LinkedIn, Indeed…)
├── resources/views/
│   ├── accueil/                           # Page d'accueil animée
│   ├── positionnement/                    # Générateur IA
│   ├── digest/                            # RemoteDigest abonnement
│   ├── avis/                              # Avis clients
│   ├── docs/                              # Documentation
│   ├── don/                               # Page de soutien / donation
│   └── admin/                             # Dashboard + gestion LLM
└── routes/web.php
```

---

## Déploiement VPS

### Optimisations production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### Supervisor (queue worker)

```ini
[program:fidow-worker]
command=php /var/www/fidow/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
numprocs=2
stdout_logfile=/var/log/fidow-worker.log
```

---

## Contribuer

1. Fork le repo
2. Crée une branche : `git checkout -b feat/ma-fonctionnalite`
3. Commit : `git commit -m 'feat: description'`
4. Push : `git push origin feat/ma-fonctionnalite`
5. Ouvre une Pull Request

---

## Soutenir le projet

Fidow est entièrement gratuit et sans publicité. Si le projet t'a été utile :

- [Ko-fi](https://ko-fi.com/rogergnanih) — don unique ou mensuel
- [PayPal](https://paypal.me/rogergnanih)
- [GitHub Sponsors](https://github.com/sponsors/rogerfarolx)

Voir aussi la [page de don](https://fidow.nealix.org/don) sur la plateforme.

---

## Auteur

**Roger Gnanih** — [roger.nealix.org](https://roger.nealix.org) · [professionnelroger@gmail.com](mailto:professionnelroger@gmail.com)

---

## Licence

MIT — libre d'utilisation, modification et distribution.
