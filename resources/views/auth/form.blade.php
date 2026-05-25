<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $mode === 'login' ? 'Login' : 'Daftar' }} — EduPlay</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
  <style>
  :root{
    --indigo: #4F46E5;
    --indigo-light: #818CF8;
    --indigo-dark: #3730A3;
    --orange: #F97316;
    --orange-light: #FB923C;
    --sky: #0EA5E9;
    --sky-light: #38BDF8;
    --bg: #05050F;
    --bg2: #0D0D1F;
    --bg3: #12122A;
    --text: #F0F0FF;
    --muted: #8B8BAD;
    --card-bg: rgba(255,255,255,0.04);
    --card-border: rgba(255,255,255,0.08);
  }
  *{box-sizing:border-box;margin:0;padding:0}
  body{
    font-family:'DM Sans',system-ui,sans-serif;
    background:var(--bg);
    color:var(--text);
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:28px;
    position:relative;
    overflow:hidden;
  }
  body::before,body::after{content:'';position:absolute;width:420px;height:420px;border-radius:50%;filter:blur(80px);opacity:0.15;z-index:0}
  body::before{background:radial-gradient(circle at 30% 30%,rgba(79,70,229,0.4),transparent);top:-140px;left:-160px}
  body::after{background:radial-gradient(circle at 70% 30%,rgba(249,115,22,0.3),transparent);bottom:-180px;right:-120px}

  .auth-shell{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1.05fr;gap:28px;max-width:1040px;width:100%}
  .auth-visual{background:linear-gradient(145deg,var(--bg2),var(--bg));border:1px solid var(--card-border);border-radius:28px;padding:36px;color:white;display:flex;flex-direction:column;justify-content:space-between;min-height:520px;box-shadow:0 24px 50px rgba(0,0,0,0.3);backdrop-filter:blur(20px)}
  .brand{display:flex;align-items:center;gap:12px;font-weight:700;font-size:16px;text-decoration:none;color:white}
  .brand svg{width:22px;height:22px}
  .hero{margin-top:28px}
  .hero-title{font-size:28px;font-weight:700;line-height:1.3;margin-bottom:12px;color:var(--text)}
  .hero-text{font-size:13px;color:var(--muted);line-height:1.6}
  .hero-stats{margin-top:28px;display:grid;gap:12px}
  .stat-card{display:flex;justify-content:space-between;align-items:center;border:1px solid var(--card-border);padding:12px 14px;border-radius:14px;background:var(--card-bg)}
  .stat-label{font-size:12px;color:var(--muted)}
  .stat-value{font-size:16px;font-weight:700;color:var(--text)}
  .badge{display:inline-flex;gap:8px;align-items:center;background:rgba(79,70,229,0.2);border:1px solid rgba(79,70,229,0.3);padding:6px 12px;border-radius:999px;font-size:11px;color:var(--indigo-light)}

  .auth-card{background:var(--card-bg);border:1px solid var(--card-border);border-radius:28px;padding:36px;box-shadow:0 20px 48px rgba(0,0,0,0.4);animation:lift 0.7s ease;backdrop-filter:blur(20px)}
  @keyframes lift{from{transform:translateY(16px);opacity:0}to{transform:translateY(0);opacity:1}}
  .card-title{font-family:'Syne',sans-serif;font-size:24px;font-weight:700;margin-bottom:6px;color:var(--text)}
  .card-subtitle{font-size:13px;color:var(--muted);margin-bottom:18px}
  .form-group{margin-bottom:14px}
  label{display:block;font-size:11px;text-transform:uppercase;letter-spacing:0.08em;color:var(--muted);font-weight:600;margin-bottom:6px}
  input,select{width:100%;padding:12px 14px;border-radius:12px;border:1px solid var(--card-border);font-family:inherit;font-size:14px;background:rgba(255,255,255,0.05);color:var(--text);transition:0.2s}
  input:focus,select:focus{outline:none;border-color:var(--indigo);box-shadow:0 0 0 3px rgba(79,70,229,0.2);background:rgba(255,255,255,0.08)}
  input::placeholder{color:var(--muted)}
  .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
  .error-msg{font-size:12px;color:#ff6b6b;margin-top:4px}
  .input-wrap{position:relative;display:flex;align-items:center}
  .input-wrap input{padding-right:44px}
  .toggle-btn{position:absolute;right:8px;background:rgba(129,140,248,0.15);border:1px solid rgba(129,140,248,0.3);color:var(--indigo-light);border-radius:10px;padding:6px 8px;font-size:11px;font-weight:700;cursor:pointer;transition:0.2s}
  .toggle-btn:hover{background:rgba(129,140,248,0.25)}
  .strength{margin-top:8px}
  .strength-bar{height:6px;background:rgba(255,255,255,0.1);border-radius:999px;overflow:hidden}
  .strength-bar span{display:block;height:100%;width:0%;background:var(--orange);transition:width 0.2s ease,background 0.2s ease}
  .strength-text{font-size:11px;color:var(--muted);margin-top:6px}
  .toast-container{position:fixed;top:20px;right:20px;display:flex;flex-direction:column;gap:10px;z-index:200}
  .toast{min-width:220px;max-width:320px;background:var(--card-bg);border:1px solid var(--card-border);border-left:4px solid var(--indigo);border-radius:14px;padding:12px 14px;box-shadow:0 16px 40px rgba(0,0,0,0.4);display:flex;align-items:flex-start;justify-content:space-between;gap:12px;animation:toast-in 0.25s ease;backdrop-filter:blur(20px)}
  .toast.toast-success{border-left-color:#16a34a}
  .toast.toast-error{border-left-color:#ff6b6b}
  .toast-title{font-size:13px;font-weight:700;margin-bottom:4px;color:var(--text)}
  .toast-text{font-size:12.5px;color:var(--muted);line-height:1.5}
  .toast-close{border:none;background:transparent;color:var(--muted);cursor:pointer;font-size:14px;line-height:1;transition:0.2s}
  .toast-close:hover{color:var(--text)}
  .toast.is-hidden{animation:toast-out 0.2s ease forwards}
  @keyframes toast-in{from{transform:translateY(-8px);opacity:0}to{transform:translateY(0);opacity:1}}
  @keyframes toast-out{to{transform:translateY(-6px);opacity:0}}
  .btn{width:100%;padding:13px;border-radius:14px;border:none;background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;font-family:inherit;font-size:15px;font-weight:700;cursor:pointer;margin-top:6px;transition:0.2s;box-shadow:0 4px 24px rgba(79,70,229,0.3)}
  .btn:hover{filter:brightness(1.1);transform:translateY(-2px)}
  .link-row{text-align:center;font-size:13px;color:var(--muted);margin-top:12px}
  .link-row a{color:var(--indigo-light);font-weight:700;text-decoration:none;transition:0.2s}
  .link-row a:hover{color:var(--sky-light)}
  .demo-box{background:rgba(79,70,229,0.1);border:1px solid rgba(79,70,229,0.2);border-radius:14px;padding:12px 14px;margin-bottom:12px;font-size:12px;color:var(--text)}
  .demo-row{display:flex;gap:8px;margin-top:8px}
  .demo-btn{flex:1;padding:8px 10px;border-radius:10px;border:1px solid var(--card-border);background:rgba(255,255,255,0.05);font-size:11.5px;font-weight:700;cursor:pointer;color:var(--text);font-family:inherit;transition:0.2s}
  .demo-btn:hover{border-color:var(--indigo);background:rgba(79,70,229,0.15);color:var(--indigo-light)}
  .remember-row{display:flex;align-items:center;gap:8px;margin-bottom:8px}
  .remember-row label{margin:0;font-size:12px;text-transform:none;letter-spacing:0;color:var(--muted)}
  .back-link{display:inline-flex;align-items:center;gap:6px;font-size:12px;text-decoration:none;color:var(--muted);transition:0.2s}
  .back-link:hover{color:var(--text)}

  @media (max-width: 900px){
    .auth-shell{grid-template-columns:1fr}
    .auth-visual{min-height:auto}
  }
  </style>
</head>
<body>
  <div class="toast-container">
    @if(session('success'))
    <div class="toast toast-success" data-toast>
      <div>
        <div class="toast-title">Berhasil</div>
        <div class="toast-text">{{ session('success') }}</div>
      </div>
      <button type="button" class="toast-close" data-toast-close>✕</button>
    </div>
    @endif
    @if(session('error'))
    <div class="toast toast-error" data-toast>
      <div>
        <div class="toast-title">Gagal</div>
        <div class="toast-text">{{ session('error') }}</div>
      </div>
      <button type="button" class="toast-close" data-toast-close>✕</button>
    </div>
    @endif
  </div>

  <div class="auth-shell">
    <section class="auth-visual">
      <div>
        <a href="/" class="brand">
          <svg viewBox="0 0 48 48" fill="none"><rect x="8" y="20" width="32" height="14" rx="3" stroke="currentColor" stroke-width="1.7"/><path d="M14 20c0-4 4-7 10-7s10 3 10 7" stroke="currentColor" stroke-width="1.7"/><rect x="18" y="23" width="12" height="4" rx="1.5" stroke="currentColor" stroke-width="1.4"/></svg>
          EduPlayHub
        </a>
        <div class="hero">
          <div class="badge">Ruang belajar & belanja edukatif</div>
          <div class="hero-title">Akun yang rapi, transaksi yang mudah, dan katalog yang selalu siap.</div>
          <div class="hero-text">Masuk untuk melanjutkan aktivitas, atau daftar agar bisa menyewa dan membeli produk edukasi terbaik.</div>
        </div>
      </div>
      <div class="hero-stats">
        <div class="stat-card">
          <div>
            <div class="stat-label">Marketplace Edukasi</div>
            <div class="stat-value">Terintegrasi</div>
          </div>
          <div class="stat-value">24/7</div>
        </div>
        <div class="stat-card">
          <div>
            <div class="stat-label">Admin Toko</div>
            <div class="stat-value">Terverifikasi</div>
          </div>
          <div class="stat-value">1</div>
        </div>
      </div>
    </section>

    <section class="auth-card">
      @if($mode === 'login')
        <div class="card-title">Selamat Datang</div>
        <div class="card-subtitle">Masuk ke akun Anda untuk mulai belanja</div>

        <div class="demo-box">
          <strong>Akun Demo:</strong>
          <div class="demo-row">
            <button class="demo-btn" type="button" onclick="fillDemo('buyer@demo.com','password')">Akun Pembeli</button>
            <button class="demo-btn" type="button" onclick="fillDemo('seller@demo.com','password')">Akun Admin</button>
          </div>
        </div>

        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" id="emailInput" value="{{ old('email') }}" required placeholder="nama@email.com" autocomplete="email">
            @error('email')<div class="error-msg">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label>Password</label>
            <div class="input-wrap">
              <input type="password" name="password" id="passInput" required placeholder="••••••••" autocomplete="current-password">
              <button type="button" class="toggle-btn" data-toggle="#passInput">Tampilkan</button>
            </div>
            @error('password')<div class="error-msg">{{ $message }}</div>@enderror
          </div>
          <div class="remember-row">
            <input type="checkbox" name="remember" id="remember" style="width:auto;margin:0">
            <label for="remember">Ingat saya</label>
          </div>
          <button type="submit" class="btn">Masuk</button>
        </form>

        <div class="link-row">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></div>
      @else
        <div class="card-title">Buat Akun Baru</div>
        <div class="card-subtitle">Bergabung dengan ribuan pengguna EduPlayHub</div>

        <form method="POST" action="{{ route('register') }}" id="regForm">
          @csrf

          <div class="form-grid">
            <div class="form-group">
              <label>Nama Lengkap</label>
              <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama kamu">
              @error('name')<div class="error-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@domain.com">
              @error('email')<div class="error-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
              <label>Password</label>
              <div class="input-wrap">
                <input type="password" name="password" id="regPassword" required placeholder="Min. 8 karakter" data-strength>
                <button type="button" class="toggle-btn" data-toggle="#regPassword">Tampilkan</button>
              </div>
              <div class="strength" data-strength-meter>
                <div class="strength-bar"><span></span></div>
                <div class="strength-text">Kekuatan password</div>
              </div>
              @error('password')<div class="error-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
              <label>Konfirmasi Password</label>
              <div class="input-wrap">
                <input type="password" name="password_confirmation" id="regPasswordConfirm" required placeholder="Ulangi password">
                <button type="button" class="toggle-btn" data-toggle="#regPasswordConfirm">Tampilkan</button>
              </div>
            </div>
          </div>

          <button type="submit" class="btn">Daftar Sekarang</button>
        </form>

        <div class="link-row">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></div>
      @endif

      <div class="link-row" style="margin-top:10px">
        <a href="{{ route('welcome') }}" class="back-link">Kembali ke landing</a>
      </div>
    </section>
  </div>

  <script>
  function fillDemo(email, pass) {
    document.getElementById('emailInput').value = email;
    document.getElementById('passInput').value = pass;
  }

  document.querySelectorAll('[data-toggle]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var target = document.querySelector(btn.getAttribute('data-toggle'));
      if (!target) return;
      var isPassword = target.type === 'password';
      target.type = isPassword ? 'text' : 'password';
      btn.textContent = isPassword ? 'Sembunyikan' : 'Tampilkan';
    });
  });

  function scorePassword(value) {
    var score = 0;
    if (!value) return score;
    if (value.length >= 8) score++;
    if (value.length >= 12) score++;
    if (/[A-Z]/.test(value)) score++;
    if (/[0-9]/.test(value)) score++;
    if (/[^A-Za-z0-9]/.test(value)) score++;
    return Math.min(score, 4);
  }

  var strengthInput = document.querySelector('[data-strength]');
  var strengthMeter = document.querySelector('[data-strength-meter]');
  if (strengthInput && strengthMeter) {
    var bar = strengthMeter.querySelector('span');
    var text = strengthMeter.querySelector('.strength-text');
    strengthInput.addEventListener('input', function () {
      var score = scorePassword(strengthInput.value);
      var pct = (score / 4) * 100;
      bar.style.width = pct + '%';
      if (score <= 1) {
        bar.style.background = '#dc2626';
        text.textContent = 'Lemah';
      } else if (score === 2) {
        bar.style.background = '#f97316';
        text.textContent = 'Cukup';
      } else if (score === 3) {
        bar.style.background = '#16a34a';
        text.textContent = 'Kuat';
      } else {
        bar.style.background = '#0f766e';
        text.textContent = 'Sangat kuat';
      }
    });
  }

  document.querySelectorAll('[data-toast]').forEach(function (toast) {
    var close = toast.querySelector('[data-toast-close]');
    var hide = function () {
      toast.classList.add('is-hidden');
      setTimeout(function () { toast.remove(); }, 220);
    };
    if (close) close.addEventListener('click', hide);
    setTimeout(hide, 4500);
  });
  </script>
</body>
</html>
