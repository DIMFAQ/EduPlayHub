<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $mode === 'login' ? 'Login' : 'Daftar' }} — EduPlayHub</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700|fraunces:600" rel="stylesheet" />
  <style>
  :root{--bg:#0b0d14;--panel:rgba(18,20,32,0.62);--panel-strong:rgba(18,20,32,0.9);--stroke:rgba(255,255,255,0.12);--text:#eef2ff;--muted:#a6b0d8;--accent:#4da3ff;--accent-warm:#ff7a3c}
  *{box-sizing:border-box;margin:0;padding:0}
  body{background:radial-gradient(circle at 12% 15%,rgba(77,163,255,0.28),transparent 45%),radial-gradient(circle at 90% 10%,rgba(255,122,60,0.22),transparent 40%),radial-gradient(circle at 70% 70%,rgba(139,91,255,0.28),transparent 45%),var(--bg);font-family:'Space Grotesk',system-ui,sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;color:var(--text)}
  .card{background:var(--panel-strong);border-radius:28px;padding:40px;width:100%;max-width:520px;box-shadow:0 24px 70px rgba(6,10,22,0.55);border:1px solid var(--stroke);backdrop-filter:blur(24px)}
  .logo{display:flex;align-items:center;gap:10px;margin-bottom:18px;text-decoration:none;color:var(--text)}
  .logo-text{font-size:17px;font-weight:700;letter-spacing:-0.3px}
  h1{font-size:24px;font-weight:700;margin-bottom:6px}
  .subtitle{font-size:13px;color:var(--muted);margin-bottom:16px}
  .form-group{margin-bottom:12px}
  .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px}
  label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--muted);margin-bottom:6px}
  input,select{width:100%;padding:11px 14px;border-radius:12px;border:1px solid var(--stroke);background:rgba(255,255,255,0.06);font-family:inherit;font-size:14px;color:var(--text);transition:0.18s}
  input:focus,select:focus{outline:none;border-color:var(--accent);background:rgba(255,255,255,0.1);box-shadow:0 0 0 3px rgba(77,163,255,0.12)}
  .error-msg{font-size:12px;color:#f87171;margin-top:4px}
  .role-options{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:12px}
  .role-card{border:1.5px solid var(--stroke);border-radius:14px;padding:12px;cursor:pointer;transition:0.18s;text-align:center;background:rgba(255,255,255,0.03)}
  .role-card.active{border-color:var(--accent);background:rgba(77,163,255,0.08)}
  .role-icon{width:32px;height:32px;border-radius:10px;margin:0 auto 8px;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#0b0d14;background:linear-gradient(145deg,rgba(255,255,255,0.9),rgba(196,210,255,0.8));box-shadow:0 8px 16px rgba(0,0,0,0.25)}
  .btn{width:100%;padding:13px;border-radius:14px;border:none;background:linear-gradient(135deg,var(--accent),var(--accent-warm));color:#0b0d14;font-family:inherit;font-size:15px;font-weight:700;cursor:pointer;margin-top:6px}
  .btn:hover{filter:brightness(1.05)}
  .link-row{text-align:center;font-size:13px;color:var(--muted);margin-top:12px}
  .link-row a{color:var(--accent);font-weight:600;text-decoration:none}
  .demo-box{background:var(--panel);border-radius:12px;padding:12px 14px;margin-bottom:10px;font-size:12px;color:var(--muted);border:1px solid var(--stroke)}
  .demo-row{display:flex;gap:8px;margin-top:6px}
  .demo-btn{flex:1;padding:8px 10px;border-radius:10px;border:1px solid var(--stroke);background:rgba(255,255,255,0.06);font-size:11.5px;font-weight:600;cursor:pointer;color:var(--text);font-family:inherit}
  .demo-btn:hover{border-color:var(--accent);color:var(--accent)}
  </style>
</head>
<body>
  <div class="card">
    <a href="/" class="logo">
      <svg width="22" height="22" viewBox="0 0 48 48" fill="none"><rect x="8" y="20" width="32" height="14" rx="3" stroke="#0D1F3C" stroke-width="1.7"/><path d="M14 20c0-4 4-7 10-7s10 3 10 7" stroke="#0D1F3C" stroke-width="1.7"/><rect x="18" y="23" width="12" height="4" rx="1.5" stroke="#0D1F3C" stroke-width="1.4"/></svg>
      <span class="logo-text">EduPlayHub</span>
    </a>

    @if($mode === 'login')
      <h1>Selamat Datang</h1>
      <p class="subtitle">Masuk ke akun Anda untuk mulai belanja</p>

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

      <div class="link-row">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></div>

    @else
      <h1>Buat Akun Baru</h1>
      <p class="subtitle">Bergabung dengan ribuan pengguna EduPlayHub</p>

      <form method="POST" action="{{ route('register') }}" id="regForm">
        @csrf
        <input type="hidden" name="role" id="roleInput" value="buyer">

        <div class="form-group">
          <label>Saya ingin...</label>
          <div class="role-options">
            <div class="role-card active" id="roleBuyer" onclick="setRole('buyer')">
              <div class="role-icon">BY</div>
              <div class="role-name">Pembeli</div>
              <div class="role-desc">Sewa & beli produk</div>
            </div>
            <div class="role-card" id="roleSeller" onclick="setRole('seller')">
              <div class="role-icon">SL</div>
              <div class="role-name">Penjual</div>
              <div class="role-desc">Jual & sewakan produk</div>
            </div>
          </div>
        </div>

        <div class="form-grid">
          <div>
            <label>Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama kamu">
            @error('name')<div class="error-msg">{{ $message }}</div>@enderror
          </div>
          <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@domain.com">
            @error('email')<div class="error-msg">{{ $message }}</div>@enderror
          </div>
          <div>
            <label>Password</label>
            <input type="password" name="password" required placeholder="Min. 6 karakter">
            @error('password')<div class="error-msg">{{ $message }}</div>@enderror
          </div>
          <div>
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required placeholder="Ulangi password">
          </div>
        </div>

        <div class="form-group" id="shopField" style="display:none">
          <label>Nama Toko</label>
          <input type="text" name="shop_name" value="{{ old('shop_name') }}" placeholder="Nama toko Anda">
          @error('shop_name')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn">Daftar Sekarang</button>
      </form>

      <div class="link-row">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></div>
    @endif

    <div class="link-row" style="margin-top:10px"><a href="{{ route('welcome') }}">Kembali ke landing</a></div>
  </div>

  <script>
  function setRole(role) {
    document.getElementById('roleInput').value = role;
    document.getElementById('roleBuyer')?.classList.toggle('active', role === 'buyer');
    document.getElementById('roleSeller')?.classList.toggle('active', role === 'seller');
    const shop = document.getElementById('shopField');
    if (shop) shop.style.display = (role === 'seller') ? 'block' : 'none';
  }
  function fillDemo(email, pass) { document.getElementById('emailInput').value = email; document.getElementById('passInput').value = pass; }
  @if(old('role') === 'seller') setRole('seller'); @endif
  </script>
</body>
</html>
