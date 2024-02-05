<?php

namespace App\Http\Controllers\Private\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceRealmController extends Controller
{
    public function index()
    {
        $invoices = Invoice::orderBy('id', 'desc')->where('via', 'WEB')->paginate(10);
        return view('pages.private.invoice.index', [
            'invoices' => $invoices,
        ]);
    }

    public function reseller(Request $request)
    {
        if(auth()->user()->role->admin) {
            $invoices = Invoice::orderBy('id', 'desc')->where('via', 'REALM')->paginate(10);
        } else {
            $invoices = Invoice::orderBy('id', 'desc')->where('via', 'REALM')->where('realm_user_id', $request->id)->paginate(10);
        }        
        return view('pages.private.invoice.index', [
            'invoices' => $invoices,
        ]);
    }

    public function show(Request $request) {
        $invoices = Invoice::with(['game', 'harga', 'payment'])->where('nomor_invoice', $request->id)->first();
        return response()->json($invoices);
    }
}
