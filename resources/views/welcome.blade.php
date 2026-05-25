<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EduPlay — Sewa & Beli Alat Kuliah + Hiburan</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

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

  html { scroll-behavior: smooth; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    color: var(--text);
    overflow-x: hidden;
    cursor: none;
  }

  /* ── CUSTOM CURSOR ── */
  #cursor {
    position: fixed; top: 0; left: 0; z-index: 9999;
    width: 12px; height: 12px;
    background: var(--indigo-light);
    border-radius: 50%;
    pointer-events: none;
    transition: transform 0.15s ease, background 0.2s;
    transform: translate(-50%, -50%);
  }
  #cursor-ring {
    position: fixed; top: 0; left: 0; z-index: 9998;
    width: 36px; height: 36px;
    border: 1.5px solid rgba(129,140,248,0.5);
    border-radius: 50%;
    pointer-events: none;
    transition: transform 0.4s cubic-bezier(.17,.67,.47,1.3), width 0.3s, height 0.3s, border-color 0.3s;
    transform: translate(-50%, -50%);
  }
  body:has(a:hover) #cursor-ring,
  body:has(button:hover) #cursor-ring { width: 52px; height: 52px; border-color: var(--orange); }

  /* ── NOISE OVERLAY ── */
  body::before {
    content: '';
    position: fixed; inset: 0; z-index: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
    pointer-events: none;
    opacity: 0.5;
  }

  /* ── BACKGROUND ORBS ── */
  .orb {
    position: fixed; border-radius: 50%; filter: blur(80px);
    pointer-events: none; z-index: 0; animation: orb-drift 20s ease-in-out infinite alternate;
  }
  .orb-1 { width: 600px; height: 600px; background: radial-gradient(circle, rgba(79,70,229,0.25) 0%, transparent 70%); top: -200px; left: -200px; animation-delay: 0s; }
  .orb-2 { width: 500px; height: 500px; background: radial-gradient(circle, rgba(249,115,22,0.15) 0%, transparent 70%); top: 200px; right: -150px; animation-delay: -7s; }
  .orb-3 { width: 400px; height: 400px; background: radial-gradient(circle, rgba(14,165,233,0.12) 0%, transparent 70%); bottom: 100px; left: 200px; animation-delay: -14s; }

  @keyframes orb-drift {
    0% { transform: translate(0, 0) scale(1); }
    100% { transform: translate(40px, 30px) scale(1.08); }
  }

  /* ── NAV ── */
  nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 100;
    padding: 1.2rem 2.5rem;
    display: flex; align-items: center; justify-content: space-between;
    background: rgba(5,5,15,0.7);
    backdrop-filter: blur(20px);
    border-bottom: 1px solid var(--card-border);
  }
  .nav-logo {
    font-family: 'Syne', sans-serif;
    font-size: 1.5rem; font-weight: 800;
    background: linear-gradient(135deg, var(--indigo-light), var(--orange-light));
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    letter-spacing: -0.02em;
  }
  .nav-logo span { -webkit-text-fill-color: var(--orange-light); }
  .nav-links { display: flex; align-items: center; gap: 2rem; }
  .nav-links a {
    color: var(--muted); text-decoration: none; font-size: 0.9rem;
    transition: color 0.2s; cursor: none;
  }
  .nav-links a:hover { color: var(--text); }
  .nav-cta {
    background: var(--indigo);
    color: white !important;
    padding: 0.5rem 1.2rem;
    border-radius: 100px;
    font-weight: 500;
    transition: background 0.2s, transform 0.2s !important;
  }
  .nav-cta:hover { background: var(--indigo-dark); transform: scale(1.04) !important; }

  /* ── HERO ── */
  .hero {
    position: relative; z-index: 1;
    min-height: 100vh;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    padding: 8rem 2rem 4rem;
    text-align: center;
    overflow: hidden;
  }

  .hero-badge {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: rgba(79,70,229,0.15);
    border: 1px solid rgba(79,70,229,0.35);
    padding: 0.4rem 1rem;
    border-radius: 100px;
    font-size: 0.8rem; color: var(--indigo-light);
    margin-bottom: 1.5rem;
    animation: fade-up 0.6s ease both;
  }
  .hero-badge::before { content: ''; width: 6px; height: 6px; background: var(--indigo-light); border-radius: 50%; animation: pulse 2s infinite; }

  @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.5;transform:scale(0.8)} }

  .hero-title {
    font-family: 'Syne', sans-serif;
    font-size: clamp(3rem, 8vw, 6.5rem);
    font-weight: 800;
    line-height: 1.0;
    letter-spacing: -0.04em;
    margin-bottom: 1.5rem;
    animation: fade-up 0.7s ease 0.1s both;
  }
  .hero-title .line1 { display: block; color: var(--text); }
  .hero-title .line2 {
    display: block;
    background: linear-gradient(135deg, var(--indigo-light) 0%, var(--sky-light) 40%, var(--orange-light) 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-size: 200% 200%;
    animation: fade-up 0.7s ease 0.1s both, grad-shift 6s ease infinite alternate;
  }
  @keyframes grad-shift { 0%{background-position:0% 50%} 100%{background-position:100% 50%} }

  .hero-sub {
    max-width: 540px;
    font-size: 1.1rem; line-height: 1.7;
    color: var(--muted);
    margin-bottom: 2.5rem;
    animation: fade-up 0.7s ease 0.2s both;
  }

  .hero-actions {
    display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;
    margin-bottom: 4rem;
    animation: fade-up 0.7s ease 0.3s both;
  }
  .btn-primary {
    padding: 0.8rem 2rem;
    background: linear-gradient(135deg, var(--indigo), var(--indigo-dark));
    color: white; border: none; border-radius: 100px;
    font-family: 'DM Sans', sans-serif; font-size: 1rem; font-weight: 500;
    cursor: none; text-decoration: none;
    transition: transform 0.2s, box-shadow 0.2s;
    box-shadow: 0 4px 24px rgba(79,70,229,0.35);
  }
  .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 32px rgba(79,70,229,0.5); }
  .btn-outline {
    padding: 0.8rem 2rem;
    background: transparent;
    color: var(--text); border: 1px solid var(--card-border); border-radius: 100px;
    font-family: 'DM Sans', sans-serif; font-size: 1rem; font-weight: 500;
    cursor: none; text-decoration: none;
    transition: border-color 0.2s, background 0.2s;
  }
  .btn-outline:hover { border-color: rgba(255,255,255,0.25); background: rgba(255,255,255,0.05); }

  @keyframes fade-up { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }

  /* ── STATS STRIP ── */
  .stats-strip {
    display: flex; gap: 3rem; justify-content: center; flex-wrap: wrap;
    padding: 1.5rem 2rem;
    border-top: 1px solid var(--card-border);
    border-bottom: 1px solid var(--card-border);
    margin-bottom: 5rem;
    animation: fade-up 0.7s ease 0.4s both;
  }
  .stat { text-align: center; }
  .stat-num {
    font-family: 'Syne', sans-serif; font-size: 2rem; font-weight: 800;
    background: linear-gradient(135deg, var(--text), var(--muted));
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  }
  .stat-label { font-size: 0.8rem; color: var(--muted); margin-top: 2px; }

  /* ── 3D PRODUCT CARDS MARQUEE ── */
  .marquee-section {
    position: relative; z-index: 1;
    overflow: hidden;
    padding: 0 0 2rem;
    margin-bottom: 6rem;
  }
  .marquee-label {
    text-align: center;
    font-size: 0.75rem; letter-spacing: 0.15em; text-transform: uppercase;
    color: var(--muted); margin-bottom: 2rem;
  }
  .marquee-track {
    display: flex; gap: 1.5rem;
    width: max-content;
    animation: marquee-scroll 40s linear infinite;
  }
  .marquee-track:hover { animation-play-state: paused; }
  .marquee-row { display: flex; gap: 1.5rem; }
  .marquee-row2 { animation: marquee-scroll-rev 35s linear infinite; margin-top: 1.5rem; }
  .marquee-row2:hover { animation-play-state: paused; }

  @keyframes marquee-scroll { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }
  @keyframes marquee-scroll-rev { 0%{transform:translateX(-50%)} 100%{transform:translateX(0)} }

  .prod-card {
    position: relative;
    width: 220px; min-width: 220px;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid var(--card-border);
    background: var(--card-bg);
    backdrop-filter: blur(10px);
    cursor: none;
    transition: transform 0.4s cubic-bezier(.23,1,.32,1), border-color 0.3s;
    transform-style: preserve-3d;
  }
  .prod-card:hover { border-color: rgba(129,140,248,0.35); transform: scale(1.04) translateY(-4px); }
  .prod-card img {
    width: 100%; height: 140px;
    object-fit: cover; display: block;
    filter: brightness(0.85) saturate(1.1);
    transition: filter 0.3s, transform 0.5s;
  }
  .prod-card:hover img { filter: brightness(1) saturate(1.2); transform: scale(1.06); }
  .prod-card-body { padding: 1rem; }
  .prod-card-tag {
    font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em;
    padding: 2px 8px; border-radius: 100px;
    display: inline-block; margin-bottom: 0.5rem;
  }
  .tag-edu { background: rgba(14,165,233,0.15); color: var(--sky-light); }
  .tag-play { background: rgba(249,115,22,0.15); color: var(--orange-light); }
  .prod-card-name {
    font-family: 'Syne', sans-serif; font-size: 0.9rem; font-weight: 700;
    color: var(--text); margin-bottom: 0.5rem; line-height: 1.3;
  }
  .prod-card-price {
    font-size: 0.8rem; color: var(--muted);
    display: flex; align-items: center; gap: 0.5rem;
  }
  .price-rent { color: var(--indigo-light); font-weight: 500; }
  .prod-card-shine {
    position: absolute; inset: 0; pointer-events: none;
    background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, transparent 60%);
  }

  /* ── SECTION: CATEGORIES ── */
  .section {
    position: relative; z-index: 1;
    max-width: 1200px; margin: 0 auto;
    padding: 0 2rem 7rem;
  }
  .section-label {
    font-size: 0.75rem; letter-spacing: 0.15em; text-transform: uppercase;
    color: var(--indigo-light); margin-bottom: 0.75rem;
  }
  .section-title {
    font-family: 'Syne', sans-serif;
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 800; letter-spacing: -0.03em;
    line-height: 1.1; margin-bottom: 1rem;
  }
  .section-sub { color: var(--muted); font-size: 1rem; line-height: 1.7; max-width: 500px; margin-bottom: 3rem; }

  .cat-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }

  .cat-card {
    position: relative; overflow: hidden;
    border-radius: 20px; border: 1px solid var(--card-border);
    padding: 2.5rem;
    background: var(--card-bg);
    cursor: none;
    transition: border-color 0.3s, transform 0.3s;
    transform-style: preserve-3d;
  }
  .cat-card:hover { border-color: rgba(129,140,248,0.4); transform: translateY(-4px); }
  .cat-card-edu { grid-row: span 1; }
  .cat-card-play { grid-row: span 1; }

  .cat-icon {
    font-size: 3rem; margin-bottom: 1.5rem; display: block;
    filter: drop-shadow(0 0 20px currentColor);
  }
  .cat-card-edu .cat-icon { color: var(--sky); }
  .cat-card-play .cat-icon { color: var(--orange); }

  .cat-title {
    font-family: 'Syne', sans-serif; font-size: 1.5rem; font-weight: 800;
    margin-bottom: 0.5rem;
  }
  .cat-desc { color: var(--muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem; }
  .cat-tags { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 2rem; }
  .cat-tag {
    font-size: 0.75rem; padding: 0.25rem 0.75rem;
    border-radius: 100px; border: 1px solid var(--card-border);
    color: var(--muted);
  }
  .cat-link {
    display: inline-flex; align-items: center; gap: 0.5rem;
    font-size: 0.9rem; font-weight: 500; text-decoration: none;
    cursor: none;
    transition: gap 0.2s;
  }
  .cat-card-edu .cat-link { color: var(--sky-light); }
  .cat-card-play .cat-link { color: var(--orange-light); }
  .cat-link:hover { gap: 0.75rem; }

  .cat-card-bg {
    position: absolute; right: -40px; bottom: -40px;
    width: 220px; height: 220px; border-radius: 50%;
    filter: blur(60px); opacity: 0.15; pointer-events: none;
    transition: opacity 0.3s;
  }
  .cat-card:hover .cat-card-bg { opacity: 0.25; }
  .cat-card-edu .cat-card-bg { background: var(--sky); }
  .cat-card-play .cat-card-bg { background: var(--orange); }

  /* ── HOW IT WORKS ── */
  .steps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
  .step-card {
    border-radius: 16px; border: 1px solid var(--card-border);
    padding: 2rem; background: var(--card-bg);
    position: relative; overflow: hidden;
    transition: border-color 0.3s, transform 0.3s;
  }
  .step-card:hover { border-color: rgba(129,140,248,0.3); transform: translateY(-4px); }
  .step-num {
    font-family: 'Syne', sans-serif; font-size: 4rem; font-weight: 800;
    color: rgba(255,255,255,0.04); position: absolute; top: 1rem; right: 1.5rem;
    line-height: 1;
  }
  .step-icon {
    font-size: 1.8rem; margin-bottom: 1rem; display: block;
  }
  .step-title { font-family: 'Syne', sans-serif; font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; }
  .step-desc { color: var(--muted); font-size: 0.85rem; line-height: 1.6; }

  /* ── FEATURED PRODUCTS ── */
  .feat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
  .feat-card {
    border-radius: 16px; border: 1px solid var(--card-border);
    background: var(--card-bg); overflow: hidden;
    cursor: none;
    transition: transform 0.3s cubic-bezier(.23,1,.32,1), border-color 0.3s;
  }
  .feat-card:hover { transform: translateY(-6px) scale(1.02); border-color: rgba(129,140,248,0.35); }
  .feat-card-img {
    width: 100%; height: 180px;
    object-fit: cover; display: block;
    filter: brightness(0.8) saturate(1.1);
    transition: filter 0.3s, transform 0.5s;
  }
  .feat-card:hover .feat-card-img { filter: brightness(0.95) saturate(1.3); transform: scale(1.05); }
  .feat-card-img-wrap { overflow: hidden; }
  .feat-card-body { padding: 1.25rem; }
  .feat-badge {
    font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em;
    padding: 3px 10px; border-radius: 100px; display: inline-block; margin-bottom: 0.75rem;
  }
  .badge-rent { background: rgba(79,70,229,0.2); color: var(--indigo-light); }
  .badge-buy { background: rgba(34,197,94,0.15); color: #86EFAC; }
  .badge-both { background: rgba(249,115,22,0.15); color: var(--orange-light); }
  .feat-name { font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem; }
  .feat-price-row { display: flex; justify-content: space-between; align-items: center; }
  .feat-rent { font-size: 0.85rem; color: var(--indigo-light); font-weight: 500; }
  .feat-buy { font-size: 0.75rem; color: var(--muted); }
  .feat-btn {
    width: 32px; height: 32px; border-radius: 50%;
    background: rgba(79,70,229,0.2); border: 1px solid rgba(79,70,229,0.3);
    color: var(--indigo-light); font-size: 1.2rem; line-height: 32px; text-align: center;
    transition: background 0.2s;
  }
  .feat-card:hover .feat-btn { background: var(--indigo); color: white; }

  /* ── TESTIMONIAL ── */
  .testi-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
  .testi-card {
    border-radius: 16px; border: 1px solid var(--card-border);
    padding: 1.5rem; background: var(--card-bg);
    transition: border-color 0.3s;
  }
  .testi-card:hover { border-color: rgba(129,140,248,0.3); }
  .testi-stars { color: #FCD34D; font-size: 0.85rem; margin-bottom: 1rem; letter-spacing: 2px; }
  .testi-text { font-size: 0.9rem; color: var(--muted); line-height: 1.6; margin-bottom: 1.25rem; font-style: italic; }
  .testi-author { display: flex; align-items: center; gap: 0.75rem; }
  .testi-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, var(--indigo), var(--sky));
    display: flex; align-items: center; justify-content: center;
    font-size: 0.8rem; font-weight: 700; color: white;
    font-family: 'Syne', sans-serif;
  }
  .testi-name { font-size: 0.85rem; font-weight: 500; }
  .testi-role { font-size: 0.75rem; color: var(--muted); }

  /* ── CTA SECTION ── */
  .cta-section {
    position: relative; z-index: 1;
    text-align: center;
    padding: 5rem 2rem 8rem;
    overflow: hidden;
  }
  .cta-glow {
    position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
    width: 600px; height: 300px; border-radius: 50%;
    background: radial-gradient(ellipse, rgba(79,70,229,0.25) 0%, transparent 70%);
    filter: blur(40px); pointer-events: none;
  }
  .cta-title {
    font-family: 'Syne', sans-serif;
    font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800;
    letter-spacing: -0.03em; line-height: 1.1; margin-bottom: 1rem;
  }
  .cta-sub { color: var(--muted); margin-bottom: 2.5rem; font-size: 1rem; }

  /* ── FOOTER ── */
  footer {
    position: relative; z-index: 1;
    border-top: 1px solid var(--card-border);
    padding: 2rem 2.5rem;
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 1rem;
  }
  .footer-logo {
    font-family: 'Syne', sans-serif; font-size: 1.2rem; font-weight: 800;
    background: linear-gradient(135deg, var(--indigo-light), var(--orange-light));
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  }
  footer p { font-size: 0.8rem; color: var(--muted); }

  /* ── SCROLL ANIMATIONS ── */
  .reveal {
    opacity: 0; transform: translateY(30px);
    transition: opacity 0.7s ease, transform 0.7s ease;
  }
  .reveal.visible { opacity: 1; transform: translateY(0); }

  /* ── RESPONSIVE ── */
  @media (max-width: 768px) {
    nav { padding: 1rem 1.25rem; }
    .nav-links { display: none; }
    .hero { padding: 7rem 1.5rem 3rem; }
    .cat-grid, .steps-grid, .feat-grid, .testi-grid { grid-template-columns: 1fr; }
    .stats-strip { gap: 1.5rem; }
    footer { flex-direction: column; text-align: center; }
  }

  /* ── 3D TILT (JS) ── */
  .tilt-card { transition: transform 0.1s ease; }
</style>
</head>
<body>

<div id="cursor"></div>
<div id="cursor-ring"></div>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<!-- NAV -->
<nav>
  <div class="nav-logo">Edu<span>Play</span></div>
  <div class="nav-links">
    <a href="#eduzone">EduZone</a>
    <a href="#playzone">PlayZone</a>
    <a href="#cara-kerja">Cara Kerja</a>
    <a href="#produk">Produk</a>
    @auth
      <a href="{{ route('catalog') }}" class="nav-cta">Jelajahi Katalog</a>
    @else
      <a href="{{ route('login') }}">Masuk</a>
      <a href="{{ route('register') }}" class="nav-cta">Daftar Sekarang</a>
    @endauth
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-badge">🚀 Platform Sewa & Beli Alat Terlengkap di Lampung</div>
  <h1 class="hero-title">
    <span class="line1">Belajar Lebih Seru,</span>
    <span class="line2">Main Lebih Hemat.</span>
  </h1>
  <p class="hero-sub">
    Sewa kamera, ESP32, proyektor, dan alat riset lainnya. Atau nikmati sesi gaming PS5 dengan harga bersahabat. Semua ada di EduPlay.
  </p>
  <div class="hero-actions">
    <a href="#produk" class="btn-primary">Jelajahi Produk →</a>
    <a href="#cara-kerja" class="btn-outline">Cara Kerja</a>
  </div>

  <div class="stats-strip">
    <div class="stat"><div class="stat-num" data-target="250">0</div><div class="stat-label">Produk Tersedia</div></div>
    <div class="stat"><div class="stat-num" data-target="1200">0</div><div class="stat-label">Pengguna Aktif</div></div>
    <div class="stat"><div class="stat-num" data-target="98">0</div><div class="stat-label">% Kepuasan</div></div>
    <div class="stat"><div class="stat-num" data-target="15">0</div><div class="stat-label">Kategori Produk</div></div>
  </div>
</section>

<!-- MARQUEE ROW 1 -->
<section class="marquee-section">
  <p class="marquee-label">Produk Unggulan</p>
  <div style="position:relative">
    <div style="position:absolute;left:0;top:0;bottom:0;width:120px;background:linear-gradient(to right,var(--bg),transparent);z-index:2;pointer-events:none"></div>
    <div style="position:absolute;right:0;top:0;bottom:0;width:120px;background:linear-gradient(to left,var(--bg),transparent);z-index:2;pointer-events:none"></div>
    <div class="marquee-row" id="row1"></div>
    <div class="marquee-row marquee-row2" id="row2" style="margin-top:1.5rem"></div>
  </div>
</section>

<!-- CATEGORIES -->
<section class="section" id="eduzone">
  <div class="reveal">
    <p class="section-label">Kategori</p>
    <h2 class="section-title">Dua Dunia,<br>Satu Platform</h2>
    <p class="section-sub">Dari peralatan riset serius hingga hiburan santai — EduPlay punya semuanya untuk kamu.</p>
  </div>
  <div class="cat-grid reveal">
    <div class="cat-card cat-card-edu tilt-card">
      <div class="cat-card-bg"></div>
      <span class="cat-icon">📚</span>
      <h3 class="cat-title">EduZone</h3>
      <p class="cat-desc">Alat kuliah dan penelitian berkualitas. Sewa harian atau beli langsung — fleksibel sesuai kebutuhanmu.</p>
      <div class="cat-tags">
        <span class="cat-tag">Kamera DSLR</span>
        <span class="cat-tag">ESP32 / Arduino</span>
        <span class="cat-tag">Proyektor</span>
        <span class="cat-tag">Drone</span>
        <span class="cat-tag">Mikroskop</span>
        <span class="cat-tag">Laptop</span>
      </div>
      <a href="#" class="cat-link">Lihat Semua EduZone <span>→</span></a>
    </div>
    <div class="cat-card cat-card-play tilt-card" id="playzone">
      <div class="cat-card-bg"></div>
      <span class="cat-icon">🎮</span>
      <h3 class="cat-title">PlayZone</h3>
      <p class="cat-desc">Sewa konsol gaming premium per jam atau per hari. Nikmati gaming tanpa harus beli konsol mahal.</p>
      <div class="cat-tags">
        <span class="cat-tag">PlayStation 5</span>
        <span class="cat-tag">PlayStation 4</span>
        <span class="cat-tag">Nintendo Switch</span>
        <span class="cat-tag">VR Headset</span>
        <span class="cat-tag">Controller Ekstra</span>
      </div>
      <a href="#" class="cat-link" style="color:var(--orange-light)">Lihat Semua PlayZone <span>→</span></a>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="section" id="cara-kerja">
  <div class="reveal">
    <p class="section-label">Cara Kerja</p>
    <h2 class="section-title">Mudah dalam<br>3 Langkah</h2>
    <p class="section-sub">Proses sewa dan beli yang simpel — dari browse sampai barang di tanganmu.</p>
  </div>
  <div class="steps-grid reveal">
    <div class="step-card">
      <div class="step-num">01</div>
      <span class="step-icon">🔍</span>
      <h4 class="step-title">Pilih Produk</h4>
      <p class="step-desc">Browse ratusan produk EduZone dan PlayZone. Filter berdasarkan kategori, harga, dan ketersediaan stok real-time.</p>
    </div>
    <div class="step-card">
      <div class="step-num">02</div>
      <span class="step-icon">📅</span>
      <h4 class="step-title">Tentukan Durasi</h4>
      <p class="step-desc">Pilih tanggal mulai dan selesai sewa. Harga otomatis terhitung. Atau langsung beli jika ingin memiliki.</p>
    </div>
    <div class="step-card">
      <div class="step-num">03</div>
      <span class="step-icon">⚡</span>
      <h4 class="step-title">Bayar & Nikmati</h4>
      <p class="step-desc">Bayar aman via Midtrans — GoPay, QRIS, Virtual Account, atau kartu kredit. Barang siap digunakan!</p>
    </div>
  </div>
</section>

<!-- FEATURED PRODUCTS -->
<section class="section" id="produk">
  <div class="reveal">
    <p class="section-label">Produk Pilihan</p>
    <h2 class="section-title">Yang Paling<br>Banyak Dicari</h2>
    <p class="section-sub">Produk terpopuler minggu ini, dipilih berdasarkan rating dan jumlah sewa.</p>
  </div>
  <div class="feat-grid reveal" id="feat-grid"></div>
</section>

<!-- TESTIMONIALS -->
<section class="section">
  <div class="reveal">
    <p class="section-label">Testimoni</p>
    <h2 class="section-title">Kata Mereka<br>Tentang EduPlay</h2>
  </div>
  <div class="testi-grid reveal">
    <div class="testi-card">
      <div class="testi-stars">★★★★★</div>
      <p class="testi-text">"Sewa kamera buat sidang skripsi gampang banget. Harga terjangkau, barangnya mulus. Pasti balik lagi!"</p>
      <div class="testi-author">
        <div class="testi-avatar">AR</div>
        <div><div class="testi-name">Ahmad Ridho</div><div class="testi-role">Mahasiswa Teknik, Unila</div></div>
      </div>
    </div>
    <div class="testi-card">
      <div class="testi-stars">★★★★★</div>
      <p class="testi-text">"ESP32 dan sensor-sensornya lengkap banget. Bisa sewa buat project IoT tanpa keluar modal besar. Mantap!"</p>
      <div class="testi-author">
        <div class="testi-avatar" style="background:linear-gradient(135deg,var(--sky),var(--indigo))">DS</div>
        <div><div class="testi-name">Desi Susanti</div><div class="testi-role">Peneliti, Institut Teknologi</div></div>
      </div>
    </div>
    <div class="testi-card">
      <div class="testi-stars">★★★★☆</div>
      <p class="testi-text">"PS5-nya kinclong, sewa per jam cukup hemat buat nemenin begadang. Chat ke adminnya juga responsif!"</p>
      <div class="testi-author">
        <div class="testi-avatar" style="background:linear-gradient(135deg,var(--orange),#DC2626)">BW</div>
        <div><div class="testi-name">Budi Wijaya</div><div class="testi-role">Gamer, Bandar Lampung</div></div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section" id="daftar">
  <div class="cta-glow"></div>
  <div style="position:relative;z-index:1">
    <p class="section-label" style="margin-bottom:1rem">Mulai Sekarang</p>
    <h2 class="cta-title">Daftar Gratis,<br>Sewa Langsung.</h2>
    <p class="cta-sub">Bergabung dengan 1.200+ pengguna yang sudah merasakan kemudahan EduPlay.</p>
    <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
      <a href="#" class="btn-primary">Buat Akun Gratis →</a>
      <a href="#" class="btn-outline">Lihat Semua Produk</a>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-logo">EduPlay</div>
  <p>© 2024 EduPlay — Bandar Lampung, Indonesia</p>
  <div style="display:flex;gap:1.5rem">
    <a href="#" style="color:var(--muted);font-size:0.8rem;text-decoration:none;cursor:none">Privacy</a>
    <a href="#" style="color:var(--muted);font-size:0.8rem;text-decoration:none;cursor:none">Terms</a>
    <a href="#" style="color:var(--muted);font-size:0.8rem;text-decoration:none;cursor:none">Kontak</a>
  </div>
</footer>

<script>
// ── CURSOR
const cur = document.getElementById('cursor');
const ring = document.getElementById('cursor-ring');
let mx=0,my=0,rx=0,ry=0;
document.addEventListener('mousemove',e=>{mx=e.clientX;my=e.clientY;cur.style.transform=`translate(${mx}px,${my}px) translate(-50%,-50%)`;});
function animRing(){rx+=(mx-rx)*0.12;ry+=(my-ry)*0.12;ring.style.transform=`translate(${rx}px,${ry}px) translate(-50%,-50%)`;requestAnimationFrame(animRing);}
animRing();

// ── COUNTER ANIMATION
function animateCounter(el,target){
  let start=0; const dur=2000; const step=16;
  const inc=target/(dur/step);
  const timer=setInterval(()=>{
    start=Math.min(start+inc,target);
    el.textContent=Math.floor(start)+(target===98?'%':'+');
    if(start>=target)clearInterval(timer);
  },step);
}
const observer=new IntersectionObserver(entries=>{
  entries.forEach(e=>{
    if(e.isIntersecting){
      document.querySelectorAll('.stat-num').forEach(el=>{
        animateCounter(el,+el.dataset.target);
      });
      observer.disconnect();
    }
  });
},{threshold:0.5});
observer.observe(document.querySelector('.stats-strip'));

// ── REVEAL ON SCROLL
const revealObs=new IntersectionObserver(entries=>{
  entries.forEach((e,i)=>{
    if(e.isIntersecting){
      setTimeout(()=>e.target.classList.add('visible'),i*80);
    }
  });
},{threshold:0.1});
document.querySelectorAll('.reveal').forEach(el=>revealObs.observe(el));

// ── PRODUCT DATA - FETCH FROM API
let products = [];

async function loadProductsFromAPI() {
  try {
    const res = await fetch('/api/products?limit=20');
    const data = await res.json();
    if (data.data && data.data.length > 0) {
      products = data.data.map(p => ({
        id: p.id,
        name: p.name,
        slug: p.slug,
        tag: p.category?.type === 'play' ? 'play' : 'edu',
        img: p.images?.[0]?.image_url || 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=400&q=60',
        rent: p.rent_price ? `Rp ${new Intl.NumberFormat('id-ID').format(p.rent_price)}/hari` : 'Hubungi',
        buy: p.sale_price ? `Rp ${new Intl.NumberFormat('id-ID').format(p.sale_price)}` : null
      }));
      initializeMarquees();
    }
  } catch (e) {
    console.error('API error, using demo data:', e);
    products = [
      {name:'Laptop Asus E210',tag:'edu',img:'https://api.mdp.co.id/upload/pictures/product/LP5103.jpg',rent:'Rp 35.000/hari',buy:'Rp 4.500.000'},
      {name:'Tablet Huawei MatePad',tag:'edu',img:'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSUGd8ujTYsJKFho2_7BK5_fHcs-XXf3eT3IA&s',rent:'Rp 25.000/hari',buy:'Rp 2.800.000'},
      {name:'Kit Arduino Starter',tag:'edu',img:'https://store.arduino.cc/cdn/shop/files/starterkit_02.unbox_934x700.jpg?v=1773148487',rent:'Rp 20.000/hari',buy:'Rp 350.000'},
      {name:'PlayStation 5',tag:'play',img:'https://media.dinomarket.com/docs/imgTD/2024-02/DM_CA961EB8D9C88E81647BBFE7417EB9C0_210224140212_ll.jpg',rent:'Rp 25.000/jam',buy:null},
      {name:'Mikroskop Digital 1000x',tag:'edu',img:'https://upload.jaknot.com/2025/12/images/products/83c1c9/original/taffware-mikroskop-digital-10-mp-pembesaran-1000x-55-inch-led-display-g5.jpg',rent:'Rp 45.000/hari',buy:'Rp 850.000'},
      {name:'Drone DJI Mini',tag:'edu',img:'https://sumberbahagia.co.id/wp-content/uploads/2026/03/dji-mini-4k-a.jpg',rent:'Rp 120.000/hari',buy:null},
      {name:'Nintendo Switch',tag:'play',img:'https://m.media-amazon.com/images/I/51YXZgm0DbL._AC_UF894,1000_QL80_DpWeblab_.jpg',rent:'Rp 20.000/jam',buy:null},
      {name:'Proyektor Epson',tag:'edu',img:'https://els.id/wp-content/uploads/2024/10/Epson-EB-E600.jpg',rent:'Rp 80.000/hari',buy:'Rp 3.200.000'},
      {name:'Kamera Sony Alpha',tag:'edu',img:'https://admin.focusnusantara.com/media/catalog/product/cache/417d5822b01094047ca5b50bfdc0690a/c/s/csn24353-sony-alpha-a7-iii-kit-fe-28-70mm-f-3.5-5.6-oss_d2_1.png',rent:'Rp 150.000/hari',buy:null},
      {name:'VR Headset Meta Quest',tag:'play',img:'https://wafuu.com/cdn/shop/products/meta-quest-2-advanced-all-in-one-virtual-reality-headset-128gb-213690.jpg?v=1695255826',rent:'Rp 35.000/jam',buy:null},
      {name:'Raspberry Pi 4',tag:'edu',img:'https://embeddednesia.com/v1/wp-content/uploads/2020/05/rpi4-e1590678460592.jpg',rent:'Rp 30.000/hari',buy:'Rp 750.000'},
      {name:'Osiloskop Digital',tag:'edu',img:'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSIdw-avYgMQ_aAzTsVJrpPF-HqlfrW_VIX3A&s',rent:'Rp 55.000/hari',buy:'Rp 1.800.000'},
    ];
    initializeMarquees();
  }
}

// ── BUILD MARQUEE & FEATURED
function initializeMarquees() {
  function makeCard(p){
    return `<div class="prod-card">
      <div class="prod-card-shine"></div>
      <img src="${p.img}" alt="${p.name}" loading="lazy">
      <div class="prod-card-body">
        <span class="prod-card-tag ${p.tag==='edu'?'tag-edu':'tag-play'}">${p.tag==='edu'?'EduZone':'PlayZone'}</span>
        <div class="prod-card-name">${p.name}</div>
        <div class="prod-card-price"><span class="price-rent">${p.rent}</span>${p.buy?`<span>• ${p.buy}</span>`:''}</div>
      </div>
    </div>`;
  }

  const row1=document.getElementById('row1');
  const row2=document.getElementById('row2');
  row1.innerHTML = '';
  row2.innerHTML = '';
  const half=Math.ceil(products.length/2);
  const set1=products.slice(0,half);
  const set2=products.slice(half);
  // duplicate for infinite scroll
  [...set1,...set1].forEach(p=>row1.insertAdjacentHTML('beforeend',makeCard(p)));
  [...set2,...set2].forEach(p=>row2.insertAdjacentHTML('beforeend',makeCard(p)));

  // ── FEATURED GRID
  const featured = products.slice(0, 6);
  const fg=document.getElementById('feat-grid');
  fg.innerHTML = '';
  featured.forEach(p=>{
    const badge=p.tag==='play'?'badge-rent':(p.buy?'badge-both':'badge-rent');
    const badgeLabel=p.tag==='play'?'Sewa Saja':(p.buy?'Sewa & Beli':'Sewa');
    fg.insertAdjacentHTML('beforeend',`
      <div class="feat-card">
        <div class="feat-card-img-wrap">
          <img class="feat-card-img" src="${p.img}" alt="${p.name}" loading="lazy">
        </div>
        <div class="feat-card-body">
          <span class="feat-badge ${badge}">${badgeLabel}</span>
          <div class="feat-name">${p.name}</div>
          <div class="feat-price-row">
            <div>
              <div class="feat-rent">${p.rent}</div>
              ${p.buy?`<div class="feat-buy">Beli: ${p.buy}</div>`:''}
            </div>
            <div class="feat-btn">+</div>
          </div>
        </div>
      </div>`);
  });
}

// ── LOAD INITIAL DATA
loadProductsFromAPI();

// ── 3D TILT
document.querySelectorAll('.tilt-card').forEach(card=>{
  card.addEventListener('mousemove',e=>{
    const r=card.getBoundingClientRect();
    const x=e.clientX-r.left,y=e.clientY-r.top;
    const cx=r.width/2,cy=r.height/2;
    const rx2=((y-cy)/cy)*-8;
    const ry2=((x-cx)/cx)*8;
    card.style.transform=`perspective(600px) rotateX(${rx2}deg) rotateY(${ry2}deg) translateY(-4px)`;
  });
  card.addEventListener('mouseleave',()=>{
    card.style.transform='perspective(600px) rotateX(0) rotateY(0) translateY(0)';
  });
});

// ── NAV scroll effect
window.addEventListener('scroll',()=>{
  document.querySelector('nav').style.background=
    window.scrollY>50?'rgba(5,5,15,0.92)':'rgba(5,5,15,0.7)';
});
</script>
</body>
</html>