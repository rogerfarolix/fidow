<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $template ? 'Éditer' : 'Nouveau' }} prompt — Admin Fidow</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cabinet+Grotesk:wght@700;800;900&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
<style>
:root{--bg:#080606;--s1:#0f0a0a;--s2:#170e0e;--s3:#1f1414;--accent:#872323;--green:#2ef0a0;--gold:#e8a030;--blue:#3b82f6;--text:#f4eded;--text2:#c8b8b8;--muted:#6b5757;--border:rgba(135,35,35,.2);--border2:rgba(255,255,255,.05)}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:grid;grid-template-columns:240px 1fr}
.sidebar{background:var(--s1);border-right:1px solid var(--border);display:flex;flex-direction:column;position:sticky;top:0;height:100vh;overflow-y:auto}
.sidebar-logo{padding:20px 18px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;flex-shrink:0}
.sidebar-logo img{height:28px}
.sidebar-logo-text{font-family:'Cabinet Grotesk',sans-serif;font-weight:900;font-size:16px}
.sidebar-badge{font-size:9px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;background:rgba(135,35,35,.15);border:1px solid rgba(135,35,35,.25);color:#d47070;border-radius:100px;padding:2px 8px}
.nav-section{padding:16px 14px 6px;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted)}
.nav-item{display:flex;align-items:center;gap:9px;padding:9px 14px;color:var(--muted);font-size:13px;font-weight:500;text-decoration:none;transition:all .18s;border-radius:9px;margin:1px 8px}
.nav-item:hover{color:var(--text);background:rgba(135,35,35,.1)}
.nav-item.active{color:var(--text);background:rgba(135,35,35,.14);border:1px solid rgba(135,35,35,.22)}
.sidebar-footer{margin-top:auto;padding:16px 10px;border-top:1px solid var(--border)}
.logout-btn{width:100%;padding:9px 14px;background:transparent;border:1px solid rgba(135,35,35,.2);border-radius:9px;color:var(--muted);font-size:13px;cursor:pointer;transition:all .2s;font-family:'DM Sans',sans-serif;display:flex;align-items:center;gap:8px;justify-content:center}
.logout-btn:hover{background:rgba(135,35,35,.1);color:#d47070}

.main{overflow-y:auto;background:var(--bg)}
.main-inner{padding:36px 40px 80px;max-width:860px}
.breadcrumb{display:flex;align-items:center;gap:8px;margin-bottom:24px;font-size:13px;color:var(--muted)}
.breadcrumb a{color:var(--muted);text-decoration:none;transition:color .2s}
.breadcrumb a:hover{color:var(--text)}
.breadcrumb-sep{opacity:.4}
.page-title{font-family:'Cabinet Grotesk',sans-serif;font-size:22px;font-weight:900;letter-spacing:-.02em;margin-bottom:6px}
.page-sub{color:var(--muted);font-size:13px;margin-bottom:30px}

.card{background:var(--s1);border:1px solid var(--border);border-radius:16px;padding:28px;margin-bottom:18px}
.card-title{font-family:'Cabinet Grotesk',sans-serif;font-size:14px;font-weight:800;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:18px;display:flex;align-items:center;gap:7px}

.field-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:0}
.field{display:flex;flex-direction:column;gap:7px;margin-bottom:16px}
.field-full{grid-column:1/-1}
label{font-size:11px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--muted)}
input[type=text],input[type=number],select,textarea{background:var(--s2);border:1px solid rgba(255,255,255,.07);border-radius:11px;padding:11px 13px;color:var(--text);font-family:'DM Sans',sans-serif;font-size:14px;outline:none;transition:border-color .2s,box-shadow .2s;width:100%}
input::placeholder,textarea::placeholder{color:var(--muted);font-style:italic}
input:focus,textarea:focus,select:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(135,35,35,.12)}
select{cursor:pointer;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%236b5757' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 13px center;padding-right:36px}
select option{background:#170e0e}
textarea{resize:vertical}
.field-hint{font-size:11px;color:var(--muted);line-height:1.4}

/* PROMPT TEXTAREA */
.prompt-textarea{font-family:'DM Mono','Courier New',monospace;font-size:12px;line-height:1.7;min-height:240px;color:var(--text2)}

/* VARIABLES FIELD */
.vars-help{font-size:11px;color:var(--muted);background:var(--s2);border-radius:8px;padding:10px 13px;margin-top:6px;line-height:1.6}
.vars-help code{background:var(--s3);padding:1px 5px;border-radius:4px;font-size:11px;color:var(--gold)}

/* IMAGE UPLOAD */
.upload-zone{border:2px dashed rgba(135,35,35,.25);border-radius:12px;padding:32px 24px;text-align:center;cursor:pointer;transition:all .22s;background:var(--s2);position:relative}
.upload-zone:hover,.upload-zone.drag{border-color:var(--accent);background:rgba(135,35,35,.05)}
.upload-zone input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.upload-icon{width:40px;height:40px;border-radius:12px;background:rgba(135,35,35,.1);display:grid;place-items:center;margin:0 auto 12px}
.upload-title{font-size:13px;font-weight:600;color:var(--text);margin-bottom:4px}
.upload-sub{font-size:11px;color:var(--muted)}
.current-img{margin-top:16px;text-align:center}
.current-img img{max-width:100%;max-height:160px;border-radius:8px;object-fit:contain;border:1px solid var(--border2)}
.remove-img-label{display:flex;align-items:center;gap:7px;margin-top:10px;font-size:12px;color:var(--muted);cursor:pointer;justify-content:center}
.remove-img-label input{width:auto;background:none;border:none;padding:0;width:14px;height:14px;accent-color:var(--accent)}

/* TOGGLE */
.toggle-row{display:flex;align-items:center;justify-content:space-between;padding:14px 16px;background:var(--s2);border-radius:10px}
.toggle-label{font-size:13px;color:var(--text);font-weight:500}
.toggle-sub{font-size:11px;color:var(--muted);margin-top:2px}
input[type=checkbox]{width:36px;height:20px;accent-color:var(--accent);cursor:pointer;flex-shrink:0}

/* BUTTONS */
.form-footer{display:flex;gap:10px;align-items:center;margin-top:8px}
.btn-save{padding:12px 26px;background:linear-gradient(135deg,var(--accent),#6b1a1a);border:none;border-radius:11px;color:#fff;font-family:'Cabinet Grotesk',sans-serif;font-size:14px;font-weight:800;cursor:pointer;transition:all .2s;box-shadow:0 5px 20px rgba(135,35,35,.3);display:flex;align-items:center;gap:8px}
.btn-save:hover{transform:translateY(-2px);box-shadow:0 10px 32px rgba(135,35,35,.5)}
.btn-cancel{padding:12px 20px;background:transparent;border:1px solid var(--border);border-radius:11px;color:var(--muted);font-family:'DM Sans',sans-serif;font-size:13px;cursor:pointer;transition:all .2s;text-decoration:none}
.btn-cancel:hover{color:var(--text);border-color:rgba(135,35,35,.35)}

.errors{padding:14px 16px;background:rgba(135,35,35,.1);border:1px solid rgba(135,35,35,.3);border-radius:10px;margin-bottom:18px}
.errors p{font-size:13px;color:#e05555;margin-bottom:3px}

@media(max-width:900px){body{grid-template-columns:1fr}.sidebar{display:none}.main-inner{padding:20px 16px 60px}.field-grid{grid-template-columns:1fr}}
</style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('assets/logo.png') }}" alt="Fidow">
        <div><div class="sidebar-logo-text">Fidow</div></div>
        <div style="margin-left:auto"><div class="sidebar-badge">Admin</div></div>
    </div>
    <div class="nav-section">Dashboard</div>
    <a href="{{ route('admin.data') }}" class="nav-item">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M3 12h18M3 6h18M3 18h18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        Générations
    </a>
    <a href="{{ route('admin.prompts') }}" class="nav-item active">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="3" stroke="currentColor" stroke-width="1.5"/><path d="M7 8h10M7 12h7M7 16h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        Prompts IA
    </a>
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Déconnexion
            </button>
        </form>
    </div>
</aside>

<main class="main">
<div class="main-inner">

    <div class="breadcrumb">
        <a href="{{ route('admin.prompts') }}">Prompts</a>
        <span class="breadcrumb-sep">›</span>
        <span>{{ $template ? 'Éditer : ' . $template->titre : 'Nouveau prompt' }}</span>
    </div>

    <div class="page-title">{{ $template ? 'Éditer le prompt' : 'Créer un nouveau prompt' }}</div>
    <p class="page-sub">Les variables entre <code style="background:var(--s2);padding:1px 6px;border-radius:4px;font-size:12px;color:var(--gold)">&#123;&#123;nom_variable&#125;&#125;</code> seront remplacées par les infos de l'utilisateur.</p>

    @if($errors->any())
    <div class="errors">
        @foreach($errors->all() as $err)
            <p>{{ $err }}</p>
        @endforeach
    </div>
    @endif

    <form method="POST"
          action="{{ $template ? route('admin.prompts.update', $template->id) : route('admin.prompts.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if($template) @method('PUT') @endif

        {{-- INFOS GÉNÉRALES --}}
        <div class="card">
            <div class="card-title">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/><path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                Informations générales
            </div>
            <div class="field-grid">
                <div class="field">
                    <label>Type <span style="color:#d47070">*</span></label>
                    <select name="type" required>
                        <option value="profil" @selected(old('type', $template?->type) === 'profil')>Photo de profil</option>
                        <option value="banniere" @selected(old('type', $template?->type) === 'banniere')>Bannière / Couverture</option>
                    </select>
                </div>
                <div class="field">
                    <label>Ordre d'affichage</label>
                    <input type="number" name="ordre" value="{{ old('ordre', $template?->ordre ?? 0) }}" min="0" max="255" placeholder="0">
                    <span class="field-hint">Plus petit = affiché en premier</span>
                </div>
                <div class="field field-full">
                    <label>Titre <span style="color:#d47070">*</span></label>
                    <input type="text" name="titre" value="{{ old('titre', $template?->titre) }}" placeholder="Ex: Portrait IA — Expert Digital Africain" required maxlength="120">
                </div>
                <div class="field field-full">
                    <label>Sous-titre</label>
                    <input type="text" name="sous_titre" value="{{ old('sous_titre', $template?->sous_titre) }}" placeholder="Ex: Style confiant, fond neutre premium" maxlength="200">
                </div>
                <div class="field field-full">
                    <label>Description courte (visible par l'utilisateur)</label>
                    <textarea name="description" rows="2" placeholder="Explication rapide de ce que génère ce prompt, comment l'utiliser…" maxlength="1000">{{ old('description', $template?->description) }}</textarea>
                </div>
                <div class="field">
                    <label>Plateforme(s)</label>
                    <input type="text" name="plateforme" value="{{ old('plateforme', $template?->plateforme) }}" placeholder="Ex: LinkedIn, Facebook" maxlength="80">
                </div>
                <div class="field">
                    <label>Dimensions</label>
                    <input type="text" name="dimensions" value="{{ old('dimensions', $template?->dimensions) }}" placeholder="Ex: 1584×396 px" maxlength="80">
                </div>
            </div>
        </div>

        {{-- PROMPT --}}
        <div class="card">
            <div class="card-title">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                Corps du prompt
            </div>
            <div class="field" style="margin-bottom:0">
                <label>Prompt complet <span style="color:#d47070">*</span></label>
                <textarea class="prompt-textarea" name="prompt_body" rows="14" placeholder="Saisis le prompt ici. Utilise {{nom_variable}} pour les zones que l'utilisateur devra remplir.
Ex: Background color: {{couleur_fond}}" required>{{ old('prompt_body', $template?->prompt_body) }}</textarea>
                <div class="vars-help">
                    Syntaxe des variables : <code>&#123;&#123;nom_variable&#125;&#125;</code> — ex: <code>&#123;&#123;couleur1&#125;&#125;</code>, <code>&#123;&#123;phrase&#125;&#125;</code>, <code>&#123;&#123;metier&#125;&#125;</code><br>
                    Les variables seront remplacées par ce que l'utilisateur saisit dans le formulaire.
                </div>
            </div>
        </div>

        {{-- VARIABLES --}}
        <div class="card">
            <div class="card-title">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                Variables attendues
            </div>
            <div class="field" style="margin-bottom:0">
                <label>Liste des variables (JSON ou séparées par des virgules)</label>
                <input type="text"
                       name="variables"
                       value="{{ old('variables', $template?->variables ? (is_array($template->variables) ? implode(', ', $template->variables) : $template->variables) : '') }}"
                       placeholder="couleur1, couleur2, metier, phrase">
                <div class="vars-help">
                    Liste exacte des noms de variables utilisés dans le prompt body.<br>
                    Ex: <code>couleur1, couleur2, metier</code> — chaque variable deviendra un champ à remplir dans l'outil.<br>
                    Variables reconnues avec labels auto : <code>phrase</code>, <code>couleur1</code>, <code>couleur2</code>, <code>metier</code>, <code>couleur_fond</code>, <code>tenue</code>, etc.
                </div>
            </div>
        </div>

        {{-- IMAGE --}}
        <div class="card">
            <div class="card-title">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.5"/><circle cx="9" cy="9" r="2" stroke="currentColor" stroke-width="1.5"/><path d="M21 15l-5-5L5 21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                Image d'aperçu (optionnel)
            </div>
            <div class="upload-zone" id="uploadZone">
                <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
                <div class="upload-icon">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div class="upload-title">Glisse une image ici ou clique pour parcourir</div>
                <div class="upload-sub">PNG, JPG, WEBP — max 3 Mo — sera affiché en miniature dans l'outil</div>
            </div>

            @if($template?->image_path)
            <div class="current-img" id="currentImg">
                <div style="font-size:11px;color:var(--muted);margin-bottom:8px;text-transform:uppercase;letter-spacing:.06em;font-weight:700">Image actuelle</div>
                <img src="{{ $template->image_url }}" alt="Aperçu actuel" id="previewImg">
                <label class="remove-img-label">
                    <input type="checkbox" name="remove_image" value="1"> Supprimer cette image
                </label>
            </div>
            @else
            <div class="current-img" id="currentImg" style="display:none">
                <img src="" alt="Aperçu" id="previewImg" style="max-height:160px;border-radius:8px;object-fit:contain;border:1px solid var(--border2)">
            </div>
            @endif
        </div>

        {{-- STATUT --}}
        <div class="card">
            <div class="card-title">Statut</div>
            <div class="toggle-row">
                <div>
                    <div class="toggle-label">Prompt actif</div>
                    <div class="toggle-sub">Si désactivé, ce prompt n'apparaîtra pas dans les outils publics.</div>
                </div>
                <input type="checkbox" name="actif" value="1" @checked(old('actif', $template?->actif ?? true))>
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="btn-save">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                {{ $template ? 'Enregistrer les modifications' : 'Créer le prompt' }}
            </button>
            <a href="{{ route('admin.prompts') }}" class="btn-cancel">Annuler</a>
        </div>
    </form>

</div>
</main>

<script>
function previewImage(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (ev) => {
        document.getElementById('previewImg').src = ev.target.result;
        document.getElementById('currentImg').style.display = 'block';
    };
    reader.readAsDataURL(file);
}

// Drag & Drop styling
const zone = document.getElementById('uploadZone');
zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('drag'); });
zone.addEventListener('dragleave', () => zone.classList.remove('drag'));
zone.addEventListener('drop', () => zone.classList.remove('drag'));
</script>
</body>
</html>
