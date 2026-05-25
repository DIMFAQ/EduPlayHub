<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $order_number
 * @property string|null $order_code
 * @property int $user_id
 * @property int $shop_id
 * @property string $type
 * @property string $status
 * @property string $payment_status
 * @property string|null $midtrans_order_id
 * @property string|null $midtrans_token
 * @property string $recipient_name
 * @property string $address
 * @property string $city
 * @property string $postal_code
 * @property string $phone
 * @property string $payment_method
 * @property float $subtotal
 * @property float $shipping_cost
 * @property float $discount
 * @property float $total
 * @property string|null $voucher_code
 * @property \Illuminate\Support\Carbon|null $rental_start
 * @property \Illuminate\Support\Carbon|null $rental_end
 * @property int|null $rental_days
 */
class Order extends Model {
    protected $fillable = [
        'order_number','user_id','shop_id','type','status',
        'recipient_name','address','city','postal_code','phone',
        'payment_method','subtotal','shipping_cost','discount','total',
        'voucher_code','rental_start','rental_end','rental_days',
        'midtrans_order_id','midtrans_token','payment_status','order_code',
    ];
    protected $casts = [
        'rental_start' => 'date',
        'rental_end'   => 'date',
    ];

    public function user()  { return $this->belongsTo(User::class); }
    public function shop()  { return $this->belongsTo(Shop::class); }
    public function items() { return $this->hasMany(OrderItem::class); }

    public function statusLabel(): string
    {
        return match($this->status) {
            'masuk'      => 'Pesanan Masuk',
            'proses'     => 'Diproses',
            'kirim'      => 'Dikirim',
            'selesai'    => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default      => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match($this->status) {
            'masuk'      => 'red',
            'proses'     => 'blue',
            'kirim'      => 'sky',
            'selesai'    => 'green',
            'dibatalkan' => 'gray',
            default      => 'blue',
        };
    }

    public function fmtTotal(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }
}
