@extends('layouts.buyer')
@section('title', 'Keranjang')

@push('styles')
<style>
.container{max-width:1200px;margin:0 auto;padding:0 36px 60px}
.page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:16px}
.page-header h1{font-size:26px;font-weight:700;letter-spacing:-0.4px}
.back-link{display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:40px;font-size:13px;font-weight:500;background:white;border:1px solid var(--border-soft);text-decoration:none;color:var(--ink)}
.back-link:hover{border-color:var(--accent);color:var(--accent)}
.cart-grid{display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start}
.cart-items{background:white;border-radius:24px;padding:24px;border:1px solid var(--border-soft);box-shadow:var(--shadow-soft)}
.items-header{display:grid;grid-template-columns:1fr 140px 100px 40px;padding-bottom:12px;border-bottom:1px solid var(--border-soft);font-size:11px;font-weight:600;color:var(--ink-dim);letter-spacing:0.5px;text-transform:uppercase;gap:8px;margin-bottom:8px}
.cart-item{display:grid;grid-template-columns:1fr 140px 100px 40px;align-items:center;padding:16px 0;border-bottom:1px solid var(--border-soft);gap:8px}
.cart-item:last-child{border-bottom:none}
.product-info{display:flex;gap:14px;align-items:center}
.product-img{width:76px;height:60px;border-radius:14px;overflow:hidden;border:1px solid var(--border-soft);flex-shrink:0}
.product-img img{width:100%;height:100%;object-fit:cover}
.product-name{font-weight:600;font-size:14px;margin-bottom:2px}
.product-variant{font-size:12px;color:var(--ink-dim)}
.product-shop{font-size:11px;color:var(--accent);margin-top:2px}
.qty-control{display:flex;align-items:center;gap:8px;background:var(--bg);padding:5px 10px;border-radius:40px;border:1px solid var(--border-soft)}
.qty-btn{width:26px;height:26px;border-radius:50%;background:white;border:1px solid var(--border-soft);font-size:15px;cursor:pointer;color:var(--ink);display:flex;align-items:center;justify-content:center;font-family:inherit;transition:0.2s}
.qty-btn:hover{background:var(--accent);color:white;border-color:var(--accent)}
.qty-val{font-size:14px;font-weight:600;min-width:24px;text-align:center}
.item-price{font-weight:700;font-size:15px;color:var(--ink)}
.remove-btn{width:30px;height:30px;border-radius:50%;border:none;background:none;cursor:pointer;color:var(--ink-dim);display:flex;align-items:center;justify-content:center;transition:0.2s;font-size:16px}
.remove-btn:hover{background:rgba(239,68,68,0.1);color:#dc2626}
.order-summary{background:white;border-radius:24px;padding:24px;border:1px solid var(--border-soft);box-shadow:var(--shadow-soft);position:sticky;top:90px}
.summary-title{font-size:16px;font-weight:600;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--border-soft)}
.summary-row{display:flex;justify-content:space-between;align-items:center;padding:8px 0;font-size:14px;color:var(--ink-mid)}
.summary-row.total{margin-top:16px;padding-top:14px;border-top:1px solid var(--border-soft);font-weight:700;font-size:17px;color:var(--ink)}
.voucher-row{display:flex;gap:8px;margin:16px 0}
.voucher-input{flex:1;padding:10px 14px;border-radius:12px;border:1px solid var(--border-soft);background:var(--bg);font-family:inherit;font-size:13px;color:var(--ink)}
.voucher-input:focus{border-color:var(--accent);outline:none}
.apply-btn{padding:0 14px;border-radius:12px;background:var(--ink);color:white;border:none;font-family:inherit;font-size:12.5px;font-weight:600;cursor:pointer}
.apply-btn:hover{background:var(--accent)}
.checkout-btn{width:100%;padding:14px;background:var(--accent);color:white;border:none;border-radius:16px;font-size:15px;font-weight:600;cursor:pointer;font-family:inherit;margin-top:16px}
.checkout-btn:hover{background:var(--accent-hover)}
.empty-cart{text-align:center;padding:80px;color:var(--ink-dim)}
.voucher-msg{padding:8px 14px;border-radius:10px;font-size:13px;margin-bottom:12px}
.voucher-msg.ok{background:rgba(34,197,94,0.1);color:#16a34a}
.voucher-msg.err{background:rgba(239,68,68,0.1);color:#dc2626}
</style>
@endpush

@section('content')
<div class="container">
  <div class="page-header">
    <h1>Keranjang Belanja</h1>
    <a href="{{ route('catalog') }}" class="back-link">← Lanjut Belanja</a>
  </div>

  @if($items->isEmpty())
  <div class="cart-items">
    <div class="empty-cart">
      <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" style="margin-bottom:16px;opacity:0.3"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
      <p style="font-size:17px;font-weight:600;margin-bottom:8px">Keranjang masih kosong</p>
      <p style="font-size:13px;margin-bottom:24px">Yuk jelajahi produk dan tambahkan ke keranjang!</p>
      <a href="{{ route('catalog') }}" class="btn-primary" style="display:inline-flex;align-items:center;padding:12px 28px;border-radius:40px;background:var(--accent);color:white;text-decoration:none;font-weight:600">Jelajahi Produk</a>
    </div>
  </div>
  @else
  <div class="cart-grid">
    <div class="cart-items">
      <div class="items-header">
        <span>Produk</span>
        <span>Jumlah</span>
        <span>Subtotal</span>
        <span></span>
      </div>

      @foreach($items as $item)
      <div class="cart-item" id="item-{{ $item->id }}">
        <div class="product-info">
          <div class="product-img">
            <img src="{{ $item->product->mainImage() }}" alt="{{ $item->product->name }}">
          </div>
          <div>
            <div class="product-name">{{ $item->product->name }}</div>
            @if($item->variant)<div class="product-variant">{{ $item->variant }}</div>@endif
            <div class="product-shop">{{ $item->product->shop->name }}</div>
          </div>
        </div>

        <div class="qty-control">
          <button class="qty-btn" onclick="updateQty({{ $item->id }}, -1)">−</button>
          <span class="qty-val" id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
          <button class="qty-btn" onclick="updateQty({{ $item->id }}, 1)">+</button>
        </div>

        <div class="item-price" id="price-{{ $item->id }}">
          Rp {{ number_format(($item->product->price_rent ?? $item->product->price_buy ?? 0) * $item->quantity, 0, ',', '.') }}
        </div>

        <form method="POST" action="{{ route('cart.remove', $item->id) }}">
          @csrf @method('DELETE')
          <button type="submit" class="remove-btn" title="Hapus">✕</button>
        </form>
      </div>
      @endforeach
    </div>

    <!-- ORDER SUMMARY -->
    <div class="order-summary">
      <div class="summary-title">Ringkasan Pesanan</div>

      @if(session('voucher_success'))
      <div class="voucher-msg ok">{{ session('voucher_success') }}</div>
      @endif
      @if(session('voucher_error'))
      <div class="voucher-msg err">{{ session('voucher_error') }}</div>
      @endif

      <div class="summary-row">
        <span>Subtotal ({{ $items->where('selected', true)->count() }} produk)</span>
        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
      </div>
      @if($discount > 0)
      <div class="summary-row" style="color:#16a34a">
        <span>Diskon Voucher</span>
        <span>−Rp {{ number_format($discount, 0, ',', '.') }}</span>
      </div>
      @endif
      <div class="summary-row total">
        <span>Total</span>
        <span>Rp {{ number_format($subtotal - $discount, 0, ',', '.') }}</span>
      </div>

      <form method="POST" action="{{ route('cart.voucher') }}" class="voucher-row">
        @csrf
        <input type="text" name="code" placeholder="Kode voucher (PROMO10)" class="voucher-input"
               value="{{ $voucher ?? '' }}">
        <button type="submit" class="apply-btn">Pakai</button>
      </form>

      <form method="GET" action="{{ route('checkout.index') }}">
        <button type="submit" class="checkout-btn" @if($subtotal == 0) disabled @endif>
          Lanjut ke Checkout
        </button>
      </form>
    </div>
  </div>
  @endif
</div>
@endsection

@push('scripts')
<script>
function updateQty(id, delta) {
  const qtyEl = document.getElementById('qty-' + id);
  const priceEl = document.getElementById('price-' + id);
  let qty = parseInt(qtyEl.textContent) + delta;
  if (qty < 1) return;
  qtyEl.textContent = qty;

  fetch('{{ url("/keranjang") }}/' + id, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
    },
    body: JSON.stringify({ quantity: qty })
  }).then(() => location.reload());
}
</script>
@endpush
