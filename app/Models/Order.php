<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = [
        'order_number','user_id','shop_id','type','status',
        'recipient_name','address','city','postal_code','phone',
        'payment_method','subtotal','shipping_cost','discount','total',
        'voucher_code','rental_start','rental_end','rental_days',
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
