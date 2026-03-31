<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Prompts — Admin Fidow</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cabinet+Grotesk:wght@700;800;900&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
<style>
:root{--bg:#080606;--s1:#0f0a0a;--s2:#170e0e;--s3:#1f1414;--accent:#872323;--green:#2ef0a0;--gold:#e8a030;--blue:#3b82f6;--text:#f4eded;--text2:#c8b8b8;--muted:#6b5757;--border:rgba(135,35,35,.2);--border2:rgba(255,255,255,.05)}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:grid;grid-template-columns:240px 1fr}
/* SIDEBAR — identique au data.blade */
.sidebar{background:var(--s1);border-right:1px solid var(--border);display:flex;flex-direction:column;position:sticky;top:0;height:100vh;overflow-y:auto}
.sidebar-logo{padding:20px 18px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;flex-shrink:0}
.sidebar-logo img{height:28px;width:auto}
.sidebar-logo-text{font-family:'Cabinet Grotesk',sans-serif;font-weight:900;font-size:16px;color:var(--text)}
.sidebar-badge{font-size:9px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;background:rgba(135,35,35,.15);border:1px solid rgba(135,35,35,.25);color:#d47070;border-radius:100px;padding:2px 8px}
.nav-section{padding:16px 14px 6px;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted)}
.nav-item{display:flex;align-items:center;gap:9px;padding:9px 14px;color:var(--muted);font-size:13px;font-weight:500;text-decoration:none;transition:all .18s;border-radius:9px;margin:1px 8px}
.nav-item:hover{color:var(--text);background:rgba(135,35,35,.1)}
.nav-item.active{color:var(--text);background:rgba(135,35,35,.14);border:1px solid rgba(135,35,35,.22)}
.sidebar-footer{margin-top:auto;padding:16px 10px;border-top:1px solid var(--border)}
.logout-btn{width:100%;padding:9px 14px;background:transparent;border:1px solid rgba(135,35,35,.2);border-radius:9px;color:var(--muted);font-size:13px;cursor:pointer;transition:all .2s;font-family:'DM Sans',sans-serif;display:flex;align-items:center;gap:8px;justify-content:center}
.logout-btn:hover{background:rgba(135,35,35,.1);color:#d47070;border-color:var(--accent)}
/* MAIN */
.main{overflow-y:auto;background:var(--bg)}
.main-inner{padding:36px 36px 80px;max-width:1100px}
.main-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:30px;gap:16px;flex-wrap:wrap}
.page-title{font-family:'Cabinet Grotesk',sans-serif;font-size:24px;font-weight:900;letter-spacing:-.02em}
.page-sub{color:var(--muted);font-size:13px;margin-top:3px}
.btn-new{padding:10px 20px;background:linear-gradient(135deg,var(--accent),#6b1a1a);border:none;border-radius:10px;color:#fff;font-family:'Cabinet Grotesk',sans-serif;font-size:13px;font-weight:800;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:7px;box-shadow:0 4px 16px rgba(135,35,35,.3);transition:all .2s}
.btn-new:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(135,35,35,.45)}

/* TABS */
.type-tabs{display:flex;gap:8px;margin-bottom:24px}
.type-tab{padding:7px 16px;border-radius:100px;border:1px solid var(--border);font-size:12px;font-weight:600;cursor:pointer;transition:all .2s;color:var(--muted);background:transparent}
.type-tab.active-profil{background:rgba(59,130,246,.1);border-color:rgba(59,130,246,.3);color:#7bb3ff}
.type-tab.active-banniere{background:rgba(232,160,48,.1);border-color:rgba(232,160,48,.3);color:var(--gold)}
.type-tab:hover{color:var(--text)}

/* TABLE */
.table-wrap{overflow-x:auto;border-radius:14px;border:1px solid var(--border);margin-bottom:16px}
table{width:100%;border-collapse:collapse;font-size:13px}
thead tr{background:var(--s1)}
th{padding:11px 14px;text-align:left;font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);border-bottom:1px solid var(--border);white-space:nowrap}
td{padding:12px 14px;border-bottom:1px solid rgba(255,255,255,.03);vertical-align:middle}
tr:last-child td{border-bottom:none}
tr:hover td{background:rgba(135,35,35,.03)}
.td-trunc{max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:var(--muted);font-size:12px}

/* THUMB */
.thumb-wrap{cursor:pointer;transition:opacity .2s}
.thumb-wrap:hover{opacity:.8}
.thumb-img{width:72px;height:36px;object-fit:cover;border-radius:6px;border:1px solid var(--border2)}
.thumb-placeholder{width:72px;height:36px;background:var(--s2);border-radius:6px;border:1px solid var(--border2);display:grid;place-items:center}

/* BADGES */
.badge{display:inline-flex;align-items:center;font-size:9px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;border-radius:100px;padding:3px 10px;border:1px solid}
.badge-profil{background:rgba(59,130,246,.07);border-color:rgba(59,130,246,.22);color:#7bb3ff}
.badge-banniere{background:rgba(232,160,48,.07);border-color:rgba(232,160,48,.22);color:var(--gold)}
.badge-on{background:rgba(46,240,160,.07);border-color:rgba(46,240,160,.22);color:var(--green)}
.badge-off{background:var(--s2);border-color:var(--border2);color:var(--muted)}

/* ACTIONS */
.action-btns{display:flex;gap:6px;align-items:center}
.btn-edit{color:#7bb3ff;font-size:12px;font-weight:600;text-decoration:none;padding:5px 11px;border:1px solid rgba(59,130,246,.25);border-radius:7px;transition:all .2s}
.btn-edit:hover{background:rgba(59,130,246,.1)}
.btn-del{padding:5px 11px;border:1px solid rgba(135,35,35,.25);border-radius:7px;color:#d47070;font-size:12px;font-weight:600;cursor:pointer;background:transparent;font-family:'DM Sans',sans-serif;transition:all .2s}
.btn-del:hover{background:rgba(135,35,35,.12);border-color:var(--accent)}

/* LIGHTBOX */
.lightbox{position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:1000;display:none;place-items:center;backdrop-filter:blur(8px)}
.lightbox.open{display:grid}
.lightbox-inner{position:relative;max-width:90vw;max-height:90vh}
.lightbox-img{max-width:90vw;max-height:85vh;border-radius:12px;object-fit:contain;box-shadow:0 24px 80px rgba(0,0,0,.6)}
.lightbox-close{position:absolute;top:-14px;right:-14px;width:32px;height:32px;background:var(--s2);border:1px solid var(--border);border-radius:50%;display:grid;place-items:center;cursor:pointer;color:var(--muted);transition:all .2s}
.lightbox-close:hover{color:var(--text);border-color:rgba(135,35,35,.4)}
.lightbox-caption{text-align:center;margin-top:12px;font-size:12px;color:var(--muted)}

/* FLASH */
.flash{padding:11px 16px;border-radius:10px;font-size:13px;margin-bottom:20px;display:flex;align-items:center;gap:8px}
.flash-success{background:rgba(46,240,160,.08);border:1px solid rgba(46,240,160,.22);color:var(--green)}

@media(max-width:900px){body{grid-template-columns:1fr}.sidebar{display:none}.main-inner{padding:20px 16px 60px}}
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
    <a href="{{ route('stats') }}" class="nav-item" target="_blank">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><line x1="12" y1="20" x2="12" y2="4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><line x1="6" y1="20" x2="6" y2="14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        Stats publiques ↗
    </a>
    <div class="nav-section">Site</div>
    <a href="{{ route('home') }}" class="nav-item" target="_blank">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/><path d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20" stroke="currentColor" stroke-width="1.5"/></svg>
        Voir le site ↗
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
    <div class="main-header">
        <div>
            <div class="page-title">Bibliothèque de prompts</div>
            <div class="page-sub">Gérez les prompts photo de profil et bannière disponibles dans les outils.</div>
        </div>
        <a href="{{ route('admin.prompts.create') }}" class="btn-new">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Nouveau prompt
        </a>
    </div>

    @if(session('success'))
    <div class="flash flash-success">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- TABS --}}
    @php
        $profils   = $templates->where('type','profil');
        $bannieres = $templates->where('type','banniere');
    @endphp

    <div class="type-tabs">
        <button class="type-tab active-profil" onclick="showTab('profil',this)">
            Photo de profil ({{ $profils->count() }})
        </button>
        <button class="type-tab" onclick="showTab('banniere',this)">
            Bannières ({{ $bannieres->count() }})
        </button>
    </div>

    {{-- TABLE PROFIL --}}
    <div id="tab-profil">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Aperçu</th>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Variables</th>
                        <th>Plateforme</th>
                        <th>Ordre</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($profils as $tpl)
                    <tr>
                        <td>
                            @if($tpl->image_path)
                                <div class="thumb-wrap" onclick="openLightbox('{{ $tpl->image_url }}', '{{ $tpl->titre }}')">
                                    <img class="thumb-img" src="{{ $tpl->image_url }}" alt="{{ $tpl->titre }}">
                                </div>
                            @else
                                <div class="thumb-placeholder">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" style="opacity:.3"><rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.5"/><circle cx="9" cy="9" r="2" stroke="currentColor" stroke-width="1.5"/><path d="M21 15l-5-5L5 21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                                </div>
                            @endif
                        </td>
                        <td style="font-weight:600;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $tpl->titre }}</td>
                        <td class="td-trunc" title="{{ $tpl->description }}">{{ $tpl->description }}</td>
                        <td style="font-size:11px;color:var(--muted)">
                            @if($tpl->variables)
                                <code style="background:var(--s2);padding:2px 6px;border-radius:4px">{{ implode(', ', $tpl->variables) }}</code>
                            @else —
                            @endif
                        </td>
                        <td style="font-size:12px;color:var(--muted)">{{ $tpl->plateforme ?? '—' }}</td>
                        <td style="font-size:13px;text-align:center">{{ $tpl->ordre }}</td>
                        <td>
                            @if($tpl->actif)
                                <span class="badge badge-on">Actif</span>
                            @else
                                <span class="badge badge-off">Inactif</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.prompts.edit', $tpl->id) }}" class="btn-edit">Éditer</a>
                                <form method="POST" action="{{ route('admin.prompts.destroy', $tpl->id) }}" onsubmit="return confirm('Supprimer ce prompt ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-del">Suppr.</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" style="text-align:center;color:var(--muted);padding:40px">Aucun prompt de profil. <a href="{{ route('admin.prompts.create') }}" style="color:#d47070">Créer le premier →</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TABLE BANNIÈRE --}}
    <div id="tab-banniere" style="display:none">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Aperçu</th>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Variables</th>
                        <th>Dimensions</th>
                        <th>Ordre</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bannieres as $tpl)
                    <tr>
                        <td>
                            @if($tpl->image_path)
                                <div class="thumb-wrap" onclick="openLightbox('{{ $tpl->image_url }}', '{{ $tpl->titre }}')">
                                    <img class="thumb-img" src="{{ $tpl->image_url }}" alt="{{ $tpl->titre }}">
                                </div>
                            @else
                                <div class="thumb-placeholder">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" style="opacity:.3"><rect x="2" y="7" width="20" height="10" rx="2" stroke="currentColor" stroke-width="1.5"/></svg>
                                </div>
                            @endif
                        </td>
                        <td style="font-weight:600;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $tpl->titre }}</td>
                        <td class="td-trunc" title="{{ $tpl->description }}">{{ $tpl->description }}</td>
                        <td style="font-size:11px;color:var(--muted)">
                            @if($tpl->variables)
                                <code style="background:var(--s2);padding:2px 6px;border-radius:4px">{{ implode(', ', $tpl->variables) }}</code>
                            @else —
                            @endif
                        </td>
                        <td style="font-size:11px;color:var(--muted)">{{ $tpl->dimensions ?? '—' }}</td>
                        <td style="font-size:13px;text-align:center">{{ $tpl->ordre }}</td>
                        <td>
                            @if($tpl->actif)
                                <span class="badge badge-on">Actif</span>
                            @else
                                <span class="badge badge-off">Inactif</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.prompts.edit', $tpl->id) }}" class="btn-edit">Éditer</a>
                                <form method="POST" action="{{ route('admin.prompts.destroy', $tpl->id) }}" onsubmit="return confirm('Supprimer ce prompt ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-del">Suppr.</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" style="text-align:center;color:var(--muted);padding:40px">Aucun prompt de bannière. <a href="{{ route('admin.prompts.create') }}" style="color:#d47070">Créer le premier →</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</main>

{{-- LIGHTBOX --}}
<div class="lightbox" id="lightbox" onclick="closeLightbox(event)">
    <div class="lightbox-inner">
        <div class="lightbox-close" onclick="closeLightbox()">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        </div>
        <img class="lightbox-img" id="lightboxImg" src="" alt="">
        <div class="lightbox-caption" id="lightboxCaption"></div>
    </div>
</div>

<script>
function showTab(tab, btn) {
    document.getElementById('tab-profil').style.display = tab === 'profil' ? 'block' : 'none';
    document.getElementById('tab-banniere').style.display = tab === 'banniere' ? 'block' : 'none';
    document.querySelectorAll('.type-tab').forEach(b => {
        b.classList.remove('active-profil','active-banniere');
    });
    btn.classList.add('active-' + tab);
}

function openLightbox(src, caption) {
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightboxCaption').textContent = caption;
    document.getElementById('lightbox').classList.add('open');
}

function closeLightbox(e) {
    if (!e || e.target === document.getElementById('lightbox') || e.target.closest('.lightbox-close')) {
        document.getElementById('lightbox').classList.remove('open');
    }
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') document.getElementById('lightbox').classList.remove('open');
});
</script>
</body>
</html>
