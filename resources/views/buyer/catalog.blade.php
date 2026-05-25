@extends('layouts.buyer')

@section('title', 'Katalog')

@push('styles')
<style>
.container{max-width:1400px;margin:0 auto;padding:2rem 2rem 4rem;position:relative;z-index:1}
.hero{background:rgba(255,255,255,0.04);backdrop-filter:blur(20px);border-radius:28px;padding:3rem 3rem;border:1px solid var(--card-border);box-shadow:0 8px 32px rgba(0,0,0,0.3);margin-bottom:3rem}
.hero-grid{display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:center}
.hero h1{font-size:2.5rem;font-weight:700;line-height:1.1;letter-spacing:-0.035em;margin-bottom:1rem;font-family:'Syne',sans-serif;color:var(--text)}
.hero p{font-size:1rem;color:var(--muted);margin-bottom:1.5rem;line-height:1.6}
.hero-img{height:300px;border-radius:22px;overflow:hidden;background:linear-gradient(135deg,rgba(79,70,229,0.2),rgba(249,115,22,0.15))}
.hero-img img{width:100%;height:100%;object-fit:cover;filter:brightness(0.9) saturate(1.1)}
.hero-btns{display:flex;gap:1rem;flex-wrap:wrap}
.btn-primary{padding:0.7rem 1.5rem;border-radius:40px;font-weight:600;font-size:0.95rem;border:none;cursor:none;background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;box-shadow:0 4px 24px rgba(79,70,229,0.35);font-family:inherit;text-decoration:none;display:inline-flex;align-items:center;transition:all 0.2s}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 32px rgba(79,70,229,0.5)}
.btn-secondary{padding:0.7rem 1.5rem;border-radius:40px;font-weight:600;font-size:0.95rem;border:1px solid var(--card-border);cursor:none;background:transparent;color:var(--text);font-family:inherit;text-decoration:none;display:inline-flex;align-items:center;transition:all 0.2s}
.btn-secondary:hover{border-color:rgba(255,255,255,0.25);background:rgba(255,255,255,0.05)}

/* Category */
.cat-section{margin:2rem 0 1.5rem;position:relative;z-index:1}
.cat-section h2{font-size:0.75rem;font-weight:600;color:var(--indigo-light);letter-spacing:1px;text-transform:uppercase;margin-bottom:1rem}
.cat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(120px,1fr));gap:0.75rem}
.cat-card{background:rgba(255,255,255,0.04);padding:1.2rem 0.8rem;border-radius:16px;text-align:center;cursor:none;transition:all 0.2s;border:1px solid var(--card-border);box-shadow:none;text-decoration:none;display:block;backdrop-filter:blur(10px)}
.cat-card:hover{transform:translateY(-3px);border-color:rgba(129,140,248,0.35);background:rgba(79,70,229,0.1)}
.cat-card.active{background:rgba(79,70,229,0.2);border-color:rgba(129,140,248,0.35)}
.cat-card.active .cat-title,.cat-card.active .cat-count{color:var(--indigo-light)}
.cat-title{font-weight:600;font-size:0.9rem;color:var(--text);margin-bottom:0.25rem}
.cat-count{font-size:0.8rem;color:var(--muted)}

/* Search bar */
.search-bar{display:flex;gap:0.75rem;margin-bottom:1.75rem;position:relative;z-index:1}
.search-bar form{flex:1;display:flex;gap:0.75rem}
.search-bar input{flex:1;padding:0.9rem 1.5rem;border-radius:40px;border:1px solid var(--card-border);background:rgba(255,255,255,0.06);font-size:0.95rem;font-family:inherit;color:var(--text);backdrop-filter:blur(10px)}
.search-bar input::placeholder{color:var(--muted)}
.search-bar input:focus{outline:none;border-color:rgba(129,140,248,0.5);background:rgba(255,255,255,0.08);box-shadow:0 0 0 3px rgba(79,70,229,0.15)}
.search-bar button{padding:0 1.8rem;border-radius:40px;background:var(--indigo);color:white;font-family:inherit;font-weight:500;font-size:0.95rem;border:none;cursor:none;transition:all 0.2s;box-shadow:0 4px 24px rgba(79,70,229,0.35)}
.search-bar button:hover{background:var(--indigo-dark);transform:scale(1.02)}

