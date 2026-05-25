@extends('layouts.buyer')
@section('title', 'Pembayaran')

@push('styles')
<style>
.payment-wrap{max-width:600px;margin:60px auto;padding:0 24px 80px;text-align:center;position:relative;z-index:1}
.payment-card{background:var(--card-bg);border-radius:28px;padding:48px 40px;border:1px solid var(--card-border);box-shadow:var(--shadow);backdrop-filter:blur(20px)}
.payment-title{font-size:24px;font-weight:700;margin-bottom:8px;letter-spacing:-0.4px;color:var(--text);font-family:'Syne',sans-serif}
.payment-subtitle{font-size:14px;color:var(--muted);margin-bottom:32px;line-height:1.6}
.payment-info{background:rgba(255,255,255,0.04);border-radius:16px;padding:20px;margin-bottom:32px;text-align:left;border:1px solid var(--card-border)}
.info-row{display:flex;justify-content:space-between;padding:12px 0;font-size:14px;border-bottom:1px solid var(--card-border)}
.info-row:last-child{border-bottom:none}
.info-label{color:var(--muted);font-weight:600}
.info-value{font-weight:700;color:var(--text)}
.payment-btn{padding:14px 40px;border-radius:40px;background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;text-decoration:none;font-weight:600;font-size:16px;border:none;cursor:pointer;font-family:inherit;width:100%;max-width:280px;margin:20px auto 0;box-shadow:0 8px 24px rgba(79,70,229,0.28)}
.payment-btn:hover{transform:translateY(-2px)}
.payment-methods{text-align:left;margin-top:32px;font-size:13px;color:var(--muted);line-height:1.8}
.warning-box{background:rgba(249,115,22,0.1);border:1px solid rgba(249,115,22,0.3);border-radius:12px;padding:16px;margin-bottom:20px;font-size:13px;color:var(--orange-light);line-height:1.6}
.spinner{display:inline-block;width:20px;height:20px;border:3px solid rgba(255,255,255,0.15);border-radius:50%;border-top-color:var(--indigo-light);animation:spin 0.8s linear infinite;margin-right:8px;vertical-align:middle}
@keyframes spin{to{transform:rotate(360deg)}}
</style>
@endpush

@section('content')
<div class="payment-wrap">
  <div class="payment-card">
    <h1 class="payment-title">Pembayaran Pesanan</h1>
    <p class="payment-subtitle">
      Silakan lanjutkan pembayaran untuk menyelesaikan pesanan Anda
    </p>

    <div class="warning-box">
      Jangan tutup tab ini atau refresh halaman selama proses pembayaran berlangsung.
    </div>

    <div class="payment-info">
      <div class="info-row">
        <span class="info-label">Nomor Pesanan</span>
        <span class="info-value">#{{ $order->order_number }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Jumlah Item</span>
        <span class="info-value">{{ $order->items->sum('quantity') }} item</span>
      </div>
      <div class="info-row">
        <span class="info-label">Total Pembayaran</span>
        <span class="info-value" style="color:var(--accent);font-size:16px">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Metode Pembayaran</span>
        <span class="info-value">{{ $order->payment_method === 'transfer' ? 'Transfer Bank' : 'E-Wallet' }}</span>
      </div>
    </div>

    <button id="pay-button" class="payment-btn" onclick="processPayment()">
      Lanjutkan Pembayaran
    </button>

    <div class="payment-methods">
      <strong>Metode Pembayaran Tersedia:</strong><br>
      • Transfer Bank (BCA, Mandiri, BRI, BNI)<br>
      • Kartu Kredit (Visa, Mastercard)<br>
      • E-Wallet (GCash, Dana, OVO, LinkAja)<br>
      • BNPL (Akulaku, Kredivo, Kredivo)
    </div>
  </div>
</div>

<!-- Midtrans Snap.js -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>

<script>
function processPayment() {
    var button = document.getElementById('pay-button');
    button.disabled = true;
    button.innerHTML = '<span class="spinner"></span>Memproses...';

    // Trigger Midtrans Snap popup
    snap.pay('{{ $snapToken }}', {
        onSuccess: function(result) {
            console.log('Payment success:', result);
            // Redirect to success page after successful payment
            setTimeout(() => {
            window.location.href = '{{ route("checkout.success", $order) }}?sync_payment=1';
            }, 2000);
        },
        onPending: function(result) {
            console.log('Payment pending:', result);
            alert('Pembayaran sedang diproses. Mohon tunggu...');
            button.disabled = false;
            button.innerHTML = 'Lanjutkan Pembayaran';
        },
        onError: function(result) {
            console.log('Payment error:', result);
            alert('Pembayaran gagal. Silakan coba lagi.');
            button.disabled = false;
            button.innerHTML = 'Lanjutkan Pembayaran';
        },
        onClose: function() {
            console.log('Customer closed the popup without finishing the payment');
            button.disabled = false;
            button.innerHTML = 'Lanjutkan Pembayaran';
        }
    });
}

// Auto-trigger payment on page load
window.addEventListener('load', function() {
    // Optional: Auto-trigger, or let user click the button
    // Uncomment below to auto-trigger:
    // processPayment();
});
</script>
@endsection
