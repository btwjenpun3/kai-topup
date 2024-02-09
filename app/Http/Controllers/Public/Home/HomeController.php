<?php

namespace App\Http\Controllers\Public\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Flashsale;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $now =  Carbon::now()->format('Y-m-d H:i:s');
        $flashsales = Flashsale::where('status', '1')->where('expired_at', '>', $now)->where('stock', '>', '0')->get();
        return view('pages.public.home.index', [
            'flashsales' => $flashsales,
            'games' => Game::where('kategori', 'Games')->orderBy('nama', 'asc')->where('status', 1)->get(),
            'listriks' => Game::where('kategori', 'Listrik')->get(),
            'vouchers' => Game::where('kategori', 'Voucher')->get(),
            'pulsas' => Game::where('kategori', 'Pulsa')->get()
        ]);
    }
}
