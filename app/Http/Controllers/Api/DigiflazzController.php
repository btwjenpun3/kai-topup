<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Events\TopUpEvent;
use App\Events\TopUpFailEvent;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

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
                    $invoice = Invoice::with(['digiflazz', 'harga'])->where('nomor_invoice', $payload['data']['ref_id'])->first();
                    if ($invoice) {                        
                        $invoice->digiflazz->update([
                            'trx_id' => $payload['data']['trx_id'],
                            'message' => $payload['data']['message'],
                            'sn' => $payload['data']['sn'],
                            'status' => $payload['data']['status']
                        ]);
                        if(isset($invoice->user->id)) {
                            event(new TopUpEvent('Pembelian produk (' . $invoice->harga->nama_produk . ') berhasil! (SN : ' . $payload['data']['sn'] . ')'));
                            if($invoice->user->role_id == 2) {
                                $potongSaldo = $invoice->user->saldo - $invoice->harga->harga_jual_reseller;
                                User::where('id', $invoice->realm_user_id)->update([
                                    'saldo' => $potongSaldo
                                ]); 
                            }   
                        }                                                                    
                        return response()->json(200);
                    }
                } else if ($payload['data']['status'] == 'Pending') {
                    $invoice = Invoice::with('digiflazz')->where('nomor_invoice', $payload['data']['ref_id'])->first();
                    if ($invoice) {
                        $invoice->digiflazz->update([
                            'trx_id' => $payload['data']['trx_id'],
                            'message' => $payload['data']['message'],
                            'status' => $payload['data']['status']
                        ]);
                        return response()->json(200);
                    }
                } else if ($payload['data']['status'] == 'Gagal') {
                    $invoice = Invoice::with(['user', 'digiflazz'])->where('nomor_invoice', $payload['data']['ref_id'])->first();
                    if ($invoice) {
                        $invoice->digiflazz->update([
                            'trx_id' => $payload['data']['trx_id'],
                            'message' => $payload['data']['message'],
                            'status' => $payload['data']['status']
                        ]);
                        if(isset($invoice->user->id)) {
                            $invoice->update([
                                'status' => 'EXPIRED'
                            ]);
                            event(new TopUpFailEvent('Pembelian produk (' . $invoice->harga->nama_produk . ') gagal! Saldo kamu tidak terpotong.'));
                        }                        
                        return response()->json(200);
                    }
                }                
            } 
        } catch (\Exception $e) {
            Log::error('Payload Error:' . $e->getMessage());
        }
    }
}
