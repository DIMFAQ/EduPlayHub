<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * GET /api/payment/{order_id}
     * Ambil info pembayaran dan QRIS code
     */
    public function getPaymentInfo($orderId)
    {
        $order = Order::findOrFail($orderId);
        $payment = Payment::where('pesanan_id', $orderId)->firstOrFail();

        return response()->json([
            'order_id' => $order->id,
            'amount' => $order->total_price,
            'order_status' => $order->status,
            'payment_status' => $payment->status,
            'qris_code' => $payment->qris_code,
            'qris_image_url' => $this->generateQRISImageURL($payment->qris_code),
            'payment_method' => 'QRIS',
            'instructions' => 'Gunakan aplikasi e-wallet atau mobile banking Anda untuk memindai kode QRIS di atas',
        ]);
    }

    /**
     * POST /api/payment/upload
     * Upload bukti pembayaran
     */
    public function uploadPaymentProof(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:pesanan,id',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // max 5MB
        ]);

        try {
            $order = Order::findOrFail($validated['order_id']);
            $payment = Payment::where('pesanan_id', $order->id)->firstOrFail();

            // Validasi payment masih pending
            if ($payment->status !== 'pending') {
                return response()->json([
                    'message' => 'Payment sudah ' . $payment->status . ', tidak bisa upload bukti lagi',
                ], 400);
            }

            // Simpan file bukti pembayaran
            $path = $request->file('proof_image')->store(
                'payment_proofs/order_' . $order->id,
                'public'
            );

            // Update payment record
            $payment->update([
                'proof_image_path' => $path,
                'status' => 'pending', // Tetap pending, menunggu verifikasi admin
            ]);

            return response()->json([
                'message' => 'Bukti pembayaran berhasil diupload',
                'payment' => $payment,
                'image_url' => asset('storage/' . $path),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Upload bukti pembayaran gagal',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * POST /api/payment/verify
     * Admin verifikasi pembayaran
     */
    public function verifyPayment(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:pesanan,id',
        ]);

        try {
            $order = Order::findOrFail($validated['order_id']);
            $payment = Payment::where('pesanan_id', $order->id)->firstOrFail();

            // Cek apakah sudah ada bukti pembayaran
            if (!$payment->proof_image_path) {
                return response()->json([
                    'message' => 'Belum ada bukti pembayaran yang diupload',
                ], 400);
            }

            // Update payment dan order
            $payment->update([
                'status' => 'verified',
                'verified_at' => now(),
            ]);

            $order->update([
                'status' => 'paid',
            ]);

            return response()->json([
                'message' => 'Pembayaran berhasil diverifikasi',
                'payment' => $payment,
                'order_status' => $order->status,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Verifikasi pembayaran gagal',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * GET /api/payment/pending-verifications
     * Admin lihat payment yang menunggu verifikasi
     */
    public function getPendingVerifications()
    {
        $payments = Payment::where('status', 'pending')
            ->whereNotNull('proof_image_path')
            ->with('pesanan.user')
            ->get();

        return response()->json([
            'total' => count($payments),
            'payments' => $payments,
        ]);
    }

    private function generateQRISImageURL($qrisCode)
    {
        // Simulasi: Generate QR Code image dari qrisCode
        // Untuk demo, return dummy URL
        // Di production, bisa gunakan library seperti phpqrcode atau qr-code
        return 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($qrisCode);
    }
}
