<?php

namespace App\Http\Controllers\Public\Harga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Http\Controllers\Global\GlobalController;

class HargaController extends Controller
{
    public function index()
    {
        $formatHarga = new GlobalController();
        $games = Game::with('harga')->orderBy('nama', 'asc')->get();
        return view('pages.public.harga.index', [
            'games' => $games,
            'formatHarga' => $formatHarga
        ]);
    }
}