/* Layout */
.main-layout{display:grid;grid-template-columns:270px 1fr;gap:1.5rem;position:relative;z-index:1}
.sidebar{background:rgba(255,255,255,0.04);padding:1.5rem;border-radius:20px;position:sticky;top:110px;height:fit-content;border:1px solid var(--card-border);box-shadow:none;backdrop-filter:blur(10px)}
.sidebar h2{font-size:1rem;font-weight:600;margin-bottom:1.25rem;color:var(--text)}
.filter-group{margin-bottom:1.5rem}
.filter-group h4{font-size:0.75rem;font-weight:700;color:var(--indigo-light);text-transform:uppercase;letter-spacing:0.8px;margin-bottom:0.5rem}
.filter-group select,.filter-group input[type=number]{width:100%;padding:0.6rem 0.9rem;border-radius:10px;border:1px solid var(--card-border);background:rgba(255,255,255,0.06);font-size:0.9rem;font-family:inherit;color:var(--text);backdrop-filter:blur(10px)}
.filter-group select option{background:var(--bg2);color:var(--text)}
.filter-group select:focus,.filter-group input:focus{outline:none;border-color:rgba(129,140,248,0.5);background:rgba(255,255,255,0.08)}
.radio-row{display:flex;gap:1rem;margin-top:0.5rem;flex-wrap:wrap}
.radio-row label{display:flex;align-items:center;gap:0.4rem;font-size:0.85rem;cursor:pointer;color:var(--muted);transition:color 0.2s}
.radio-row label:hover{color:var(--text)}
.btn-reset{width:100%;background:rgba(255,255,255,0.04);color:var(--muted);border:1px solid var(--card-border);padding:0.6rem;border-radius:10px;font-family:inherit;font-size:0.85rem;font-weight:500;cursor:none;transition:all 0.2s;backdrop-filter:blur(10px)}
.btn-reset:hover{background:rgba(79,70,229,0.1);color:var(--indigo-light);border-color:rgba(129,140,248,0.35)}

