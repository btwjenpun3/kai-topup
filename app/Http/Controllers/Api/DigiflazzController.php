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
            if ($request->header('X-Hub-Signature') == 'sha1=' . $signature) {
                Log::error(json_decode($request->getContent(), true));
            } 
        } catch (\Exception $e) {
            Log::error(json_decode($request->getContent(), true));
        }
    }
}
