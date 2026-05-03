<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model {
    protected $fillable = ['buyer_id','seller_id','last_message_at'];
    protected $casts    = ['last_message_at' => 'datetime'];
    public function buyer()    { return $this->belongsTo(User::class, 'buyer_id'); }
    public function seller()   { return $this->belongsTo(User::class, 'seller_id'); }
    public function messages() { return $this->hasMany(Message::class)->orderBy('created_at'); }
    public function lastMessage() { return $this->hasOne(Message::class)->latestOfMany(); }

    public function unreadCountFor(int $userId): int
    {
        return $this->messages()->where('sender_id', '!=', $userId)->where('is_read', false)->count();
    }
}
