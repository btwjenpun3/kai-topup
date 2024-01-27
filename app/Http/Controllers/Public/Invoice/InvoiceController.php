<?php

namespace App\Http\Controllers\Public\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\Http;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        try {
            $invoice = Invoice::where('nomor_invoice', $request->id)->first();
            return view('pages.public.invoice.index', [
                'invoice' => $invoice
            ]);
        } catch (\Exception $e) {

        }
    }

    public function statusPembayaran(Request $request)
    {
        try {            
            $data = Invoice::where('nomor_invoice', $request->id)->first();
            if($data->payment_type == 'EWALLET') {
                $response = Http::withHeaders([                    
                    'Authorization' => 'Basic ' . base64_encode(env('XENDIT_SECRET_KEY') . ':'),
                ])->get('https://api.xendit.co/ewallets/charges/' . $data->xendit_invoice_id);
                if($response['status'] == 'SUCCEEDED') {
                    $data->update([
                        'status' => 'PAID'
                    ]);
                }
                return response()->json([
                    'status' => $response['status']
                ]); 
            }  
        } catch (\Exception $e) {

        }
    }
}
