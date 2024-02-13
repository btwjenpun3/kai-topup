<?php

namespace App\Http\Controllers\Public\Pencarian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;

class PencarianController extends Controller
{
    public function index(Request $request)
    {
        if(isset($request->keyword)) {
            $games = Game::where('nama', 'LIKE', '%' . $request->keyword . '%')->get();
            return view('pages.public.pencarian.index', [
                'keyword' => $request->keyword,
                'games' => $games
            ]);
        } else {
            abort(404);
        }
    }
}
