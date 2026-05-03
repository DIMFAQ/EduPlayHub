@extends('layouts.buyer')
@section('title', $product->name)

@push('styles')
<style>
.wrap{max-width:1200px;margin:0 auto;padding:0 36px 60px}
.back-link{display:inline-flex;align-items:center;gap:6px;font-size:13px;color:var(--ink-mid);text-decoration:none;margin-bottom:24px}
.back-link:hover{color:var(--accent)}
.product-layout{display:grid;grid-template-columns:1fr 1fr;gap:40px;margin-bottom:48px}
.product-images .main-img{width:100%;height:360px;border-radius:22px;overflow:hidden;border:1px solid var(--border-soft);margin-bottom:12px}
.product-images .main-img img{width:100%;height:100%;object-fit:cover}
.thumb-row{display:flex;gap:10px}
.thumb{width:64px;height:52px;border-radius:12px;overflow:hidden;border:2px solid var(--border-soft);cursor:pointer;transition:0.2s}
.thumb:hover,.thumb.active{border-color:var(--accent)}
.thumb img{width:100%;height:100%;object-fit:cover}
.product-info{display:flex;flex-direction:column;gap:16px}
.category-badge{display:inline-block;font-size:11px;font-weight:600;background:var(--accent-light);color:var(--accent);padding:4px 12px;border-radius:20px}
.product-title{font-size:28px;font-weight:700;letter-spacing:-0.4px;line-height:1.2}
.shop-row{display:flex;align-items:center;gap:10px;font-size:13px;color:var(--ink-mid);padding:12px 0;border-top:1px solid var(--border-soft);border-bottom:1px solid var(--border-soft)}
.shop-name{font-weight:600;color:var(--ink)}
.rating-row{display:flex;align-items:center;gap:8px;font-size:13px}
.stars{color:#f59e0b;font-size:14px}
.price-section{background:var(--bg);border-radius:16px;padding:20px}
.price-label{font-size:11px;font-weight:600;text-transform:uppercase;color:var(--ink-dim);letter-spacing:0.5px;margin-bottom:4px}
.price-value{font-size:32px;font-weight:700;color:var(--ink);letter-spacing:-0.5px}
.price-sub{font-size:12px;color:var(--ink-dim)}
.badges{display:flex;gap:8px;flex-wrap:wrap}
.badge-rent{background:rgba(99,102,241,0.1);color:#4f46e5;padding:5px 14px;border-radius:20px;font-size:12px;font-weight:600}
.badge-buy{background:rgba(34,197,94,0.1);color:#16a34a;padding:5px 14px;border-radius:20px;font-size:12px;font-weight:600}
.location-row{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--ink-mid)}
.actions{display:flex;flex-direction:column;gap:10px}
.btn-cart-full{width:100%;padding:14px;border-radius:14px;border:1px solid var(--accent);background:white;color:var(--accent);font-size:15px;font-weight:600;cursor:pointer;font-family:inherit}
.btn-cart-full:hover{background:var(--accent-light)}
.btn-rent-full{width:100%;padding:14px;border-radius:14px;border:none;background:var(--ink);color:white;font-size:15px;font-weight:600;cursor:pointer;font-family:inherit}
.btn-rent-full:hover{background:var(--accent)}
.btn-buy-full{width:100%;padding:14px;border-radius:14px;border:none;background:var(--accent);color:white;font-size:15px;font-weight:600;cursor:pointer;font-family:inherit}
.btn-buy-full:hover{background:var(--accent-hover)}
.desc-section,.related-section{margin-bottom:36px}
.section-title{font-size:18px;font-weight:600;margin-bottom:16px;letter-spacing:-0.2px}
.desc-text{font-size:14px;color:var(--ink-mid);line-height:1.7}
.related-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px}
.product-card{background:white;border-radius:18px;overflow:hidden;border:1px solid var(--border-soft);box-shadow:var(--shadow-soft);transition:0.2s;text-decoration:none;color:inherit;display:block}
.product-card:hover{transform:translateY(-3px);box-shadow:0 12px 32px rgba(13,31,60,0.1)}
.product-card img{width:100%;height:140px;object-fit:cover}
.card-body{padding:12px}
.card-body h3{font-size:13px;font-weight:600;margin-bottom:4px}
.card-price{font-size:15px;font-weight:700;margin-top:6px}
.reviews-section{margin-bottom:36px}
.review-card{background:white;border-radius:16px;padding:18px;border:1px solid var(--border-soft);margin-bottom:10px}
.reviewer{display:flex;align-items:center;gap:10px;margin-bottom:8px}
.reviewer-avatar{width:36px;height:36px;border-radius:50%;background:var(--ink);color:white;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600}
.reviewer-name{font-weight:600;font-size:14px}
.reviewer-date{font-size:11px;color:var(--ink-dim)}
.review-text{font-size:13px;color:var(--ink-mid);line-height:1.6}
</style>
@endpush

@section('content')
<div class="wrap">
  <a href="{{ route('catalog') }}" class="back-link">← Kembali ke Katalog</a>

  <div class="product-layout">
    <!-- Images -->
    <div class="product-images">
      <div class="main-img">
        <img src="{{ $product->mainImage() }}" alt="{{ $product->name }}" id="mainImg">
      </div>
      @if($product->images->count())
      <div class="thumb-row">
        <div class="thumb active" onclick="switchImg('{{ $product->mainImage() }}', this)">
          <img src="{{ $product->mainImage() }}" alt="">
        </div>
        @foreach($product->images as $img)
        <div class="thumb" onclick="switchImg('{{ asset('storage/'.$img->image) }}', this)">
          <img src="{{ asset('storage/'.$img->image) }}" alt="">
        </div>
        @endforeach
      </div>
      @endif
    </div>

    <!-- Info -->
    <div class="product-info">
      <div><span class="category-badge">{{ $product->category->name }}</span></div>
      <h1 class="product-title">{{ $product->name }}</h1>

      <div class="shop-row">
        <span>Oleh</span>
        <span class="shop-name">{{ $product->shop->name }}</span>
        <span style="color:var(--border-soft)">·</span>
        <span>{{ $product->location }}</span>
      </div>

      <div class="rating-row">
        <span class="stars">★ {{ number_format($product->rating, 1) }}</span>
        <span style="color:var(--ink-dim)">({{ $product->reviews->count() }} ulasan)</span>
        <span style="color:var(--ink-dim)">·</span>
        <span style="color:var(--ink-dim)">{{ $product->total_rented }} kali disewa</span>
      </div>

      <div class="price-section">
        @if($product->rentable && $product->price_rent)
        <div class="price-label">Harga Sewa / Hari</div>
        <div class="price-value">Rp {{ number_format($product->price_rent, 0, ',', '.') }}</div>
        @endif
        @if($product->sellable && $product->price_buy)
        <div class="price-label" style="margin-top:8px">Harga Beli</div>
        <div class="price-value">Rp {{ number_format($product->price_buy, 0, ',', '.') }}</div>
        @endif
      </div>

      <div class="badges">
        @if($product->rentable)<span class="badge-rent">Bisa Sewa</span>@endif
        @if($product->sellable)<span class="badge-buy">Bisa Beli</span>@endif
      </div>

      <div class="location-row">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
        {{ $product->location }}
        · Stok: {{ $product->stock }} unit
      </div>

      @auth
      <div class="actions">
        <form method="POST" action="{{ route('cart.add') }}">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">
          <button type="submit" class="btn-cart-full">
            {{ $inCart ? '✓ Sudah di Keranjang' : '+ Tambah ke Keranjang' }}
          </button>
        </form>
        @if($product->rentable)
        <form method="POST" action="{{ route('cart.add') }}">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">
          <button type="submit" class="btn-rent-full" formaction="{{ route('checkout.index') }}">Sewa Sekarang</button>
        </form>
        @endif
        @if($product->sellable)
        <form method="POST" action="{{ route('cart.add') }}">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">
          <button type="submit" class="btn-buy-full">Beli Sekarang</button>
        </form>
        @endif
        <a href="{{ route('chat.conversation', $product->shop->user) }}" style="display:block;text-align:center;padding:12px;border-radius:14px;border:1px solid var(--border-soft);color:var(--ink-mid);text-decoration:none;font-size:13px;font-weight:500">
          💬 Tanya Penjual
        </a>
      </div>
      @else
      <div style="text-align:center;padding:20px;background:var(--bg);border-radius:14px">
        <a href="{{ route('login') }}" style="color:var(--accent);font-weight:600;text-decoration:none">Login</a> untuk membeli atau menyewa
      </div>
      @endauth
    </div>
  </div>

  <!-- Description -->
  @if($product->description)
  <div class="desc-section">
    <h2 class="section-title">Deskripsi Produk</h2>
    <div class="desc-text">{{ $product->description }}</div>
  </div>
  @endif

  <!-- Reviews -->
  @if($product->reviews->count())
  <div class="reviews-section">
    <h2 class="section-title">Ulasan ({{ $product->reviews->count() }})</h2>
    @foreach($product->reviews->take(5) as $review)
    <div class="review-card">
      <div class="reviewer">
        <div class="reviewer-avatar">{{ $review->user->initials() }}</div>
        <div>
          <div class="reviewer-name">{{ $review->user->name }}</div>
          <div class="reviewer-date">{{ $review->created_at->format('d M Y') }} · {{ $review->rating }}★</div>
        </div>
      </div>
      <div class="review-text">{{ $review->comment }}</div>
    </div>
    @endforeach
  </div>
  @endif

  <!-- Related -->
  @if($related->count())
  <div class="related-section">
    <h2 class="section-title">Produk Serupa</h2>
    <div class="related-grid">
      @foreach($related as $p)
      <a href="{{ route('product.show', $p) }}" class="product-card">
        <img src="{{ $p->mainImage() }}" alt="{{ $p->name }}" loading="lazy">
        <div class="card-body">
          <h3>{{ $p->name }}</h3>
          <div class="card-price">{{ $p->displayPrice() }}</div>
        </div>
      </a>
      @endforeach
    </div>
  </div>
  @endif
</div>
@endsection

@push('scripts')
<script>
function switchImg(src, el) {
  document.getElementById('mainImg').src = src;
  document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
}
</script>
@endpush
