@extends('layouts.seller')
@section('title', 'Profil Toko')
@section('page-title', 'Profil & Toko')

@push('styles')
<style>
.profile-layout{display:grid;grid-template-columns:1fr 1fr;gap:20px;align-items:start}
.card{background:var(--card-bg);border-radius:20px;padding:28px;border:1px solid var(--card-border);box-shadow:var(--shadow);backdrop-filter:blur(20px)}
.card-title{font-size:15px;font-weight:700;margin-bottom:22px;padding-bottom:14px;border-bottom:1px solid var(--card-border);color:var(--text)}
.form-group{margin-bottom:16px}
.form-label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;color:var(--muted);display:block;margin-bottom:6px}
.frost-input,.frost-select,.frost-textarea{width:100%;padding:11px 14px;border-radius:12px;border:1px solid var(--card-border);background:rgba(255,255,255,0.05);font-size:13px;font-family:inherit;color:var(--text)}
.frost-input:focus,.frost-select:focus,.frost-textarea:focus{outline:none;border-color:var(--indigo);background:rgba(255,255,255,0.08)}
.frost-textarea{resize:vertical;min-height:90px}
.error-msg{font-size:12px;color:#dc2626;margin-top:6px}
.avatar-section{display:flex;align-items:center;gap:16px;margin-bottom:22px;padding-bottom:22px;border-bottom:1px solid var(--card-border)}
.avatar-large{width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:700;flex-shrink:0;overflow:hidden}
.avatar-large img{width:100%;height:100%;object-fit:cover}
.avatar-info{flex:1}
.avatar-name{font-size:18px;font-weight:700;margin-bottom:4px;color:var(--text)}
.avatar-role{font-size:13px;color:var(--muted)}
.submit-btn{display:inline-flex;align-items:center;gap:8px;padding:11px 24px;background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;border:none;border-radius:40px;font-size:13.5px;font-weight:600;cursor:pointer;font-family:inherit;box-shadow:0 8px 24px rgba(79,70,229,0.24)}
.submit-btn:hover{transform:translateY(-2px)}
.stat-row{display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid var(--card-border);font-size:13px}
.stat-row:last-child{border-bottom:none}
.stat-row .label{color:var(--muted)}
.stat-row .value{font-weight:700;color:var(--text)}
.balance-card{background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));border-radius:18px;padding:22px;color:white;margin-bottom:20px;box-shadow:0 12px 30px rgba(79,70,229,0.25)}
.balance-label{font-size:11px;font-weight:600;opacity:0.7;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px}
.balance-value{font-size:28px;font-weight:700;letter-spacing:-0.5px}
.balance-sub{font-size:12px;opacity:0.65;margin-top:4px}
</style>
@endpush

@section('content')
<div class="profile-layout">
  <!-- LEFT: Edit Profile -->
  <div>
    <div class="card">
      <div class="avatar-section">
        <div class="avatar-large">
          @if(auth()->user()->avatar)
          <img src="{{ asset('storage/'.auth()->user()->avatar) }}" alt="">
          @else
          {{ auth()->user()->initials() }}
          @endif
        </div>
        <div class="avatar-info">
          <div class="avatar-name">{{ auth()->user()->name }}</div>
          <div class="avatar-role">{{ $shop->name }}</div>
        </div>
      </div>

      <div class="card-title">Edit Profil & Toko</div>

      <form method="POST" action="{{ route('seller.profile.update') }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="form-group">
          <label class="form-label">Foto Profil</label>
          <input type="file" name="avatar" class="frost-input" accept="image/*">
          @error('avatar')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" name="name" class="frost-input" value="{{ auth()->user()->name }}" required>
          @error('name')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">No. Telepon</label>
          <input type="text" name="phone" class="frost-input" value="{{ auth()->user()->phone }}">
          @error('phone')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Nama Toko</label>
          <input type="text" name="shop_name" class="frost-input" value="{{ $shop->name }}" required>
          @error('shop_name')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Kota Toko</label>
          <input type="text" name="shop_city" class="frost-input" value="{{ $shop->city }}">
          @error('shop_city')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Deskripsi Toko</label>
          <textarea name="shop_desc" class="frost-textarea">{{ $shop->description }}</textarea>
          @error('shop_desc')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="submit-btn">Simpan Perubahan</button>
      </form>
    </div>
  </div>

  <!-- RIGHT: Stats -->
  <div>
    <!-- Balance -->
    <div class="balance-card">
      <div class="balance-label">Saldo Toko</div>
      <div class="balance-value">{{ $shop->fmtBalance() }}</div>
      <div class="balance-sub">Siap dicairkan</div>
    </div>

    <!-- Shop Stats -->
    <div class="card">
      <div class="card-title">Statistik Toko</div>
      <div class="stat-row">
        <span class="label">Rating Toko</span>
        <span class="value">{{ number_format($shop->rating, 1) }}</span>
      </div>
      <div class="stat-row">
        <span class="label">Total Produk</span>
        <span class="value">{{ $shop->products()->count() }}</span>
      </div>
      <div class="stat-row">
        <span class="label">Produk Aktif</span>
        <span class="value">{{ $shop->products()->where('is_active', true)->count() }}</span>
      </div>
      <div class="stat-row">
        <span class="label">Total Transaksi</span>
        <span class="value">{{ $shop->orders()->count() }}</span>
      </div>
      <div class="stat-row">
        <span class="label">Total Pendapatan</span>
        <span class="value">Rp {{ number_format($shop->orders()->where('status','selesai')->sum('total'), 0, ',', '.') }}</span>
      </div>
      <div class="stat-row">
        <span class="label">Member Sejak</span>
        <span class="value">{{ $shop->created_at->format('M Y') }}</span>
      </div>
    </div>
  </div>
</div>
@endsection
