<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin — Fidow</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cabinet+Grotesk:wght@700;900&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
<style>
:root{--bg:#080606;--s1:#0f0a0a;--s2:#170e0e;--accent:#872323;--text:#f4eded;--muted:#6b5757;--border:rgba(135,35,35,.2);--green:#2ef0a0}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:grid;place-items:center;padding:24px;position:relative;overflow:hidden}
body::before{content:'';position:fixed;inset:0;background:radial-gradient(ellipse 60% 50% at 50% 50%,rgba(135,35,35,.1) 0%,transparent 70%);pointer-events:none}
body::after{content:'';position:fixed;inset:0;opacity:.025;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");background-size:256px;pointer-events:none}

.login-wrap{position:relative;z-index:1;width:100%;max-width:420px}

.login-header{text-align:center;margin-bottom:32px}
.login-logo{display:flex;align-items:center;justify-content:center;gap:10px;margin-bottom:24px;text-decoration:none}
.login-logo img{height:36px}
.login-logo-text{font-family:'Cabinet Grotesk',sans-serif;font-size:22px;font-weight:900;color:var(--text)}
.login-title{font-family:'Cabinet Grotesk',sans-serif;font-size:22px;font-weight:900;letter-spacing:-.03em;margin-bottom:6px}
.login-sub{color:var(--muted);font-size:13px}

.box{background:var(--s1);border:1px solid var(--border);border-radius:20px;padding:36px;box-shadow:0 0 80px rgba(135,35,35,.06),0 20px 60px rgba(0,0,0,.4)}

.field{display:flex;flex-direction:column;gap:7px;margin-bottom:18px}
label{font-size:11px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--muted)}
input{background:var(--s2);border:1px solid rgba(255,255,255,.07);border-radius:11px;padding:12px 14px;color:var(--text);font-family:'DM Sans',sans-serif;font-size:14px;outline:none;width:100%;transition:border-color .2s,box-shadow .2s}
input::placeholder{color:var(--muted)}
input:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(135,35,35,.14)}

.btn{width:100%;padding:14px;background:linear-gradient(135deg,var(--accent) 0%,#6b1a1a 100%);border:none;border-radius:11px;color:#fff;font-family:'Cabinet Grotesk',sans-serif;font-size:15px;font-weight:800;cursor:pointer;margin-top:6px;transition:all .22s;box-shadow:0 6px 22px rgba(135,35,35,.35);letter-spacing:.01em}
.btn:hover{transform:translateY(-2px);box-shadow:0 10px 32px rgba(135,35,35,.5)}

.error{color:#e05555;font-size:13px;margin-bottom:18px;background:rgba(135,35,35,.1);border:1px solid rgba(135,35,35,.28);border-radius:10px;padding:11px 14px;line-height:1.45}

.back-link{display:block;text-align:center;margin-top:20px;color:var(--muted);font-size:13px;text-decoration:none;transition:color .2s}
.back-link:hover{color:var(--text)}

.security-note{display:flex;align-items:center;gap:7px;justify-content:center;margin-top:24px;font-size:12px;color:var(--muted)}
.security-note svg{flex-shrink:0}

@keyframes rise{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:none}}
.login-wrap{animation:rise .7s cubic-bezier(.22,1,.36,1) both}
</style>
</head>
<body>
<div class="login-wrap">
    <div class="login-header">
        <a href="{{ route('home') }}" class="login-logo">
            <img src="{{ asset('assets/logo.png') }}" alt="Fidow">
        </a>
        <div class="login-title">Espace Administration</div>
        <p class="login-sub">Accès réservé à l'administrateur Fidow.</p>
    </div>

    <div class="box">
        @if($errors->any())
            <div class="error">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:6px"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/><path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="field">
                <label>Adresse e-mail</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@fidow.io" required autofocus>
            </div>
            <div class="field" style="margin-bottom:22px">
                <label>Mot de passe</label>
                <input type="password" name="password" placeholder="••••••••••" required>
            </div>
            <button type="submit" class="btn">Se connecter →</button>
        </form>
    </div>

    <a href="{{ route('home') }}" class="back-link">← Retour au site</a>

    <div class="security-note">
        <svg width="12" height="12" fill="none" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor" stroke-width="1.5"/></svg>
        Connexion sécurisée — Fidow Admin
    </div>
</div>
</body>
</html>
