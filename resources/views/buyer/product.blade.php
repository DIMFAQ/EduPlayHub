@extends('layouts.buyer')
@section('title', $product->name)

@push('styles')
<style>
.wrap{max-width:1200px;margin:0 auto;padding:0 2rem 4rem;position:relative;z-index:1}
.back-link{display:inline-flex;align-items:center;gap:0.4rem;font-size:0.9rem;color:var(--muted);text-decoration:none;margin-bottom:1.5rem;transition:color 0.2s;cursor:none}
.back-link:hover{color:var(--sky-light)}
.back-link:hover{color:var(--indigo-light)}
.product-layout{display:grid;grid-template-columns:1fr 1fr;gap:2.5rem;margin-bottom:3rem}
.product-images .main-img{width:100%;height:360px;border-radius:20px;overflow:hidden;border:1px solid var(--card-border);margin-bottom:0.75rem;background:rgba(255,255,255,0.04)}
.product-images .main-img img{width:100%;height:100%;object-fit:cover;filter:brightness(0.9) saturate(1.1)}
.thumb-row{display:flex;gap:0.6rem}
.thumb{width:64px;height:52px;border-radius:12px;overflow:hidden;border:2px solid var(--card-border);cursor:none;transition:all 0.2s;background:rgba(255,255,255,0.04)}
.thumb:hover,.thumb.active{border-color:rgba(129,140,248,0.5);background:rgba(79,70,229,0.1)}
.thumb img{width:100%;height:100%;object-fit:cover}
.product-info{display:flex;flex-direction:column;gap:1rem}
.category-badge{display:inline-block;font-size:0.75rem;font-weight:600;background:rgba(14,165,233,0.15);color:var(--sky-light);padding:0.3rem 0.8rem;border-radius:20px}
.product-title{font-size:2rem;font-weight:700;letter-spacing:-0.4px;line-height:1.2;font-family:'Syne',sans-serif;color:var(--text)}
.shop-row{display:flex;align-items:center;gap:0.6rem;font-size:0.9rem;color:var(--muted);padding:0.75rem 0;border-top:1px solid var(--card-border);border-bottom:1px solid var(--card-border)}
.shop-name{font-weight:600;color:var(--text)}
.rating-row{display:flex;align-items:center;gap:0.5rem;font-size:0.85rem}
.stars{color:#FBBF24;font-size:0.9rem}
.price-section{background:rgba(255,255,255,0.04);border-radius:16px;padding:1.25rem;border:1px solid var(--card-border);backdrop-filter:blur(10px)}
.price-label{font-size:0.75rem;font-weight:600;text-transform:uppercase;color:var(--muted);letter-spacing:0.5px;margin-bottom:0.25rem}
.price-value{font-size:2rem;font-weight:700;color:var(--indigo-light);letter-spacing:-0.5px}
.price-sub{font-size:0.8rem;color:var(--muted)}
.badges{display:flex;gap:0.5rem;flex-wrap:wrap}
.badge-rent{background:rgba(79,70,229,0.2);color:var(--indigo-light);padding:0.3rem 0.9rem;border-radius:20px;font-size:0.85rem;font-weight:600}
.badge-buy{background:rgba(16,185,129,0.2);color:#10B981;padding:0.3rem 0.9rem;border-radius:20px;font-size:0.85rem;font-weight:600}
.location-row{display:flex;align-items:center;gap:0.5rem;font-size:0.9rem;color:var(--muted)}
.actions{display:flex;flex-direction:column;gap:0.6rem}
.btn-cart-full{width:100%;padding:0.9rem;border-radius:12px;border:1px solid var(--indigo-light);background:transparent;color:var(--indigo-light);font-size:1rem;font-weight:600;cursor:none;font-family:inherit;transition:all 0.2s}
.btn-cart-full:hover{background:rgba(129,140,248,0.15)}
.btn-rent-full{width:100%;padding:0.9rem;border-radius:12px;border:none;background:var(--sky);color:white;font-size:1rem;font-weight:600;cursor:none;font-family:inherit;transition:all 0.2s;box-shadow:0 4px 24px rgba(14,165,233,0.35)}
.btn-rent-full:hover{background:var(--sky-light);transform:translateY(-2px);box-shadow:0 8px 32px rgba(14,165,233,0.5)}
.btn-buy-full{width:100%;padding:0.9rem;border-radius:12px;border:none;background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;font-size:1rem;font-weight:600;cursor:none;font-family:inherit;transition:all 0.2s;box-shadow:0 4px 24px rgba(79,70,229,0.35)}
.btn-buy-full:hover{transform:translateY(-2px);box-shadow:0 8px 32px rgba(79,70,229,0.5)}
.desc-section,.related-section{margin-bottom:2.25rem}
.section-title{font-size:1.25rem;font-weight:700;margin-bottom:1rem;letter-spacing:-0.2px;font-family:'Syne',sans-serif;color:var(--text)}
.desc-text{font-size:0.95rem;color:var(--muted);line-height:1.7}
.related-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:0.9rem}
.product-card{background:rgba(255,255,255,0.04);border-radius:16px;overflow:hidden;border:1px solid var(--card-border);box-shadow:none;transition:all 0.3s cubic-bezier(0.23,1,0.32,1);text-decoration:none;color:inherit;display:block;backdrop-filter:blur(10px)}
.product-card:hover{transform:translateY(-4px) scale(1.02);border-color:rgba(129,140,248,0.35);background:rgba(79,70,229,0.08)}
.product-card img{width:100%;height:120px;object-fit:cover;filter:brightness(0.85) saturate(1.1);transition:filter 0.3s}
.product-card:hover img{filter:brightness(1) saturate(1.2)}
.card-body{padding:0.8rem}
.card-body h3{font-size:0.85rem;font-weight:600;margin-bottom:0.3rem;color:var(--text)}
.card-price{font-size:0.95rem;font-weight:700;margin-top:0.4rem;color:var(--indigo-light)}
.reviews-section{margin-bottom:2.25rem}
.review-card{background:rgba(255,255,255,0.04);border-radius:14px;padding:1.1rem;border:1px solid var(--card-border);margin-bottom:0.6rem;backdrop-filter:blur(10px)}
.reviewer{display:flex;align-items:center;gap:0.6rem;margin-bottom:0.5rem}
.reviewer-avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--indigo),var(--sky));color:white;display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:600}
.reviewer-name{font-weight:600;font-size:0.95rem;color:var(--text)}
.reviewer-date{font-size:0.8rem;color:var(--muted)}
.review-text{font-size:0.9rem;color:var(--muted);line-height:1.6}

