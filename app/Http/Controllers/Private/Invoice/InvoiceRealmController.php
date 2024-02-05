<?php

namespace App\Http\Controllers\Private\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\Gate;

class InvoiceRealmController extends Controller
{
    public function index()
    {
        if(Gate::allows('admin')) {
            $invoices = Invoice::orderBy('id', 'desc')->where('via', 'WEB')->paginate(10);
            return view('pages.private.invoice.web.index', [
                'invoices' => $invoices,
            ]);
        } else {
            abort(404);
        }
    }

    public function reseller()
    {        
        $invoices = Invoice::orderBy('id', 'desc')->where('via', 'REALM')->where('realm_user_id', auth()->id())->paginate(10);             
        return view('pages.private.invoice.reseller.index', [
            'invoices' => $invoices,
        ]);
    }

    public function admin()
    {      
        if(Gate::allows('admin')) {
            $invoices = Invoice::with('user')->orderBy('id', 'desc')->where('via', 'REALM')->paginate(10);             
            return view('pages.private.invoice.admin.index', [
                'invoices' => $invoices,
            ]);
        } else {
            abort(404);
        } 
    }

    public function show(Request $request) {
        $invoices = Invoice::with(['game', 'harga', 'payment'])->where('nomor_invoice', $request->id)->first();
        return response()->json($invoices);
    }
}
