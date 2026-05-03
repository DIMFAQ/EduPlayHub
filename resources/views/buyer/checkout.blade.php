@extends('layouts.buyer')
@section('title', 'Checkout')

@push('styles')
<style>
.wrap{max-width:1100px;margin:0 auto;padding:0 36px 60px}
.page-head{margin-bottom:28px}
.page-title{font-size:26px;font-weight:700;letter-spacing:-0.4px;margin-bottom:4px}
.page-sub{font-size:13px;color:var(--ink-dim)}
.checkout-layout{display:grid;grid-template-columns:1fr 360px;gap:24px;align-items:start}
.frost-card{background:white;border-radius:20px;padding:24px;border:1px solid var(--border-soft);box-shadow:var(--shadow-soft);margin-bottom:16px}
.sec-label{display:flex;align-items:center;gap:10px;margin-bottom:18px}
.sec-num{width:28px;height:28px;border-radius:50%;background:var(--accent);color:white;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;flex-shrink:0}
.sec-title{font-size:15px;font-weight:600}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.field label{display:block;font-size:11px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;color:var(--ink-dim);margin-bottom:6px}
.frost-input{width:100%;padding:11px 14px;border-radius:12px;border:1px solid var(--border-soft);background:var(--bg);font-size:13px;font-family:inherit;color:var(--ink)}
.frost-input:focus{outline:none;border-color:var(--accent);background:rgba(255,255,255,0.9);box-shadow:0 0 0 3px rgba(42,95,196,0.09)}
.trans-options{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.trans-card{border:1.5px solid var(--border-soft);border-radius:16px;padding:16px;cursor:pointer;transition:all 0.2s;display:flex;gap:12px;align-items:flex-start}
.trans-card:hover,.trans-card.selected{border-color:var(--accent);background:var(--accent-light)}
.trans-card .radio-circle{width:18px;height:18px;border-radius:50%;border:2px solid var(--border);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;transition:0.2s}
.trans-card.selected .radio-circle{border-color:var(--accent);background:var(--accent)}
.trans-card.selected .radio-circle::after{content:"";width:7px;height:7px;background:white;border-radius:50%}
.t-name{font-weight:600;font-size:14px;margin-bottom:3px}
.t-desc{font-size:12px;color:var(--ink-dim)}
.pay-options{display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px}
.pay-card{border:1.5px solid var(--border-soft);border-radius:14px;padding:14px;cursor:pointer;text-align:center;transition:all 0.2s}
.pay-card:hover,.pay-card.selected{border-color:var(--accent);background:var(--accent-light)}
.pay-icon{font-size:22px;margin-bottom:6px}
.pay-label{font-size:12px;font-weight:500;color:var(--ink-mid)}

/* Order summary */
.order-items{margin-bottom:20px}
.oi-row{display:flex;gap:12px;align-items:center;padding:10px 0;border-bottom:1px solid var(--border-soft)}
.oi-row:last-child{border-bottom:none}
.oi-img{width:48px;height:40px;border-radius:10px;overflow:hidden;border:1px solid var(--border-soft);flex-shrink:0}
.oi-img img{width:100%;height:100%;object-fit:cover}
.oi-name{font-size:13px;font-weight:600;flex:1}
.oi-price{font-size:13px;font-weight:700}
.cost-row{display:flex;justify-content:space-between;padding:7px 0;font-size:13px;color:var(--ink-mid)}
.total-row{display:flex;justify-content:space-between;padding:12px 0 0;margin-top:10px;border-top:1px solid var(--border-soft);font-size:17px;font-weight:700;color:var(--ink)}
.submit-btn{width:100%;padding:14px;background:var(--accent);color:white;border:none;border-radius:16px;font-size:15px;font-weight:600;cursor:pointer;font-family:inherit;margin-top:20px}
.submit-btn:hover{background:var(--accent-hover)}
.rental-section{display:none;margin-top:14px}
.rental-section.show{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px}
</style>
@endpush

@section('content')
<div class="wrap">
  <div class="page-head">
    <a href="{{ route('cart.index') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:13px;color:var(--ink-mid);text-decoration:none;margin-bottom:12px">← Kembali ke Keranjang</a>
    <h1 class="page-title">Checkout</h1>
    <div class="page-sub">EduPlayHub Marketplace</div>
  </div>

  <form method="POST" action="{{ route('checkout.store') }}" id="checkoutForm">
    @csrf
    <div class="checkout-layout">
      <!-- LEFT: FORMS -->
      <div>
        <!-- Trans Type -->
        <div class="frost-card">
          <div class="sec-label"><div class="sec-num">1</div><div class="sec-title">Tipe Transaksi</div></div>
          <div class="trans-options">
            <div class="trans-card" id="optSewa" onclick="setType('sewa')">
              <div class="radio-circle"></div>
              <div><div class="t-name">Sewa Produk</div><div class="t-desc">Pilih durasi & tanggal sewa</div></div>
            </div>
            <div class="trans-card selected" id="optBeli" onclick="setType('beli')">
              <div class="radio-circle"></div>
              <div><div class="t-name">Beli Produk</div><div class="t-desc">Pembelian permanen</div></div>
            </div>
          </div>
          <input type="hidden" name="trans_type" id="transTypeInput" value="beli">

          <div class="rental-section" id="rentalSection">
            <div>
              <label class="field" style="display:block;margin-bottom:6px"><span style="font-size:11px;font-weight:600;text-transform:uppercase;color:var(--ink-dim)">Tanggal Pinjam</span></label>
              <input type="date" name="rental_start" id="startDate" class="frost-input" min="{{ date('Y-m-d') }}">
            </div>
            <div>
              <label class="field" style="display:block;margin-bottom:6px"><span style="font-size:11px;font-weight:600;text-transform:uppercase;color:var(--ink-dim)">Tanggal Kembali</span></label>
              <input type="date" name="rental_end" id="endDate" class="frost-input">
            </div>
            <div>
              <label class="field" style="display:block;margin-bottom:6px"><span style="font-size:11px;font-weight:600;text-transform:uppercase;color:var(--ink-dim)">Durasi (hari)</span></label>
              <input type="number" id="durationVal" class="frost-input" readonly placeholder="Auto">
            </div>
          </div>
        </div>

        <!-- Shipping -->
        <div class="frost-card">
          <div class="sec-label"><div class="sec-num">2</div><div class="sec-title">Alamat Pengiriman</div></div>
          <div class="form-grid">
            <div class="field">
              <label>Nama Penerima</label>
              <input type="text" name="recipient_name" class="frost-input" value="{{ auth()->user()->name }}" required>
            </div>
            <div class="field">
              <label>No. Telepon</label>
              <input type="text" name="phone" class="frost-input" value="{{ auth()->user()->phone }}" required>
            </div>
            <div class="field" style="grid-column:1/-1">
              <label>Alamat Lengkap</label>
              <input type="text" name="address" class="frost-input" value="{{ auth()->user()->address }}" required placeholder="Jl. ... No. ...">
            </div>
            <div class="field">
              <label>Kota</label>
              <input type="text" name="city" class="frost-input" value="{{ auth()->user()->city }}" required placeholder="Jakarta Selatan">
            </div>
            <div class="field">
              <label>Kode Pos</label>
              <input type="text" name="postal_code" class="frost-input" value="{{ auth()->user()->postal_code }}" required placeholder="12190">
            </div>
          </div>
        </div>

        <!-- Payment -->
        <div class="frost-card">
          <div class="sec-label"><div class="sec-num">3</div><div class="sec-title">Metode Pembayaran</div></div>
          <div class="pay-options">
            <div class="pay-card selected" onclick="setPay('transfer', this)">
              <div class="pay-icon">🏦</div>
              <div class="pay-label">Transfer Bank</div>
            </div>
            <div class="pay-card" onclick="setPay('cod', this)">
              <div class="pay-icon">💵</div>
              <div class="pay-label">Bayar di Tempat</div>
            </div>
            <div class="pay-card" onclick="setPay('ewallet', this)">
              <div class="pay-icon">📱</div>
              <div class="pay-label">E-Wallet</div>
            </div>
          </div>
          <input type="hidden" name="payment_method" id="paymentInput" value="transfer">
        </div>
      </div>

      <!-- RIGHT: SUMMARY -->
      <div>
        <div class="frost-card" style="position:sticky;top:90px">
          <div class="sec-label" style="margin-bottom:14px"><div class="sec-num" style="background:var(--ink)">✓</div><div class="sec-title">Ringkasan Pesanan</div></div>
          <div class="order-items">
            @foreach($items as $item)
            <div class="oi-row">
              <div class="oi-img"><img src="{{ $item->product->mainImage() }}" alt="{{ $item->product->name }}"></div>
              <div class="oi-name">{{ $item->product->name }}@if($item->variant) · <span style="color:var(--ink-dim)">{{ $item->variant }}</span>@endif</div>
              <div class="oi-price">×{{ $item->quantity }}</div>
            </div>
            @endforeach
          </div>
          <div class="cost-row"><span>Subtotal</span><span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
          @if($discount > 0)
          <div class="cost-row" style="color:#16a34a"><span>Diskon</span><span>−Rp {{ number_format($discount, 0, ',', '.') }}</span></div>
          @endif
          <div class="cost-row"><span>Ongkir</span><span>Rp {{ number_format($shipping, 0, ',', '.') }}</span></div>
          <div class="total-row"><span>Total</span><span>Rp {{ number_format($total, 0, ',', '.') }}</span></div>
          <button type="submit" class="submit-btn">Konfirmasi Pesanan</button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
function setType(t) {
  document.getElementById('transTypeInput').value = t;
  document.getElementById('optSewa').classList.toggle('selected', t === 'sewa');
  document.getElementById('optBeli').classList.toggle('selected', t === 'beli');
  document.getElementById('rentalSection').classList.toggle('show', t === 'sewa');
}

function setPay(val, el) {
  document.getElementById('paymentInput').value = val;
  document.querySelectorAll('.pay-card').forEach(c => c.classList.remove('selected'));
  el.classList.add('selected');
}

document.getElementById('startDate')?.addEventListener('change', calcDuration);
document.getElementById('endDate')?.addEventListener('change', calcDuration);

function calcDuration() {
  const s = document.getElementById('startDate').value;
  const e = document.getElementById('endDate').value;
  if (s && e) {
    const d = Math.ceil((new Date(e) - new Date(s)) / 86400000) + 1;
    document.getElementById('durationVal').value = d > 0 ? d : 0;
  }
}
</script>
@endpush
