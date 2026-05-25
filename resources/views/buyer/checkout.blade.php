@extends('layouts.buyer')
@section('title', 'Checkout')

@push('styles')
<style>
.wrap{max-width:1100px;margin:0 auto;padding:0 36px 60px;position:relative;z-index:1}
.page-head{margin-bottom:28px}
.page-title{font-size:26px;font-weight:700;letter-spacing:-0.4px;margin-bottom:4px;font-family:'Syne',sans-serif;color:var(--text)}
.page-sub{font-size:13px;color:var(--muted)}
.checkout-layout{display:grid;grid-template-columns:1fr 360px;gap:24px;align-items:start}
.frost-card{background:var(--card-bg);border-radius:20px;padding:24px;border:1px solid var(--card-border);box-shadow:var(--shadow);margin-bottom:16px;backdrop-filter:blur(20px)}
.sec-label{display:flex;align-items:center;gap:10px;margin-bottom:18px}
.sec-num{width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;flex-shrink:0}
.sec-title{font-size:15px;font-weight:600}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.field label{display:block;font-size:11px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;color:var(--muted);margin-bottom:6px}
.frost-input{width:100%;padding:11px 14px;border-radius:12px;border:1px solid var(--card-border);background:rgba(255,255,255,0.05);font-size:13px;font-family:inherit;color:var(--text)}
.frost-input::placeholder{color:var(--muted)}
.frost-input:focus{outline:none;border-color:var(--indigo);background:rgba(255,255,255,0.08);box-shadow:0 0 0 3px rgba(79,70,229,0.15)}
.trans-options{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.trans-card{border:1.5px solid var(--card-border);border-radius:16px;padding:16px;cursor:pointer;transition:all 0.2s;display:flex;gap:12px;align-items:flex-start;background:rgba(255,255,255,0.03)}
.trans-card:hover,.trans-card.selected{border-color:var(--indigo);background:rgba(79,70,229,0.12)}
.trans-card .radio-circle{width:18px;height:18px;border-radius:50%;border:2px solid var(--card-border);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;transition:0.2s}
.trans-card.selected .radio-circle{border-color:var(--indigo);background:var(--indigo)}
.trans-card.selected .radio-circle::after{content:"";width:7px;height:7px;background:white;border-radius:50%}
.t-name{font-weight:600;font-size:14px;margin-bottom:3px;color:var(--text)}
.t-desc{font-size:12px;color:var(--muted)}
.pay-options{display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px}
.pay-card{border:1.5px solid var(--card-border);border-radius:14px;padding:14px;cursor:pointer;text-align:center;transition:all 0.2s;background:rgba(255,255,255,0.03)}
.pay-card:hover,.pay-card.selected{border-color:var(--indigo);background:rgba(79,70,229,0.12)}
.pay-icon{font-size:22px;margin-bottom:6px}
.pay-label{font-size:12px;font-weight:500;color:var(--text)}

/* Order summary */
.order-items{margin-bottom:20px}
.oi-row{display:flex;gap:12px;align-items:center;padding:10px 0;border-bottom:1px solid var(--card-border)}
.oi-row:last-child{border-bottom:none}
.oi-img{width:48px;height:40px;border-radius:10px;overflow:hidden;border:1px solid var(--card-border);flex-shrink:0;background:rgba(255,255,255,0.04)}
.oi-img img{width:100%;height:100%;object-fit:cover}
.oi-name{font-size:13px;font-weight:600;flex:1;color:var(--text)}
.oi-price{font-size:13px;font-weight:700}
.cost-row{display:flex;justify-content:space-between;padding:7px 0;font-size:13px;color:var(--muted)}
.total-row{display:flex;justify-content:space-between;padding:12px 0 0;margin-top:10px;border-top:1px solid var(--card-border);font-size:17px;font-weight:700;color:var(--text)}
.submit-btn{width:100%;padding:14px;background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;border:none;border-radius:16px;font-size:15px;font-weight:600;cursor:pointer;font-family:inherit;margin-top:20px;box-shadow:0 8px 24px rgba(79,70,229,0.28)}
.submit-btn:hover{transform:translateY(-2px)}
.rental-section{display:none;margin-top:14px}
.rental-section.show{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px}
@media (max-width: 980px){.checkout-layout{grid-template-columns:1fr}.frost-card{position:relative!important;top:0!important}}
@media (max-width: 720px){.wrap{padding:0 1rem 48px}.form-grid,.trans-options,.pay-options,.rental-section.show{grid-template-columns:1fr}}
</style>
@endpush

@section('content')
<div class="wrap">
  <div class="page-head">
    <a href="{{ route('cart.index') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:13px;color:var(--muted);text-decoration:none;margin-bottom:12px">← Kembali ke Keranjang</a>
    <h1 class="page-title">Checkout</h1>
    <div class="page-sub">EduPlayHub Marketplace</div>
  </div>

  <form method="POST" action="{{ route('checkout.store') }}" id="checkoutForm">
    @csrf
    @if(request('product'))
      <input type="hidden" name="quick_product_id" value="{{ request('product') }}">
      <input type="hidden" name="quick_type" value="{{ request('type', 'beli') }}">
    @endif
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
              <label class="field" style="display:block;margin-bottom:6px"><span style="font-size:11px;font-weight:600;text-transform:uppercase;color:var(--muted)">Tanggal Pinjam</span></label>
              <input type="date" name="rental_start" id="startDate" class="frost-input" min="{{ date('Y-m-d') }}">
            </div>
            <div>
              <label class="field" style="display:block;margin-bottom:6px"><span style="font-size:11px;font-weight:600;text-transform:uppercase;color:var(--muted)">Tanggal Kembali</span></label>
              <input type="date" name="rental_end" id="endDate" class="frost-input">
            </div>
            <div>
              <label class="field" style="display:block;margin-bottom:6px"><span style="font-size:11px;font-weight:600;text-transform:uppercase;color:var(--muted)">Durasi (hari)</span></label>
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
          <div class="sec-label" style="margin-bottom:14px"><div class="sec-num" style="background:linear-gradient(135deg,var(--indigo),var(--indigo-dark))">✓</div><div class="sec-title">Ringkasan Pesanan</div></div>
          <div class="order-items">
            @foreach($items as $item)
            <div class="oi-row">
              <div class="oi-img"><img src="{{ $item->product->mainImage() }}" alt="{{ $item->product->name }}"></div>
              <div class="oi-name">{{ $item->product->name }}@if($item->variant) · <span style="color:var(--muted)">{{ $item->variant }}</span>@endif</div>
              <div class="oi-price">×{{ $item->quantity }}</div>
            </div>
            @endforeach
          </div>
          <div class="cost-row"><span>Subtotal</span><span id="subtotalVal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
          @if($discount > 0)
          <div class="cost-row" style="color:#16a34a"><span>Diskon</span><span>−Rp {{ number_format($discount, 0, ',', '.') }}</span></div>
          @endif
          <div class="cost-row"><span>Ongkir</span><span>Rp {{ number_format($shipping, 0, ',', '.') }}</span></div>
          <div class="total-row"><span>Total</span><span id="totalVal">Rp {{ number_format($total, 0, ',', '.') }}</span></div>
          <button type="submit" class="submit-btn">Konfirmasi Pesanan</button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
const itemPrices = {
  @foreach($items as $item)
    {{ $item->id }}: { rent: {{ $item->product->price_rent ?? 0 }}, buy: {{ $item->product->price_buy ?? 0 }}, qty: {{ $item->quantity }} },
  @endforeach
};
const initialType = @json(request('type', 'beli'));

function setType(t) {
  document.getElementById('transTypeInput').value = t;
  document.getElementById('optSewa').classList.toggle('selected', t === 'sewa');
  document.getElementById('optBeli').classList.toggle('selected', t === 'beli');
  document.getElementById('rentalSection').classList.toggle('show', t === 'sewa');
  updateTotal();
}

function setPay(val, el) {
  document.getElementById('paymentInput').value = val;
  document.querySelectorAll('.pay-card').forEach(c => c.classList.remove('selected'));
  el.classList.add('selected');
}

function updateTotal() {
  const type = document.getElementById('transTypeInput').value;
  let subtotal = 0;
  
  for (let id in itemPrices) {
    const item = itemPrices[id];
    if (type === 'sewa') {
      const start = document.getElementById('startDate')?.value;
      const end = document.getElementById('endDate')?.value;
      if (start && end) {
        const days = Math.ceil((new Date(end) - new Date(start)) / 86400000) + 1;
        subtotal += (item.rent * item.qty) * Math.max(1, days);
      } else {
        subtotal += item.rent * item.qty;
      }
    } else {
      subtotal += item.buy * item.qty;
    }
  }
  
  const discount = {{ $discount }};
  const shipping = 15000;
  const total = Math.max(0, subtotal - discount + shipping);
  
  document.getElementById('subtotalVal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
  document.getElementById('totalVal').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

document.getElementById('startDate')?.addEventListener('change', () => {
  calcDuration();
  updateTotal();
});
document.getElementById('endDate')?.addEventListener('change', () => {
  calcDuration();
  updateTotal();
});

function calcDuration() {
  const s = document.getElementById('startDate').value;
  const e = document.getElementById('endDate').value;
  if (s && e) {
    const d = Math.ceil((new Date(e) - new Date(s)) / 86400000) + 1;
    document.getElementById('durationVal').value = d > 0 ? d : 0;
  }
}

// Initialize the requested transaction type on page load
document.addEventListener('DOMContentLoaded', () => {
  setType(initialType);
});
</script>
@endpush
