<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /** Buyer: list of conversations */
    public function buyerIndex()
    {
        $conversations = Conversation::where('buyer_id', Auth::id())
            ->with(['seller', 'lastMessage'])
            ->orderByDesc('last_message_at')
            ->get();

        $cartCount = Auth::user()->cartCount();
        return view('buyer.chat_list', compact('conversations', 'cartCount'));
    }

    /** Contact / Find seller page */
    public function contactPage()
    {
        $sellers   = User::where('role', 'seller')->with('shop')->get();
        $cartCount = Auth::user()->cartCount();
        return view('buyer.contact_chat', compact('sellers', 'cartCount'));
    }

    /** Open or create conversation with a user */
    public function conversation(User $user)
    {
        $me = Auth::user();

        // Determine buyer/seller roles
        [$buyerId, $sellerId] = $me->role === 'buyer'
            ? [$me->id, $user->id]
            : [$user->id, $me->id];

        $conversation = Conversation::firstOrCreate(
            ['buyer_id' => $buyerId, 'seller_id' => $sellerId],
        );

        // Mark messages as read
        $conversation->messages()
            ->where('sender_id', '!=', $me->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $conversation->load(['messages.sender', 'buyer', 'seller']);

        $otherUser = $me->id === $buyerId ? $conversation->seller : $conversation->buyer;
        $cartCount = $me->cartCount();

        return view('buyer.chat_room', compact('conversation', 'otherUser', 'cartCount'));
    }

    public function sendMessage(Request $request, User $user)
    {
        $request->validate(['body' => 'required|string|max:2000']);
        $me = Auth::user();

        [$buyerId, $sellerId] = $me->role === 'buyer'
            ? [$me->id, $user->id]
            : [$user->id, $me->id];

        $conversation = Conversation::firstOrCreate(['buyer_id' => $buyerId, 'seller_id' => $sellerId]);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $me->id,
            'body'            => $request->body,
        ]);

        $conversation->update(['last_message_at' => now()]);

        if ($request->ajax()) {
            return response()->json([
                'id'         => $message->id,
                'body'       => $message->body,
                'sender_id'  => $message->sender_id,
                'created_at' => $message->created_at->format('H:i'),
            ]);
        }

        return back();
    }

    public function getMessages(User $user)
    {
        $me = Auth::user();
        [$buyerId, $sellerId] = $me->role === 'buyer'
            ? [$me->id, $user->id]
            : [$user->id, $me->id];

        $conversation = Conversation::where('buyer_id', $buyerId)->where('seller_id', $sellerId)->first();
        if (!$conversation) return response()->json([]);

        $messages = $conversation->messages()->with('sender')->get()->map(fn($m) => [
            'id'         => $m->id,
            'body'       => $m->body,
            'sender_id'  => $m->sender_id,
            'sender'     => $m->sender->name,
            'created_at' => $m->created_at->format('H:i'),
            'mine'       => $m->sender_id === $me->id,
        ]);

        return response()->json($messages);
    }

    /** Seller: list of conversations */
    public function sellerIndex()
    {
        $conversations = Conversation::where('seller_id', Auth::id())
            ->with(['buyer', 'lastMessage'])
            ->orderByDesc('last_message_at')
            ->get();

        return view('seller.chat', compact('conversations'));
    }
}
