# Fidow - Plateforme IA Multifonctionnelle

![Laravel](https://img.shields.io/badge/Laravel-11.31-red?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat&logo=php)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.4-38B2AC?style=flat&logo=tailwindcss)
![Vite](https://img.shields.io/badge/Vite-6.0-646CFF?style=flat&logo=vite)

Fidow est une plateforme web multifonctionnelle basée sur Laravel qui intègre plusieurs services intelligents : génération de positionnement professionnel, système d'avis clients, digest d'offres d'emploi, et administration dynamique de providers IA.

## 🌟 Fonctionnalités Principales

### 🎯 Générateur de Positionnement Professionnel
- Création de textes de positionnement personnalisés via IA
- Configuration multi-paramètres (métier, technologies, niveau, cible, etc.)
- Support de plusieurs providers IA avec système de fallback automatique
- Historique des générations et possibilité de retenir les phrases préférées

### 📊 Système d'Avis Clients
- Soumission d'avis avec validation et modération
- Interface d'administration pour approuver/rejeter les avis
- Système de throttling pour prévenir les abus
- Affichage public des avis validés

### 📧 Digest d'Offres d'Emploi
- Abonnement personnalisé avec préférences (domaine, contrat, niveau, salaire)
- Agrégation d'offres d'emploi avec déduplication automatique
- Envoi automatisé de digests par email selon les fuseaux horaires
- Interface de gestion des abonnés et des préférences

### 🤖 Administration des Providers IA
- Configuration dynamique de multiples providers IA (Groq, Mistral, Google AI, Cloudflare, Cerebras)
- Système de priorité et fallback automatique
- Monitoring des statistiques d'utilisation et taux de succès
- Tests de connectivité et gestion des clés API

### 📈 Tableaux de Bord et Statistiques
- Interface d'administration complète avec dashboard
- Statistiques d'utilisation en temps réel
- Monitoring des performances des services IA
- Export de données et rapports

## 🏗️ Architecture Technique

### Backend
- **Framework**: Laravel 11.31
- **PHP**: 8.2+
- **Base de données**: MySQL/PostgreSQL (configurable)
- **Queue System**: Laravel Queues pour les tâches asynchrones
- **Cache**: Redis/File (configurable)

### Frontend
- **Build Tool**: Vite 6.0
- **CSS Framework**: TailwindCSS 3.4
- **JavaScript**: Vanilla JS avec Axios
- **Styling**: Support Dark Mode avec patch automatique

### Services Externes
- **Providers IA**: Groq, Mistral, Google AI, Cloudflare Workers AI, Cerebras
- **Email**: Laravel Mail (configurable)
- **Monitoring**: Logs intégrés et statistiques

## 📦 Dépendances

### PHP (via Composer)
```json
{
    "laravel/framework": "^11.31",
    "laravel/tinker": "^2.9",
    "laravel/pail": "^1.1",
    "laravel/pint": "^1.13",
    "laravel/sail": "^1.26"
}
```

### Node.js (via NPM)
```json
{
    "vite": "^6.0.11",
    "laravel-vite-plugin": "^1.2.0",
    "tailwindcss": "^3.4.13",
    "autoprefixer": "^10.4.20",
    "axios": "^1.7.4"
}
```

## 🚀 Installation

### Prérequis
- PHP 8.2+
- Composer
- Node.js 18+
- Base de données (MySQL/PostgreSQL/SQLite)

### Étapes d'Installation

1. **Cloner le repository**
```bash
git clone <repository-url>
cd fidow
```

2. **Installer les dépendances**
```bash
composer install
npm install
```

3. **Configuration de l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurer la base de données**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fidow
DB_USERNAME=root
DB_PASSWORD=
```

5. **Configurer les services IA**
```env
# Groq
GROQ_KEY=your_groq_api_key

# Mistral
MISTRAL_API_KEY=your_mistral_api_key

# Google AI
GOOGLE_AI_API_KEY=your_google_ai_api_key

# Cloudflare
CLOUDFLARE_API_KEY=your_cloudflare_api_key
CLOUDFLARE_ACCOUNT_ID=your_account_id

# Cerebras
CEREBRAS_API_KEY=your_cerebras_api_key
```

6. **Exécuter les migrations**
```bash
php artisan migrate
```

7. **Lancer le serveur de développement**
```bash
npm run dev
php artisan serve
```

## 📁 Structure du Projet

```
fidow/
├── app/
│   ├── Http/Controllers/          # Contrôleurs MVC
│   ├── Models/                    # Modèles Eloquent
│   ├── Services/                  # Services métier
│   └── Jobs/                      # Tâches asynchrones
├── database/
│   ├── migrations/                # Migrations de base de données
│   ├── seeders/                   # Données initiales
│   └── factories/                 # Factories pour les tests
├── resources/
│   ├── views/                     # Templates Blade
│   ├── css/                       # Styles TailwindCSS
│   └── js/                        # JavaScript frontend
├── routes/
│   ├── web.php                    # Routes web
│   └── console.php                # Commandes Artisan
└── config/                        # Configuration Laravel
```

## 🔧 Configuration

### Providers IA
Les providers IA sont configurés via l'interface d'administration dans `/admin/llm`. Vous pouvez :

- Ajouter/supprimer des providers
- Définir l'ordre de priorité
- Configurer les paramètres (temperature, max_tokens, timeout)
- Activer/désactiver les providers
- Définir un provider principal

### Digest d'Emploi
Configurez les domaines supportés et les préférences d'abonnement :

- Domaines: dev, design, marketing, cyber, data, product, other
- Types de contrat: full_time, part_time, freelance, contract
- Niveaux: junior, mid, senior, expert
- Pays et salaires minimums

### Throttling et Limites
- Génération de positionnement: 5 requêtes/minute
- Soumission d'avis: 3 requêtes/minute
- Abonnement digest: 5 requêtes/5 minutes

## 📊 API Endpoints

### Public
- `GET /` - Page d'accueil
- `GET /stats` - Statistiques publiques
- `GET /positionnement` - Formulaire de positionnement
- `POST /generer` - Génération de positionnement
- `GET /avis` - Liste des avis
- `POST /avis` - Soumission d'avis

### Digest
- `GET /remote-digest` - Page d'abonnement
- `POST /remote-digest/subscribe` - Inscription
- `GET /remote-digest/unsubscribe/{token}` - Désabonnement
- `GET /remote-digest/preferences/{token}` - Préférences

### Administration
- `GET /admin/login` - Connexion admin
- `GET /admin/dashboard` - Tableau de bord
- `GET /admin/llm` - Gestion des providers IA
- `GET /admin/avis` - Modération des avis
- `GET /admin/data` - Données et statistiques

## 🧪 Tests

### Exécuter les tests
```bash
php artisan test
```

### Tests unitaires
```bash
vendor/bin/phpunit
```

### Code Style
```bash
vendor/bin/pint
```

## 📝 Scripts Utiles

### Développement
```bash
# Lancer tous les services de développement
composer run dev

# Vider les caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Dark Mode Patch
Un script Python est disponible pour ajouter le support dark mode aux templates existants :
```bash
python patch_admin_dark_mode.py
```

## 🔒 Sécurité

- Validation rigoureuse des entrées utilisateur
- Protection CSRF activée
- Throttling configurable
- Hashage des mots de passe avec bcrypt
- Validation des emails et tokens
- Logs détaillés pour l'audit

## 📈 Monitoring

### Logs
- Logs d'application via Laravel Log
- Logs spécifiques pour les services IA
- Monitoring des erreurs et performances

### Statistiques
- Taux de succès des providers IA
- Nombre d'utilisations par service
- Performance des temps de réponse
- Historique des générations

## 🤝 Contribution

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/amazing-feature`)
3. Commit les changements (`git commit -m 'Add amazing feature'`)
4. Push vers la branche (`git push origin feature/amazing-feature`)
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 🆘 Support

Pour toute question ou support technique :

- Créer une issue sur le repository GitHub
- Consulter la documentation Laravel officielle
- Vérifier les logs dans `storage/logs/laravel.log`

---

**Développé avec ❤️ par [Votre Nom]**