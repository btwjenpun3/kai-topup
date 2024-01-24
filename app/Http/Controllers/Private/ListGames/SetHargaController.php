<?php

namespace App\Http\Controllers\Private\ListGames;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Harga;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SetHargaController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.private.list-games.set-harga', [
            'game' => Game::where('id', $request->id)->first(),
            'harga' => Harga::where('game_id', $request->id)->get()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validation = $request->validate([
                'nama_produk' => 'required',
                'kode_produk' => 'required',
                'modal' => 'required|integer',
                'harga_jual' => 'required|integer',
                'gambar' => 'required|unique:hargas,gambar|image|mimes:jpeg,png,jpg,webp|max:2048'
            ]);
            if($validation) {            
                $profit = $request->harga_jual - $request->modal;
                $originalName = $request->file('gambar')->getClientOriginalName();
                $randomName = Str::random(10) . '-' . $originalName;
                $gambarPath = $request->file('gambar')->storeAs('produk', $randomName, 'public');
                Harga::create([
                    'game_id' => $request->id,
                    'nama_produk' => $request->nama_produk,
                    'kode_produk' => $request->kode_produk,
                    'gambar' => $gambarPath,
                    'modal' => $request->modal,
                    'harga_jual' => $request->harga_jual,
                    'profit' => $profit,
                    'status' => 1 
                ]);
                return redirect()->route('harga.index', ['id' => $request->id])->with('produk-berhasil-di-buat', 'Produk ' . $request->nama_produk . ' berhasil di buat.');            
            } else {
                return redirect()->route('harga.index', ['id' => $request->id])->withErrors($validation);
            }
        } catch (\Exception $e) {
            Log::error('Pesan Error: ' . $e->getMessage());
            return redirect()->route('harga.index', ['id' => $request->id])->withErrors($e->getMessage());
        }
    }

    public function show(Request $request)
    {
        try {
            $harga = Harga::where('id', $request->id)->first();
            return response()->json($harga);
        } catch (\Exception $e) {
            Log::error('Pesan Error: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {               
        try {
            $validation = $request->validate([
                'edit_nama_produk' => 'required',
                'edit_kode_produk' => [
                    'required',
                    Rule::unique('hargas', 'kode_produk')->ignore($request->id)
                ],
                'edit_modal' => 'required|integer',
                'edit_harga_jual' => 'required|integer',
                'edit_status' => 'required'
            ]);
            if($validation) {
                $profit = $request->edit_harga_jual - $request->edit_modal;
                Harga::where('id', $request->id)->update([
                    'nama_produk' => $request->edit_nama_produk,
                    'kode_produk' => $request->edit_kode_produk,
                    'modal' => $request->edit_modal,
                    'harga_jual' => $request->edit_harga_jual,
                    'profit' => $profit,
                    'status' => $request->edit_status 
                ]);
                return response()->json([
                    'success' => 'Produk berhasil di update!'
                ], 200);
            } else {
                return response()->json([
                    'error' => 'Gagal di Update'
                ], 422);
            }
        } catch (\Exception $e) {
            Log::error('Pesan Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }        
    }

    public function destroy(Request $request)
    {
        try {
            $getData = Harga::where('id', $request->id)->first();
            Storage::disk('public')->delete($getData->gambar);
            $getData->delete();
            return response()->json([
                'success' => 'Produk berhasil di hapus!'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Pesan Error: ' . $e->getMessage());
        }
    }
}
