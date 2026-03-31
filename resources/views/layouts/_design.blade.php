<style>
/* ─────────────────────────────────────────
   FIDOW DESIGN SYSTEM v2 — #872323 Crimson
   ───────────────────────────────────────── */
@import url('https://fonts.googleapis.com/css2?family=Cabinet+Grotesk:wght@400;500;700;800;900&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap');

:root {
    --bg:      #080606;
    --s1:      #0f0a0a;
    --s2:      #170e0e;
    --s3:      #1f1414;
    --accent:  #872323;
    --accent2: #a82b2b;
    --aglow:   rgba(135,35,35,.22);
    --aglow2:  rgba(135,35,35,.08);
    --gold:    #e8a030;
    --green:   #2ef0a0;
    --text:    #f4eded;
    --text2:   #c8b8b8;
    --muted:   #6b5757;
    --border:  rgba(135,35,35,.2);
    --border2: rgba(255,255,255,.05);
    --r:       14px;
    --r2:      20px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
    overflow-x: hidden;
    line-height: 1.6;
}

/* ── Ambient Background ── */
.ambient {
    position: fixed; inset: 0; pointer-events: none; z-index: 0;
    background:
        radial-gradient(ellipse 70% 55% at 15% 0%, rgba(135,35,35,.14) 0%, transparent 65%),
        radial-gradient(ellipse 50% 40% at 85% 95%, rgba(135,35,35,.10) 0%, transparent 60%),
        radial-gradient(ellipse 40% 30% at 50% 50%, rgba(135,35,35,.04) 0%, transparent 70%);
}
.noise {
    position: fixed; inset: 0; pointer-events: none; z-index: 0; opacity: .028;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
    background-size: 256px;
}

