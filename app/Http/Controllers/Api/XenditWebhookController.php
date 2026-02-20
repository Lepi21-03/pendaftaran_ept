<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class XenditWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Ambil callback token dari header request
        $webhookToken = $request->header('x-callback-token');
        
        // Verifikasi token dengan yang ada di .env
        $myToken = env('XENDIT_CALLBACK_TOKEN');

        if ($webhookToken !== $myToken) {
            return response()->json(['message' => 'Invalid token'], 403);
        }

        // Ambil data pembayaran
        $data = $request->all();
        
        // Log data untuk debugging (opsional, bisa dihapus nanti)
        Log::info('Xendit Webhook Received:', $data);

        // TODO: Implementasikan update status pembayaran di database Anda di sini
        // Contoh:
        // $externalId = $data['external_id'];
        // $status = $data['status'];
        // if ($status === 'PAID') { ... }

        return response()->json(['message' => 'Success'], 200);
    }
}
