@extends('layouts.buyer')

@section('title', 'Katalog')

@push('styles')
<style>
.container{max-width:1540px;margin:0 auto;padding:0 36px 60px}
.hero{background:var(--glass);backdrop-filter:blur(20px) saturate(160%);border-radius:28px;padding:40px 48px;border:1px solid var(--border);box-shadow:var(--shadow);margin-bottom:40px}
.hero-grid{display:grid;grid-template-columns:1fr 1fr;gap:52px;align-items:center}
.hero h1{font-size:48px;font-weight:700;line-height:1.06;letter-spacing:-0.035em;margin-bottom:14px}
.hero p{font-size:15px;color:var(--ink-mid);margin-bottom:24px;line-height:1.6}
.hero-img{height:300px;border-radius:22px;overflow:hidden;background:linear-gradient(135deg,#dce3f0,#c5d5ec)}
.hero-img img{width:100%;height:100%;object-fit:cover}
.hero-btns{display:flex;gap:12px}
.btn-primary{padding:11px 26px;border-radius:40px;font-weight:600;font-size:13.5px;border:none;cursor:pointer;background:var(--accent);color:white;box-shadow:0 4px 14px rgba(42,95,196,0.3);font-family:inherit;text-decoration:none;display:inline-flex;align-items:center}
.btn-primary:hover{background:var(--accent-hover)}
.btn-secondary{padding:11px 26px;border-radius:40px;font-weight:600;font-size:13.5px;border:1px solid var(--border-soft);cursor:pointer;background:white;color:var(--ink);font-family:inherit;text-decoration:none;display:inline-flex;align-items:center}
.btn-secondary:hover{border-color:var(--accent);color:var(--accent)}

/* Category */
.cat-section{margin:40px 0 28px}
.cat-section h2{font-size:13px;font-weight:600;color:var(--ink-dim);letter-spacing:1px;text-transform:uppercase;margin-bottom:14px}
.cat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(120px,1fr));gap:12px}
.cat-card{background:white;padding:18px 12px;border-radius:18px;text-align:center;cursor:pointer;transition:all 0.2s;border:1px solid var(--border-soft);box-shadow:var(--shadow-soft);text-decoration:none;display:block}
.cat-card:hover{transform:translateY(-3px);border-color:var(--accent);box-shadow:0 8px 24px rgba(42,95,196,0.12)}
.cat-card.active{background:var(--accent);border-color:var(--accent)}
.cat-card.active .cat-title,.cat-card.active .cat-count{color:white}
.cat-title{font-weight:600;font-size:14px;color:var(--ink);margin-bottom:4px}
.cat-count{font-size:11px;color:var(--ink-dim)}

/* Search bar */
.search-bar{display:flex;gap:12px;margin-bottom:28px}
.search-bar form{flex:1;display:flex;gap:12px}
.search-bar input{flex:1;padding:14px 22px;border-radius:40px;border:1px solid var(--border-soft);background:white;font-size:14px;font-family:inherit;color:var(--ink)}
.search-bar input:focus{outline:none;border-color:var(--accent);box-shadow:0 0 0 3px rgba(42,95,196,0.09)}
.search-bar button{padding:0 28px;border-radius:40px;background:var(--ink);color:white;font-family:inherit;font-weight:500;font-size:14px;border:none;cursor:pointer}
.search-bar button:hover{background:var(--accent)}

/* Layout */
.main-layout{display:grid;grid-template-columns:270px 1fr;gap:24px}
.sidebar{background:white;padding:24px;border-radius:24px;position:sticky;top:90px;height:fit-content;border:1px solid var(--border-soft);box-shadow:var(--shadow-soft)}
.sidebar h2{font-size:15px;font-weight:600;margin-bottom:20px}
.filter-group{margin-bottom:22px}
.filter-group h4{font-size:10.5px;font-weight:700;color:var(--accent);text-transform:uppercase;letter-spacing:0.8px;margin-bottom:8px}
.filter-group select,.filter-group input[type=number]{width:100%;padding:10px 14px;border-radius:12px;border:1px solid var(--border-soft);background:var(--bg);font-size:13px;font-family:inherit;color:var(--ink)}
.filter-group select:focus,.filter-group input:focus{outline:none;border-color:var(--accent)}
.radio-row{display:flex;gap:16px;margin-top:6px;flex-wrap:wrap}
.radio-row label{display:flex;align-items:center;gap:6px;font-size:13px;cursor:pointer;color:var(--ink-mid)}
.btn-reset{width:100%;background:var(--bg);color:var(--ink-mid);border:1px solid var(--border-soft);padding:10px;border-radius:12px;font-family:inherit;font-size:13px;font-weight:500;cursor:pointer}

/* Products grid */
.products-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}
.products-header h2{font-size:22px;font-weight:600;letter-spacing:-0.3px}
.summary-text{font-size:12.5px;color:var(--ink-dim)}
.product-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px;margin-bottom:28px}
.product-card{background:white;border-radius:20px;overflow:hidden;border:1px solid var(--border-soft);box-shadow:var(--shadow-soft);transition:all 0.2s;cursor:pointer;text-decoration:none;color:inherit;display:block}
.product-card:hover{transform:translateY(-4px);box-shadow:0 12px 32px rgba(13,31,60,0.1);border-color:rgba(42,95,196,0.2)}
.product-card img{width:100%;height:160px;object-fit:cover}
.card-body{padding:14px}
.card-body h3{font-size:14px;font-weight:600;margin-bottom:6px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.category-badge{display:inline-block;font-size:10px;font-weight:600;background:var(--accent-light);color:var(--accent);padding:3px 10px;border-radius:20px;margin-bottom:6px}
.location{font-size:11.5px;color:var(--ink-dim);margin-bottom:8px;display:flex;align-items:center;gap:4px}
.price{font-size:16px;font-weight:700;color:var(--ink);margin-bottom:10px}
.type-badges{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:10px}
.badge-rent{background:rgba(99,102,241,0.1);color:#4f46e5;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600}
.badge-buy{background:rgba(34,197,94,0.1);color:#16a34a;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600}
.actions{display:flex;gap:6px;flex-wrap:wrap}
.btn-cart{flex:1;padding:8px;border-radius:10px;border:1px solid var(--border);background:white;color:var(--ink);font-size:12px;font-weight:500;cursor:pointer;font-family:inherit}
.btn-cart:hover{border-color:var(--accent);color:var(--accent)}
.btn-detail{flex:1;padding:8px;border-radius:10px;border:none;background:var(--accent);color:white;font-size:12px;font-weight:600;cursor:pointer;font-family:inherit;text-decoration:none;text-align:center}
.btn-detail:hover{background:var(--accent-hover)}

/* Pagination */
.pagination{display:flex;gap:6px;justify-content:center;margin-top:20px}
.page-info{font-size:13px;color:var(--ink-dim);margin-top:12px;text-align:center}
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
        <img src="https://picsum.photos/id/20/800/400" alt="EduPlayHub Hero">
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