/* ── Nav ── */
.fidow-nav {
    position: sticky; top: 0; z-index: 100;
    backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
    background: rgba(8,6,6,.7);
    border-bottom: 1px solid rgba(135,35,35,.12);
    padding: 0 32px;
}
.nav-inner {
    max-width: 1180px; margin: 0 auto;
    display: flex; align-items: center; justify-content: space-between;
    height: 66px; gap: 32px;
}
.nav-logo {
    display: flex; align-items: center; gap: 10px;
    text-decoration: none; flex-shrink: 0;
}
.nav-logo img { height: 32px; width: auto; }
.nav-logo-text {
    font-family: 'Cabinet Grotesk', sans-serif;
    font-size: 20px; font-weight: 900; letter-spacing: -.03em; color: var(--text);
}
.nav-links { display: flex; align-items: center; gap: 6px; }
.nav-links a {
    color: var(--muted); text-decoration: none; font-size: 14px; font-weight: 500;
    padding: 7px 14px; border-radius: 8px; transition: all .2s;
}
.nav-links a:hover { color: var(--text); background: rgba(135,35,35,.1); }
.nav-links a.active { color: var(--text2); background: rgba(135,35,35,.08); }
.nav-cta {
    padding: 9px 20px;
    background: linear-gradient(135deg, var(--accent) 0%, #6b1a1a 100%);
    border: none; border-radius: 10px; color: #fff;
    font-family: 'Cabinet Grotesk', sans-serif; font-size: 13px; font-weight: 800;
    cursor: pointer; text-decoration: none; transition: all .22s;
    box-shadow: 0 4px 18px rgba(135,35,35,.35);
    white-space: nowrap;
}
.nav-cta:hover { transform: translateY(-1px); box-shadow: 0 7px 28px rgba(135,35,35,.5); }
.nav-badge {
    font-size: 11px; color: var(--muted); background: var(--s1);
    border: 1px solid var(--border); border-radius: 100px; padding: 4px 12px;
    white-space: nowrap;
}
.nav-badge b { color: var(--green); }

/* ── Live dot ── */
.live-dot {
    display: inline-block; width: 7px; height: 7px; border-radius: 50%;
    background: var(--green); box-shadow: 0 0 8px var(--green);
    animation: pulse-dot 2s ease infinite;
}
@keyframes pulse-dot { 0%,100%{opacity:1} 50%{opacity:.25} }

/* ── Cards ── */
.card {
    background: var(--s1);
    border: 1px solid var(--border);
    border-radius: var(--r2);
    padding: 32px;
}
.card-sm { padding: 24px; border-radius: var(--r); }
.card-glow {
    box-shadow: 0 0 0 1px var(--border), 0 0 60px rgba(135,35,35,.07);
}

/* ── Buttons ── */
.btn-primary {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 13px 28px;
    background: linear-gradient(135deg, var(--accent) 0%, #6b1a1a 100%);
    border: none; border-radius: 11px; color: #fff;
    font-family: 'Cabinet Grotesk', sans-serif; font-size: 14px; font-weight: 800;
    cursor: pointer; text-decoration: none; transition: all .22s;
    box-shadow: 0 6px 24px rgba(135,35,35,.35);
}
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 36px rgba(135,35,35,.5); }
.btn-primary:disabled { opacity: .5; cursor: not-allowed; transform: none; }
.btn-ghost {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 13px 24px;
    background: transparent; border: 1px solid var(--border); border-radius: 11px;
    color: var(--muted); font-family: 'DM Sans', sans-serif; font-size: 14px;
    cursor: pointer; text-decoration: none; transition: all .2s;
}
.btn-ghost:hover { border-color: rgba(135,35,35,.4); color: var(--text); }

/* ── Form elements ── */
.field { display: flex; flex-direction: column; gap: 7px; }
.field label {
    font-size: 11px; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: var(--muted);
}
.field label .req { color: var(--accent2); }
input[type=text], input[type=email], input[type=password],
input[type=search], textarea, select {
    background: var(--s2); border: 1px solid rgba(255,255,255,.07);
    border-radius: 11px; padding: 12px 15px; color: var(--text);
    font-family: 'DM Sans', sans-serif; font-size: 14px;
    outline: none; transition: border-color .2s, box-shadow .2s; width: 100%;
}
input::placeholder, textarea::placeholder { color: var(--muted); font-style: italic; }
textarea { resize: vertical; min-height: 90px; }
select {
    appearance: none; cursor: pointer;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%236b5757' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 14px center;
    padding-right: 40px;
}
select option { background: #170e0e; }
input:focus, textarea:focus, select:focus {
    border-color: var(--accent); box-shadow: 0 0 0 3px rgba(135,35,35,.14);
}

/* ── Section header ── */
.section-tag {
    display: inline-block;
    background: rgba(135,35,35,.12); border: 1px solid rgba(135,35,35,.25);
    border-radius: 100px; padding: 4px 14px;
    font-size: 11px; font-weight: 700; letter-spacing: .1em;
    text-transform: uppercase; color: #d47070; margin-bottom: 14px;
}
.section-title {
    font-family: 'Cabinet Grotesk', sans-serif;
    font-size: clamp(26px, 4vw, 40px); font-weight: 900; letter-spacing: -.03em;
    line-height: 1.08; margin-bottom: 10px;
}
.section-sub { color: var(--muted); font-size: 15px; line-height: 1.65; }

/* ── Gradient text ── */
.grad {
    background: linear-gradient(90deg, #e05555 0%, #872323 40%, #e07050 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text; background-size: 200%;
    animation: shimmer 5s linear infinite;
}
.grad-gold {
    background: linear-gradient(90deg, var(--gold) 0%, #f0c060 60%, #e8a030 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
}
@keyframes shimmer { 0%{background-position:0%} 100%{background-position:200%} }

/* ── Page rise animation ── */
@keyframes rise { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:none} }
.rise { animation: rise .8s cubic-bezier(.22,1,.36,1) both; }
.rise-2 { animation: rise .8s .1s cubic-bezier(.22,1,.36,1) both; }
.rise-3 { animation: rise .8s .2s cubic-bezier(.22,1,.36,1) both; }

/* ── Wrap ── */
.wrap { position: relative; z-index: 1; max-width: 1180px; margin: 0 auto; padding: 0 28px; }
.wrap-sm { max-width: 860px; }
.wrap-xs { max-width: 600px; }

/* ── Divider ── */
.divider { height: 1px; background: var(--border2); margin: 0; }

/* ── Footer ── */
.fidow-footer {
    border-top: 1px solid rgba(135,35,35,.1);
    padding: 28px 32px; position: relative; z-index: 1;
}
.footer-inner {
    max-width: 1180px; margin: 0 auto;
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 12px;
}
.footer-copy { font-size: 13px; color: var(--muted); }
.footer-links { display: flex; gap: 20px; }
.footer-links a { font-size: 13px; color: var(--muted); text-decoration: none; transition: color .2s; }
.footer-links a:hover { color: var(--text); }

/* ── Spinner ── */
.spinner {
    width: 16px; height: 16px;
    border: 2px solid rgba(255,255,255,.2); border-top-color: #fff;
    border-radius: 50%; animation: spin .65s linear infinite; display: inline-block;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Error box ── */
.error-box {
    display: none; margin-top: 12px; padding: 12px 16px; border-radius: 10px;
    background: rgba(135,35,35,.1); border: 1px solid rgba(135,35,35,.3);
    color: #e05555; font-size: 13px; line-height: 1.5;
}

/* ── Admin sidebar layout ── */
.admin-layout { display: grid; grid-template-columns: 240px 1fr; min-height: 100vh; }
.admin-sidebar {
    background: var(--s1); border-right: 1px solid var(--border);
    padding: 24px 0; display: flex; flex-direction: column;
    position: sticky; top: 0; height: 100vh; overflow-y: auto;
}
.admin-sidebar-logo {
    padding: 0 20px 24px; border-bottom: 1px solid var(--border);
    margin-bottom: 20px; display: flex; align-items: center; gap: 10px;
}
.admin-sidebar-logo img { height: 28px; }
.admin-sidebar-logo span {
    font-family: 'Cabinet Grotesk', sans-serif; font-weight: 900; font-size: 17px;
}
.admin-nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 20px; color: var(--muted); font-size: 13px; font-weight: 500;
    text-decoration: none; transition: all .18s; border-radius: 0;
    margin: 1px 10px; border-radius: 9px;
}
.admin-nav-item:hover { color: var(--text); background: rgba(135,35,35,.1); }
.admin-nav-item.active { color: var(--text); background: rgba(135,35,35,.15); border: 1px solid rgba(135,35,35,.2); }
.admin-nav-section {
    padding: 16px 20px 6px; font-size: 10px; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase; color: var(--muted);
}
.admin-main { padding: 40px 36px; overflow-y: auto; }
.admin-main-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 32px; flex-wrap: wrap; gap: 14px;
}
.admin-page-title {
    font-family: 'Cabinet Grotesk', sans-serif; font-size: 26px;
    font-weight: 900; letter-spacing: -.02em;
}
.admin-page-sub { color: var(--muted); font-size: 13px; margin-top: 3px; }

/* ── Table ── */
.table-wrap { overflow-x: auto; border-radius: 16px; border: 1px solid var(--border); }
table { width: 100%; border-collapse: collapse; font-size: 13px; }
thead tr { background: var(--s1); }
th {
    padding: 13px 16px; text-align: left; font-size: 10px;
    font-weight: 700; letter-spacing: .08em; text-transform: uppercase;
    color: var(--muted); border-bottom: 1px solid var(--border); white-space: nowrap;
}
td {
    padding: 13px 16px; border-bottom: 1px solid rgba(255,255,255,.03);
    vertical-align: middle;
}
tr:last-child td { border-bottom: none; }
tr:hover td { background: rgba(135,35,35,.03); }
.td-trunc { max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

/* ── Badges ── */
.badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 10px; font-weight: 700; letter-spacing: .08em;
    text-transform: uppercase; border-radius: 100px; padding: 3px 10px;
    border: 1px solid;
}
.badge-green { background: rgba(46,240,160,.08); border-color: rgba(46,240,160,.25); color: var(--green); }
.badge-red { background: rgba(135,35,35,.12); border-color: var(--border); color: #d47070; }
.badge-gold { background: rgba(232,160,48,.08); border-color: rgba(232,160,48,.25); color: var(--gold); }
.badge-muted { background: var(--s2); border-color: var(--border2); color: var(--muted); }

/* ── Pagination ── */
.pagination { display: flex; justify-content: center; gap: 6px; flex-wrap: wrap; margin-top: 24px; }
.pagination a, .pagination span {
    padding: 8px 13px; background: var(--s1); border: 1px solid var(--border);
    border-radius: 8px; font-size: 13px; color: var(--muted); text-decoration: none;
    transition: all .18s;
}
.pagination a:hover { border-color: var(--accent); color: var(--text); }
.pagination .active span { background: rgba(135,35,35,.2); border-color: var(--accent); color: var(--text); }

@media(max-width:900px) {
    .admin-layout { grid-template-columns: 1fr; }
    .admin-sidebar { display: none; }
    .admin-main { padding: 24px 16px; }
}
@media(max-width:640px) {
    .wrap { padding: 0 16px; }
    .nav-inner { padding: 0; }
    .fidow-nav { padding: 0 16px; }
    .fidow-footer { padding: 20px 16px; }
}
</style>
