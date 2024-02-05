<?php

namespace App\Http\Controllers\Private\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Digiflazz;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TransactionController extends Controller
{
    public function index()
    {
        if(Gate::allows('admin')) { 
            $data = Invoice::with('digiflazz')->orderBy('id', 'desc')->paginate(10);
            $transactions = Digiflazz::get();
            return view('pages.private.transaksi.index', [
                'datas' => $data,
                'transactions' => $transactions
            ]);
        } else {
            abort(404);
        }
    }
}
