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
            'recipient_name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string',
            'city' => 'sometimes|string|max:100',
            'postal_code' => 'sometimes|string|max:10',
            'phone' => 'sometimes|string|max:20',
        ]);

        $user = $request->user();
        $recipientName = $request->input('recipient_name') ?? $user->name;
        $address = $request->input('address') ?? $user->address;
        $city = $request->input('city') ?? $user->city;
        $postalCode = $request->input('postal_code') ?? $user->postal_code;
        $phone = $request->input('phone') ?? $user->phone;

        if (!$recipientName || !$address || !$city || !$postalCode || !$phone) {
            return response()->json([
                'message' => 'Recipient information is incomplete. Please provide recipient_name, address, city, postal_code, and phone in the request or complete your profile.',
            ], 422);
        }

        $subtotal = 0;
        $orderItems = [];

        foreach ($validated['items'] as $item) {
            $product = Product::findOrFail($item['product_id']);

            if ($item['type'] === 'rent') {
                $itemSubtotal = ($product->price_rent ?? 0) * $item['qty'] * ($item['duration_days'] ?? 1);
            } else {
                $itemSubtotal = ($product->price_buy ?? 0) * $item['qty'];
            }

            $subtotal += $itemSubtotal;
            $orderItems[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_image' => $product->image,
                'quantity' => $item['qty'],
                'unit_price' => $item['type'] === 'rent' ? ($product->price_rent ?? 0) : ($product->price_buy ?? 0),
            ];
        }

        $firstItemProduct = Product::findOrFail($validated['items'][0]['product_id']);
        $shopId = $firstItemProduct->shop_id;
        $firstItemType = $validated['items'][0]['type'];
        $type = $firstItemType === 'rent' ? 'sewa' : 'beli';
        $typeTransaction = $firstItemType;
        $rentalDays = $firstItemType === 'rent' ? ($validated['items'][0]['duration_days'] ?? 1) : null;
        
        $shipping = 15000;
        $total = $subtotal + $shipping;

        $order = Order::create([
            'order_number' => 'EPH-' . Str::upper(Str::random(8)),
            'order_code' => 'ORD-' . Str::upper(Str::random(12)),
            'user_id' => $user->id,
            'shop_id' => $shopId,
            'type' => $type,
            'type_transaction' => $typeTransaction,
            'status' => 'masuk',
            'payment_status' => 'pending',
            'recipient_name' => $recipientName,
            'address' => $address,
            'city' => $city,
            'postal_code' => $postalCode,
            'phone' => $phone,
            'payment_method' => 'transfer',
            'subtotal' => $subtotal,
            'shipping_cost' => $shipping,
            'discount' => 0,
            'total' => $total,
            'rental_days' => $rentalDays,
            'duration_days' => $rentalDays,
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($orderItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'product_image' => $item['product_image'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);
            
            // Increment total_rented just like web checkout
            Product::where('id', $item['product_id'])->increment('total_rented');
        }

        $snapToken = $this->midtransService->createSnapToken($order);

        return response()->json([
            'message' => 'Transaction created successfully',
            'order_id' => $order->id,
            'snap_token' => $snapToken,
            'total_price' => $total,
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
