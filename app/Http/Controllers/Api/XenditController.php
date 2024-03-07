<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Digiflazz;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Events\TopUpEvent;

class XenditController extends Controller
{ 
    public function handleCallBackEWallet(Request $request)
    {
        try {
            $header = $request->header('x-callback-token');
            if($header == env('XENDIT_CALLBACK_TOKEN')) {
                $response = $request->all();
                if($response['data']['status'] == "SUCCEEDED") {
                    $invoice = Invoice::where('xendit_invoice_id', $response['data']['id'])->first();
                    if(isset($invoice)) {
                        $invoice->update([
                            'status' => 'PAID',
                            'webhook_id' => $request->header('webhook-id')
                        ]);
                        $digiflazz = Http::withHeaders([
                            'Content-Type' => 'application/json',
                        ])->post('https://api.digiflazz.com/v1/transaction', [
                            'username' => env('DIGIFLAZZ_USERNAME'),
                            'buyer_sku_code' => $invoice->harga->kode_produk,
                            'customer_no' => $invoice->customer,
                            'ref_id' => $invoice->nomor_invoice,
                            'sign' => md5(env('DIGIFLAZZ_USERNAME') . env('DIGIFLAZZ_SECRET_KEY') . $invoice->nomor_invoice)
                        ]);
                        if($digiflazz->successful()) {
                            if(isset($digiflazz['data']['wa'])) {
                                $wa = $digiflazz['data']['wa'];
                            } else {
                                $wa = 'Kosong';
                            }
                            if(isset($digiflazz['data']['tele'])) {
                                $tele = $digiflazz['data']['tele'];
                            } else {
                                $tele = 'Kosong';
                            }
                            $updateDigiflazz = Digiflazz::create([
                                'saldo_terakhir' => $digiflazz['data']['buyer_last_saldo'],
                                'saldo_terpotong' => $digiflazz['data']['price'],
                                'message' => $digiflazz['data']['message'],
                                'seller_telegram' => $tele,
                                'seller_whatsapp' => $wa,
                                'status' => $digiflazz['data']['status']
                            ]);
                            $invoice->update([
                                'digiflazz_id' => $updateDigiflazz->id
                            ]);     
                            event(new TopUpEvent('Pembayaran Berhasil', $invoice->nomor_invoice));                        
                            return response()->json(200);
                        } else {
                            Log::channel('digiflazz')->error('Gagal:' . json_decode($digiflazz->getBody()->getContents(), true));
                            return response()->json(200);
                        } 
                    } else {
                        return response()->json([                            
                            'error' => 'Invoice not found'
                        ], 404);
                    }
                } else {
                    return redirect()->route('invoice.index', ['id' => $response['data']['reference_id']])->with(['message' => 'Pembayaran kamu sedang Pending. Harap menunggu beberapa saat dan refresh halaman ini atau hubungi Admin']);
                }
            } else {
                return response()->json([
                    'error' => 'Unauthorized'
                ], 401);
            }
        } catch (\Exception $e) {
            Log::error('Gagal:' . $e->getMessage());
            return response()->json([
                'error' => 'Unknown Error'
            ], 401);
        }
    }

