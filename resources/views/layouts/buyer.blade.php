<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'EduPlayHub') — EduPlayHub</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
<style>
:root {
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
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{background:var(--bg);font-family:'DM Sans',system-ui,sans-serif;color:var(--text);min-height:100vh;overflow-x:hidden}
html{scroll-behavior:smooth}

/* ── NOISE OVERLAY ── */
body::before {
  content: '';
  position: fixed; inset: 0; z-index: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
  pointer-events: none;
  opacity: 0.5;
}

/* ─── HEADER ─── */
.edu-header{padding:20px 36px;position:sticky;top:0;z-index:100;background:rgba(5,5,15,0.7);backdrop-filter:blur(20px)}
.header-container{position:relative;display:flex;align-items:center;justify-content:space-between;padding:12px 24px;border-radius:18px;background:rgba(13,13,31,0.6);backdrop-filter:blur(16px) saturate(150%);border:1px solid var(--card-border);box-shadow:0 8px 32px rgba(0,0,0,0.3)}
.logo{display:flex;align-items:center;gap:9px;font-weight:700;font-size:15px;letter-spacing:-0.3px;text-decoration:none;font-family:'Syne',sans-serif;background:linear-gradient(135deg,var(--indigo-light),var(--orange-light));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.logo-icon{width:20px;height:20px;color:var(--indigo-light)}
.nav-center{position:absolute;left:50%;transform:translateX(-50%);display:flex;gap:4px;background:rgba(255,255,255,0.06);padding:4px;border-radius:40px;border:1px solid var(--card-border);backdrop-filter:blur(10px)}
.nav-link{font-size:13px;text-decoration:none;color:var(--muted);padding:6px 18px;border-radius:40px;transition:all 0.2s;font-weight:500;cursor:pointer}
.nav-icons{display:flex;gap:8px;align-items:center;position:relative;z-index:1}
.icon-btn{width:34px;height:34px;border-radius:50%;border:1px solid var(--card-border);background:rgba(255,255,255,0.06);display:flex;align-items:center;justify-content:center;color:var(--muted);transition:all 0.2s;cursor:pointer;text-decoration:none;position:relative;backdrop-filter:blur(10px)}
.icon-btn svg{width:14px;height:14px;stroke-width:1.7}
.icon-btn:hover{color:var(--indigo-light);background:rgba(129,140,248,0.15);border-color:rgba(129,140,248,0.35);transform:scale(1.05)}
.cart-badge{position:absolute;top:-4px;right:-4px;width:16px;height:16px;background:var(--orange);color:white;border-radius:50%;font-size:9px;font-weight:700;display:flex;align-items:center;justify-content:center;border:1.5px solid var(--bg)}
.profile-btn{width:34px;height:34px;border-radius:50%;background:rgba(79,70,229,0.25);color:white;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;letter-spacing:0.5px;cursor:pointer;transition:0.2s;text-decoration:none;border:1px solid rgba(129,140,248,0.3)}
.profile-btn:hover{background:rgba(79,70,229,0.4)}
.profile-menu{position:relative}
.profile-trigger{list-style:none;cursor:pointer}
.profile-trigger::-webkit-details-marker{display:none}
.profile-trigger::marker{display:none}
.profile-avatar{width:100%;height:100%;border-radius:50%;overflow:hidden;display:flex;align-items:center;justify-content:center}
.profile-avatar img{width:100%;height:100%;object-fit:cover}
.profile-dropdown{position:absolute;right:0;top:44px;min-width:200px;background:rgba(13,13,31,0.95);border-radius:16px;border:1px solid var(--card-border);box-shadow:0 8px 32px rgba(0,0,0,0.4);padding:10px;display:flex;flex-direction:column;gap:6px;z-index:50;backdrop-filter:blur(20px)}
.profile-dropdown a,.profile-dropdown button{display:flex;align-items:center;gap:8px;padding:8px 10px;border-radius:10px;text-decoration:none;color:var(--text);font-size:13px;font-weight:600;border:none;background:transparent;cursor:pointer;font-family:inherit;transition:all 0.2s}
.profile-dropdown a:hover,.profile-dropdown button:hover{background:rgba(79,70,229,0.2);color:var(--indigo-light)}
.profile-meta{padding:8px 10px;border-radius:10px;background:rgba(255,255,255,0.04);border:1px solid var(--card-border);font-size:12px;color:var(--muted)}
.profile-name{font-weight:700;color:var(--text);font-size:13px}

/* ─── TOAST ─── */
.toast-container{position:fixed;top:20px;right:20px;display:flex;flex-direction:column;gap:10px;z-index:200}
.toast{min-width:240px;max-width:360px;background:rgba(13,13,31,0.95);border:1px solid var(--card-border);border-left:4px solid var(--indigo-light);border-radius:14px;padding:12px 14px;box-shadow:0 8px 32px rgba(0,0,0,0.4);display:flex;align-items:flex-start;justify-content:space-between;gap:12px;animation:toast-in 0.25s ease;backdrop-filter:blur(20px)}
.toast.toast-success{border-left-color:#10B981}
.toast.toast-error{border-left-color:#EF4444}
.toast-title{font-size:13px;font-weight:700;margin-bottom:4px;color:var(--text)}
.toast-text{font-size:12.5px;color:var(--muted);line-height:1.5}
.toast-close{border:none;background:transparent;color:var(--muted);cursor:pointer;font-size:14px;line-height:1;transition:color 0.2s}
.toast-close:hover{color:var(--text)}
.toast.is-hidden{animation:toast-out 0.2s ease forwards}
@keyframes toast-in{from{transform:translateY(-8px);opacity:0}to{transform:translateY(0);opacity:1}}
@keyframes toast-out{to{transform:translateY(-6px);opacity:0}}

/* ─── FLASH ─── */
.flash{padding:12px 20px;border-radius:12px;margin:0 36px 12px;font-size:13px;font-weight:500;border:1px solid var(--card-border)}
.flash.success{background:rgba(16,185,129,0.1);color:#10B981}
.flash.error{background:rgba(239,68,68,0.1);color:#EF4444}

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
      <a href="{{ route('orders.buyer') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">Pesanan</a>
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
      <details class="profile-menu">
        <summary class="profile-btn profile-trigger" title="Akun">
          <span class="profile-avatar">
            @if(auth()->user()->avatar)
            <img src="{{ asset('storage/'.auth()->user()->avatar) }}" alt="">
            @else
            {{ auth()->user()->initials() }}
            @endif
          </span>
        </summary>
        <div class="profile-dropdown">
          <div class="profile-meta">
            <div class="profile-name">{{ auth()->user()->name }}</div>
            {{ auth()->user()->email }}
          </div>
          <a href="{{ route('profile') }}">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            Profil Saya
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
      @else
      <a href="{{ route('login') }}" class="icon-btn" title="Login">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
      </a>
      @endauth
    </div>
  </div>
</header>

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
