<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DigiflazzController extends Controller
{
    public function handleCallBack(Request $request)
    {
        try {
            $secret = env('DIGIFLAZZ_WEBHOOK_SECRET'); 
            $payload = $request->getContent();                       
            $signature = hash_hmac('sha1', $payload, $secret);
            Log::error($signature);
            if ($request->header('X-Hub-Signature') == 'sha1=' . $signature) {
                Log::error('Payload Berhasil:' . json_decode($request->getContent(), true));
            } else {
                Log::error('Payload Gagal:' . json_decode($request->getContent(), true));
            }
        } catch (\Exception $e) {
            Log::error('Payload Error:' . $e->getMessage());
        }
    }
}
