/**
 * autocomplete-data.js
 * Données d'autocomplétion pour le générateur de positionnement Fidow
 * Place ce fichier dans /public/js/autocomplete-data.js
 */

window.autocompleteData = {

    // ─────────────────────────────────────────────
    //  MÉTIERS — 350+ entrées
    // ─────────────────────────────────────────────
    metiers: [
        // Développement Web & Mobile
        "Développeur Web", "Développeur Web Fullstack", "Développeur Frontend", "Développeur Backend",
        "Développeur Full Stack", "Développeur Mobile", "Développeur iOS", "Développeur Android",
        "Développeur React Native", "Développeur Flutter", "Développeur React", "Développeur Vue.js",
        "Développeur Angular", "Développeur Node.js", "Développeur Laravel", "Développeur Symfony",
        "Développeur Django", "Développeur Rails", "Développeur PHP", "Développeur Python",
        "Développeur JavaScript", "Développeur TypeScript", "Développeur Java", "Développeur Kotlin",
        "Développeur Swift", "Développeur Go", "Développeur Rust", "Développeur C#",
        "Développeur .NET", "Développeur Spring Boot", "Développeur NestJS", "Développeur Next.js",
        "Développeur Nuxt.js", "Développeur WordPress", "Développeur Shopify", "Développeur Magento",
        "Développeur PrestaShop", "Développeur Webflow", "Intégrateur Web", "Intégrateur HTML/CSS",

        // Architecture & Infrastructure
        "Architecte Logiciel", "Architecte Cloud", "Architecte Solution", "Architecte Données",
        "Architecte Sécurité", "Architecte Microservices", "Architecte API", "Architecte Technique",
        "Lead Developer", "Lead Tech", "Tech Lead", "CTO", "VP Engineering",
        "Engineering Manager", "Staff Engineer", "Principal Engineer", "Senior Engineer",

        // DevOps & Cloud & SRE
        "DevOps Engineer", "Cloud Engineer", "Site Reliability Engineer", "Platform Engineer",
        "Infrastructure Engineer", "System Administrator", "Network Engineer", "Linux Administrator",
        "AWS Engineer", "Azure Engineer", "GCP Engineer", "Cloud Architect",
        "Kubernetes Engineer", "Docker Specialist", "CI/CD Engineer", "MLOps Engineer",
        "DataOps Engineer", "FinOps Specialist", "Infrastructure as Code Specialist",

        // Data & IA
        "Data Scientist", "Data Analyst", "Data Engineer", "Data Architect",
        "Machine Learning Engineer", "AI Engineer", "Deep Learning Engineer", "NLP Engineer",
        "Computer Vision Engineer", "MLOps Engineer", "Analytics Engineer", "BI Developer",
        "Business Intelligence Developer", "Power BI Consultant", "Tableau Developer",
        "Looker Developer", "Databricks Engineer", "Spark Engineer", "Hadoop Engineer",
        "Quantitative Analyst", "Statisticien", "Actuaire", "Scientifique des Données",
        "Data Product Manager", "AI Product Manager", "Prompt Engineer", "LLM Engineer",
        "RAG Specialist", "AI Consultant", "Consultant IA", "Expert en IA Générative",

        // Cybersécurité
        "Expert Cybersécurité", "Consultant Cybersécurité", "Analyste Cybersécurité",
        "Pentester", "Ethical Hacker", "RSSI", "CISO", "Security Engineer",
        "SOC Analyst", "Analyste SOC", "Incident Response Specialist",
        "Cloud Security Engineer", "Application Security Engineer", "IAM Specialist",
        "Cryptographe", "Forensics Analyst", "Red Team Analyst", "Blue Team Analyst",

        // Design & UX/UI
        "Designer UX/UI", "UX Designer", "UI Designer", "Product Designer", "Visual Designer",
        "Web Designer", "Designer Graphique", "Motion Designer", "Designer 3D",
        "Designer d'Interaction", "UX Researcher", "UX Writer", "Content Designer",
        "Brand Designer", "Designer de Marque", "Designer Print", "Directeur Artistique",
        "Directeur Création", "Designer Figma", "Designer Sketch", "Illustrateur Numérique",
        "Designer d'Interface", "Service Designer", "Design System Specialist",
        "Designer Accessibilité", "Spécialiste Accessibilité Web",

        // Product & Management
        "Product Manager", "Product Owner", "Chief Product Officer", "CPO",
        "Product Strategist", "Growth Product Manager", "Technical Product Manager",
        "API Product Manager", "Platform Product Manager", "Product Designer",
        "Scrum Master", "Agile Coach", "Coach Agile", "Release Train Engineer",
        "Chef de Projet", "Chef de Projet Digital", "Chef de Projet IT", "Project Manager",
        "Program Manager", "Portfolio Manager", "Delivery Manager", "Responsable MOA",
        "Responsable AMOA", "Business Analyst", "Analyste Fonctionnel", "Analyste Métier",

        // Marketing Digital
        "Responsable Marketing Digital", "Directeur Marketing Digital", "CMO",
        "Growth Hacker", "Growth Marketer", "Community Manager", "Social Media Manager",
        "Content Manager", "Content Strategist", "Copywriter", "Rédacteur Web",
        "SEO Specialist", "SEO Expert", "SEM Specialist", "SEA Specialist",
        "Traffic Manager", "Acquisition Manager", "Conversion Specialist", "CRO Specialist",
        "Email Marketing Specialist", "Marketing Automation Specialist", "CRM Manager",
        "Inbound Marketing Specialist", "Account-Based Marketing Specialist",
        "Performance Marketing Manager", "Media Buyer", "Affiliate Manager",
        "Influencer Marketing Manager", "Brand Strategist", "Stratège Digital",

        // Communication & Relations Publiques
        "Responsable Communication", "Directeur Communication", "Consultant Communication",
        "Chargé de Communication", "Attaché de Presse", "Relations Presse", "RP Manager",
        "Event Manager", "Responsable Événementiel", "Brand Manager", "Responsable Marque",
        "Responsable Contenu", "Éditeur de Contenu", "Journaliste", "Journaliste Digital",

        // Commercial & Business Development
        "Business Developer", "Business Development Manager", "Commercial B2B",
        "Account Manager", "Account Executive", "Key Account Manager", "KAM",
        "Sales Manager", "Directeur Commercial", "VP Sales", "Inside Sales",
        "Customer Success Manager", "Customer Success", "Customer Experience Manager",
        "Pre-Sales Consultant", "Solutions Engineer", "Partner Manager", "Alliance Manager",
        "Revenue Operations", "RevOps Specialist", "SDR", "Sales Development Representative",

        // Finance & Comptabilité
        "Directeur Financier", "CFO", "Contrôleur de Gestion", "Financial Controller",
        "Analyste Financier", "Comptable", "Expert-Comptable", "DAF",
        "Trésorier d'Entreprise", "Analyste Crédit", "Risk Manager", "Compliance Officer",
        "Auditeur Interne", "Auditeur Externe", "Consultant Financier", "M&A Analyst",
        "Private Equity Analyst", "Venture Capital Analyst", "Financial Modeler",

        // RH & Recrutement
        "DRH", "Directeur des Ressources Humaines", "HRBP", "HR Business Partner",
        "Talent Acquisition Manager", "Responsable Recrutement", "Chasseur de Têtes",
        "Responsable Formation", "L&D Manager", "Learning & Development Manager",
        "Responsable SIRH", "HR Data Analyst", "Compensation & Benefits Manager",
        "Employee Experience Manager", "Chief People Officer", "CPO",
        "Onboarding Specialist", "Culture Manager",

        // Consulting & Stratégie
        "Consultant Stratégie", "Consultant Digital", "Consultant IT", "Consultant Transformation",
        "Consultant Organisationnel", "Consultant en Management", "Directeur Conseil",
        "Associé Cabinet de Conseil", "Consultant Indépendant", "Freelance Consultant",
        "Consultant Lean", "Consultant Six Sigma", "Expert en Processus",
        "Consultant ERP", "Consultant SAP", "Consultant Salesforce", "Consultant HubSpot",

        // Support & Qualité
        "Testeur QA", "QA Engineer", "Quality Assurance Engineer", "Automation Tester",
        "Performance Tester", "Security Tester", "Technical Support Engineer",
        "Customer Support Specialist", "Help Desk Technician", "L1/L2/L3 Support",
        "Documentation Specialist", "Technical Writer", "Rédacteur Technique",
        "Knowledge Manager", "Change Manager", "Responsable Conduite du Changement",

        // E-commerce & Retail Digital
        "E-commerce Manager", "Responsable E-commerce", "Digital Manager", "Webmaster",
        "CX Manager", "UX E-commerce", "Responsable Marketplace", "Seller Amazon",
        "Consultant E-commerce", "Category Manager", "Merchandiser Digital",

        // Low-code / No-code
        "Expert No-Code", "Expert Low-Code", "Webflow Developer", "Bubble Developer",
        "Airtable Expert", "Make Expert", "Zapier Expert", "Power Apps Developer",
        "AppMaker Expert", "Glide Developer", "Notion Consultant",

        // Éducation & Formation Tech
        "Formateur Digital", "Formateur Développement Web", "Coach Tech", "Mentor Dev",
        "Facilitateur Agile", "Instructeur en Ligne", "Créateur de Cours Tech",

        // Blockchain & Web3
        "Développeur Blockchain", "Smart Contract Developer", "Solidity Developer",
        "Web3 Developer", "DeFi Specialist", "NFT Creator", "Crypto Analyst",
        "Tokenomics Expert", "DAO Contributor",

        // Autres
        "Ingénieur Logiciel", "Ingénieur Système", "Ingénieur Réseau", "Ingénieur DevOps",
        "Ingénieur Données", "Ingénieur IA", "Ingénieur R&D", "Research Engineer",
        "Entrepreneur", "Fondateur", "CEO", "COO", "Cofondateur",
        "Intrapreneur", "Freelance Polyvalent", "Consultant Freelance",
        "Product Builder", "Indie Hacker", "Maker"
    ],

    // ─────────────────────────────────────────────
    //  CIBLES — 250+ entrées
    // ─────────────────────────────────────────────
    cibles: [
        // Types d'entreprises
        "Startups early-stage", "Startups Series A/B", "Startups SaaS", "Startups tech",
        "Startups Deeptech", "Startups Fintech", "Startups Healthtech", "Startups Edtech",
        "Startups B2B", "Startups B2C", "Scale-ups", "Licornes",
        "PME", "PME en croissance", "PME industrielles", "PME de services",
        "ETI", "Grandes Entreprises", "Grands Comptes", "Entreprises du CAC 40",
        "Multinationales", "Groupes Internationaux", "Filiales de groupes",
        "Agences digitales", "Agences web", "Agences de communication",
        "Agences marketing", "Agences créatives", "Agences conseil",
        "Cabinets de conseil", "Cabinets de conseil en management", "Cabinets d'audit",
        "Cabinets d'expertise comptable", "ESN", "SSII", "Sociétés de conseil IT",
        "Éditeurs de logiciels", "Éditeurs SaaS", "ISV", "Software Houses",

        // Profils professionnels
        "Freelances", "Indépendants", "Consultants indépendants", "Auto-entrepreneurs",
        "Professions libérales", "Artisans numériques", "Créateurs de contenu",
        "Entrepreneurs", "Cofondateurs techniques", "Fondateurs non-techniques",
        "Dirigeants de PME", "Directeurs Généraux", "CEO", "COO", "CTO",
        "CFO", "CMO", "CDO", "Comités de direction", "CODIR",
        "Décideurs IT", "DSI", "Directeurs Informatique", "CIO",
        "Directeurs Marketing", "VP Marketing", "VP Product",
        "Managers d'équipes tech", "Tech Leads", "Engineering Managers",
        "Product Managers", "Chefs de Projet", "Directeurs de Programme",
        "DRH", "HR Business Partners", "Talent Acquisition",
        "Directeurs Commerciaux", "VP Sales", "Country Managers",

        // Niveaux de maturité digitale
        "Entreprises en transformation digitale", "Entreprises en mutation numérique",
        "Organisations peu digitalisées", "Entreprises early-adopter tech",
        "Entreprises cloud-native", "Entreprises data-driven",
        "Organisations Agile", "Entreprises en restructuration IT",

        // Secteurs d'activité
        // Finance
        "Banques", "Banques en ligne", "Néobanques", "Fintech", "Insurtech",
        "Assurances", "Mutuelles", "Sociétés de gestion d'actifs", "Hedge Funds",
        "Cabinet de gestion de patrimoine", "Sociétés de Private Equity",
        "Venture Capital", "Family Offices",

        // Santé & Medtech
        "Hôpitaux", "Cliniques", "Centres de santé", "Cabinets médicaux",
        "Pharmacies", "Groupes pharmaceutiques", "Laboratoires", "Biotech",
        "Medtech", "Healthtech", "Télémédecine", "E-santé",
        "Établissements de soins", "EHPAD", "Mutuelles santé",

        // Éducation & Edtech
        "Établissements d'enseignement supérieur", "Grandes Écoles", "Universités",
        "Lycées et collèges", "Organismes de formation", "CFA",
        "Edtech", "Plateformes de e-learning", "MOOC", "EdTech B2B",
        "Centres de formation professionnelle", "Organismes Qualiopi",

        // Retail & Commerce
        "Retailers", "E-commerce pure players", "Marketplaces", "Marques DTC",
        "Enseignes de grande distribution", "Franchise", "Secteur du luxe",
        "Mode et textile", "Beauté et cosmétique", "Sport et outdoor",
        "Décoration et mobilier", "Alimentation et épicerie fine",

        // Industrie & Manufacturing
        "Industriels", "Fabricants", "Sous-traitants industriels",
        "Industrie automobile", "Industrie aéronautique", "Aérospatial",
        "Industrie pharmaceutique", "Chimie", "Agroalimentaire",
        "Industrie 4.0", "Fabrication additive", "Manufacturing",
        "Energie", "Pétrole et gaz", "Énergies renouvelables",
        "Eau et environnement", "Traitement des déchets",

        // Tech & Numérique
        "Scale-up tech", "Entreprises cloud", "Plateformes numériques",
        "SaaS B2B", "SaaS B2C", "Marketplace tech", "Médias en ligne",
        "Réseaux sociaux", "Gaming", "Studios de jeux vidéo", "AdTech",
        "PropTech", "LegalTech", "GovTech", "AgriTech", "CleanTech",
        "SpaceTech", "MobilityTech", "ConstructionTech",

        // Services & Conseils
        "Cabinets d'avocats", "Cabinets notariaux", "Études notariales",
        "Agences immobilières", "Promoteurs immobiliers", "PropTech",
        "Hôtels et hôtellerie", "Restaurants et restauration", "Tourisme",
        "Transport et logistique", "Supply Chain", "Transitaires",
        "Télécommunications", "Opérateurs télécoms", "FAI",

        // Public & Associatif
        "Secteur public", "Administrations", "Ministères", "Collectivités territoriales",
        "Régions et départements", "Mairies", "Services publics", "Agences gouvernementales",
        "Hôpitaux publics", "ONG", "Associations", "Fondations",
        "Think tanks", "Organismes internationaux", "ESS", "Économie sociale",

        // Médias & Culture
        "Médias", "Presse écrite", "Presse en ligne", "Chaînes TV",
        "Radios", "Podcasts", "Studios de production", "Maisons de disques",
        "Maisons d'édition", "Musées", "Institutions culturelles",

        // Profils individuels / communautés
        "Développeurs juniors", "Développeurs seniors", "Développeurs en reconversion",
        "Designers en reconversion", "Profils en reconversion digitale",
        "Étudiants en informatique", "Étudiants en école de commerce",
        "Jeunes diplômés", "Alternants", "Stagiaires",
        "Profils en recherche d'emploi", "Candidats remote", "Digital nomades",
        "Communauté tech francophone", "Communauté de développeurs",
        "Communauté de designers", "Makers et bricoleurs numériques",
        "Investisseurs tech", "Business Angels", "Solopreneurs"
    ],

    // ─────────────────────────────────────────────
    //  SPÉCIALITÉS & TECHNOLOGIES — 200+ entrées
    // ─────────────────────────────────────────────
    specialites: [
        // IA & Machine Learning
        "Intelligence Artificielle", "Machine Learning", "Deep Learning",
        "NLP", "Traitement du Langage Naturel", "Computer Vision",
        "Reinforcement Learning", "IA Générative", "LLM", "Grands Modèles de Langage",
        "RAG", "Fine-tuning LLM", "Prompt Engineering", "AI Ops",
        "MLflow", "Hugging Face", "OpenAI API", "Anthropic Claude", "Gemini API",
        "TensorFlow", "PyTorch", "Keras", "Scikit-learn", "XGBoost",

        // Data
        "Data Science", "Big Data", "Analytics", "Business Intelligence",
        "Data Visualization", "Data Storytelling", "Data Engineering",
        "ETL/ELT", "Data Pipeline", "Data Lake", "Data Warehouse", "Data Lakehouse",
        "dbt", "Apache Spark", "Apache Kafka", "Airflow", "Prefect",
        "Snowflake", "BigQuery", "Redshift", "Databricks", "Duckdb",
        "Power BI", "Tableau", "Looker", "Metabase", "Apache Superset",
        "Python Analytics", "R Statistics", "SQL Avancé", "Pandas", "Polars",

        // Cloud & Infrastructure
        "AWS", "Amazon Web Services", "Azure", "Microsoft Azure", "Google Cloud Platform",
        "GCP", "Multi-cloud", "Cloud Architecture", "Serverless",
        "Lambda", "EC2", "S3", "RDS", "DynamoDB", "Firebase",
        "Kubernetes", "K8s", "Docker", "Helm", "ArgoCD", "FluxCD",
        "Terraform", "Pulumi", "Ansible", "Chef", "Puppet",
        "Infrastructure as Code", "GitOps", "CI/CD", "GitHub Actions",
        "GitLab CI", "Jenkins", "CircleCI", "Travis CI",
        "Observabilité", "Prometheus", "Grafana", "Datadog", "New Relic",
        "OpenTelemetry", "ELK Stack", "Elasticsearch",

        // Développement Web Frontend
        "React", "React.js", "Next.js", "Vue.js", "Nuxt.js",
        "Angular", "Svelte", "SvelteKit", "Astro", "Remix",
        "TypeScript", "JavaScript ES6+", "HTML5", "CSS3",
        "Tailwind CSS", "Styled Components", "Sass/SCSS",
        "Redux", "Zustand", "Pinia", "React Query", "GraphQL",
        "REST API", "WebSocket", "Web Components", "PWA",
        "Storybook", "Design Systems", "Performance Web", "Core Web Vitals",
        "Accessibility / A11y", "Accessibilité Web", "WCAG",

        // Développement Backend
        "Node.js", "Express.js", "NestJS", "Fastify",
        "Python", "Django", "FastAPI", "Flask",
        "Java", "Spring Boot", "Spring Framework",
        "PHP", "Laravel", "Symfony",
        "Go / Golang", "Rust", "C#", ".NET", "ASP.NET",
        "Ruby", "Ruby on Rails", "Elixir", "Phoenix",
        "Microservices", "API REST", "GraphQL", "gRPC",
        "Architecture Hexagonale", "DDD", "Domain Driven Design",
        "Event Sourcing", "CQRS", "Clean Architecture",

        // Bases de données
        "PostgreSQL", "MySQL", "MariaDB", "SQLite",
        "MongoDB", "Redis", "Cassandra", "DynamoDB",
        "Prisma", "TypeORM", "Sequelize", "SQLAlchemy",
        "Neo4j", "TimescaleDB", "ClickHouse",

        // Mobile
        "iOS", "Swift", "SwiftUI", "UIKit",
        "Android", "Kotlin", "Jetpack Compose",
        "React Native", "Flutter", "Expo",
        "PWA", "Capacitor", "Ionic",

        // Cybersécurité
        "Cybersécurité", "Sécurité Informatique", "Pentesting",
        "OWASP", "ISO 27001", "SOC 2", "RGPD / GDPR",
        "IAM", "Zero Trust", "SIEM", "SOC",
        "Cryptographie", "TLS/SSL", "OAuth2", "JWT",
        "Vulnerability Management", "Threat Intelligence",

        // Méthodologies & Outils
        "Agile", "Scrum", "Kanban", "Lean", "SAFe",
        "OKR", "Shape Up", "Extreme Programming", "XP",
        "ITIL", "Prince2", "PMP", "PMI",
        "Design Thinking", "Lean Startup", "Customer Development",
        "User Research", "A/B Testing", "Experimentation",
        "Growth", "Acquisition", "Rétention", "Activation",

        // Marketing & Growth Tech
        "SEO", "SEM", "SEA", "Google Ads", "Meta Ads",
        "Marketing Automation", "HubSpot", "Marketo", "Pardot",
        "Salesforce", "CRM", "Pipedrive", "Monday",
        "Email Marketing", "Klaviyo", "Mailchimp", "Brevo",
        "Analytics", "Google Analytics 4", "Mixpanel", "Amplitude",
        "Tag Manager", "Google Tag Manager", "Segment",

        // Blockchain & Web3
        "Blockchain", "Ethereum", "Solidity", "Web3.js", "ethers.js",
        "Smart Contracts", "DeFi", "NFT", "DAO", "Layer 2",
        "Polygon", "Solana", "Near Protocol", "Cosmos",

        // Design & Créatif
        "Figma", "Sketch", "Adobe XD", "InVision",
        "Adobe Creative Suite", "Photoshop", "Illustrator", "After Effects",
        "Framer", "Webflow", "Notion", "Miro",
        "User Interface Design", "User Experience Design",
        "Motion Design", "3D / Blender", "Cinema 4D", "Spline",

        // Low-code / No-code
        "No-Code", "Low-Code", "Bubble", "Webflow", "Adalo",
        "Glide", "Appsheet", "Power Apps", "Make / Integromat",
        "Zapier", "n8n", "Airtable", "Notion API",

        // E-commerce
        "Shopify", "WooCommerce", "Magento", "PrestaShop",
        "Stripe", "PayPal", "Braintree",
        "Logistique e-commerce", "Fulfilment", "Dropshipping"
    ],

    // ─────────────────────────────────────────────
    //  SECTEURS D'ACTIVITÉ — 80+ entrées
    // ─────────────────────────────────────────────
    secteurs: [
        "Tech & Numérique", "Fintech & Finance", "Santé & Medtech",
        "Éducation & Edtech", "E-commerce & Retail", "Industrie 4.0",
        "Agroalimentaire", "Énergie & Cleantech", "Mobilité & Transport",
        "Immobilier & Proptech", "Médias & Communication",
        "Tourisme & Hôtellerie", "Mode & Luxe", "Sport",
        "Jeux Vidéo & Gaming", "Cybersécurité", "Blockchain & Web3",
        "Supply Chain & Logistique", "Aéronautique & Spatial",
        "Automobile", "Chimie & Matériaux", "Pharmaceutique & Biotech",
        "Agriculture & AgriTech", "Construction & BTP",
        "Télécommunications", "Administration Publique",
        "ONG & Associations", "Économie Sociale & Solidaire",
        "Conseil & Services", "Audit & Expertise Comptable",
        "Droit & Legaltech", "Ressources Humaines & HR Tech",
        "Marketing & Publicité", "Édition & Publishing",
        "Intelligence Artificielle", "Data & Analytics",
        "Robotique & Automation", "IoT & Objets Connectés",
        "AR & VR", "Réalité Augmentée", "Réalité Virtuelle",
        "Impression 3D & Fabrication Additive", "Green Tech",
        "Smart Cities & GovTech", "InsurTech", "WealthTech",
        "Cyber & Privacy", "Music & AudioTech", "Food & FoodTech"
    ],

    // ─────────────────────────────────────────────
    //  RÉSULTATS CONCRETS — 60+ phrases d'amorce
    // ─────────────────────────────────────────────
    resultats: [
        "j'aide mes clients à lancer leur produit 2x plus vite",
        "je réduis les coûts d'infrastructure de 30 à 50%",
        "j'améliore le taux de conversion des interfaces",
        "je structure les équipes techniques pour scaler",
        "j'accélère la mise en production avec du CI/CD solide",
        "je transforme des données brutes en insights actionnables",
        "j'aide les fondateurs à clarifier leur vision produit",
        "je construis des architectures scalables et maintenables",
        "je sécurise les systèmes contre les vulnérabilités critiques",
        "j'automatise les processus répétitifs pour libérer du temps",
        "j'améliore la rétention utilisateurs grâce à un UX soigné",
        "j'aide les équipes à adopter les pratiques Agile",
        "je rends les projets prédictibles et dans les délais",
        "je génère du trafic organique via une stratégie SEO solide",
        "j'augmente le ROI des campagnes publicitaires",
        "j'aide à recruter et structurer les équipes tech",
        "j'optimise les performances et la vitesse des applications",
        "je crée des expériences utilisateur mémorables",
        "j'aide les entreprises à migrer vers le cloud sereinement",
        "je mets en place des pipelines de données fiables"
    ],

    // ─────────────────────────────────────────────
    //  VALEURS DIFFÉRENCIANTES — 40+ entrées
    // ─────────────────────────────────────────────
    valeurs: [
        "Rapidité d'exécution", "Fiabilité", "Pragmatisme",
        "Orienté résultats", "Pédagogie", "Créativité",
        "Rigueur technique", "Sens business", "Vision produit",
        "Autonomie", "Communication claire", "Adaptabilité",
        "Approche data-driven", "Focus utilisateur", "Curiosité intellectuelle",
        "Maîtrise end-to-end", "Culture Startup", "Culture entreprise",
        "Expérience internationale", "Expertise sectorielle",
        "Bilinguisme", "Remote-first", "Asynchrone",
        "Long terme", "Quick wins", "Ownership complet",
        "Transparence", "Feedback continu", "Amélioration continue",
        "Profil hybride tech+business", "T-shaped profile",
        "Full ownership", "Zero bullshit", "Deliver first"
    ]
};

// Alias courts pour compatibilité
window.autocompleteData.metierList = window.autocompleteData.metiers;
window.autocompleteData.cibleList  = window.autocompleteData.cibles;