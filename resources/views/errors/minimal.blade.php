<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Erreur — Fidow</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #0a0a0d; color: #d1d5db; font-family: 'Inter', system-ui, sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem; }
        .card { max-width: 440px; width: 100%; text-align: center; }
        .icon { width: 64px; height: 64px; border-radius: 50%; background: rgba(135,35,35,.15); border: 1px solid rgba(135,35,35,.3); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; }
        h1 { font-size: 4.5rem; font-weight: 900; color: #f3f4f6; line-height: 1; margin-bottom: .5rem; }
        p { color: #9ca3af; font-size: .95rem; line-height: 1.65; margin-bottom: 2rem; }
        .btn { display: inline-flex; align-items: center; gap: .4rem; padding: .7rem 1.4rem; background: #872323; color: #fff; border: none; border-radius: 10px; font-weight: 700; font-size: .875rem; cursor: pointer; text-decoration: none; margin: .25rem; }
        .btn-ghost { background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1); color: #d1d5db; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">
            <svg width="28" height="28" fill="none" stroke="#f87171" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
        </div>
        <h1>{{ $exception?->getStatusCode() ?? 'Erreur' }}</h1>
        <p>Une erreur s'est produite. Veuillez réessayer dans quelques instants.</p>
        <div>
            <button onclick="location.reload()" class="btn">Réessayer</button>
            <a href="/" class="btn btn-ghost">Accueil</a>
        </div>
    </div>
</body>
</html>
