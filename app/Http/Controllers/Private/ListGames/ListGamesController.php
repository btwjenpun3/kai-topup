<?php

namespace App\Http\Controllers\Private\ListGames;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Gate;

class ListGamesController extends Controller
{
    public function index()
    {
        if(Gate::allows('admin')) {
            return view('pages.private.list-games.index', [
                'games' => Game::orderBy('nama', 'asc')->where('slug', '!=', 'undawn-all-bind')->get()
            ]);
        } else {
            abort(404);
        }        
    }

    public function store(Request $request)
    {
        if(Gate::allows('admin')) {
            $validation = $request->validate([
                'nama' => 'required',
                'kode' => 'required|unique:games,kode',
                'gambar' => 'required|unique:games,url_gambar|image|mimes:jpeg,png,jpg,webp|max:2048'
            ]);
            if($validation) {
                try {
                    $gambarPath = $request->file('gambar')->storeAs('games', $request->file('gambar')->getClientOriginalName(), 'public');
                    Game::create([
                        'nama' => $request->nama,
                        'kode' => $request->kode,
                        'url_gambar' => $gambarPath,
                        'slug' => Str::slug($request->nama)
                    ]);
                    return redirect()->route('games.index')->with('game-berhasil-di-buat', 'Game ' . $request->nama . ' berhasil di tambahkan.');
                } catch(\Exception $e) {
                    
                }
            } else {
                return redirect()->route('games.index')->withErrors($validation);
            }
        } else {
            abort(500);
        }
    }
}
