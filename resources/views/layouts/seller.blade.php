<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Dashboard') — EduPlayHub Seller</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet">
<style>
:root{
  --bg:#05050F;--bg2:#0D0D1F;--bg3:#12122A;
  --text:#F0F0FF;--muted:#8B8BAD;--muted-2:rgba(240,240,255,0.62);
  --indigo:#4F46E5;--indigo-light:#818CF8;--indigo-dark:#3730A3;
  --orange:#F97316;--orange-light:#FB923C;--sky:#0EA5E9;--sky-light:#38BDF8;
  --card-bg:rgba(255,255,255,0.04);--card-border:rgba(255,255,255,0.08);
  --accent:var(--indigo);--accent-hover:var(--indigo-dark);--accent-light:rgba(79,70,229,0.16);
  --border:var(--card-border);--border-soft:var(--card-border);
  --glass:rgba(255,255,255,0.04);--glass-strong:rgba(255,255,255,0.08);
  --shadow-soft:0 8px 28px rgba(0,0,0,0.28);--shadow:0 16px 48px rgba(0,0,0,0.35);
  --radius:24px;--sidebar-w:240px;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{background:var(--bg);font-family:'DM Sans',system-ui,sans-serif;color:var(--text);min-height:100vh;display:flex}

/* ─── SIDEBAR ─── */
.sidebar{width:var(--sidebar-w);background:rgba(13,13,31,0.92);border-right:1px solid var(--card-border);display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh;z-index:50;padding:24px 16px;backdrop-filter:blur(20px)}
.sidebar-logo{display:flex;align-items:center;gap:9px;color:var(--text);font-weight:700;font-size:15px;letter-spacing:-0.3px;padding:8px 10px;margin-bottom:8px;text-decoration:none;font-family:'Syne',sans-serif;background:linear-gradient(135deg,var(--indigo-light),var(--orange-light));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.sidebar-logo-icon{width:22px;height:22px}
.sidebar-divider{height:1px;background:var(--border-soft);margin:12px 0}
.sidebar-section{font-size:9.5px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:0.8px;padding:0 10px;margin-bottom:6px}
.nav-item{display:flex;align-items:center;gap:11px;padding:10px 12px;border-radius:12px;font-size:13.5px;font-weight:500;color:var(--muted);text-decoration:none;transition:all 0.18s;margin-bottom:2px}
.nav-item svg{width:16px;height:16px;flex-shrink:0;stroke-width:1.7}
.nav-item:hover{background:rgba(79,70,229,0.14);color:var(--text)}
.nav-item.active{background:var(--accent);color:white}
.nav-item.active svg{stroke:white}
.sidebar-bottom{margin-top:auto}
.user-panel{display:flex;align-items:center;gap:10px;padding:12px;border-radius:14px;background:var(--card-bg);margin-top:8px;border:1px solid var(--card-border)}
.user-av{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0}
.user-av img{width:100%;height:100%;object-fit:cover}
.user-name{font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.user-role{font-size:10.5px;color:var(--muted)}
.profile-menu{position:relative}
.profile-trigger{list-style:none}
.profile-trigger::-webkit-details-marker{display:none}
.profile-trigger::marker{display:none}
.profile-dropdown{position:absolute;right:0;top:-6px;transform:translateY(-100%);min-width:190px;background:rgba(13,13,31,0.96);border-radius:14px;border:1px solid var(--card-border);box-shadow:var(--shadow);padding:10px;display:flex;flex-direction:column;gap:6px;z-index:10;backdrop-filter:blur(20px)}
.profile-dropdown a,.profile-dropdown button{display:flex;align-items:center;gap:8px;padding:8px 10px;border-radius:10px;text-decoration:none;color:var(--text);font-size:13px;font-weight:600;border:none;background:transparent;cursor:pointer;font-family:inherit}
.profile-dropdown a:hover,.profile-dropdown button:hover{background:rgba(79,70,229,0.16);color:var(--indigo-light)}
.profile-meta{padding:8px 10px;border-radius:10px;background:var(--card-bg);border:1px solid var(--card-border);font-size:12px;color:var(--muted)}
.profile-name{font-weight:700;color:var(--text);font-size:13px}

/* ─── TOAST ─── */
.toast-container{position:fixed;top:20px;right:20px;display:flex;flex-direction:column;gap:10px;z-index:200}
.toast{min-width:240px;max-width:360px;background:rgba(13,13,31,0.96);border:1px solid var(--card-border);border-left:4px solid var(--accent);border-radius:14px;padding:12px 14px;box-shadow:var(--shadow);display:flex;align-items:flex-start;justify-content:space-between;gap:12px;animation:toast-in 0.25s ease;backdrop-filter:blur(20px)}
.toast.toast-success{border-left-color:#16a34a}
.toast.toast-error{border-left-color:#dc2626}
.toast-title{font-size:13px;font-weight:700;margin-bottom:4px;color:var(--text)}
.toast-text{font-size:12.5px;color:var(--muted);line-height:1.5}
.toast-close{border:none;background:transparent;color:var(--muted);cursor:pointer;font-size:14px;line-height:1}
.toast-close:hover{color:var(--text)}
.toast.is-hidden{animation:toast-out 0.2s ease forwards}
@keyframes toast-in{from{transform:translateY(-8px);opacity:0}to{transform:translateY(0);opacity:1}}
@keyframes toast-out{to{transform:translateY(-6px);opacity:0}}

/* ─── MAIN ─── */
.main-content{margin-left:var(--sidebar-w);flex:1;min-height:100vh;display:flex;flex-direction:column}
.topbar{padding:18px 32px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--card-border);background:rgba(13,13,31,0.88);position:sticky;top:0;z-index:40;backdrop-filter:blur(20px)}
.topbar-title{font-size:18px;font-weight:700;letter-spacing:-0.3px}
.topbar-actions{display:flex;align-items:center;gap:10px}
.page-body{padding:28px 32px;flex:1}
.flash{padding:12px 20px;border-radius:12px;margin-bottom:16px;font-size:13px;font-weight:500}
.flash.success{background:rgba(34,197,94,0.1);color:#4ade80;border:1px solid rgba(34,197,94,0.2)}
.flash.error{background:rgba(239,68,68,0.1);color:#fca5a5;border:1px solid rgba(239,68,68,0.2)}
.btn{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:40px;font-size:13px;font-weight:600;border:none;cursor:pointer;font-family:inherit;text-decoration:none;transition:0.18s}
.btn-primary{background:var(--accent);color:white;box-shadow:0 4px 14px rgba(42,95,196,0.28)}
.btn-primary:hover{background:var(--accent-hover)}
.btn-secondary{background:white;color:var(--ink);border:1px solid var(--border-soft)}
.btn-secondary:hover{border-color:var(--accent);color:var(--accent)}
.btn-danger{background:rgba(239,68,68,0.1);color:#dc2626;border:1px solid rgba(239,68,68,0.2)}
.btn-danger:hover{background:rgba(239,68,68,0.2)}
@yield('extra-css')
</style>
@stack('styles')
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <a href="{{ route('seller.dashboard') }}" class="sidebar-logo">
    <svg class="sidebar-logo-icon" viewBox="0 0 48 48" fill="none"><rect x="8" y="20" width="32" height="14" rx="3" stroke="currentColor" stroke-width="1.7"/><path d="M14 20c0-4 4-7 10-7s10 3 10 7" stroke="currentColor" stroke-width="1.7"/><rect x="18" y="23" width="12" height="4" rx="1.5" stroke="currentColor" stroke-width="1.4"/><path d="M24 10l6 3-6 3-6-3 6-3z" fill="currentColor"/></svg>
    EduPlayHub
  </a>

  <div class="sidebar-divider"></div>
  <div class="sidebar-section">Menu Utama</div>

  <a href="{{ route('seller.dashboard') }}" class="nav-item {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
    Dashboard
  </a>
  <a href="{{ route('seller.products') }}" class="nav-item {{ request()->routeIs('seller.products*') ? 'active' : '' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
    Produk Saya
  </a>
  <a href="{{ route('seller.orders') }}" class="nav-item {{ request()->routeIs('seller.orders*') ? 'active' : '' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h4"/></svg>
    Pesanan
  </a>
  <a href="{{ route('seller.chat') }}" class="nav-item {{ request()->routeIs('seller.chat*') ? 'active' : '' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15a4 4 0 01-4 4H7l-4 3V7a4 4 0 014-4h10a4 4 0 014 4z"/></svg>
    Pesan
  </a>

  <div class="sidebar-divider"></div>
  <div class="sidebar-section">Akun</div>

  <a href="{{ route('seller.profile') }}" class="nav-item {{ request()->routeIs('seller.profile*') ? 'active' : '' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
    Profil Toko
  </a>
  <a href="{{ route('catalog') }}" class="nav-item">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
    Lihat Katalog
  </a>

  <div class="sidebar-bottom">
    <details class="profile-menu">
      <summary class="user-panel profile-trigger">
        <div class="user-av">
          @if(auth()->user()->avatar)
          <img src="{{ asset('storage/'.auth()->user()->avatar) }}" alt="">
          @else
          {{ auth()->user()->initials() }}
          @endif
        </div>
        <div style="min-width:0">
          <div class="user-name">{{ auth()->user()->name }}</div>
          <div class="user-role">{{ auth()->user()->shop?->name }}</div>
        </div>
      </summary>
      <div class="profile-dropdown">
        <div class="profile-meta">
          <div class="profile-name">{{ auth()->user()->name }}</div>
          {{ auth()->user()->email }}
        </div>
        <a href="{{ route('seller.profile') }}">
          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
          Profil Toko
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Logout
          </button>
        </form>
      </div>
    </details>
  </div>
</aside>

<!-- MAIN -->
<div class="main-content">
  <div class="topbar">
    <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
    <div class="topbar-actions">@yield('topbar-actions')</div>
  </div>

  <div class="page-body">
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

    @yield('content')
  </div>
</div>

@stack('scripts')
<script>
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
