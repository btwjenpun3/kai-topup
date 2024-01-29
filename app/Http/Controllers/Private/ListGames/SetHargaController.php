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
use Illuminate\Support\Facades\Http;

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
                'edit_kode_produk' => 'required',
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

    public function import(Request $request)
    {
        try {
            $data = Game::where('id', $request->id)->first();
            if(isset($data)){
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->post('https://api.digiflazz.com/v1/price-list', [
                    'cmd' => 'prepaid',
                    'username' => env('DIGIFLAZZ_USERNAME'),
                    'sign' => md5(env('DIGIFLAZZ_USERNAME') . env('DIGIFLAZZ_SECRET_KEY') . 'pricelist')
                ]);
                if($response->successful()) {
                    $jsonDecode = json_decode($response, true);
                    $produk = Harga::where('game_id', $data->id)->get();
                    foreach ($jsonDecode['data'] as $item) {
                        if ($item['brand'] == $data->brand) {
                            if($produk->contains('kode_produk', $item['buyer_sku_code'])) {
                                Harga::where('kode_produk', $item['buyer_sku_code'])->update([
                                    'game_id' => $data->id,
                                    'nama_produk' => $item['product_name'],
                                    'seller_name' => $item['seller_name'],
                                    'kode_produk' => $item['buyer_sku_code'],
                                    'deskripsi' => $item['desc'],
                                    'modal' => $item['price'],
                                    'start_cut_off' => $item['start_cut_off'],
                                    'end_cut_off' => $item['end_cut_off'],
                                ]);
                            } else {
                                Harga::create([
                                    'game_id' => $data->id,
                                    'nama_produk' => $item['product_name'],
                                    'seller_name' => $item['seller_name'],
                                    'kode_produk' => $item['buyer_sku_code'],
                                    'deskripsi' => $item['desc'],
                                    'gambar' => 'produk/ml-diamond.webp',
                                    'modal' => $item['price'],
                                    'harga_jual' => 0,
                                    'profit' => 0,
                                    'start_cut_off' => $item['start_cut_off'],
                                    'end_cut_off' => $item['end_cut_off'],
                                    'status' => 0
                                ]);
                            }                            
                        }
                    }
                    return response()->json([
                        'success' => 'Produk ' . $data->nama . ' berhasil di Import'
                    ]);
                } else {
                    return response()->json([
                        'error' => 'Terdapat masalah saat import data'
                    ]);
                }
            } else {
                return response()->json([
                    'error' => 'Game tidak ditemukan'
                ]);
            }
        } catch (\Exception $e) {
            Log::channel('product-import')->error('Error occurred: ' . $e->getMessage());            
            return response()->json(['error' => 'Unknown error'], 400);
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
