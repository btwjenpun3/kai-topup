<?php

namespace App\Http\Controllers\Public\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.public.home.index', [
            'games' => Game::all()
        ]);
    }
}
