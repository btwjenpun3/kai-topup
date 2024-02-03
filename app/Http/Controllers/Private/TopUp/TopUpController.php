<?php

namespace App\Http\Controllers\Private\TopUp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Harga;

class TopUpController extends Controller
{
    public function indexMobileLegend(Request $request)
    {
        return view('pages.private.topup.index');
    }
}
