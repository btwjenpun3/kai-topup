<?php

namespace App\Http\Controllers\Private\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $data = Payment::get();
        return view('pages.private.payment.index', [
            'datas' => $data
        ]);
    }
}
