@extends('layouts.buyer')
@section('title', 'Profil Saya')

@push('styles')
<style>
.profile-wrap{max-width:1080px;margin:26px auto 40px;padding:0 36px;display:grid;grid-template-columns:1.1fr 0.9fr;gap:22px}
.profile-card{background:white;border-radius:20px;padding:28px;border:1px solid var(--border-soft);box-shadow:var(--shadow-soft)}
.profile-title{font-size:18px;font-weight:700;margin-bottom:18px}
.profile-subtitle{font-size:12.5px;color:var(--ink-mid);margin:-8px 0 16px}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.form-group{display:flex;flex-direction:column;gap:6px;margin-bottom:14px}
.form-label{font-size:11px;text-transform:uppercase;letter-spacing:0.08em;color:var(--ink-dim);font-weight:700}
.form-input,.form-textarea{border:1px solid var(--border-soft);border-radius:12px;padding:11px 14px;font-family:inherit;font-size:13px;color:var(--ink);background:var(--bg)}
.form-input:focus,.form-textarea:focus{outline:none;border-color:var(--accent);background:white}
.form-textarea{min-height:90px;resize:vertical}
.error-msg{font-size:12px;color:#dc2626}
.input-wrap{position:relative;display:flex;align-items:center}
.input-wrap .form-input{padding-right:44px}
.toggle-btn{position:absolute;right:8px;background:var(--glass);border:1px solid var(--border);color:var(--ink-mid);border-radius:10px;padding:6px 8px;font-size:11px;font-weight:700;cursor:pointer}
.toggle-btn:hover{color:var(--ink)}
.strength{margin-top:8px}
.strength-bar{height:6px;background:rgba(13,31,60,0.08);border-radius:999px;overflow:hidden}
.strength-bar span{display:block;height:100%;width:0%;background:#dc2626;transition:width 0.2s ease,background 0.2s ease}
.strength-text{font-size:11px;color:var(--ink-mid);margin-top:6px}
.avatar-row{display:flex;align-items:center;gap:16px;margin-bottom:18px}
.avatar{width:72px;height:72px;border-radius:50%;background:var(--ink);color:white;display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:700;overflow:hidden}
.avatar img{width:100%;height:100%;object-fit:cover}
.avatar-meta{flex:1}
.avatar-name{font-weight:700;font-size:16px}
.avatar-sub{color:var(--ink-mid);font-size:13px;margin-top:4px}
.primary-btn{display:inline-flex;align-items:center;gap:8px;background:var(--accent);color:white;border:none;border-radius:999px;padding:11px 22px;font-size:13.5px;font-weight:600;cursor:pointer}
.primary-btn:hover{background:var(--accent-hover)}
.note-card{background:linear-gradient(135deg,#0D1F3C,#214A95);color:white;border-radius:18px;padding:22px}
.note-title{font-weight:700;font-size:14px;margin-bottom:6px}
.note-text{font-size:13px;opacity:0.8;line-height:1.5}
.stat-list{margin-top:16px;display:grid;gap:10px}
.stat-row{display:flex;justify-content:space-between;font-size:13px;padding:10px 0;border-bottom:1px solid rgba(255,255,255,0.18)}
.stat-row:last-child{border-bottom:none}
.section-divider{height:1px;background:var(--border-soft);margin:18px 0}
@media (max-width: 900px){
  .profile-wrap{grid-template-columns:1fr}
}
</style>
@endpush

@section('content')
<div class="profile-wrap">
  <div class="profile-card">
    <div class="avatar-row">
      <div class="avatar">
        @if($user->avatar)
        <img src="{{ asset('storage/'.$user->avatar) }}" alt="">
        @else
        {{ $user->initials() }}
        @endif
      </div>
      <div class="avatar-meta">
        <div class="avatar-name">{{ $user->name }}</div>
        <div class="avatar-sub">Akun Pembeli</div>
      </div>
    </div>

    <div class="profile-title">Perbarui Profil</div>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label class="form-label">Foto Profil</label>
        <input type="file" name="avatar" class="form-input" accept="image/*">
        @error('avatar')<div class="error-msg">{{ $message }}</div>@enderror
      </div>

      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
          @error('name')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Nomor Telepon</label>
          <input type="text" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}">
          @error('phone')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Alamat</label>
        <textarea name="address" class="form-textarea">{{ old('address', $user->address) }}</textarea>
        @error('address')<div class="error-msg">{{ $message }}</div>@enderror
      </div>

      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">Kota</label>
          <input type="text" name="city" class="form-input" value="{{ old('city', $user->city) }}">
          @error('city')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Provinsi</label>
          <input type="text" name="province" class="form-input" value="{{ old('province', $user->province) }}">
          @error('province')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Kode Pos</label>
        <input type="text" name="postal_code" class="form-input" value="{{ old('postal_code', $user->postal_code) }}">
        @error('postal_code')<div class="error-msg">{{ $message }}</div>@enderror
      </div>

      <button type="submit" class="primary-btn">Simpan Perubahan</button>
    </form>
  </div>

  <div>
    <div class="profile-card" style="margin-bottom:18px">
      <div class="profile-title">Ubah Password</div>
      <div class="profile-subtitle">Gunakan minimal 8 karakter dan jangan bagikan ke siapapun.</div>
      <form method="POST" action="{{ route('profile.password') }}">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label class="form-label">Password Saat Ini</label>
          <div class="input-wrap">
            <input type="password" name="current_password" id="currentPassword" class="form-input" required>
            <button type="button" class="toggle-btn" data-toggle="#currentPassword">Tampilkan</button>
          </div>
          @error('current_password')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Password Baru</label>
          <div class="input-wrap">
            <input type="password" name="password" id="newPassword" class="form-input" required data-strength>
            <button type="button" class="toggle-btn" data-toggle="#newPassword">Tampilkan</button>
          </div>
          <div class="strength" data-strength-meter>
            <div class="strength-bar"><span></span></div>
            <div class="strength-text">Kekuatan password</div>
          </div>
          @error('password')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Konfirmasi Password Baru</label>
          <div class="input-wrap">
            <input type="password" name="password_confirmation" id="confirmPassword" class="form-input" required>
            <button type="button" class="toggle-btn" data-toggle="#confirmPassword">Tampilkan</button>
          </div>
        </div>

        <button type="submit" class="primary-btn">Perbarui Password</button>
      </form>
    </div>

    <div class="note-card">
      <div class="note-title">Ringkasan Akun</div>
      <div class="note-text">Data profil membantu kami menyiapkan rekomendasi produk, pengiriman, dan komunikasi yang lebih tepat.</div>

      <div class="stat-list">
        <div class="stat-row">
          <span>Email</span>
          <span>{{ $user->email }}</span>
        </div>
        <div class="stat-row">
          <span>Kota</span>
          <span>{{ $user->city ?? '-' }}</span>
        </div>
        <div class="stat-row">
          <span>Bergabung</span>
          <span>{{ $user->created_at->format('d M Y') }}</span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
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
</script>
@endpush
