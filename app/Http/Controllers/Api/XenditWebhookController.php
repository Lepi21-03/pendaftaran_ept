<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PembayaranService;

class XenditWebhookController extends Controller
{
    protected $pembayaranService;

    public function __construct(PembayaranService $pembayaranService)
    {
        $this->pembayaranService = $pembayaranService;
    }

    public function handle(Request $request)
    {
        try {
            $this->pembayaranService->handleWebhook(
                (string)$request->header('x-callback-token'), 
                $request->all()
            );
            return response()->json(['message' => 'Success'], 200);
        } catch (\Exception $e) {
            $status = $e->getCode();
            $statusCode = is_numeric($status) && $status >= 400 && $status < 600 ? $status : 500;
            return response()->json(['message' => $e->getMessage()], $statusCode);
        }
    }
}
