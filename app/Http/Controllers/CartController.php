<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $items     = Auth::user()->cartItems()->with('product.shop')->get();
        $cartCount = $items->count();

        $subtotal  = $items->where('selected', true)
            ->sum(fn($i) => ($i->product->price_rent ?? $i->product->price_buy ?? 0) * $i->quantity);

        $voucher   = session('voucher');
        $discount  = 0;
        if ($voucher) {
            $v = Voucher::where('code', $voucher)->first();
            if ($v && $v->isValid()) {
                $discount = $v->calcDiscount($subtotal);
            }
        }

        return view('buyer.cart', compact('items', 'cartCount', 'subtotal', 'voucher', 'discount'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'nullable|integer|min:1',
            'variant'    => 'nullable|string',
        ]);

        $existing = CartItem::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->where('variant', $request->variant)
            ->first();

        if ($existing) {
            $existing->increment('quantity', $request->quantity ?? 1);
        } else {
            CartItem::create([
                'user_id'    => Auth::id(),
                'product_id' => $request->product_id,
                'variant'    => $request->variant,
                'quantity'   => $request->quantity ?? 1,
                'selected'   => true,
            ]);
        }

        if ($request->ajax()) {
            return response()->json(['count' => Auth::user()->cartCount(), 'success' => true]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, int $id)
    {
        $item = CartItem::where('user_id', Auth::id())->findOrFail($id);

        if ($request->has('quantity')) {
            $qty = max(1, (int) $request->quantity);
            $item->update(['quantity' => $qty]);
        }
        if ($request->has('selected')) {
            $item->update(['selected' => (bool) $request->selected]);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        return back();
    }

    public function remove(int $id)
    {
        CartItem::where('user_id', Auth::id())->findOrFail($id)->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'count' => Auth::user()->cartCount()]);
        }
        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function applyVoucher(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        $code    = strtoupper(trim($request->code));
        $voucher = Voucher::where('code', $code)->first();

        if (!$voucher || !$voucher->isValid()) {
            session()->forget('voucher');
            return back()->with('voucher_error', 'Kode voucher tidak valid atau sudah expired.');
        }

        session(['voucher' => $code]);
        return back()->with('voucher_success', 'Voucher berhasil diterapkan!');
    }

    public function count()
    {
        return response()->json(['count' => Auth::user()->cartCount()]);
    }
}
