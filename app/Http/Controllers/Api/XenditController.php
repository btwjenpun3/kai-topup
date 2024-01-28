<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class XenditController extends Controller
{
    public function handleCallBack(Request $request) 
    {
        try {
            $header = $request->header('x-callback-token');
            if($header == env('XENDIT_CALLBACK_TOKEN')) {
                $response = $request->all();
                if($response['data']['hehe']) {
                    $invoice = Invoice::where('xendit_invoice_id', $response['id'])->first();
                    if(isset($invoice)) {
                        $invoice->update([
                            'status' => 'PAID'
                        ]);
                        return response()->json([
                            'success' => 'Invoice' . $response['id'] . ' successfully paid'
                        ], 200);
                    } else {
                        return response()->json([
                            'error' => 'Invoice not found'
                        ], 401);
                    }
                } else {
                    return response()->json([
                        'error' => 'Data Empty'
                    ], 401);
                }
            } else {
                return response()->json([
                    'error' => 'Unauthorized'
                ], 401);
            }
        } catch (\Exception $e) {

        }
    }

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
                            'status' => 'PAID'
                        ]);
                        return response()->json([
                            'success' => 'Invoice' . $response['id'] . ' successfully paid'
                        ], 200);
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
                            'status' => 'PAID'
                        ]);
                        return response()->json([
                            'success' => 'Invoice' . $response['data']['reference_id'] . ' successfully paid'
                        ], 200);
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
                            'xendit_va_payment_id' => $response['payment_id'],
                            'status' => 'PAID',
                            'webhook_id' => $request->header('webhook-id')
                        ]);
                        return response()->json([
                            'success' => 'Invoice' . $response['data']['reference_id'] . ' successfully paid'
                        ], 200);
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
