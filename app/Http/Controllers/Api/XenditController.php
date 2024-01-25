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
                if($response) {
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
                if($response) {
                    $invoice = Invoice::where('xendit_invoice_id', $response['id'])->first();
                    if($invoice) {
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
                    return redirect()->route('invoice.index', ['id' => $response['id']])->with('message', 'Pembayaran sedang Pending, harap tunggu sesaat atau hubungi Admin');
                }
            } else {
                return response()->json([
                    'error' => 'Unauthorized'
                ], 401);
            }
        } catch (\Exception $e) {

        }
    }
}
