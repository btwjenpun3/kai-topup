<?php

namespace App\Http\Controllers\Private\Reseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class ResellerSaldoController extends Controller
{
    public function index()
    {
        if(Gate::allows('reseller')) {
            $user = User::find(auth()->id());
            return view('pages.private.reseller.saldo.index', [
                'user' => $user
            ]);
        } else {
            abort(404);
        }
    }     
}
