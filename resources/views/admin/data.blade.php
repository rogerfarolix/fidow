<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Générations — Admin Fidow</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cabinet+Grotesk:wght@700;800;900&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
<style>
:root{--bg:#080606;--s1:#0f0a0a;--s2:#170e0e;--s3:#1f1414;--accent:#872323;--green:#2ef0a0;--gold:#e8a030;--text:#f4eded;--text2:#c8b8b8;--muted:#6b5757;--border:rgba(135,35,35,.2);--border2:rgba(255,255,255,.05)}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:grid;grid-template-columns:240px 1fr}

/* ── SIDEBAR ── */
.sidebar{background:var(--s1);border-right:1px solid var(--border);display:flex;flex-direction:column;position:sticky;top:0;height:100vh;overflow-y:auto}
.sidebar-logo{padding:20px 18px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;flex-shrink:0}
.sidebar-logo img{height:28px;width:auto}
.sidebar-logo-text{font-family:'Cabinet Grotesk',sans-serif;font-weight:900;font-size:16px;color:var(--text)}
.sidebar-badge{font-size:9px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;background:rgba(135,35,35,.15);border:1px solid rgba(135,35,35,.25);color:#d47070;border-radius:100px;padding:2px 8px}
.nav-section{padding:16px 14px 6px;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted)}
.nav-item{display:flex;align-items:center;gap:9px;padding:9px 14px;color:var(--muted);font-size:13px;font-weight:500;text-decoration:none;transition:all .18s;border-radius:9px;margin:1px 8px}
.nav-item:hover{color:var(--text);background:rgba(135,35,35,.1)}
.nav-item.active{color:var(--text);background:rgba(135,35,35,.14);border:1px solid rgba(135,35,35,.22)}
.nav-item svg{flex-shrink:0;opacity:.7}
.nav-item.active svg{opacity:1}
.sidebar-footer{margin-top:auto;padding:16px 10px;border-top:1px solid var(--border)}
.logout-form{width:100%}
.logout-btn{width:100%;padding:9px 14px;background:transparent;border:1px solid rgba(135,35,35,.2);border-radius:9px;color:var(--muted);font-size:13px;cursor:pointer;transition:all .2s;font-family:'DM Sans',sans-serif;display:flex;align-items:center;gap:8px;justify-content:center}
.logout-btn:hover{background:rgba(135,35,35,.1);color:#d47070;border-color:var(--accent)}

/* ── MAIN ── */
.main{overflow-y:auto;background:var(--bg)}
.main-inner{padding:36px 36px 80px;max-width:1100px}
.main-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:30px;gap:16px;flex-wrap:wrap}
.page-title{font-family:'Cabinet Grotesk',sans-serif;font-size:24px;font-weight:900;letter-spacing:-.02em}
.page-sub{color:var(--muted);font-size:13px;margin-top:3px}

/* ── TOOLBAR ── */
.toolbar{display:flex;gap:10px;margin-bottom:22px;flex-wrap:wrap}
.toolbar input[type=text]{background:var(--s1);border:1px solid var(--border);border-radius:10px;padding:9px 13px;color:var(--text);font-family:'DM Sans',sans-serif;font-size:13px;outline:none;transition:border-color .2s;flex:1;min-width:180px}
.toolbar input[type=text]::placeholder{color:var(--muted)}
.toolbar input[type=text]:focus{border-color:var(--accent)}
.toolbar select{background:var(--s1);border:1px solid var(--border);border-radius:10px;padding:9px 32px 9px 13px;color:var(--text);font-family:'DM Sans',sans-serif;font-size:13px;outline:none;transition:border-color .2s;cursor:pointer;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%236b5757' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center}
.toolbar select option{background:#170e0e}
.toolbar select:focus{border-color:var(--accent)}
.btn-filter{padding:9px 18px;background:rgba(135,35,35,.14);border:1px solid var(--border);border-radius:10px;color:#d47070;font-family:'DM Sans',sans-serif;font-size:12px;font-weight:600;cursor:pointer;transition:all .2s;white-space:nowrap}
.btn-filter:hover{background:rgba(135,35,35,.22);border-color:var(--accent)}
.btn-reset-filter{padding:9px 14px;background:transparent;border:1px solid var(--border2);border-radius:10px;color:var(--muted);font-size:12px;cursor:pointer;text-decoration:none;transition:all .2s;display:inline-flex;align-items:center}
.btn-reset-filter:hover{color:var(--text);border-color:var(--border)}

/* ── TABLE ── */
.table-wrap{overflow-x:auto;border-radius:14px;border:1px solid var(--border)}
table{width:100%;border-collapse:collapse;font-size:13px}
thead tr{background:var(--s1)}
th{padding:11px 14px;text-align:left;font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);border-bottom:1px solid var(--border);white-space:nowrap}
td{padding:12px 14px;border-bottom:1px solid rgba(255,255,255,.03);vertical-align:middle}
tr:last-child td{border-bottom:none}
tr:hover td{background:rgba(135,35,35,.03)}
.td-trunc{max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.td-id{color:var(--muted);font-size:11px;font-family:monospace}
.td-date{color:var(--muted);font-size:11px;white-space:nowrap}
.td-ip{color:var(--muted);font-size:12px;font-family:monospace}
.badge{display:inline-flex;align-items:center;gap:5px;font-size:10px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;border-radius:100px;padding:3px 10px;border:1px solid}
.badge-green{background:rgba(46,240,160,.07);border-color:rgba(46,240,160,.22);color:var(--green)}
.badge-muted{background:var(--s2);border-color:var(--border2);color:var(--muted)}
.view-btn{color:#d47070;font-size:12px;font-weight:600;text-decoration:none;padding:5px 11px;border:1px solid rgba(135,35,35,.25);border-radius:7px;transition:all .2s;white-space:nowrap;display:inline-block}
.view-btn:hover{background:rgba(135,35,35,.12);border-color:var(--accent)}

/* ── PAGINATION ── */
.pagination-wrap{margin-top:22px;display:flex;justify-content:center;gap:6px;flex-wrap:wrap}
.pagination-wrap a,.pagination-wrap span{padding:7px 12px;background:var(--s1);border:1px solid var(--border);border-radius:8px;font-size:12px;color:var(--muted);text-decoration:none;transition:all .18s;display:inline-block}
.pagination-wrap a:hover{border-color:var(--accent);color:var(--text)}
.pagination-wrap .active span{background:rgba(135,35,35,.18);border-color:var(--accent);color:var(--text)}

/* ── STATS ROW ── */
.mini-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:24px}
.mini-stat{background:var(--s1);border:1px solid var(--border);border-radius:12px;padding:16px 18px}
.mini-stat-num{font-family:'Cabinet Grotesk',sans-serif;font-size:26px;font-weight:900;display:block;line-height:1;margin-bottom:4px}
.mini-stat-lbl{font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:.06em}

@media(max-width:900px){body{grid-template-columns:1fr}.sidebar{display:none}.main-inner{padding:20px 16px 60px}}
@media(max-width:600px){.mini-stats{grid-template-columns:1fr 1fr}}
</style>
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('assets/logo.png') }}" alt="Fidow">
        <div>
            <div class="sidebar-logo-text">Fidow</div>
        </div>
        <div style="margin-left:auto"><div class="sidebar-badge">Admin</div></div>
    </div>

    <div class="nav-section">Dashboard</div>
    <a href="{{ route('admin.data') }}" class="nav-item active">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M3 12h18M3 6h18M3 18h18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        Générations
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
    <a href="{{ route('positionnement') }}" class="nav-item" target="_blank">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        Outil Positionnement ↗
    </a>

    <div class="sidebar-footer">
        <form class="logout-form" method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Déconnexion
            </button>
        </form>
    </div>
</aside>

{{-- MAIN --}}
<main class="main">
<div class="main-inner">
    <div class="main-header">
        <div>
            <div class="page-title">Générations de positionnement</div>
            <div class="page-sub">Toutes les phrases générées par les utilisateurs</div>
        </div>
        <div style="font-size:12px;color:var(--muted);background:var(--s1);border:1px solid var(--border);border-radius:10px;padding:8px 14px">
            Total : <strong style="color:var(--text)">{{ $generations->total() }}</strong> générations
        </div>
    </div>

    {{-- MINI STATS --}}
    <div class="mini-stats">
        <div class="mini-stat">
            <span class="mini-stat-num" style="color:#d47070">{{ $generations->total() }}</span>
            <div class="mini-stat-lbl">Total</div>
        </div>
        <div class="mini-stat">
            <span class="mini-stat-num" style="color:var(--green)">{{ \App\Models\PositioningGeneration::whereNotNull('phrase_retenue')->count() }}</span>
            <div class="mini-stat-lbl">Phrases retenues</div>
        </div>
        <div class="mini-stat">
            <span class="mini-stat-num" style="color:var(--gold)">{{ $allMetiers->count() }}</span>
            <div class="mini-stat-lbl">Métiers distincts</div>
        </div>
    </div>

    {{-- TOOLBAR --}}
    <form method="GET" action="{{ route('admin.data') }}">
        <div class="toolbar">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par métier, cible, IP…">
            <select name="metier">
                <option value="">Tous les métiers</option>
                @foreach($allMetiers as $m)
                    <option value="{{ $m }}" @selected(request('metier') === $m)>{{ $m }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-filter">Filtrer</button>
            <a href="{{ route('admin.data') }}" class="btn-reset-filter">Reset</a>
        </div>
    </form>

    {{-- TABLE --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>IP</th>
                    <th>Métier</th>
                    <th>Cible</th>
                    <th>Phrase principale</th>
                    <th>Retenue</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($generations as $i => $g)
                <tr>
                    <td class="td-id">{{ $generations->firstItem() + $i }}</td>
                    <td class="td-date">{{ $g->created_at->format('d/m/y H:i') }}</td>
                    <td class="td-ip">{{ $g->ip_address }}</td>
                    <td style="font-weight:500;max-width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $g->metier }}</td>
                    <td class="td-trunc" style="color:var(--muted)" title="{{ $g->cible }}">{{ $g->cible }}</td>
                    <td class="td-trunc" title="{{ $g->phrase_1 }}">{{ $g->phrase_1 }}</td>
                    <td>
                        @if($g->phrase_retenue)
                            <span class="badge badge-green">
                                <svg width="8" height="8" fill="none" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Oui
                            </span>
                        @else
                            <span class="badge badge-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.show', $g->id) }}" class="view-btn">Voir →</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;color:var(--muted);padding:48px">
                        <svg width="32" height="32" fill="none" viewBox="0 0 24 24" style="display:block;margin:0 auto 10px;opacity:.3"><circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="1.5"/><path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        Aucun résultat trouvé.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $generations->links('pagination::simple-default') }}
    </div>
</div>
</main>

</body>
</html>
