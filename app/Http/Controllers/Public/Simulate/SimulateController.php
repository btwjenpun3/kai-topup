<?php

namespace App\Http\Controllers\Public\Simulate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Invoice;

class SimulateController extends Controller
{
    public function simulateVa(Request $request)
    {
        $invoice = Invoice::where('nomor_invoice', $request->id)->first();
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode(env('XENDIT_SECRET_KEY') . ':'),
        ])->post('https://api.xendit.co/callback_virtual_accounts/external_id='.$invoice->nomor_invoice.'/simulate_payment', [
            'amount' => $invoice->total
        ]);
        if($response['status'] == 'COMPLETED') {
            return response()->json([
                'success' => 'Pembayaran Berhasil'
            ]);
        } else {
            return response()->json([
                'failed' => 'asdasd'
            ]);
        }
    }
}
