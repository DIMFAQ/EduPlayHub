<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function handleCallback(Request $request)
    {
        $data = $request->all();

        if (!$this->midtransService->verifySignature($data, config('services.midtrans.server_key'))) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $this->midtransService->handleCallback($data);

        return response()->json(['message' => 'OK']);
    }
}
