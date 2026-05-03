<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar — EduPlayHub</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{--accent:#2A5FC4;--accent-hover:#1E4FA8;--border:rgba(13,31,60,0.1);--bg:#F4F7FC;--ink:#0D1F3C;--ink-mid:rgba(13,31,60,0.6)}
*{box-sizing:border-box;margin:0;padding:0}
body{background:var(--bg);font-family:'DM Sans',sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
.card{background:white;border-radius:28px;padding:40px;width:100%;max-width:460px;box-shadow:0 20px 64px rgba(13,31,60,0.1);border:1px solid var(--border)}
.logo{display:flex;align-items:center;gap:10px;margin-bottom:24px;text-decoration:none}
.logo-text{font-size:17px;font-weight:700;color:var(--ink);letter-spacing:-0.3px}
h1{font-size:22px;font-weight:700;margin-bottom:4px}
.subtitle{font-size:13px;color:var(--ink-mid);margin-bottom:24px}
.form-group{margin-bottom:14px}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px}
label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;color:var(--ink-mid);margin-bottom:6px}
input,select{width:100%;padding:11px 14px;border-radius:12px;border:1px solid var(--border);background:#F4F7FC;font-family:inherit;font-size:14px;color:var(--ink);transition:0.18s}
input:focus,select:focus{outline:none;border-color:var(--accent);background:white;box-shadow:0 0 0 3px rgba(42,95,196,0.1)}
.error-msg{font-size:12px;color:#dc2626;margin-top:4px}
.role-options{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:16px}
.role-card{border:1.5px solid var(--border);border-radius:14px;padding:14px 12px;cursor:pointer;transition:0.18s;text-align:center}
.role-card:hover{border-color:var(--accent)}
.role-card.active{border-color:var(--accent);background:rgba(42,95,196,0.06)}
.role-icon{font-size:24px;margin-bottom:6px}
.role-name{font-size:13px;font-weight:700}
.role-desc{font-size:11px;color:var(--ink-mid)}
.shop-field{display:none}
.shop-field.show{display:block}
.btn{width:100%;padding:13px;border-radius:14px;border:none;background:var(--accent);color:white;font-family:inherit;font-size:15px;font-weight:600;cursor:pointer;margin-top:4px}
.btn:hover{background:var(--accent-hover)}
.link-row{text-align:center;font-size:13px;color:var(--ink-mid);margin-top:16px}
.link-row a{color:var(--accent);font-weight:600;text-decoration:none}
</style>
</head>
<body>
<div class="card">
  <a href="/" class="logo">
    <svg width="22" height="22" viewBox="0 0 48 48" fill="none"><rect x="8" y="20" width="32" height="14" rx="3" stroke="#0D1F3C" stroke-width="1.7"/><path d="M14 20c0-4 4-7 10-7s10 3 10 7" stroke="#0D1F3C" stroke-width="1.7"/><rect x="18" y="23" width="12" height="4" rx="1.5" stroke="#0D1F3C" stroke-width="1.4"/></svg>
    <span class="logo-text">EduPlayHub</span>
  </a>

  <h1>Buat Akun Baru</h1>
  <p class="subtitle">Bergabung dengan ribuan pengguna EduPlayHub</p>

  <form method="POST" action="{{ route('register') }}" id="regForm">
    @csrf
    <input type="hidden" name="role" id="roleInput" value="buyer">

    <div class="form-group">
      <label>Saya ingin...</label>
      <div class="role-options">
        <div class="role-card active" id="roleBuyer" onclick="setRole('buyer')">
          <div class="role-icon">🛒</div>
          <div class="role-name">Pembeli</div>
          <div class="role-desc">Sewa & beli produk</div>
        </div>
        <div class="role-card" id="roleSeller" onclick="setRole('seller')">
          <div class="role-icon">🏪</div>
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

    <div class="form-group shop-field" id="shopField">
      <label>Nama Toko</label>
      <input type="text" name="shop_name" value="{{ old('shop_name') }}" placeholder="Nama toko Anda">
      @error('shop_name')<div class="error-msg">{{ $message }}</div>@enderror
    </div>

    <button type="submit" class="btn">Daftar Sekarang</button>
  </form>

  <div class="link-row">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></div>
</div>

<script>
function setRole(role) {
  document.getElementById('roleInput').value = role;
  document.getElementById('roleBuyer').classList.toggle('active', role === 'buyer');
  document.getElementById('roleSeller').classList.toggle('active', role === 'seller');
  document.getElementById('shopField').classList.toggle('show', role === 'seller');
}
// Show shop field if validation failed with seller role
@if(old('role') === 'seller') setRole('seller'); @endif
</script>
</body>
</html>
