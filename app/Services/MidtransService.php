<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction as MidtransTransaction;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function createSnapToken(Order $order)
    {
        $items = [];
        foreach ($order->items as $item) {
            $items[] = [
                'id' => 'ITEM-' . $item->product_id,
                'price' => (int) $item->unit_price,
                'quantity' => (int) $item->quantity,
                'name' => $item->product_name,
            ];
        }

        $transactionDetails = [
            'order_id' => $order->order_code,
            'gross_amount' => (int) $order->total,
        ];

        $customerDetails = [
            'first_name' => $order->user->name,
            'email' => $order->user->email,
            'phone' => $order->user->phone,
            'billing_address' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone,
                'address' => $order->user->address,
                'city' => $order->user->city,
                'postal_code' => $order->user->postal_code,
                'country_code' => 'IDN',
            ],
        ];

        $transaction = [
            'transaction_details' => $transactionDetails,
            'item_details' => $items,
            'customer_details' => $customerDetails,
        ];

        $snapToken = Snap::getSnapToken($transaction);

        $order->update([
            'midtrans_order_id' => $order->order_code,
            'midtrans_token' => $snapToken,
        ]);

        return $snapToken;
    }

    public function handleCallback(array $data): bool
    {
        $order = Order::where('midtrans_order_id', $data['order_id'])->first();

        if (!$order) {
            return false;
        }

        $transaction = MidtransTransaction::status($data['order_id']);
        $transactionObj = (object) $transaction;
        $this->applyTransactionStatus($order, $transactionObj);

        return true;
    }

    public function syncOrderPaymentStatus(Order $order): bool
    {
        $midtransOrderId = $order->midtrans_order_id ?: $order->order_code;

        if (empty($midtransOrderId)) {
            return false;
        }

        $transaction = MidtransTransaction::status($midtransOrderId);
        $transactionObj = (object) $transaction;

        return $this->applyTransactionStatus($order, $transactionObj);
    }

    private function applyTransactionStatus(Order $order, object $transactionObj): bool
    {
        $transactionStatus = (string) ($transactionObj->transaction_status ?? '');

        if ($transactionStatus === 'capture' || $transactionStatus === 'settlement') {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'proses',
            ]);
            return true;
        }

        if ($transactionStatus === 'pending') {
            $order->update(['payment_status' => 'pending']);
            return true;
        }

        if ($transactionStatus === 'deny') {
            $order->update(['payment_status' => 'failed']);
            return true;
        }

        if ($transactionStatus === 'expire' || $transactionStatus === 'expired') {
            $order->update(['payment_status' => 'expired']);
            return true;
        }

        if ($transactionStatus === 'cancel') {
            $order->update(['payment_status' => 'cancelled']);
            return true;
        }

        return false;
    }

    public function verifySignature(array $data, string $serverKey): bool
    {
        $orderId = $data['order_id'];
        $statusCode = $data['status_code'];
        $grossAmount = $data['gross_amount'];
        $signature = $data['signature_key'];

        $calculatedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        return $calculatedSignature === $signature;
    }
}
