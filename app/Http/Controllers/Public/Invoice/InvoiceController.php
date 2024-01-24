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
            $item = $invoice->harga->nama_produk;
            $harga = $invoice->harga->harga_jual;
            $gambar = $invoice->game->url_gambar;
            return view('pages.public.invoice.index', [
                'invoice' => $invoice->nomor_invoice,
                'item' => $item,
                'harga' => $harga,
                'gambar' => $gambar,
                'invoice_url' => $invoice->invoice_url
            ]);
        } catch (\Exception $e) {

        }
    }
}
