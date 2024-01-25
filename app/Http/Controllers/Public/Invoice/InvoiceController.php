<?php

namespace App\Http\Controllers\Public\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        try {
            $invoice = Invoice::where('nomor_invoice', $request->id)->first();
            return view('pages.public.invoice.index', [
                'invoice' => $invoice->nomor_invoice,
                'item' => $invoice->harga->nama_produk,
                'total' => $invoice->total,
                'gambar' => $invoice->game->url_gambar,
                'invoice_url' => $invoice->xendit_invoice_url,
                'status' => $invoice->status
            ]);
        } catch (\Exception $e) {

        }
    }
}
