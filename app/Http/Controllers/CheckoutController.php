<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $items = Auth::user()->cartItems()
            ->with('product.shop')
            ->where('selected', true)
            ->get();

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
        $cartCount   = Auth::user()->cartCount();

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

        $items = Auth::user()->cartItems()
            ->with('product.shop')
            ->where('selected', true)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $subtotal  = $items->sum(fn($i) => ($i->product->price_rent ?? $i->product->price_buy ?? 0) * $i->quantity);
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

        $order = DB::transaction(function () use ($request, $items, $subtotal, $discount, $shipping, $total, $voucher, $rentalDays) {
            // Group by shop – create one order per shop
            $shopId = $items->first()->product->shop_id;

            $order = Order::create([
                'order_number'   => 'EPH-' . strtoupper(Str::random(8)),
                'user_id'        => Auth::id(),
                'shop_id'        => $shopId,
                'type'           => $request->trans_type,
                'status'         => 'masuk',
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
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $item->product_id,
                    'product_name'  => $item->product->name,
                    'variant'       => $item->variant,
                    'product_image' => $item->product->image,
                    'quantity'      => $item->quantity,
                    'unit_price'    => $item->product->price_rent ?? $item->product->price_buy ?? 0,
                ]);

                // Increase sales counter
                $item->product->increment('total_rented');
            }

            // Clear selected cart items
            CartItem::where('user_id', Auth::id())->where('selected', true)->delete();
            session()->forget('voucher');

            return $order;
        });

        return redirect()->route('checkout.success', $order)->with('success', 'Pesanan berhasil dibuat!');
    }

    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        $order->load('items.product', 'shop');
        $cartCount = Auth::user()->cartCount();
        return view('buyer.checkout_success', compact('order', 'cartCount'));
    }
}
