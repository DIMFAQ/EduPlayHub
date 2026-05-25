<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->with(['items', 'items.product'])
            ->latest()
            ->paginate(10);

        return response()->json([
            'data' => $orders->items(),
            'meta' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
            ],
        ]);
    }

    public function show($id)
    {
        $order = Order::with(['items', 'items.product'])->findOrFail($id);

        $this->authorize('view', $order);

        return response()->json([
            'data' => $order,
        ]);
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.type' => 'required|in:buy,rent',
            'items.*.duration_days' => 'required_if:items.*.type,rent|integer|min:1',
            'notes' => 'sometimes|string|max:500',
        ]);

        $totalPrice = 0;
        $orderItems = [];

        foreach ($validated['items'] as $item) {
            $product = Product::findOrFail($item['product_id']);

            if ($item['type'] === 'rent') {
                $subtotal = ($product->price_rent ?? 0) * $item['qty'] * ($item['duration_days'] ?? 1);
            } else {
                $subtotal = ($product->price_buy ?? 0) * $item['qty'];
            }

            $totalPrice += $subtotal;
            $orderItems[] = [
                'product_id' => $item['product_id'],
                'type' => $item['type'],
                'qty' => $item['qty'],
                'duration_days' => $item['duration_days'] ?? null,
                'subtotal' => $subtotal,
            ];
        }

        $order = Order::create([
            'user_id' => $request->user()->id,
            'order_code' => 'ORD-' . Str::upper(Str::random(10)),
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($orderItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'type' => $item['type'],
                'qty' => $item['qty'],
                'duration_days' => $item['duration_days'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        $snapToken = $this->midtransService->createSnapToken($order);

        return response()->json([
            'message' => 'Transaction created successfully',
            'order_id' => $order->id,
            'snap_token' => $snapToken,
            'total_price' => $totalPrice,
        ], 201);
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        $this->authorize('update', $order);

        if ($order->status !== 'pending' || $order->payment_status === 'paid') {
            return response()->json([
                'message' => 'Cannot cancel this order',
            ], 400);
        }

        $order->update(['status' => 'cancelled']);

        return response()->json([
            'message' => 'Order cancelled successfully',
        ]);
    }

    public function getStatus($id)
    {
        $order = Order::findOrFail($id);

        $this->authorize('view', $order);

        return response()->json([
            'status' => $order->status,
            'payment_status' => $order->payment_status,
        ]);
    }
}
