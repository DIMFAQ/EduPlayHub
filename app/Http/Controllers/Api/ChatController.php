<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function listRooms(Request $request)
    {
        $rooms = Conversation::where('buyer_id', $request->user()->id)
            ->orWhere('seller_id', $request->user()->id)
            ->with(['product'])
            ->latest('last_message_at')
            ->paginate(20);

        return response()->json([
            'data' => $rooms->items(),
            'meta' => [
                'current_page' => $rooms->currentPage(),
                'last_page' => $rooms->lastPage(),
                'per_page' => $rooms->perPage(),
                'total' => $rooms->total(),
            ],
        ]);
    }

    public function createRoom(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'message' => 'sometimes|string|max:500',
        ]);

        $product = \App\Models\Product::findOrFail($validated['product_id']);

        $room = Conversation::where('buyer_id', $request->user()->id)
            ->where('product_id', $validated['product_id'])
            ->first();

        if (!$room) {
            $room = Conversation::create([
                'buyer_id' => $request->user()->id,
                'seller_id' => $product->shop->user_id,
                'product_id' => $validated['product_id'],
                'status' => 'open',
            ]);
        }

        if ($validated['message'] ?? null) {
            Message::create([
                'conversation_id' => $room->id,
                'sender_id' => $request->user()->id,
                'body' => $validated['message'],
            ]);

            broadcast(new MessageSent($room, $request->user()));
        }

        return response()->json([
            'message' => 'Room created/opened successfully',
            'room_id' => $room->id,
        ], 201);
    }

    public function getMessages($roomId, Request $request)
    {
        $room = Conversation::findOrFail($roomId);

        $this->authorize('view', $room);

        $messages = Message::where('conversation_id', $roomId)
            ->with('sender')
            ->latest()
            ->paginate(30);

        return response()->json([
            'data' => $messages->items(),
            'meta' => [
                'current_page' => $messages->currentPage(),
                'last_page' => $messages->lastPage(),
                'per_page' => $messages->perPage(),
                'total' => $messages->total(),
            ],
        ]);
    }

    public function sendMessage($roomId, Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'type' => 'sometimes|in:text,image,file',
        ]);

        $room = Conversation::findOrFail($roomId);

        $this->authorize('send', $room);

        $message = Message::create([
            'conversation_id' => $roomId,
            'sender_id' => $request->user()->id,
            'body' => $validated['message'],
            'type' => $validated['type'] ?? 'text',
        ]);

        $room->update(['last_message_at' => now()]);

        broadcast(new MessageSent($room, $request->user(), $message));

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $message,
        ], 201);
    }

    public function markRead($roomId, Request $request)
    {
        $room = Conversation::findOrFail($roomId);

        $this->authorize('view', $room);

        Message::where('conversation_id', $roomId)
            ->where('sender_id', '!=', $request->user()->id)
            ->update(['is_read' => true]);

        return response()->json([
            'message' => 'Messages marked as read',
        ]);
    }

    public function uploadAttachment($roomId, Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|max:5120',
        ]);

        $room = Conversation::findOrFail($roomId);

        $this->authorize('send', $room);

        $path = $request->file('file')->store('chat-attachments', 'public');

        $message = Message::create([
            'conversation_id' => $roomId,
            'sender_id' => $request->user()->id,
            'body' => $path,
            'type' => 'file',
            'attachment_url' => asset('storage/' . $path),
        ]);

        return response()->json([
            'message' => 'File uploaded successfully',
            'data' => $message,
        ], 201);
    }
}
