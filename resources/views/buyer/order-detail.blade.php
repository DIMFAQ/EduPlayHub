@extends('layouts.buyer')

@section('content')
<style>
  .order-detail-container {
    position: relative; z-index: 1;
    max-width: 1000px; margin: 0 auto;
    padding: 2rem;
  }

  .back-link {
    display: inline-flex; align-items: center; gap: 0.5rem;
    color: var(--indigo-light);
    text-decoration: none;
    font-size: 0.9rem;
    margin-bottom: 2rem;
    transition: 0.2s;
  }

  .back-link:hover { color: var(--sky-light); }

  .detail-header {
    display: grid; grid-template-columns: 1fr auto;
    gap: 2rem; margin-bottom: 2rem;
  }

  .order-info {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 1.5rem;
    backdrop-filter: blur(20px);
  }

  .order-title {
    font-family: 'Syne', sans-serif;
    font-size: 1.5rem; font-weight: 700;
    color: var(--text);
    margin-bottom: 0.5rem;
  }

  .order-code-small {
    color: var(--muted); font-size: 0.9rem;
    margin-bottom: 1rem;
  }

  .order-info-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 1rem; margin-bottom: 1rem;
  }

  .info-item {
    display: flex; flex-direction: column;
  }

  .info-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--muted);
    margin-bottom: 0.4rem;
  }

  .info-value {
    font-size: 0.95rem; font-weight: 600;
    color: var(--text);
  }

  .status-timeline {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 1.5rem;
    backdrop-filter: blur(20px);
  }

  .timeline-title {
    font-family: 'Syne', sans-serif;
    font-size: 1rem; font-weight: 700;
    color: var(--text);
    margin-bottom: 1.5rem;
  }

  .timeline-item {
    display: flex; gap: 1rem; margin-bottom: 1.5rem;
    position: relative;
  }

  .timeline-item:not(:last-child)::after {
    content: '';
    position: absolute; left: 19px; top: 40px;
    width: 2px; height: calc(100% + 0.5rem);
    background: var(--card-border);
  }

  .timeline-dot {
    width: 40px; height: 40px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
    background: rgba(255,255,255,0.05);
    border: 2px solid var(--card-border);
  }

  .timeline-item.active .timeline-dot {
    background: linear-gradient(135deg, var(--indigo), var(--indigo-dark));
    border-color: var(--indigo);
  }

  .timeline-content {
    flex: 1; padding-top: 0.5rem;
  }

  .timeline-status {
    font-weight: 600; color: var(--text);
    margin-bottom: 0.25rem;
  }

  .timeline-date {
    font-size: 0.8rem; color: var(--muted);
  }

  /* ── ITEMS SECTION ── */
  .items-section {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 1.5rem;
    backdrop-filter: blur(20px);
    margin-bottom: 2rem;
  }

  .section-title {
    font-family: 'Syne', sans-serif;
    font-size: 1.1rem; font-weight: 700;
    color: var(--text);
    margin-bottom: 1.5rem;
  }

  .items-table {
    width: 100%;
  }

  .items-table thead tr {
    border-bottom: 1px solid var(--card-border);
  }

  .items-table th {
    text-align: left;
    padding: 1rem;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--muted);
    font-weight: 600;
  }

  .items-table tbody tr {
    border-bottom: 1px solid rgba(255,255,255,0.04);
  }

  .items-table td {
    padding: 1.2rem 1rem;
    vertical-align: middle;
  }

  .item-product {
    display: flex; gap: 1rem;
  }

  .item-img {
    width: 60px; height: 60px;
    border-radius: 8px;
    background: rgba(255,255,255,0.05);
    border: 1px solid var(--card-border);
    overflow: hidden;
    flex-shrink: 0;
  }

  .item-img img {
    width: 100%; height: 100%; object-fit: cover;
  }

  .item-details {
    flex: 1;
  }

  .item-name {
    font-weight: 600; color: var(--text);
    margin-bottom: 0.25rem;
  }

  .item-variant {
    font-size: 0.8rem; color: var(--muted);
  }

  .item-price {
    text-align: right;
    color: var(--indigo-light);
    font-weight: 600;
  }

  .item-qty {
    text-align: center;
    color: var(--text);
  }

  .item-subtotal {
    text-align: right;
    color: var(--text);
    font-weight: 700;
  }

  /* ── SUMMARY ── */
  .order-summary {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 1.5rem;
    backdrop-filter: blur(20px);
    max-width: 400px;
    margin-left: auto;
  }

  .summary-row {
    display: flex; justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(255,255,255,0.04);
  }

  .summary-row:last-child {
    border-bottom: none;
    padding-top: 1rem;
  }

  .summary-label {
    color: var(--muted); font-size: 0.9rem;
  }

  .summary-value {
    color: var(--text); font-weight: 600;
  }

  .summary-total {
    font-family: 'Syne', sans-serif;
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--sky-light);
  }

  /* ── SHIPPING ADDRESS ── */
  .address-section {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 1.5rem;
    backdrop-filter: blur(20px);
    margin-bottom: 2rem;
  }

  .address-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 2rem;
  }

  .address-block {
    display: flex; flex-direction: column;
  }

  .address-title {
    font-weight: 700; color: var(--text);
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
  }

  .address-content {
    color: var(--muted); font-size: 0.9rem; line-height: 1.6;
  }

  .address-item {
    margin-bottom: 0.5rem;
  }

  .address-item-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--muted);
    margin-bottom: 0.2rem;
  }

  .address-item-value {
    color: var(--text); font-weight: 500;
  }

  /* ── ACTION BUTTONS ── */
  .action-buttons {
    display: flex; gap: 1rem;
    margin-top: 2rem;
    flex-wrap: wrap;
  }

  .btn {
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
    text-decoration: none;
    display: inline-block;
    text-align: center;
  }

  .btn-primary {
    background: linear-gradient(135deg, var(--indigo), var(--indigo-dark));
    color: white;
  }

  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 24px rgba(79,70,229,0.3);
  }

  .btn-secondary {
    background: rgba(255,255,255,0.05);
    color: var(--text);
    border: 1px solid var(--card-border);
  }

  .btn-secondary:hover {
    background: rgba(255,255,255,0.08);
    border-color: var(--indigo);
  }

  .badge {
    display: inline-block;
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-right: 0.5rem;
  }

  .badge-type-beli { background: rgba(14,165,233,0.15); color: var(--sky-light); }
  .badge-type-sewa { background: rgba(249,115,22,0.15); color: var(--orange-light); }
  .badge-status-masuk { background: rgba(79,70,229,0.15); color: var(--indigo-light); }
  .badge-status-proses { background: rgba(14,165,233,0.15); color: var(--sky-light); }
  .badge-status-kirim { background: rgba(129,140,248,0.15); color: var(--indigo-light); }
  .badge-status-selesai { background: rgba(34,197,94,0.15); color: #4ade80; }
</style>

<div class="order-detail-container">
  <a href="{{ route('orders.buyer') }}" class="back-link">← Kembali ke Riwayat</a>

  <div class="detail-header">
    <div class="order-info">
      <div class="order-title">{{ $order->order_number }}</div>
      <div class="order-code-small">{{ $order->order_code }}</div>

      <div class="order-info-grid">
        <div class="info-item">
          <div class="info-label">Jenis Order</div>
          <div class="info-value">
            <span class="badge badge-type-{{ $order->type }}">
              {{ $order->type === 'beli' ? 'Pembelian' : 'Penyewaan' }}
            </span>
          </div>
        </div>
        <div class="info-item">
          <div class="info-label">Status Order</div>
          <div class="info-value">
            <span class="badge badge-status-{{ $order->status }}">
              @switch($order->status)
                @case('masuk') Pesanan Masuk @break
                @case('proses') Diproses @break
                @case('kirim') Dikirim @break
                @case('selesai') Selesai @break
                @case('dibatalkan') Dibatalkan @break
                @default {{ $order->status }} @endswitch
            </span>
          </div>
        </div>
        <div class="info-item">
          <div class="info-label">Tanggal Order</div>
          <div class="info-value">{{ $order->created_at->format('d M Y H:i') }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Toko</div>
          <div class="info-value">{{ $order->shop->name ?? 'N/A' }}</div>
        </div>
      </div>
    </div>

    <div class="status-timeline">
      <div class="timeline-title">Status Pesanan</div>

      <div class="timeline-item {{ $order->status !== 'masuk' && $order->status !== 'dibatalkan' ? 'active' : '' }}">
        <div class="timeline-dot">📥</div>
        <div class="timeline-content">
          <div class="timeline-status">Pesanan Diterima</div>
          <div class="timeline-date">{{ $order->created_at->format('d M Y') }}</div>
        </div>
      </div>

      <div class="timeline-item {{ in_array($order->status, ['proses', 'kirim', 'selesai']) ? 'active' : '' }}">
        <div class="timeline-dot">⚙️</div>
        <div class="timeline-content">
          <div class="timeline-status">Diproses</div>
          <div class="timeline-date">{{ $order->status !== 'masuk' ? '✓ Selesai' : 'Menunggu...' }}</div>
        </div>
      </div>

      <div class="timeline-item {{ in_array($order->status, ['kirim', 'selesai']) ? 'active' : '' }}">
        <div class="timeline-dot">🚚</div>
        <div class="timeline-content">
          <div class="timeline-status">Dikirim</div>
          <div class="timeline-date">{{ in_array($order->status, ['kirim', 'selesai']) ? '✓ Dikirim' : 'Menunggu...' }}</div>
        </div>
      </div>

      <div class="timeline-item {{ $order->status === 'selesai' ? 'active' : '' }}">
        <div class="timeline-dot">✅</div>
        <div class="timeline-content">
          <div class="timeline-status">Pesanan Selesai</div>
          <div class="timeline-date">{{ $order->status === 'selesai' ? '✓ Selesai' : 'Menunggu...' }}</div>
        </div>
      </div>
    </div>
  </div>

  <!-- PAYMENT STATUS -->
  <div class="items-section" style="margin-bottom:2rem">
    <div style="display:flex;justify-content:space-between;align-items:center">
      <div class="section-title">Status Pembayaran</div>
      <div>
        @if($order->payment_status === 'paid')
          <span style="padding:0.5rem 1rem;background:rgba(34,197,94,0.15);color:#4ade80;border-radius:8px;font-weight:600;font-size:0.85rem">✓ Pembayaran Terkonfirmasi</span>
        @else
          <span style="padding:0.5rem 1rem;background:rgba(249,115,22,0.15);color:var(--orange-light);border-radius:8px;font-weight:600;font-size:0.85rem">⚠ Menunggu Pembayaran</span>
          @if($order->midtrans_token)
            <a href="{{ route('checkout.payment', $order) }}" class="btn-primary" style="padding:0.5rem 1rem;font-size:0.85rem;margin-left:0.5rem;text-decoration:none">Lanjutkan Pembayaran →</a>
          @endif
        @endif
      </div>
    </div>
    <div style="margin-top:1rem;padding:1rem;background:rgba(255,255,255,0.05);border:1px solid var(--card-border);border-radius:8px;font-size:0.9rem;color:var(--text)">
      <strong>Metode Pembayaran:</strong> {{ ucfirst($order->payment_method) }}
      @if($order->type === 'sewa')
        <br><strong>Durasi Sewa:</strong> {{ $order->rental_days }} hari ({{ \Carbon\Carbon::parse($order->rental_start)->format('d M') }} - {{ \Carbon\Carbon::parse($order->rental_end)->format('d M Y') }})
      @endif
    </div>
  </div>

  <!-- ITEMS -->
  <div class="items-section">
    <div class="section-title">Produk Dipesan</div>
    <table class="items-table">
      <thead>
        <tr>
          <th>Produk</th>
          <th>Harga Unit</th>
          <th>Jumlah</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->items as $item)
          <tr>
            <td>
              <div class="item-product">
                <div class="item-img">
                  <img src="{{ $item->product_image }}" alt="{{ $item->product_name }}" loading="lazy">
                </div>
                <div class="item-details">
                  <div class="item-name">{{ $item->product_name }}</div>
                  @if($item->variant)
                    <div class="item-variant">Varian: {{ $item->variant }}</div>
                  @endif
                </div>
              </div>
            </td>
            <td class="item-price">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
            <td class="item-qty">{{ $item->quantity }}</td>
            <td class="item-subtotal">Rp {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- SUMMARY & ADDRESS -->
  <div style="display:grid;grid-template-columns:1fr 400px;gap:2rem;margin-bottom:2rem">
    <!-- SHIPPING ADDRESS -->
    <div class="address-section">
      <div class="section-title">Informasi Pengiriman</div>
      <div class="address-grid">
        <div class="address-block">
          <div class="address-title">Penerima</div>
          <div class="address-item">
            <div class="address-item-label">Nama</div>
            <div class="address-item-value">{{ $order->recipient_name }}</div>
          </div>
          <div class="address-item">
            <div class="address-item-label">Telepon</div>
            <div class="address-item-value">{{ $order->phone }}</div>
          </div>
        </div>
        <div class="address-block">
          <div class="address-title">Alamat Tujuan</div>
          <div class="address-item">
            <div class="address-item-label">Jalan</div>
            <div class="address-item-value">{{ $order->address }}</div>
          </div>
          <div class="address-item">
            <div class="address-item-label">Kota</div>
            <div class="address-item-value">{{ $order->city }}</div>
          </div>
          <div class="address-item">
            <div class="address-item-label">Kode Pos</div>
            <div class="address-item-value">{{ $order->postal_code }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- ORDER SUMMARY -->
    <div class="order-summary">
      <div class="section-title">Ringkasan Pesanan</div>
      <div class="summary-row">
        <span class="summary-label">Subtotal</span>
        <span class="summary-value">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
      </div>
      @if($order->discount > 0)
        <div class="summary-row">
          <span class="summary-label">Diskon</span>
          <span class="summary-value" style="color:var(--orange-light)">-Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
        </div>
      @endif
      <div class="summary-row">
        <span class="summary-label">Ongkos Kirim</span>
        <span class="summary-value">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
      </div>
      <div class="summary-row" style="border:none;padding:1rem 0;border-top:2px solid var(--card-border)">
        <span class="summary-label">Total</span>
        <span class="summary-total">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
      </div>
    </div>
  </div>

  <!-- ACTION BUTTONS -->
  <div class="action-buttons">
    <a href="{{ route('orders.buyer') }}" class="btn btn-secondary">← Kembali ke Riwayat</a>
    @if($order->payment_status === 'pending' && $order->midtrans_token)
      <a href="{{ route('checkout.payment', $order) }}" class="btn btn-primary">Lanjutkan Pembayaran →</a>
    @endif
    @if($order->status === 'selesai')
      <a href="{{ route('chat.conversation', $order->shop->user) }}" class="btn btn-secondary">Hubungi Penjual</a>
    @endif
  </div>
</div>
@endsection
