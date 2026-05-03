<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function sellerIndex(Request $request)
    {
        $shop = Auth::user()->shop;

        $query = Order::where('shop_id', $shop->id)
            ->with(['user', 'items.product'])
            ->when($request->status && $request->status !== 'semua',
                fn($q) => $q->where('status', $request->status))
            ->when($request->search, function ($q) use ($request) {
                $s = '%' . $request->search . '%';
                $q->where('order_number', 'like', $s)
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', $s));
            })
            ->latest();

        $orders = $query->paginate(10)->withQueryString();

        $statusCounts = [
            'semua'   => Order::where('shop_id', $shop->id)->count(),
            'masuk'   => Order::where('shop_id', $shop->id)->where('status', 'masuk')->count(),
            'proses'  => Order::where('shop_id', $shop->id)->where('status', 'proses')->count(),
            'kirim'   => Order::where('shop_id', $shop->id)->where('status', 'kirim')->count(),
            'selesai' => Order::where('shop_id', $shop->id)->where('status', 'selesai')->count(),
        ];

        return view('seller.orders', compact('shop', 'orders', 'statusCounts', 'request'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $shop = Auth::user()->shop;
        if ($order->shop_id !== $shop->id) abort(403);

        $request->validate(['status' => 'required|in:masuk,proses,kirim,selesai,dibatalkan']);
        $order->update(['status' => $request->status]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'status' => $order->statusLabel()]);
        }

        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
