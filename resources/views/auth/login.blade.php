<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — EduPlayHub</title>
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700|fraunces:600" rel="stylesheet" />
<style>
:root{--bg:#0b0d14;--panel:rgba(18,20,32,0.62);--panel-strong:rgba(18,20,32,0.9);--stroke:rgba(255,255,255,0.12);--text:#eef2ff;--muted:#a6b0d8;--accent:#4da3ff;--accent-hover:#6db6ff;--accent-warm:#ff7a3c}
*{box-sizing:border-box;margin:0;padding:0}
body{background:radial-gradient(circle at 12% 15%,rgba(77,163,255,0.28),transparent 45%),radial-gradient(circle at 90% 10%,rgba(255,122,60,0.22),transparent 40%),radial-gradient(circle at 70% 70%,rgba(139,91,255,0.28),transparent 45%),var(--bg);font-family:'Space Grotesk',system-ui,sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:28px;color:var(--text)}
.card{background:var(--panel-strong);border-radius:28px;padding:44px 40px;width:100%;max-width:420px;box-shadow:0 24px 70px rgba(6,10,22,0.55);border:1px solid var(--stroke);backdrop-filter:blur(24px)}
.logo{display:flex;align-items:center;gap:12px;margin-bottom:28px;text-decoration:none;color:var(--text)}
.logo-icon{width:28px;height:28px}
.logo-text{font-size:17px;font-weight:700;letter-spacing:-0.3px}
h1{font-size:26px;font-weight:700;letter-spacing:-0.4px;margin-bottom:8px}
.subtitle{font-size:13px;color:var(--muted);margin-bottom:28px}
.form-group{margin-bottom:16px}
label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--muted);margin-bottom:6px}
input{width:100%;padding:12px 16px;border-radius:12px;border:1px solid var(--stroke);background:rgba(255,255,255,0.06);font-family:inherit;font-size:14px;color:var(--text);transition:0.18s}
input:focus{outline:none;border-color:var(--accent);background:rgba(255,255,255,0.1);box-shadow:0 0 0 3px rgba(77,163,255,0.2)}
.error-msg{font-size:12px;color:#f87171;margin-top:5px}
.btn{width:100%;padding:13px;border-radius:14px;border:none;background:linear-gradient(135deg,var(--accent),var(--accent-warm));color:#0b0d14;font-family:inherit;font-size:15px;font-weight:700;cursor:pointer;margin-top:8px}
.btn:hover{filter:brightness(1.05)}
.divider{text-align:center;margin:20px 0;font-size:12px;color:var(--muted);position:relative}
.divider::before,.divider::after{content:"";position:absolute;top:50%;width:42%;height:1px;background:var(--stroke)}
.divider::before{left:0}.divider::after{right:0}
.link-row{text-align:center;font-size:13px;color:var(--muted);margin-top:16px}
.link-row a{color:var(--accent);font-weight:600;text-decoration:none}
.demo-box{background:var(--panel);border-radius:12px;padding:14px 16px;margin-bottom:20px;font-size:12px;color:var(--muted);border:1px solid var(--stroke)}
.demo-box strong{color:var(--text);display:block;margin-bottom:4px}
.demo-row{display:flex;gap:8px;margin-top:6px}
.demo-btn{flex:1;padding:8px 10px;border-radius:10px;border:1px solid var(--stroke);background:rgba(255,255,255,0.06);font-size:11.5px;font-weight:600;cursor:pointer;color:var(--text);font-family:inherit}
.demo-btn:hover{border-color:var(--accent);color:var(--accent)}
</style>
</head>
<body>
<div class="card">
  <a href="/" class="logo">
    <svg class="logo-icon" viewBox="0 0 48 48" fill="none"><rect x="8" y="20" width="32" height="14" rx="3" stroke="#0D1F3C" stroke-width="1.7"/><path d="M14 20c0-4 4-7 10-7s10 3 10 7" stroke="#0D1F3C" stroke-width="1.7"/><rect x="18" y="23" width="12" height="4" rx="1.5" stroke="#0D1F3C" stroke-width="1.4"/></svg>
    <span class="logo-text">EduPlayHub</span>
  </a>

  <h1>Selamat Datang</h1>
  <p class="subtitle">Masuk ke akun Anda untuk mulai belanja</p>

  <!-- Demo Credentials -->
  <div class="demo-box">
    <strong>Akun Demo:</strong>
    <div class="demo-row">
      <button class="demo-btn" onclick="fillDemo('buyer@demo.com','password')">Akun Pembeli</button>
      <button class="demo-btn" onclick="fillDemo('seller@demo.com','password')">Akun Penjual</button>
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
      <input type="password" name="password" id="passInput" required placeholder="••••••" autocomplete="current-password">
    </div>
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px">
      <input type="checkbox" name="remember" id="remember" style="width:auto;margin:0">
      <label for="remember" style="font-size:13px;text-transform:none;letter-spacing:0;cursor:pointer;color:var(--muted)">Ingat saya</label>
    </div>
    <button type="submit" class="btn">Masuk</button>
  </form>

  <div class="divider">atau</div>
  <div class="link-row">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></div>
  <div class="link-row" style="margin-top:10px"><a href="{{ route('welcome') }}">Kembali ke landing</a></div>
</div>

<script>
function fillDemo(email, pass) {
  document.getElementById('emailInput').value = email;
  document.getElementById('passInput').value = pass;
}
</script>
</body>
</html>
