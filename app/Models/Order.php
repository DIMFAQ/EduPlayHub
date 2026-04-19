<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'user_id',
        'total_price',
        'status',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itemPesanan()
    {
        return $this->hasMany(OrderItem::class, 'pesanan_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Payment::class, 'pesanan_id');
    }
}

