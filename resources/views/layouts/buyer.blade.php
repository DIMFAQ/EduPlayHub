<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'EduPlayHub') — EduPlayHub</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet">
<style>
:root {
  --bg: #F4F7FC; --ink: #0D1F3C; --ink-mid: rgba(13,31,60,0.6);
  --ink-dim: rgba(13,31,60,0.38); --accent: #2A5FC4; --accent-hover: #1E4FA8;
  --accent-light: rgba(42,95,196,0.08); --border: rgba(42,95,196,0.12);
  --border-soft: rgba(13,31,60,0.08); --glass: rgba(255,255,255,0.60);
  --glass-strong: rgba(255,255,255,0.88); --shadow-soft: 0 4px 20px rgba(13,31,60,0.06);
  --shadow: 0 8px 32px rgba(13,31,60,0.08); --radius: 24px;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{background:var(--bg);font-family:'DM Sans',system-ui,sans-serif;color:var(--ink);min-height:100vh}

/* ─── HEADER ─── */
.edu-header{padding:20px 36px;position:sticky;top:0;z-index:100}
.header-container{position:relative;display:flex;align-items:center;justify-content:space-between;padding:12px 24px;border-radius:18px;background:rgba(255,255,255,0.66);backdrop-filter:blur(24px) saturate(180%);border:1px solid var(--border);box-shadow:0 8px 32px rgba(13,31,60,0.07),0 1px 0 rgba(255,255,255,0.9) inset}
.logo{display:flex;align-items:center;gap:9px;color:var(--ink);font-weight:600;font-size:14.5px;letter-spacing:-0.3px;text-decoration:none}
.logo-icon{width:20px;height:20px}
.nav-center{position:absolute;left:50%;transform:translateX(-50%);display:flex;gap:4px;background:rgba(255,255,255,0.5);padding:4px;border-radius:40px;border:1px solid var(--border)}
.nav-link{font-size:13px;text-decoration:none;color:var(--ink-mid);padding:6px 18px;border-radius:40px;transition:all 0.2s;font-weight:500}
.nav-link:hover{color:var(--ink);background:rgba(255,255,255,0.8)}
.nav-link.active{color:var(--ink);background:white;box-shadow:0 2px 8px rgba(13,31,60,0.08)}
.nav-icons{display:flex;gap:8px;align-items:center}
.icon-btn{width:34px;height:34px;border-radius:50%;border:1px solid var(--border);background:rgba(255,255,255,0.82);display:flex;align-items:center;justify-content:center;color:var(--ink);transition:all 0.2s;cursor:pointer;text-decoration:none;position:relative}
.icon-btn svg{width:14px;height:14px;stroke-width:1.7}
.icon-btn:hover{color:var(--accent);background:white;border-color:var(--accent);transform:scale(1.05)}
.cart-badge{position:absolute;top:-4px;right:-4px;width:16px;height:16px;background:var(--accent);color:white;border-radius:50%;font-size:9px;font-weight:700;display:flex;align-items:center;justify-content:center;border:1.5px solid white}
.profile-btn{width:34px;height:34px;border-radius:50%;background:var(--ink);color:white;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;letter-spacing:0.5px;cursor:pointer;transition:0.2s;text-decoration:none}
.profile-btn:hover{background:var(--accent)}

/* ─── FLASH ─── */
.flash{padding:12px 20px;border-radius:12px;margin:0 36px 12px;font-size:13px;font-weight:500}
.flash.success{background:rgba(34,197,94,0.1);color:#16a34a;border:1px solid rgba(34,197,94,0.2)}
.flash.error{background:rgba(239,68,68,0.1);color:#dc2626;border:1px solid rgba(239,68,68,0.2)}

@yield('extra-css')
</style>
@stack('styles')
</head>
<body>

<header class="edu-header">
  <div class="header-container">
    <a href="{{ route('catalog') }}" class="logo">
      <svg class="logo-icon" viewBox="0 0 48 48" fill="none">
        <rect x="8" y="20" width="32" height="14" rx="3" stroke="currentColor" stroke-width="1.7"/>
        <path d="M14 20c0-4 4-7 10-7s10 3 10 7" stroke="currentColor" stroke-width="1.7"/>
        <rect x="18" y="23" width="12" height="4" rx="1.5" stroke="currentColor" stroke-width="1.4"/>
        <path d="M24 10l6 3-6 3-6-3 6-3z" fill="currentColor"/>
      </svg>
      EduPlayHub
    </a>

    <nav class="nav-center">
      <a href="{{ route('catalog') }}" class="nav-link {{ request()->routeIs('catalog') ? 'active' : '' }}">Katalog</a>
      @auth
      <a href="{{ route('cart.index') }}" class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}">Keranjang</a>
      <a href="{{ route('chat.buyer') }}" class="nav-link {{ request()->routeIs('chat.*') ? 'active' : '' }}">Chat</a>
      @endauth
    </nav>

    <div class="nav-icons">
      @auth
      <a href="{{ route('cart.index') }}" class="icon-btn" title="Keranjang">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
        @if(($cartCount ?? 0) > 0)
        <span class="cart-badge">{{ $cartCount ?? 0 }}</span>
        @endif
      </a>
      <a href="{{ route('chat.buyer') }}" class="icon-btn" title="Chat">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15a4 4 0 01-4 4H7l-4 3V7a4 4 0 014-4h10a4 4 0 014 4z"/></svg>
      </a>
      @if(auth()->user()->isSeller())
      <a href="{{ route('seller.dashboard') }}" class="icon-btn" title="Dashboard Penjual">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
      </a>
      @endif
      <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button type="submit" class="profile-btn" title="Logout ({{ auth()->user()->name }})">{{ auth()->user()->initials() }}</button>
      </form>
      @else
      <a href="{{ route('login') }}" class="icon-btn" title="Login">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
      </a>
      @endauth
    </div>
  </div>
</header>

@if(session('success'))
<div class="flash success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="flash error">{{ session('error') }}</div>
@endif

@yield('content')

@stack('scripts')
</body>
</html>
