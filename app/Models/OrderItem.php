<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {
    protected $fillable = ['order_id','product_id','product_name','variant','product_image','quantity','unit_price'];
    public function order()  { return $this->belongsTo(Order::class); }
    public function product(){ return $this->belongsTo(Product::class); }
    public function subtotal(): float { return $this->unit_price * $this->quantity; }
    public function fmtPrice(): string { return 'Rp ' . number_format($this->unit_price, 0, ',', '.'); }
}
