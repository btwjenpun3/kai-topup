<?php

namespace App\Http\Controllers\Private\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Digiflazz;
use App\Models\Invoice;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $data = Invoice::all();
        return view('pages.private.transaksi.index', [
            'datas' => $data
        ]);
    }
}
