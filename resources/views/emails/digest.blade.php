<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RemoteDigest — Fidow</title>
<style>
  /* Reset email */
  body,table,td,a{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}
  body{margin:0;padding:0;background:#0f0f12;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;}
  table{border-spacing:0;mso-table-lspace:0;mso-table-rspace:0;}
  img{border:0;height:auto;line-height:100%;outline:none;text-decoration:none;}
  a{color:inherit;}

  /* Wrapper */
  .wrapper{width:100%;max-width:640px;margin:0 auto;}

  /* Header */
  .header{background:linear-gradient(135deg,#872323,#c04040);border-radius:16px 16px 0 0;padding:32px 40px 28px;}
  .header-logo{font-size:22px;font-weight:900;color:#fff;letter-spacing:-0.03em;}
  .header-logo span{color:rgba(255,255,255,0.6);}
  .header-badge{display:inline-block;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.2);color:#fff;font-size:12px;font-weight:700;padding:4px 12px;border-radius:100px;margin-top:12px;letter-spacing:0.06em;}
  .header-title{font-size:26px;font-weight:800;color:#fff;margin:14px 0 4px;line-height:1.2;letter-spacing:-0.02em;}
  .header-sub{font-size:14px;color:rgba(255,255,255,0.7);line-height:1.6;margin:0;}

  /* Profile pill */
  .profile-pill{background:#1a1a1e;border:1px solid rgba(255,255,255,0.08);border-radius:0;padding:16px 40px;}
  .profile-pill-inner{background:rgba(135,35,35,0.08);border:1px solid rgba(135,35,35,0.18);border-radius:10px;padding:12px 16px;display:inline-block;width:100%;box-sizing:border-box;}
  .profile-label{font-size:11px;font-weight:700;color:#872323;letter-spacing:0.1em;text-transform:uppercase;margin:0 0 4px;}
  .profile-value{font-size:14px;color:#d1d5db;margin:0;}
  .profile-value strong{color:#f3f4f6;font-weight:700;}

  /* Section title */
  .section-bg{background:#161619;}
  .section-header{padding:24px 40px 12px;background:#161619;}
  .section-title{font-size:11px;font-weight:800;color:#872323;letter-spacing:0.12em;text-transform:uppercase;margin:0 0 4px;}
  .section-count{font-size:14px;color:#9ca3af;margin:0;}
  .section-count strong{color:#f3f4f6;}

  /* Job card */
  .job-wrap{padding:0 40px 12px;background:#161619;}
  .job-card{background:#1e1e22;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:12px;}
  .job-card-head{padding:16px 18px 12px;border-bottom:1px solid rgba(255,255,255,0.05);}
  .job-rank{display:inline-block;font-size:11px;font-weight:800;color:#872323;background:rgba(135,35,35,0.12);padding:3px 8px;border-radius:6px;margin-bottom:8px;}
  .job-title{font-size:16px;font-weight:800;color:#f3f4f6;line-height:1.3;margin:0 0 4px;}
  .job-company{font-size:13px;color:#9ca3af;margin:0;}
  .job-company strong{color:#d1d5db;}
  .job-meta{padding:10px 18px;display:table;width:100%;box-sizing:border-box;}
  .job-meta-pill{display:inline-block;font-size:11px;font-weight:700;padding:3px 9px;border-radius:6px;margin-right:6px;margin-bottom:4px;white-space:nowrap;}
  .pill-country{background:rgba(59,130,246,0.1);color:#60a5fa;border:1px solid rgba(59,130,246,0.15);}
  .pill-type{background:rgba(16,185,129,0.1);color:#34d399;border:1px solid rgba(16,185,129,0.15);}
  .pill-score{background:rgba(245,158,11,0.1);color:#fbbf24;border:1px solid rgba(245,158,11,0.15);}
  .job-desc{padding:0 18px 12px;font-size:13px;color:#9ca3af;line-height:1.65;margin:0;}
  .job-footer{padding:12px 18px;border-top:1px solid rgba(255,255,255,0.05);text-align:right;}
  .job-cta{display:inline-block;background:#872323;color:#fff !important;text-decoration:none;font-size:13px;font-weight:800;padding:8px 18px;border-radius:8px;}

  /* Score bar */
  .score-wrap{padding:0 18px 14px;}
  .score-label{font-size:11px;color:#6b7280;margin-bottom:4px;}
  .score-bar-bg{height:4px;background:rgba(255,255,255,0.06);border-radius:99px;overflow:hidden;}
  .score-bar-fill{height:100%;border-radius:99px;background:linear-gradient(90deg,#872323,#c04040);}

  /* Divider */
  .divider{height:1px;background:rgba(255,255,255,0.04);margin:0 40px;}

  /* Footer */
  .footer{background:#111114;border-radius:0 0 16px 16px;padding:28px 40px;text-align:center;}
  .footer-logo{font-size:18px;font-weight:900;color:#f3f4f6;letter-spacing:-0.03em;margin-bottom:8px;}
  .footer-logo span{color:#872323;}
  .footer-desc{font-size:12px;color:#6b7280;line-height:1.6;margin:0 0 16px;}
  .footer-links{margin-bottom:16px;}
  .footer-link{color:#9ca3af !important;font-size:12px;text-decoration:none;margin:0 8px;}
  .footer-link:hover{color:#f3f4f6 !important;}
  .footer-copy{font-size:11px;color:#4b5563;margin:0;}
  .footer-unsub{margin-top:12px;}
  .footer-unsub a{font-size:11px;color:#6b7280 !important;text-decoration:underline;}

  /* Responsive */
  @media only screen and (max-width:600px){
    .header,.profile-pill,.section-header,.job-wrap,.footer,.divider{padding-left:20px!important;padding-right:20px!important;}
    .header-title{font-size:20px!important;}
    .job-card-head{padding:14px 14px 10px!important;}
    .job-meta,.job-desc,.score-wrap,.job-footer{padding-left:14px!important;padding-right:14px!important;}
  }
</style>
</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0" style="background:#0f0f12;padding:24px 12px;">
<tr><td>
<table class="wrapper" cellpadding="0" cellspacing="0" style="width:100%;max-width:640px;margin:0 auto;">

  {{-- ── HEADER ── --}}
  <tr><td class="header">
    <div class="header-logo">Fidow <span>/ RemoteDigest</span></div>
    <div class="header-badge">📡 DIGEST QUOTIDIEN</div>
    <div class="header-title">
      Tes {{ $jobs->count() }} opportunités remote<br>du {{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
    </div>
    <p class="header-sub">Sélectionnées spécialement pour ton profil · Jamais les mêmes deux fois</p>
  </td></tr>

  {{-- ── PROFIL DÉTECTÉ ── --}}
  <tr><td class="profile-pill">
    <div class="profile-pill-inner">
      <div class="profile-label">Profil détecté</div>
      <div class="profile-value">
        <strong>{{ $subscriber->metier }}</strong> · {{ $subscriber->domain_label }}
        @php $prefs = $subscriber->preferences_with_defaults; @endphp
        @if($prefs['pays']) · {{ $prefs['pays'] }} @endif
        @if($prefs['type_contrat']) · {{ ucfirst(str_replace('_', ' ', $prefs['type_contrat'])) }} @endif
      </div>
    </div>
  </td></tr>

  {{-- ── SECTION HEADER ── --}}
  <tr><td class="section-header section-bg">
    <div class="section-title">🔥 Offres sélectionnées</div>
    <div class="section-count"><strong>{{ $jobs->count() }} offres</strong> triées par pertinence pour ton profil</div>
  </td></tr>

  {{-- ── OFFRES ── --}}
  @foreach($jobs as $i => $job)
  <tr><td class="job-wrap section-bg">
    <div class="job-card">

      <div class="job-card-head">
        <div class="job-rank">#{{ $i + 1 }}</div>
        <div class="job-title">{{ $job->title }}</div>
        <div class="job-company">
          <strong>{{ $job->company ?? 'Entreprise' }}</strong>
        </div>
      </div>

      <div class="job-meta">
        @if($job->country)
          <span class="job-meta-pill pill-country">📍 {{ $job->country }}</span>
        @endif
        @if($job->contract_type)
          <span class="job-meta-pill pill-type">{{ $job->contract_label }}</span>
        @endif
        <span class="job-meta-pill pill-score">⚡ Remote</span>
      </div>

      @if($job->short_description)
      <p class="job-desc">{{ $job->short_description }}</p>
      @endif

      <div class="job-footer">
        <a href="{{ $job->url }}" class="job-cta" target="_blank">
          Voir l'offre &rarr;
        </a>
      </div>

    </div>
  </td></tr>

  @if(!$loop->last && ($i + 1) % 5 === 0)
  <tr><td class="divider section-bg" style="padding:4px 0;"></td></tr>
  @endif
  @endforeach

  {{-- ── FOOTER ── --}}
  <tr><td class="footer">
    <div class="footer-logo">fi<span>dow</span></div>
    <p class="footer-desc">
      Suite d'outils gratuits pour les professionnels du remote.<br>
      Ce digest est envoyé chaque jour à {{ $subscriber->send_hour }}h00 selon tes préférences.
    </p>
    <div class="footer-links">
      <a href="{{ config('app.url') }}" class="footer-link">Accueil</a>
      <a href="{{ config('app.url') }}/positionnement" class="footer-link">Positionnement Pro</a>
      <a href="{{ config('app.url') }}/remote-digest/preferences/{{ $subscriber->unsubscribe_token }}" class="footer-link">Mes préférences</a>
    </div>
    <p class="footer-copy">&copy; {{ date('Y') }} Fidow · Nealix.org · Tous droits réservés</p>
    <div class="footer-unsub">
      <a href="{{ config('app.url') }}/remote-digest/unsubscribe/{{ $subscriber->unsubscribe_token }}">
        Se désabonner en 1 clic · Plus jamais d'email
      </a>
    </div>
  </td></tr>

</table>
</td></tr>
</table>
</body>
</html>
