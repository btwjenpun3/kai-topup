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
            'games' => Game::all()
        ]);
    }
}
