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
  --bg:#F4F7FC;--ink:#0D1F3C;--ink-mid:rgba(13,31,60,0.6);--ink-dim:rgba(13,31,60,0.38);
  --accent:#2A5FC4;--accent-hover:#1E4FA8;--accent-light:rgba(42,95,196,0.08);
  --border:rgba(42,95,196,0.12);--border-soft:rgba(13,31,60,0.08);
  --glass:rgba(255,255,255,0.60);--glass-strong:rgba(255,255,255,0.88);
  --shadow-soft:0 4px 20px rgba(13,31,60,0.06);--shadow:0 8px 32px rgba(13,31,60,0.08);
  --radius:24px;--sidebar-w:240px;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{background:var(--bg);font-family:'DM Sans',system-ui,sans-serif;color:var(--ink);min-height:100vh;display:flex}

/* ─── SIDEBAR ─── */
.sidebar{width:var(--sidebar-w);background:white;border-right:1px solid var(--border-soft);display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh;z-index:50;padding:24px 16px}
.sidebar-logo{display:flex;align-items:center;gap:9px;color:var(--ink);font-weight:700;font-size:15px;letter-spacing:-0.3px;padding:8px 10px;margin-bottom:8px;text-decoration:none}
.sidebar-logo-icon{width:22px;height:22px}
.sidebar-divider{height:1px;background:var(--border-soft);margin:12px 0}
.sidebar-section{font-size:9.5px;font-weight:700;color:var(--ink-dim);text-transform:uppercase;letter-spacing:0.8px;padding:0 10px;margin-bottom:6px}
.nav-item{display:flex;align-items:center;gap:11px;padding:10px 12px;border-radius:12px;font-size:13.5px;font-weight:500;color:var(--ink-mid);text-decoration:none;transition:all 0.18s;margin-bottom:2px}
.nav-item svg{width:16px;height:16px;flex-shrink:0;stroke-width:1.7}
.nav-item:hover{background:var(--accent-light);color:var(--ink)}
.nav-item.active{background:var(--accent);color:white}
.nav-item.active svg{stroke:white}
.sidebar-bottom{margin-top:auto}
.user-panel{display:flex;align-items:center;gap:10px;padding:12px;border-radius:14px;background:var(--bg);margin-top:8px}
.user-av{width:36px;height:36px;border-radius:50%;background:var(--ink);color:white;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0}
.user-name{font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.user-role{font-size:10.5px;color:var(--ink-dim)}

/* ─── MAIN ─── */
.main-content{margin-left:var(--sidebar-w);flex:1;min-height:100vh;display:flex;flex-direction:column}
.topbar{padding:18px 32px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--border-soft);background:white;position:sticky;top:0;z-index:40}
.topbar-title{font-size:18px;font-weight:700;letter-spacing:-0.3px}
.topbar-actions{display:flex;align-items:center;gap:10px}
.page-body{padding:28px 32px;flex:1}
.flash{padding:12px 20px;border-radius:12px;margin-bottom:16px;font-size:13px;font-weight:500}
.flash.success{background:rgba(34,197,94,0.1);color:#16a34a;border:1px solid rgba(34,197,94,0.2)}
.flash.error{background:rgba(239,68,68,0.1);color:#dc2626;border:1px solid rgba(239,68,68,0.2)}
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
    <div class="user-panel">
      <div class="user-av">{{ auth()->user()->initials() }}</div>
      <div style="min-width:0">
        <div class="user-name">{{ auth()->user()->name }}</div>
        <div class="user-role">{{ auth()->user()->shop?->name }}</div>
      </div>
    </div>
    <form method="POST" action="{{ route('logout') }}" style="margin-top:8px">
      @csrf
      <button type="submit" class="nav-item" style="width:100%;background:none;cursor:pointer;border:none;font-family:inherit;color:var(--ink-mid)">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Logout
      </button>
    </form>
  </div>
</aside>

<!-- MAIN -->
<div class="main-content">
  <div class="topbar">
    <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
    <div class="topbar-actions">@yield('topbar-actions')</div>
  </div>

  <div class="page-body">
    @if(session('success'))
    <div class="flash success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="flash error">{{ session('error') }}</div>
    @endif

    @yield('content')
  </div>
</div>

@stack('scripts')
</body>
</html>
