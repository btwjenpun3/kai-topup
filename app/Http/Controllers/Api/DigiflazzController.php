<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\Log;

class DigiflazzController extends Controller
{
    public function handleCallBack(Request $request)
    {
        try {
            $secret = env('DIGIFLAZZ_WEBHOOK_SECRET'); 
            $payload = json_decode($request->getContent(), true);                       
            $signature = hash_hmac('sha1', $request->getContent(), $secret);
            if ($request->header('X-Hub-Signature') == 'sha1=' . $signature) {
                if($payload['data']['status'] == 'Sukses') {
                    $invoice = Invoice::with('digiflazz')->where('nomor_invoice', $payload['data']['ref_id'])->first();
                    if ($invoice) {
                        $invoice->digiflazz->update([
                            'trx_id' => $payload['data']['trx_id'],
                            'message' => $payload['data']['message'],
                            'status' => $payload['data']['status']
                        ]);
                    }
                } else if ($payload['data']['status'] == 'Pending') {
                    $invoice = Invoice::with('digiflazz')->where('nomor_invoice', $payload['data']['ref_id'])->first();
                    if ($invoice) {
                        $invoice->digiflazz->update([
                            'trx_id' => $payload['data']['trx_id'],
                            'message' => $payload['data']['message'],
                            'status' => $payload['data']['status']
                        ]);
                    }
                } else if ($payload['data']['status'] == 'Gagal') {
                    $invoice = Invoice::with('digiflazz')->where('nomor_invoice', $payload['data']['ref_id'])->first();
                    if ($invoice) {
                        $invoice->digiflazz->update([
                            'trx_id' => $payload['data']['trx_id'],
                            'message' => $payload['data']['message'],
                            'status' => $payload['data']['status']
                        ]);
                    }
                }                
            } 
        } catch (\Exception $e) {
            Log::error('Payload Error:' . $e->getMessage());
        }
    }
}
