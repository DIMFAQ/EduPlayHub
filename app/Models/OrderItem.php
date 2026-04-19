<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'item_pesanan';

    protected $fillable = [
        'pesanan_id',
        'produk_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Order::class, 'pesanan_id');
    }

    public function produk()
    {
        return $this->belongsTo(Product::class, 'produk_id');
    }
}

