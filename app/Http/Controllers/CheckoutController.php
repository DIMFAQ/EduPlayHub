<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Voucher;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function buyNow(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        return redirect()->route('checkout.index', ['product' => $request->product_id, 'type' => 'beli']);
    }

    public function rentNow(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        return redirect()->route('checkout.index', ['product' => $request->product_id, 'type' => 'sewa']);
    }

    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // If product from buy/rent now, save it to cart
        if ($request->product) {
            $product = \App\Models\Product::findOrFail($request->product);
            
            // Clear cart and add this product
            CartItem::where('user_id', $user->id)->delete();
            CartItem::create([
                'user_id'    => $user->id,
                'product_id' => $product->id,
                'quantity'   => 1,
                'selected'   => true,
                'variant'    => null,
            ]);
            
            // Refresh user to see new cart items
            $user = $user->fresh();
        }
        
        // Get items from cart
        $items = CartItem::where('user_id', $user->id)
            ->with('product.shop')
            ->where('selected', true)
            ->get();

        if ($items->isEmpty()) {
            $items = CartItem::where('user_id', $user->id)->with('product.shop')->get();
        }

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Pilih produk untuk di-checkout.');
        }

        $subtotal   = $items->sum(fn($i) => ($i->product->price_rent ?? $i->product->price_buy ?? 0) * $i->quantity);
        $voucher    = session('voucher');
        $discount   = 0;
        if ($voucher) {
            $v = Voucher::where('code', $voucher)->first();
            if ($v && $v->isValid()) $discount = $v->calcDiscount($subtotal);
        }
        $shipping    = 15000;
        $total       = max(0, $subtotal - $discount + $shipping);
        $cartCount   = $user->cartCount();

        return view('buyer.checkout', compact('items', 'subtotal', 'discount', 'shipping', 'total', 'voucher', 'cartCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_name'  => 'required|string',
            'address'         => 'required|string',
            'city'            => 'required|string',
            'postal_code'     => 'required|string',
            'phone'           => 'required|string',
            'payment_method'  => 'required|in:transfer,cod,ewallet',
            'trans_type'      => 'required|in:beli,sewa',
            'rental_start'    => 'nullable|date|required_if:trans_type,sewa',
            'rental_end'      => 'nullable|date|after_or_equal:rental_start|required_if:trans_type,sewa',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Get items from cart OR reconstruct from quick buy
        $items = $user->cartItems()
            ->with('product.shop')
            ->where('selected', true)
            ->get();

        if ($items->isEmpty()) {
            $items = $user->cartItems()->with('product.shop')->get();
        }

        if ($items->isEmpty() && $request->filled('quick_product_id')) {
            $product = \App\Models\Product::with('shop')->findOrFail($request->quick_product_id);
            $items = collect([(object) [
                'product_id' => $product->id,
                'variant' => null,
                'quantity' => 1,
                'product' => $product,
            ]]);
        }

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $subtotal  = $items->sum(fn($i) => ($request->trans_type === 'sewa'
            ? ($i->product->price_rent ?? $i->product->price_buy ?? 0)
            : ($i->product->price_buy ?? $i->product->price_rent ?? 0)) * $i->quantity);
        $voucher   = session('voucher');
        $discount  = 0;
        if ($voucher) {
            $v = Voucher::where('code', $voucher)->first();
            if ($v && $v->isValid()) $discount = $v->calcDiscount($subtotal);
        }
        $shipping     = 15000;
        $total        = max(0, $subtotal - $discount + $shipping);
        $rentalDays   = null;
        if ($request->trans_type === 'sewa' && $request->rental_start && $request->rental_end) {
            $rentalDays = \Carbon\Carbon::parse($request->rental_start)
                ->diffInDays(\Carbon\Carbon::parse($request->rental_end)) + 1;
        }

        $order = DB::transaction(function () use ($request, $items, $subtotal, $discount, $shipping, $total, $voucher, $rentalDays, $user) {
            $shopId = $items->first()->product->shop_id;

            $order = Order::create([
                'order_number'   => 'EPH-' . strtoupper(Str::random(8)),
                'order_code'     => 'ORD-' . strtoupper(Str::random(12)),
                'user_id'        => $user->id,
                'shop_id'        => $shopId,
                'type'           => $request->trans_type,
                'type_transaction' => $request->trans_type === 'sewa' ? 'rent' : 'buy',
                'status'         => 'masuk',
                'payment_status' => 'pending',
                'recipient_name' => $request->recipient_name,
                'address'        => $request->address,
                'city'           => $request->city,
                'postal_code'    => $request->postal_code,
                'phone'          => $request->phone,
                'payment_method' => $request->payment_method,
                'subtotal'       => $subtotal,
                'shipping_cost'  => $shipping,
                'discount'       => $discount,
                'total'          => $total,
                'voucher_code'   => $voucher,
                'rental_start'   => $request->rental_start,
                'rental_end'     => $request->rental_end,
                'rental_days'    => $rentalDays,
                'duration_days'  => $rentalDays,
            ]);

            foreach ($items as $item) {
                $unitPrice = $request->trans_type === 'sewa'
                    ? ($item->product->price_rent ?? $item->product->price_buy ?? 0)
                    : ($item->product->price_buy ?? $item->product->price_rent ?? 0);

                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $item->product_id,
                    'product_name'  => $item->product->name,
                    'variant'       => $item->variant,
                    'product_image' => $item->product->image,
                    'quantity'      => $item->quantity,
                    'unit_price'    => $unitPrice,
                ]);

                $item->product->increment('total_rented');
            }

            return $order;
        });

        /** @var Order $order */

        if (in_array($order->payment_method, ['transfer', 'ewallet'])) {
            $midtransService = new MidtransService();
            try {
                $snapToken = $midtransService->createSnapToken($order);
                $order->update(['midtrans_token' => $snapToken]);
                CartItem::where('user_id', $user->id)->where('selected', true)->delete();
                session()->forget('voucher');
                return redirect()->route('checkout.payment', $order)->with('success', 'Lanjutkan pembayaran.');
            } catch (\Exception $e) {
                return redirect()->route('checkout.index')->with('error', 'Gagal generate payment: ' . $e->getMessage());
            }
        }

        CartItem::where('user_id', $user->id)->where('selected', true)->delete();
        session()->forget('voucher');

        return redirect()->route('checkout.success', $order)->with('success', 'Pesanan berhasil dibuat!');
    }

    public function success(Request $request, Order $order)
    {
        if ((int) $order->user_id !== Auth::id()) abort(403);

        if ($request->boolean('sync_payment') && $order->payment_status === 'pending' && !empty($order->midtrans_order_id)) {
            try {
                $midtransService = new MidtransService();
                $midtransService->syncOrderPaymentStatus($order);
                $order->refresh();
            } catch (\Throwable $e) {
                // Keep success page accessible even if status sync fails.
            }
        }

        $order->load('items.product', 'shop');
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $cartCount = $user->cartCount();
        return view('buyer.checkout_success', compact('order', 'cartCount'));
    }

    public function payment(Order $order)
    {
        if ((int) $order->user_id !== Auth::id()) abort(403);
        if (empty($order->midtrans_token)) {
            return redirect()->route('checkout.success', $order)->with('error', 'Token pembayaran tidak ditemukan.');
        }
        $order->load('items.product', 'shop');
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $cartCount = $user->cartCount();
        /** @var string $snapToken */
        $snapToken = $order->midtrans_token ?? '';
        $clientKey = config('services.midtrans.client_key');
        return view('buyer.checkout_payment', compact('order', 'cartCount', 'snapToken', 'clientKey'));
    }
}
