<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — EduPlayHub</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{--accent:#2A5FC4;--accent-hover:#1E4FA8;--border:rgba(13,31,60,0.1);--bg:#F4F7FC;--ink:#0D1F3C;--ink-mid:rgba(13,31,60,0.6)}
*{box-sizing:border-box;margin:0;padding:0}
body{background:var(--bg);font-family:'DM Sans',sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
.card{background:white;border-radius:28px;padding:44px 40px;width:100%;max-width:420px;box-shadow:0 20px 64px rgba(13,31,60,0.1);border:1px solid var(--border)}
.logo{display:flex;align-items:center;gap:10px;margin-bottom:28px;text-decoration:none}
.logo-icon{width:24px;height:24px}
.logo-text{font-size:17px;font-weight:700;color:var(--ink);letter-spacing:-0.3px}
h1{font-size:24px;font-weight:700;letter-spacing:-0.4px;margin-bottom:6px}
.subtitle{font-size:13px;color:var(--ink-mid);margin-bottom:28px}
.form-group{margin-bottom:16px}
label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;color:var(--ink-mid);margin-bottom:6px}
input{width:100%;padding:12px 16px;border-radius:12px;border:1px solid var(--border);background:#F4F7FC;font-family:inherit;font-size:14px;color:var(--ink);transition:0.18s}
input:focus{outline:none;border-color:var(--accent);background:white;box-shadow:0 0 0 3px rgba(42,95,196,0.1)}
.error-msg{font-size:12px;color:#dc2626;margin-top:5px}
.btn{width:100%;padding:13px;border-radius:14px;border:none;background:var(--accent);color:white;font-family:inherit;font-size:15px;font-weight:600;cursor:pointer;margin-top:8px}
.btn:hover{background:var(--accent-hover)}
.divider{text-align:center;margin:20px 0;font-size:12px;color:var(--ink-mid);position:relative}
.divider::before,.divider::after{content:"";position:absolute;top:50%;width:42%;height:1px;background:var(--border)}
.divider::before{left:0}.divider::after{right:0}
.link-row{text-align:center;font-size:13px;color:var(--ink-mid);margin-top:16px}
.link-row a{color:var(--accent);font-weight:600;text-decoration:none}
.demo-box{background:#F4F7FC;border-radius:12px;padding:14px 16px;margin-bottom:20px;font-size:12px;color:var(--ink-mid);border:1px solid var(--border)}
.demo-box strong{color:var(--ink);display:block;margin-bottom:4px}
.demo-row{display:flex;gap:8px;margin-top:4px}
.demo-btn{flex:1;padding:6px 10px;border-radius:8px;border:1px solid var(--border);background:white;font-size:11.5px;font-weight:600;cursor:pointer;color:var(--ink);font-family:inherit}
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
      <button class="demo-btn" onclick="fillDemo('buyer@demo.com','password')">👤 Pembeli</button>
      <button class="demo-btn" onclick="fillDemo('seller@demo.com','password')">🏪 Penjual</button>
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
      <label for="remember" style="font-size:13px;text-transform:none;letter-spacing:0;cursor:pointer;color:var(--ink-mid)">Ingat saya</label>
    </div>
    <button type="submit" class="btn">Masuk</button>
  </form>

  <div class="divider">atau</div>
  <div class="link-row">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></div>
</div>

<script>
function fillDemo(email, pass) {
  document.getElementById('emailInput').value = email;
  document.getElementById('passInput').value = pass;
}
</script>
</body>
</html>