/* Products grid */
.products-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;position:relative;z-index:1}
.products-header h2{font-size:1.5rem;font-weight:700;letter-spacing:-0.3px;font-family:'Syne',sans-serif;color:var(--text)}
.summary-text{font-size:0.85rem;color:var(--muted)}
.product-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:1rem;margin-bottom:2rem}
.product-card{background:rgba(255,255,255,0.04);border-radius:16px;overflow:hidden;border:1px solid var(--card-border);box-shadow:none;transition:all 0.3s cubic-bezier(0.23,1,0.32,1);cursor:none;text-decoration:none;color:inherit;display:block;backdrop-filter:blur(10px)}
.product-card:hover{transform:translateY(-6px) scale(1.02);border-color:rgba(129,140,248,0.35);background:rgba(79,70,229,0.08)}
.product-card img{width:100%;height:140px;object-fit:cover;filter:brightness(0.85) saturate(1.1);transition:filter 0.3s,transform 0.5s}
.product-card:hover img{filter:brightness(1) saturate(1.2);transform:scale(1.06)}
.card-body{padding:1rem}
.card-body h3{font-size:0.9rem;font-weight:600;margin-bottom:0.4rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:var(--text)}
.category-badge{display:inline-block;font-size:0.7rem;font-weight:600;background:rgba(14,165,233,0.15);color:var(--sky-light);padding:0.2rem 0.6rem;border-radius:20px;margin-bottom:0.4rem}
.location{font-size:0.8rem;color:var(--muted);margin-bottom:0.5rem;display:flex;align-items:center;gap:0.25rem}
.price{font-size:1.1rem;font-weight:700;color:var(--indigo-light);margin-bottom:0.6rem}
.type-badges{display:flex;gap:0.4rem;flex-wrap:wrap;margin-bottom:0.6rem}
.badge-rent{background:rgba(79,70,229,0.2);color:var(--indigo-light);padding:0.15rem 0.5rem;border-radius:20px;font-size:0.7rem;font-weight:600}
.badge-buy{background:rgba(16,185,129,0.2);color:#10B981;padding:0.15rem 0.5rem;border-radius:20px;font-size:0.7rem;font-weight:600}
.actions{display:flex;gap:0.4rem;flex-wrap:wrap}
.btn-cart{flex:1;padding:0.5rem;border-radius:8px;border:1px solid var(--card-border);background:transparent;color:var(--indigo-light);font-size:0.8rem;font-weight:500;cursor:none;font-family:inherit;transition:all 0.2s}
.btn-cart:hover{border-color:rgba(129,140,248,0.5);background:rgba(79,70,229,0.1)}
.btn-detail{flex:1;padding:0.5rem;border-radius:8px;border:none;background:var(--indigo);color:white;font-size:0.8rem;font-weight:600;cursor:none;font-family:inherit;text-decoration:none;text-align:center;transition:all 0.2s}
.btn-detail:hover{background:var(--indigo-dark);transform:scale(1.02)}

/* Pagination */
.pagination{display:flex;gap:0.4rem;justify-content:center;margin-top:1.25rem;position:relative;z-index:1}
.page-info{font-size:0.85rem;color:var(--muted);margin-top:0.8rem;text-align:center}
</style>
@endpush

@section('content')
<div class="container">
  <!-- HERO -->
  <div class="hero">
    <div class="hero-grid">
      <div>
        <h1>Sewa & Beli<br>Peralatan Edu</h1>
        <p>Marketplace #1 untuk peralatan pendidikan, teknologi, dan riset. Sewa atau beli dengan mudah dan aman.</p>
        <div class="hero-btns">
          <a href="#produk" class="btn-primary">Jelajahi Produk</a>
          @guest
          <a href="{{ route('register') }}" class="btn-secondary">Daftar Gratis</a>
          @endguest
        </div>
      </div>
      <div class="hero-img">
        <img src="https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=1200&q=60" alt="EduPlayHub Hero">
      </div>
    </div>
  </div>

  <!-- CATEGORIES -->
  <div class="cat-section">
    <h2>Kategori</h2>
    <div class="cat-grid">
      <a href="{{ route('catalog') }}" class="cat-card {{ !request('category') ? 'active' : '' }}">
        <div class="cat-title">Semua</div>
        <div class="cat-count">{{ $categories->sum('products_count') }} produk</div>
      </a>
      @foreach($categories as $cat)
      <a href="{{ route('catalog', ['category' => $cat->slug]) }}" class="cat-card {{ request('category') === $cat->slug ? 'active' : '' }}">
        <div class="cat-title">{{ $cat->name }}</div>
        <div class="cat-count">{{ $cat->products_count }} produk</div>
      </a>
      @endforeach
    </div>
  </div>

  <!-- SEARCH -->
  <div class="search-bar" id="produk">
    <form method="GET" action="{{ route('catalog') }}">
      @foreach(request()->except('search','page') as $k => $v)
      <input type="hidden" name="{{ $k }}" value="{{ $v }}">
      @endforeach
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk, merek, atau kategori...">
      <button type="submit">Cari</button>
    </form>
  </div>

  <!-- LAYOUT -->
  <div class="main-layout">
    <!-- SIDEBAR FILTER -->
    <aside class="sidebar">
      <h2>Filter Produk</h2>
      <form method="GET" action="{{ route('catalog') }}" id="filterForm">
        <div class="filter-group">
          <h4>Kategori</h4>
          <select name="category" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="filter-group">
          <h4>Lokasi</h4>
          <select name="location" onchange="this.form.submit()">
            <option value="">Semua Lokasi</option>
            @foreach($locations as $loc)
            <option value="{{ $loc }}" {{ request('location') === $loc ? 'selected' : '' }}>{{ $loc }}</option>
            @endforeach
          </select>
        </div>
        <div class="filter-group">
          <h4>Harga Min</h4>
          <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Rp minimum">
        </div>
        <div class="filter-group">
          <h4>Harga Maks</h4>
          <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Rp maksimum">
        </div>
        <div class="filter-group">
          <h4>Tipe Transaksi</h4>
          <div class="radio-row">
            <label><input type="radio" name="trans_type" value="" {{ !request('trans_type') ? 'checked' : '' }}> Semua</label>
            <label><input type="radio" name="trans_type" value="sewa" {{ request('trans_type') === 'sewa' ? 'checked' : '' }}> Sewa</label>
            <label><input type="radio" name="trans_type" value="beli" {{ request('trans_type') === 'beli' ? 'checked' : '' }}> Beli</label>
          </div>
        </div>
        <div class="filter-group">
          <button type="submit" style="width:100%;padding:10px;background:var(--accent);color:white;border:none;border-radius:12px;cursor:pointer;font-family:inherit;font-weight:600;font-size:13px">Terapkan Filter</button>
        </div>
        <a href="{{ route('catalog') }}" class="btn-reset" style="display:block;text-align:center;text-decoration:none;padding:10px">Reset Filter</a>
      </form>
    </aside>

    <!-- PRODUCTS -->
    <div>
      <div class="products-header">
        <h2>Semua Produk</h2>
        <div class="summary-text">{{ $products->total() }} produk ditemukan · Halaman {{ $products->currentPage() }} dari {{ $products->lastPage() }}</div>
      </div>

      @if($products->isEmpty())
      <div style="text-align:center;padding:80px;color:var(--ink-dim)">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" style="margin-bottom:16px;opacity:0.4"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <p style="font-size:16px;font-weight:600">Tidak ada produk ditemukan</p>
        <p style="font-size:13px;margin-top:8px">Coba ubah filter atau kata kunci pencarian</p>
      </div>
      @else
      <div class="product-grid">
        @foreach($products as $product)
        <div class="product-card">
          <a href="{{ route('product.show', $product) }}" style="text-decoration:none;color:inherit">
            <img src="{{ $product->mainImage() }}" alt="{{ $product->name }}" loading="lazy">
            <div class="card-body">
              <h3>{{ $product->name }}</h3>
              <div class="category-badge">{{ $product->category->name }}</div>
              <div class="location">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                {{ $product->location }}
              </div>
              <div class="price">{{ $product->displayPrice() }}</div>
              <div class="type-badges">
                @if($product->rentable) <span class="badge-rent">Sewa</span> @endif
                @if($product->sellable) <span class="badge-buy">Beli</span> @endif
              </div>
            </div>
          </a>
          <div style="padding:0 14px 14px;display:flex;gap:6px">
            @auth
            <form method="POST" action="{{ route('cart.add') }}" style="flex:1">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">
              <button type="submit" class="btn-cart" style="width:100%">+ Keranjang</button>
            </form>
            @endauth
            <a href="{{ route('product.show', $product) }}" class="btn-detail">Detail</a>
          </div>
        </div>
        @endforeach
      </div>

      <!-- PAGINATION -->
      <div class="pagination">
        {{ $products->links() }}
      </div>
      @endif
    </div>
  </div>
</div>
@endsection