@media (max-width: 1024px){
  .product-layout{grid-template-columns:1fr;gap:1.5rem}
  .related-grid{grid-template-columns:repeat(2,1fr)}
}

@media (max-width: 640px){
  .wrap{padding:0 1rem 3rem}
  .product-title{font-size:1.6rem}
  .price-value{font-size:1.6rem}
  .related-grid{grid-template-columns:1fr}
  .shop-row{flex-wrap:wrap}
  .thumb-row{overflow-x:auto;padding-bottom:0.25rem}
}
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
        <span style="color:var(--card-border)">·</span>
        <span>{{ $product->location }}</span>
      </div>

      <div class="rating-row">
        <span class="stars">{{ number_format($product->rating, 1) }}</span>
        <span style="color:var(--muted)">({{ $product->reviews->count() }} ulasan)</span>
        <span style="color:var(--muted)">·</span>
        <span style="color:var(--muted)">{{ $product->total_rented }} kali disewa</span>
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
        <form method="POST" action="{{ route('checkout.rent-now') }}">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">
          <button type="submit" class="btn-rent-full">Sewa Sekarang</button>
        </form>
        @endif
        @if($product->sellable)
        <form method="POST" action="{{ route('checkout.buy-now') }}">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">
          <button type="submit" class="btn-buy-full">Beli Sekarang</button>
        </form>
        @endif
        <a href="{{ route('chat.conversation', $product->shop->user) }}" style="display:block;text-align:center;padding:12px;border-radius:14px;border:1px solid var(--card-border);color:var(--text);text-decoration:none;font-size:13px;font-weight:500;background:rgba(255,255,255,0.04);transition:0.2s">
          Tanya Admin Toko
        </a>
      </div>
      @else
      <div style="text-align:center;padding:20px;background:rgba(255,255,255,0.04);border:1px solid var(--card-border);border-radius:14px;color:var(--muted)">
        <a href="{{ route('login') }}" style="color:var(--indigo-light);font-weight:600;text-decoration:none">Login</a> untuk membeli atau menyewa
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
          <div class="reviewer-date">{{ $review->created_at->format('d M Y') }} · {{ $review->rating }}</div>
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