    public function handleCallBackQris(Request $request)
    {
        try {
            $header = $request->header('x-callback-token');
            if($header == env('XENDIT_CALLBACK_TOKEN')) {
                $response = $request->all();
                if($response['data']['status'] == "SUCCEEDED") {
                    $invoice = Invoice::where('xendit_invoice_id', $response['data']['qr_id'])->first();
                    if(isset($invoice)) {
                        $invoice->update([
                            'status' => 'PAID',
                            'webhook_id' => $request->header('webhook-id')
                        ]);
                        $digiflazz = Http::withHeaders([
                            'Content-Type' => 'application/json',
                        ])->post('https://api.digiflazz.com/v1/transaction', [
                            'username' => env('DIGIFLAZZ_USERNAME'),
                            'buyer_sku_code' => $invoice->harga->kode_produk,
                            'customer_no' => $invoice->customer,
                            'ref_id' => $invoice->nomor_invoice,
                            'sign' => md5(env('DIGIFLAZZ_USERNAME') . env('DIGIFLAZZ_SECRET_KEY') . $invoice->nomor_invoice)
                        ]);
                        if($digiflazz->successful()) {
                            if(isset($digiflazz['data']['wa'])) {
                                $wa = $digiflazz['data']['wa'];
                            } else {
                                $wa = 'Kosong';
                            }
                            if(isset($digiflazz['data']['tele'])) {
                                $tele = $digiflazz['data']['tele'];
                            } else {
                                $tele = 'Kosong';
                            }
                            $updateDigiflazz = Digiflazz::create([
                                'saldo_terakhir' => $digiflazz['data']['buyer_last_saldo'],
                                'saldo_terpotong' => $digiflazz['data']['price'],
                                'message' => $digiflazz['data']['message'],
                                'seller_telegram' => $tele,
                                'seller_whatsapp' => $wa,
                                'status' => $digiflazz['data']['status']
                            ]);
                            $invoice->update([
                                'digiflazz_id' => $updateDigiflazz->id
                            ]);   
                            event(new TopUpEvent('Pembayaran Berhasil', $invoice->nomor_invoice));                          
                            return response()->json(200);
                        } else {
                            Log::channel('digiflazz')->error('Gagal:' . json_decode($digiflazz->getBody()->getContents(), true));
                            return response()->json(200);
                        }
                    } else {
                        return response()->json([
                            'error' => 'Invoice not found'
                        ], 404);
                    }
                } else {
                    return redirect()->route('invoice.index', ['id' => $response['data']['reference_id']])->with(['message' => 'Pembayaran kamu sedang Pending. Harap menunggu beberapa saat dan refresh halaman ini atau hubungi Admin']);
                }
            } else {
                return response()->json([
                    'error' => 'Unauthorized'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unknown Error'
            ], 401);
        }
    }

    public function handleCallBackVa(Request $request)
    {
        try {
            $header = $request->header('x-callback-token');
            if($header == env('XENDIT_CALLBACK_TOKEN')) {
                $response = $request->all();
                $invoice = Invoice::where('nomor_invoice', $response['external_id'])->first();
                if(isset($invoice)) {
                    if($response['external_id'] == $invoice->nomor_invoice) {
                        $invoice->update([                            
                            'status' => 'PAID',
                            'webhook_id' => $request->header('webhook-id')
                        ]);
                        $invoice->va()->update([
                            'xendit_va_payment_id' => $response['payment_id'],
                        ]);
                        $digiflazz = Http::withHeaders([
                            'Content-Type' => 'application/json',
                        ])->post('https://api.digiflazz.com/v1/transaction', [
                            'username' => env('DIGIFLAZZ_USERNAME'),
                            'buyer_sku_code' => $invoice->harga->kode_produk,
                            'customer_no' => $invoice->customer,
                            'ref_id' => $invoice->nomor_invoice,
                            'sign' => md5(env('DIGIFLAZZ_USERNAME') . env('DIGIFLAZZ_SECRET_KEY') . $invoice->nomor_invoice)
                        ]);
                        if($digiflazz->successful()) {
                            if(isset($digiflazz['data']['wa'])) {
                                $wa = $digiflazz['data']['wa'];
                            } else {
                                $wa = 'Kosong';
                            }
                            if(isset($digiflazz['data']['tele'])) {
                                $tele = $digiflazz['data']['tele'];
                            } else {
                                $tele = 'Kosong';
                            }
                            $updateDigiflazz = Digiflazz::create([
                                'saldo_terakhir' => $digiflazz['data']['buyer_last_saldo'],
                                'saldo_terpotong' => $digiflazz['data']['price'],
                                'message' => $digiflazz['data']['message'],
                                'seller_telegram' => $tele,
                                'seller_whatsapp' => $wa,
                                'status' => $digiflazz['data']['status']
                            ]);
                            $invoice->update([
                                'digiflazz_id' => $updateDigiflazz->id
                            ]); 
                            event(new TopUpEvent('Pembayaran Berhasil', $invoice->nomor_invoice));                            
                            return response()->json(200);
                        } else {
                            Log::channel('digiflazz')->error('Gagal:' . json_decode($digiflazz->getBody()->getContents(), true));
                            return response()->json(200);
                        }
                    } else {
                        return response()->json([
                            'error' => 'Invoice not match'
                        ], 401);
                    }
                } else {
                    return response()->json([
                        'error' => 'Invoice not found'
                    ], 404);
                }                
            } else {
                return response()->json([
                    'error' => 'Unauthorized'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unknown Error'
            ], 401);
        }
    }

    public function handleCallBackOutlet(Request $request)
    {
        try {
            $header = $request->header('x-callback-token');
            if($header == env('XENDIT_CALLBACK_TOKEN')) {
                $response = $request->all();
                $invoice = Invoice::where('nomor_invoice', $response['external_id'])->first();
                if(isset($invoice)) {
                    if($response['status'] == 'COMPLETED') {
                        $invoice->update([                            
                            'status' => 'PAID',
                            'webhook_id' => $request->header('webhook-id')
                        ]);
                        $invoice->outlet()->update([
                            'payment_id' => $response['payment_id'],
                            'fixed_payment_code_payment_id' => $response['fixed_payment_code_payment_id'],
                            'fixed_payment_code_id' => $response['fixed_payment_code_id']                            
                        ]);
                        $digiflazz = Http::withHeaders([
                            'Content-Type' => 'application/json',
                        ])->post('https://api.digiflazz.com/v1/transaction', [
                            'username' => env('DIGIFLAZZ_USERNAME'),
                            'buyer_sku_code' => $invoice->harga->kode_produk,
                            'customer_no' => $invoice->customer,
                            'ref_id' => $invoice->nomor_invoice,
                            'sign' => md5(env('DIGIFLAZZ_USERNAME') . env('DIGIFLAZZ_SECRET_KEY') . $invoice->nomor_invoice)
                        ]);
                        if($digiflazz->successful()) {   
                            if(isset($digiflazz['data']['wa'])) {
                                $wa = $digiflazz['data']['wa'];
                            } else {
                                $wa = 'Kosong';
                            }
                            if(isset($digiflazz['data']['tele'])) {
                                $tele = $digiflazz['data']['tele'];
                            } else {
                                $tele = 'Kosong';
                            }                         
                            $updateDigiflazz = Digiflazz::create([
                                'saldo_terakhir' => $digiflazz['data']['buyer_last_saldo'],
                                'saldo_terpotong' => $digiflazz['data']['price'],
                                'message' => $digiflazz['data']['message'],
                                'seller_telegram' => $tele,
                                'seller_whatsapp' => $wa,
                                'status' => $digiflazz['data']['status']
                            ]);
                            $invoice->update([
                                'digiflazz_id' => $updateDigiflazz->id
                            ]);    
                            event(new TopUpEvent('Pembayaran Berhasil', $invoice->nomor_invoice));                         
                            return response()->json(200);
                        } else {
                            Log::channel('digiflazz')->error('Gagal:' . json_decode($digiflazz->getBody()->getContents(), true));
                            return response()->json(200);
                        }
                    } else {
                        return response()->json([
                            'error' => 'Invoice not match'
                        ], 401);
                    }
                } else {
                    return response()->json([
                        'error' => 'Invoice not found'
                    ], 404);
                }                
            } else {
                return response()->json([
                    'error' => 'Unauthorized'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unknown Error'
            ], 401);
        }
    }
}
