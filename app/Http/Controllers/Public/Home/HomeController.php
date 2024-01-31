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
        $flashsales = Flashsale::where('status', '1')->where('stock', '>', '0')->get();
        dd($flashsales);
        return view('pages.public.home.index', [
            'flashsales' => $flashsales,
            'games' => Game::all()
        ]);
    }
}
