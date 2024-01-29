<?php

namespace App\Http\Controllers\Private\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardContoller extends Controller
{
    public function index()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://api.digiflazz.com/v1/cek-saldo', [
            'cmd' => 'deposit',
            'username' => env('DIGIFLAZZ_USERNAME'),
            'sign' => md5(env('DIGIFLAZZ_USERNAME') . env('DIGIFLAZZ_SECRET_KEY') . 'depo')
        ]);
        if($response->successful()) {
            $saldo = $response['data']['deposit'];
        } else {
            $saldo = 'Error';
        }
        return view('pages.private.dashboard.index', [
            'saldo' => $saldo
        ]);
    }
}
