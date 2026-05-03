<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * POST /api/checkout
     * Checkout produk dan buat order baru
     */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:produk,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $totalPrice = 0;
            $orderItems = [];

            // Hitung total harga dan validasi stok
            foreach ($validated['items'] as $item) {
                $product = \App\Models\Product::findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    return response()->json([
                        'message' => 'Stok produk tidak cukup untuk: ' . $product->name,
                        'product' => $product->name,
                        'available_stock' => $product->stock,
                        'requested_quantity' => $item['quantity'],
                    ], 400);
                }

                $subtotal = $product->price * $item['quantity'];
                $totalPrice += $subtotal;

                $orderItems[] = [
                    'produk_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ];
            }

            // Buat order
            $order = Order::create([
                'user_id' => $validated['user_id'],
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            // Tambahkan order items
            foreach ($orderItems as $item) {
                $item['pesanan_id'] = $order->id;
                OrderItem::create($item);

                // Kurangi stok produk
                $product = \App\Models\Product::find($item['produk_id']);
                $product->decrement('stock', $item['quantity']);
            }

            // Buat payment record
            Payment::create([
                'pesanan_id' => $order->id,
                'amount' => $totalPrice,
                'status' => 'pending',
                'qris_code' => $this->generateQRISCode($order->id),
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Checkout berhasil',
                'order' => $order->load('itemPesanan.produk', 'pembayaran'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Checkout gagal',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function generateQRISCode($orderId)
    {
        // Simulasi QRIS code (dummy)
        $qrisCode = "00020126360014ID.CO.WEBSTATIC01051198010303UME51570010A000000000001234520400005303360406110412345678901520423081810502100063041032500820320000321012312345678901234567890215EduPlay";
        $qrisCode .= $orderId;
        $qrisCode .= "5206001562290525EEC18001234.1234.0606051040100";
        $qrisCode .= substr(str_pad($orderId, 12, '0', STR_PAD_LEFT), -12);
        $qrisCode .= "63047BB5";
        return $qrisCode;
    }

    /**
     * GET /api/orders/{order_id}
     * Ambil detail order
     */
    public function getOrder($orderId)
    {
        $order = Order::with('user', 'itemPesanan.produk', 'pembayaran')
            ->findOrFail($orderId);

        return response()->json($order);
    }
}
