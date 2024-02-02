<?php

namespace App\Http\Controllers\Private\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceRealmController extends Controller
{
    public function index()
    {
        $invoices = Invoice::orderBy('id', 'desc')->paginate(10);
        return view('pages.private.invoice.index', [
            'invoices' => $invoices,
        ]);
    }

    public function show(Request $request) {
        $invoices = Invoice::with(['game', 'harga', 'payment'])->where('nomor_invoice', $request->id)->first();
        return response()->json($invoices);
    }
}
