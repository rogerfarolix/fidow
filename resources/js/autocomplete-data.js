// Données pour l'autocomplétion des métiers et cibles
const autocompleteData = {
    metiers: [
        "Développeur Web", "Développeur Mobile", "Développeur Full Stack", "Développeur Frontend", "Développeur Backend",
        "Designer UX/UI", "Designer Graphique", "Designer Produit", "Motion Designer", "Designer 3D",
        "Chef de Projet", "Product Manager", "Product Owner", "Scrum Master", "Project Coordinator",
        "Marketing Digital", "Community Manager", "Content Manager", "SEO Specialist", "SEM Specialist",
        "Data Scientist", "Data Analyst", "Data Engineer", "Business Intelligence", "Machine Learning Engineer",
        "DevOps Engineer", "Cloud Engineer", "Site Reliability Engineer", "System Administrator", "Network Engineer",
        "Consultant IT", "Consultant Stratégie", "Consultant Digital", "Consultant Transformation",
        "Business Analyst", "Business Developer", "Sales Manager", "Account Manager", "Customer Success",
        "Référent Technique", "Architecte Logiciel", "Architecte Cloud", "Architecte Données", "Architecte Sécurité",
        "Testeur QA", "QA Engineer", "Automation Engineer", "Performance Tester", "Security Tester",
        "Technical Writer", "Rédacteur Technique", "Documentation Specialist", "Knowledge Manager",
        "Formateur Digital", "Coach Tech", "Mentor Développement", "Facilitateur Agile", "Coach Agile",
        "E-commerce Manager", "Webmaster", "Traffic Manager", "Growth Hacker", "Conversion Specialist",
        "CRM Manager", "Email Marketing Specialist", "Social Media Manager", "Influencer Marketing",
        "Brand Manager", "Communication Manager", "Public Relations", "Press Relations", "Event Manager",
        "HR Manager", "Talent Acquisition", "Recruiter", "HR Business Partner", "Learning & Development",
        "Financial Analyst", "Controller", "Accountant", "Financial Controller", "CFO",
        "Operations Manager", "Supply Chain Manager", "Logistics Manager", "Procurement Specialist",
        "Customer Support", "Technical Support", "Help Desk", "Support Engineer", "Customer Success Manager",
        "Researcher", "R&D Engineer", "Innovation Manager", "Patent Engineer", "Research Scientist"
    ],
    
    cibles: [
        "Startups", "PME", "Grands comptes", "Entreprises du CAC 40", "Multinationales",
        "Agences digitales", "Agences de communication", "Agences web", "Agences marketing", "Cabinets de conseil",
        "Freelances", "Indépendants", "Consultants indépendants", "Auto-entrepreneurs", "Professions libérales",
        "Étudiants", "Jeunes diplômés", "Alternants", "Stagiaires", "Apprentis",
        "Direction générale", "Comité de direction", "Board members", "Investisseurs", "Actionnaires",
        "Départements IT", "Équipes techniques", "Développement", "Infrastructure", "Opérations",
        "Départements Marketing", "Équipes marketing", "Communication", "Branding", "Publicité",
        "Départements RH", "Ressources humaines", "Recrutement", "Formation", "Développement des talents",
        "Départements Financiers", "Finance", "Comptabilité", "Contrôle de gestion", "Trésorerie",
        "Départements Commerciaux", "Équipes de vente", "Business development", "Account management", "Customer success",
        "Départements Juridiques", "Conseil juridique", "Conformité", "Propriété intellectuelle", "Contrats",
        "Départements R&D", "Innovation", "Recherche", "Développement produit", "Laboratoires",
        "Clients B2B", "Clients B2C", "Partenaires commerciaux", "Fournisseurs", "Sous-traitants",
        "Utilisateurs finaux", "Consommateurs", "Prospects", "Leads", "Ambassadeurs de marque",
        "Communauté tech", "Développeurs", "Designers", "Product managers", "Entrepreneurs",
        "Secteur santé", "Hôpitaux", "Cliniques", "Pharmacies", "Laboratoires pharmaceutiques",
        "Secteur éducation", "Écoles", "Universités", "Centres de formation", "EdTech",
        "Secteur finance", "Banques", "Assurances", "Fintech", "Services financiers",
        "Secteur retail", "E-commerce", "Grande distribution", "Luxue", "Mode",
        "Secteur industriel", "Manufacturing", "Automobile", "Aéronautique", "Énergie",
        "Secteur public", "Administration", "Collectivités", "Services publics", "Gouvernement",
        "Organisations sans but lucratif", "ONG", "Associations", "Fondations", "Organismes publics",
        "Médias et presse", "Chaînes TV", "Radios", "Journaux", "Médias en ligne",
        "Tourisme et hôtellerie", "Hôtels", "Restaurants", "Agences de voyage", "Tourisme",
        "Immobilier", "Promoteurs", "Agents immobiliers", "Gestionnaires de biens", "Construction",
        "Transport et logistique", "Transporteurs", "Logisticiens", "Warehouse", "Supply chain",
        "Télécommunications", "Opérateurs", "FAI", "Équipementiers", "Services télécoms",
        "Énergie et environnement", "Énergies renouvelables", "Environnement", "Développement durable", "Climat"
    ],
    
    specialites: [
        "Intelligence Artificielle", "Machine Learning", "Deep Learning", "NLP", "Computer Vision",
        "Blockchain", "Cryptomonnaies", "DeFi", "NFT", "Web3",
        "Internet des Objets", "IoT", "Smart Cities", "Connected Devices", "Edge Computing",
        "Cybersécurité", "Sécurité informatique", "Protection des données", "Privacy", "GDPR",
        "Cloud Computing", "AWS", "Azure", "Google Cloud", "Multi-cloud",
        "DevOps", "CI/CD", "Kubernetes", "Docker", "Infrastructure as Code",
        "Data Science", "Big Data", "Analytics", "Business Intelligence", "Data Visualization",
        "UX Design", "UI Design", "Design Thinking", "User Research", "Prototyping",
        "Agile", "Scrum", "Kanban", "Lean", "SAFe",
        "Marketing Automation", "CRM", "Email Marketing", "Social Media", "Content Marketing",
        "SEO", "SEM", "PPC", "Google Ads", "Facebook Ads",
        "E-commerce", "Magento", "Shopify", "WooCommerce", "Prestashop",
        "Mobile Development", "iOS", "Android", "React Native", "Flutter",
        "Web Development", "React", "Vue.js", "Angular", "Node.js",
        "Backend Development", "Python", "Java", "C#", "Go",
        "Database", "SQL", "NoSQL", "PostgreSQL", "MongoDB",
        "Microservices", "API REST", "GraphQL", "Architecture", "Integration"
    ]
};

// Exporter pour utilisation dans d'autres fichiers
if (typeof module !== 'undefined' && module.exports) {
    module.exports = autocompleteData;
}
