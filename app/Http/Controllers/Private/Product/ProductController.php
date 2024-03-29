<?php

namespace App\Http\Controllers\Private\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function index()
    {
        if(Gate::allows('admin')) { 
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://api.digiflazz.com/v1/price-list', [
                'cmd' => 'prepaid',
                'username' => env('DIGIFLAZZ_USERNAME'),
                'sign' => md5(env('DIGIFLAZZ_USERNAME') . env('DIGIFLAZZ_SECRET_KEY') . 'pricelist')
            ]);
            return view('pages.private.product.index', [
                'product' => $response
            ]);
        } else {
            abort(404);
        }
    }
}
