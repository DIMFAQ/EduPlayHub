<?php
// app/Models/Shop.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['user_id','name','description','logo','city','rating','total_sales','balance'];

    public function user()    { return $this->belongsTo(User::class); }
    public function products(){ return $this->hasMany(Product::class); }
    public function orders()  { return $this->hasMany(Order::class); }

    public function fmtBalance(): string
    {
        return 'Rp ' . number_format($this->balance, 0, ',', '.');
    }
}
