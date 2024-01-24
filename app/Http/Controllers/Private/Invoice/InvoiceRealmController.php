<?php

namespace App\Http\Controllers\Private\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceRealmController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        return view('pages.private.invoice.index', [
            'invoices' => $invoices,
        ]);
    }
}
