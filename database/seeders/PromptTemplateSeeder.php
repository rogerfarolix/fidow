<?php
// database/seeders/PromptTemplateSeeder.php

namespace Database\Seeders;

use App\Models\PromptTemplate;
use Illuminate\Database\Seeder;

class PromptTemplateSeeder extends Seeder
{
    public function run(): void
    {
        PromptTemplate::truncate();

        // ── PHOTOS DE PROFIL ─────────────────────────────────────────────────

        $profils = [
            [
                'ordre'      => 1,
                'titre'      => 'Portrait IA — Expert Digital Africain',
                'sous_titre' => 'Style confiant, fond neutre premium',
                'description'=> 'Un portrait IA professionnel à coller dans Gemini avec ta propre photo. Rendu : fond épuré, lumière studio, allure de conférencier tech.',
                'plateforme' => 'LinkedIn, Facebook, Twitter/X',
                'dimensions' => '800×800 px (carré)',
                'variables'  => ['phrase', 'style_couleur'],
                'prompt_body'=> <<<'PROMPT'
Ultra-realistic AI-enhanced professional portrait photo, African tech professional, confident posture, slight smile, looking directly at camera

Background: deep dark neutral gradient (#0f0a0a to #1a1010), subtle soft bokeh, minimal and clean

Lighting: professional studio lighting, soft key light from front-left, gentle fill light, subtle rim light from behind creating a slight glow — cinematic portrait quality

Clothing: smart casual or smart professional (crisp shirt or blazer), modern, clean, premium look

Photo quality: 8K, sharp focus on face, natural skin texture, no plastic AI skin, ultra-detailed eyes, natural expression

Style: LinkedIn premium profile, thought leader aesthetic, Forbes Africa cover quality

Color mood: {{style_couleur}}

No text, no watermarks, no borders, square format 1:1, photorealistic
PROMPT,
            ],

            [
                'ordre'      => 2,
                'titre'      => 'Portrait Créatif — Personal Branding Vibrant',
                'sous_titre' => 'Couleurs de ta marque, ambiance moderne',
                'description'=> 'Portrait avec une touche de couleur qui reflète ta marque. Idéal pour se démarquer dans les feeds LinkedIn et Facebook.',
                'plateforme' => 'LinkedIn, Facebook',
                'dimensions' => '800×800 px (carré)',
                'variables'  => ['couleur1', 'couleur2', 'metier'],
                'prompt_body'=> <<<'PROMPT'
Professional personal branding portrait photo, African creative professional, confident and approachable expression, modern aesthetic

Background: abstract gradient blending {{couleur1}} and {{couleur2}}, soft geometric shapes in background, slightly out of focus, brand identity aesthetic

Lighting: warm cinematic lighting, slight golden hour warmth, professional fill light, face clearly lit and sharp

Subject: {{metier}}, smart casual clothing that complements the background colors, modern look

Style: Dribbble-quality personal branding photo, startup founder aesthetic, social media optimized

Photo quality: ultra-sharp, 4K, natural skin, expressive eyes, authentic micro-smile

Mood: confident, creative, approachable — African excellence meets global standards

No text, square 1:1 ratio, photorealistic portrait
PROMPT,
            ],

            [
                'ordre'      => 3,
                'titre'      => 'Portrait Studio — Fond Monochrome Luxe',
                'sous_titre' => 'Fond uni coloré, style éditorial',
                'description'=> 'Un portrait éditorial façon magazine tech. Fond monochrome coloré qui fait ressortir ta personnalité. Très impactant sur LinkedIn.',
                'plateforme' => 'LinkedIn, Portfolio',
                'dimensions' => '800×800 px (carré)',
                'variables'  => ['couleur_fond', 'tenue'],
                'prompt_body'=> <<<'PROMPT'
Editorial magazine-quality portrait photograph, African tech professional, striking and memorable visual identity

Background: flat solid color {{couleur_fond}}, perfectly smooth, no texture, full studio backdrop

Lighting: high-key studio lighting, perfectly even illumination, slight shadow on one side for depth, beauty dish quality

Subject wearing: {{tenue}}, clean and intentional styling, no distracting accessories

Composition: centered subject, face occupies upper 60% of frame, slight negative space below for cropping flexibility

Expression: calm confidence, direct eye contact, subtle power pose — think TED Talk speaker

Post-processing: light editorial grade, skin looks natural and healthy, colors are saturated and rich

Style: Vogue Business, Fast Company, Tech Cabal magazine cover energy

Square format 1:1, photorealistic, no text, no watermarks
PROMPT,
            ],

            [
                'ordre'      => 4,
                'titre'      => 'Portrait Environnemental — Dans ton univers',
                'sous_titre' => 'Ambiance bureau moderne / espace de travail',
                'description'=> 'Un portrait qui te montre dans ton environnement de travail. Parfait pour humaniser ta marque et montrer ton quotidien pro.',
                'plateforme' => 'LinkedIn, Instagram, Portfolio',
                'dimensions' => '800×800 px (carré)',
                'variables'  => ['environnement', 'activite'],
                'prompt_body'=> <<<'PROMPT'
Natural environmental portrait photograph, African professional in their workspace, candid yet polished feel

Setting: {{environnement}} — modern, well-lit, organized, aspirational — laptop, subtle tech accessories, clean desk or creative studio

Activity: subject captured {{activite}}, natural candid moment, not stiff or posed

Lighting: natural window light mixed with warm artificial light, soft and flattering, cinematic quality

Subject: sharp and in focus, background beautifully blurred (f/1.8 depth of field effect), subject clearly the focal point

Expression: engaged, thoughtful, in their element — authentic and relatable

Photo quality: documentary-style professional photography, Sony A7IV quality, natural colors, true-to-life skin tones

Style: The Remote Work Era aesthetic — clean, productive, aspirational but human

Square 1:1 format, photorealistic, no text
PROMPT,
            ],

            [
                'ordre'      => 5,
                'titre'      => 'Portrait Bichromie — Identité Graphique Forte',
                'sous_titre' => 'Effet duotone / bichromie de marque',
                'description'=> 'Un portrait stylisé en bichromie avec tes couleurs de marque. Un rendu très fort et mémorable, parfait pour te démarquer.',
                'plateforme' => 'LinkedIn, Portfolio, Site web',
                'dimensions' => '800×800 px (carré)',
                'variables'  => ['couleur_ombre', 'couleur_lumiere', 'phrase'],
                'prompt_body'=> <<<'PROMPT'
Artistic duotone portrait photograph, African professional, strong graphic design aesthetic

Duotone treatment: deep {{couleur_ombre}} in shadows, bright {{couleur_lumiere}} in highlights — high contrast, clean separation, professional graphic duotone effect

Subject: confident pose, strong jawline and face structure, bold direct gaze, face clearly readable even in duotone

Composition: slightly off-center, cinematic crop, modern editorial feel

Base photo quality: sharp, high contrast original before duotone — ensures the color treatment reads beautifully

Style: agency portfolio, Awwwards website hero image quality, brand identity showcase

Mood inspired by: {{phrase}} — translate this professional statement into the visual energy of the portrait

Technical: vector-clean duotone effect, not muddy, not grainy — crisp and intentional

Square 1:1 format, graphic design quality, no text, no watermark
PROMPT,
            ],
        ];

        foreach ($profils as $data) {
            PromptTemplate::create(array_merge($data, ['type' => 'profil', 'actif' => true]));
        }

        // ── BANNIÈRES / COUVERTURES ──────────────────────────────────────────

        $bannieres = [
            [
                'ordre'      => 1,
                'titre'      => 'Bannière Split Layout — 2 Blocs Couleurs',
                'sous_titre' => 'Style agence créative africaine premium',
                'description'=> 'Le grand classique du personal branding : deux blocs de couleur, photo circulaire, formes géométriques. Tu ajoutes ton texte dans Canva/Figma après.',
                'plateforme' => 'LinkedIn Cover, Facebook Cover',
                'dimensions' => 'LinkedIn : 1584×396 px | Facebook : 820×312 px',
                'variables'  => ['couleur_bloc1', 'couleur_bloc2', 'couleur_accent', 'couleur_cadre_photo'],
                'prompt_body'=> <<<'PROMPT'
Modern premium branding banner design, African creative agency style, split horizontal layout with two distinct sections

Left/Top section (60% width):
Deep rich gradient background using {{couleur_bloc1}}, smooth ambient lighting, abstract geometric shapes — circles, arcs, minimal curves — using {{couleur_accent}} as accent shapes, subtle depth and shadows, modern tech branding aesthetic, clean and structured

Right/Bottom section (40% width):
Warm vibrant gradient using {{couleur_bloc2}}, halftone dot texture pattern overlay (10% opacity), abstract minimal circular shapes, clean and energetic

Overall composition:
Clean horizontal banner layout (aspect ratio 4:1), strong visual hierarchy, large empty space on right side for text placement, right-aligned typography zone clearly implied by negative space

Elements to include:
- Circular portrait frame placeholder on bottom left, with bright {{couleur_cadre_photo}} outline (6-8px border), modern and clean
- Small minimalist logo placeholder zone on top left corner, subtle
- Smooth transition between the two sections, not a hard cut

Design style:
Ultra clean UI/UX design, modern SaaS branding, startup landing page aesthetic, Dribbble/Behance quality, high contrast colors, smooth gradients, subtle 3D depth

Lighting: soft ambient lighting, slight glossy modern finish, no harsh shadows

No text, no watermarks, no distortion, photorealistic design render, 4:1 wide banner format
PROMPT,
            ],

            [
                'ordre'      => 2,
                'titre'      => 'Bannière Dark Premium — Particules & Code',
                'sous_titre' => 'Ambiance tech sombre, développeurs & data',
                'description'=> 'Une bannière dark ultra-pro pour les profils tech : développeurs, data scientists, DevOps. Rendu : fond sombre, particules lumineuses, lignes de code en arrière-plan.',
                'plateforme' => 'LinkedIn Cover, GitHub Profile',
                'dimensions' => 'LinkedIn : 1584×396 px',
                'variables'  => ['couleur_accent', 'specialite_tech'],
                'prompt_body'=> <<<'PROMPT'
Ultra-modern dark tech branding banner, premium LinkedIn cover design for {{specialite_tech}} professional

Background: very deep dark background (#0a0a0f), almost black with slight blue-purple tint, vast digital space feel

Visual elements:
- Abstract floating particles and light dots, small glowing nodes connected by thin lines (neural network / data mesh aesthetic)
- Faint code snippets or terminal text visible in background (blurred, atmospheric, not readable)
- Smooth geometric lines creating depth — isometric grid effect, very subtle
- One or two accent glows using {{couleur_accent}}, soft and ambient

Composition:
Left side: empty dark space for profile photo integration
Right side: large negative space for white/light text overlay
Center: subtle visual focus point with the main design element

Color mood: {{couleur_accent}} as the only color accent against a near-black background, creates premium and focused aesthetic

Style: Linear, Vercel, Stripe design system energy — minimal but sophisticated

Lighting: dramatic dark with pinpoint light sources, starfield-like ambiance

No text, no watermarks, photorealistic design render, 4:1 wide banner format, ultra HD
PROMPT,
            ],

            [
                'ordre'      => 3,
                'titre'      => 'Bannière Gradient Fluide — Couleurs Vibrantes',
                'sous_titre' => 'Dégradé organique, créatifs & marketeurs',
                'description'=> 'Un grand dégradé fluide et vivant pour les créatifs, marketeurs et community managers. Coloré, mémorable, unique. Parfait pour Facebook et LinkedIn.',
                'plateforme' => 'LinkedIn Cover, Facebook Cover',
                'dimensions' => 'LinkedIn : 1584×396 px | Facebook : 820×312 px',
                'variables'  => ['couleur1', 'couleur2', 'couleur3'],
                'prompt_body'=> <<<'PROMPT'
Vibrant fluid gradient branding banner, modern creative professional LinkedIn cover

Background: smooth organic liquid gradient flowing from {{couleur1}} on the left, transitioning through {{couleur2}} in the center, to {{couleur3}} on the right — the gradient should feel alive and fluid, like ink in water

Visual texture:
- Very subtle noise/grain texture overlaid (2-3% opacity) for premium feel
- Soft abstract blob shapes or fluid forms blending into the gradient, same color family
- Light caustic light reflections, like light through water, creating organic bright spots

Composition:
- Left quarter: darker/richer section of gradient — implied space for profile picture
- Center and right: lighter/brighter gradient — large open space for text
- Overall feel: open, airy, vibrant — not cluttered

Shapes: minimal, only organic curves and blobs — no hard geometric shapes
No patterns, no dots, no grid

Style: Apple WWDC gradient aesthetic meets African creative energy, ultra-modern 2025 design

Mood: energetic, creative, confident, vibrant

No text, no watermarks, no UI elements, 4:1 horizontal banner ratio, extremely smooth transitions, 8K resolution
PROMPT,
            ],

            [
                'ordre'      => 4,
                'titre'      => 'Bannière Minimaliste Luxe — Typographie Épurée',
                'sous_titre' => 'Fond uni, accents dorés, style consultant',
                'description'=> 'Le minimalisme au service du luxe. Pour les consultants, coaches et formateurs qui veulent projeter sérieux et expertise. Tu ajoutes ton texte dans Canva.',
                'plateforme' => 'LinkedIn Cover',
                'dimensions' => 'LinkedIn : 1584×396 px',
                'variables'  => ['couleur_fond', 'couleur_accent', 'style_metier'],
                'prompt_body'=> <<<'PROMPT'
Ultra-minimalist luxury branding banner for {{style_metier}}, premium LinkedIn cover design

Background: flat deep rich color {{couleur_fond}}, extremely smooth and even — absolute premium solid backdrop

Accent elements (very minimal):
- Single thin horizontal line in {{couleur_accent}} (gold/metallic), positioned at 1/3 from bottom, spanning 40% of banner width from left edge
- One subtle geometric shape: a thin circle outline or corner bracket in {{couleur_accent}}, positioned top-left or bottom-right, very small and discreet
- Extremely subtle gradient vignette darkening the edges (5% opacity max)

Texture: ultra-fine linen or silk-like texture overlay on the solid background (3% opacity) — gives the flat color life without pattern

Composition:
- Far left: implied space for profile photo (15-20% width)
- Center-right: massive empty space for text — this is the star of the design
- Right edge: subtle {{couleur_accent}} border line (2px, full height)

Style inspiration: Bottega Veneta, Hermès, McKinsey brand identity — quiet luxury

Color philosophy: one background + one metallic accent only — less is infinitely more

No text, no watermarks, no additional colors, 4:1 banner ratio, photorealistic material render
PROMPT,
            ],

            [
                'ordre'      => 5,
                'titre'      => 'Bannière Géométrique Africaine — Motifs & Modernité',
                'sous_titre' => 'Patterns africains réinterprétés, identité forte',
                'description'=> 'Fusionner héritage africain et esthétique moderne. Des motifs géométriques inspirés des cultures africaines, reinterprétés en design digital contemporain. Unique et mémorable.',
                'plateforme' => 'LinkedIn Cover, Facebook Cover, Portfolio',
                'dimensions' => 'LinkedIn : 1584×396 px | Facebook : 820×312 px',
                'variables'  => ['couleur_principale', 'couleur_secondaire', 'couleur_fond'],
                'prompt_body'=> <<<'PROMPT'
Modern African geometric branding banner, premium LinkedIn cover design, fusion of African heritage and contemporary design

Background: rich deep {{couleur_fond}}, full coverage

Pattern treatment:
Left side (30% width): geometric African-inspired patterns — kente weave geometry, Adinkra symbol shapes, Bogolan grid lines — reinterpreted in clean modern vector style, using {{couleur_principale}} and {{couleur_secondaire}}, moderate opacity (40-60%) so they blend with background

Center and right (70% width): clean open space, the pattern fades out smoothly leaving breathing room for text and photo
Transition between pattern zone and open zone: smooth gradient fade, not hard cut

Accent elements:
- Thin geometric border or frame element top-left using {{couleur_principale}}
- Small circular medallion element, very subtle

Color palette: {{couleur_fond}} background + {{couleur_principale}} for patterns + {{couleur_secondaire}} as highlight accent — maximum 3 colors total for cohesion

Style: Where Afrofuturism meets Silicon Valley design — proud, modern, global

Quality: Behance Featured quality, ultra-clean vector-like rendering, no blurriness in pattern elements

No text, no watermarks, 4:1 wide banner ratio, photorealistic graphic design render
PROMPT,
            ],
        ];

        foreach ($bannieres as $data) {
            PromptTemplate::create(array_merge($data, ['type' => 'banniere', 'actif' => true]));
        }
    }
}
