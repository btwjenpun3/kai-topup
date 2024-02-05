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
            'harga' => Harga::orderBy('kode_produk', 'asc')->where('game_id', $request->id)->paginate(10)
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
                'edit_tipe' => 'required',
                'edit_kode_produk' => 'required',
                'edit_modal' => 'required|integer',
                'edit_harga_jual' => 'required|integer',
                'edit_harga_jual_reseller' => 'required|integer',
                'edit_status' => 'required'
            ]);
            if($validation) {
                $profit = $request->edit_harga_jual - $request->edit_modal;   
                $profitReseller = $request->edit_harga_jual_reseller - $request->edit_modal;               
                Harga::where('id', $request->id)->update([
                    'nama_produk' => $request->edit_nama_produk,
                    'tipe' => $request->edit_tipe,
                    'kode_produk' => $request->edit_kode_produk,
                    'modal' => $request->edit_modal,
                    'harga_jual' => $request->edit_harga_jual,
                    'harga_jual_reseller' => $request->edit_harga_jual_reseller,
                    'profit' => $profit,
                    'profit_reseller' => $profitReseller,
                    'status' => $request->edit_status 
                ]);
                if ($request->hasFile('edit_gambar')) {
                    $gambarPath = $request->file('edit_gambar')->storeAs('produk', Str::random(4) . '-' . $request->file('edit_gambar')->getClientOriginalName(), 'public');
                    Harga::where('id', $request->id)->update([
                        'gambar' => $gambarPath 
                    ]);
                }
                return response()->json([
                    'success' => 'Produk berhasil di update!'
                ], 200);
            }
        } catch (\Exception $e) {
            Log::error('Pesan Error: ' . $e->getMessage());
            return response()->json(['failed' => $e->getMessage()], 500);
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
                            if($produk->contains('kode_produk', $item['buyer_sku_code']) && $item['buyer_product_status'] === true && $item['seller_product_status'] === true) {
                                Harga::where('kode_produk', $item['buyer_sku_code'])->update([
                                    'game_id' => $data->id,                                   
                                    'seller_name' => $item['seller_name'],
                                    'kode_produk' => $item['buyer_sku_code'],
                                    'deskripsi' => $item['desc'],
                                    'modal' => $item['price'],
                                    'start_cut_off' => $item['start_cut_off'],
                                    'end_cut_off' => $item['end_cut_off'],
                                    'status' => 1
                                ]);
                            } else if ($produk->contains('kode_produk', $item['buyer_sku_code']) && $item['buyer_product_status'] === true && $item['seller_product_status'] === false) {
                                Harga::where('kode_produk', $item['buyer_sku_code'])->update([
                                    'game_id' => $data->id,                                   
                                    'seller_name' => $item['seller_name'],
                                    'kode_produk' => $item['buyer_sku_code'],
                                    'deskripsi' => $item['desc'],
                                    'modal' => $item['price'],
                                    'start_cut_off' => $item['start_cut_off'],
                                    'end_cut_off' => $item['end_cut_off'],
                                    'status' => 3
                                ]);
                            } else if ($produk->contains('kode_produk', $item['buyer_sku_code']) && $item['buyer_product_status'] === false && $item['seller_product_status'] === true) {
                                Harga::where('kode_produk', $item['buyer_sku_code'])->update([
                                    'game_id' => $data->id,                                   
                                    'seller_name' => $item['seller_name'],
                                    'kode_produk' => $item['buyer_sku_code'],
                                    'deskripsi' => $item['desc'],
                                    'modal' => $item['price'],
                                    'start_cut_off' => $item['start_cut_off'],
                                    'end_cut_off' => $item['end_cut_off'],
                                    'status' => 0
                                ]);
                            } else if ($produk->contains('kode_produk', $item['buyer_sku_code']) && $item['buyer_product_status'] === false && $item['seller_product_status'] === false) {
                                Harga::where('kode_produk', $item['buyer_sku_code'])->update([
                                    'game_id' => $data->id,                                   
                                    'seller_name' => $item['seller_name'],
                                    'kode_produk' => $item['buyer_sku_code'],
                                    'deskripsi' => $item['desc'],
                                    'modal' => $item['price'],
                                    'start_cut_off' => $item['start_cut_off'],
                                    'end_cut_off' => $item['end_cut_off'],
                                    'status' => 3
                                ]);
                            } else {
                                Harga::create([
                                    'game_id' => $data->id,
                                    'nama_produk' => $item['product_name'],
                                    'tipe' => $item['type'],
                                    'seller_name' => $item['seller_name'],
                                    'kode_produk' => $item['buyer_sku_code'],
                                    'deskripsi' => $item['desc'],
                                    'gambar' => 'produk/ml-diamond.webp',
                                    'modal' => $item['price'],
                                    'harga_jual' => 0,
                                    'profit' => 0,
                                    'start_cut_off' => $item['start_cut_off'],
                                    'end_cut_off' => $item['end_cut_off'],
                                    'status' => 1
                                ]);
                            }                            
                        }
                    }
                    return response()->json([
                        'success' => 'Produk ' . $data->nama . ' berhasil di Import'
                    ]);
                } else {
                    return response()->json([
                        'unaccepted' => 'Terdapat masalah saat import data'
                    ]);
                }
            } else {
                return response()->json([
                    'unaccepted' => 'Game tidak ditemukan'
                ]);
            }
        } catch (\Exception $e) {
            Log::channel('product-import')->error('Error occurred: ' . $e->getMessage());            
            return response()->json(['unaccepted' => 'Unknown error'], 400);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $getData = Harga::where('id', $request->id)->first();            
            $delete = $getData->delete();
            if($delete) {
                Storage::disk('public')->delete($getData->gambar);
                return response()->json([
                    'success' => 'Produk berhasil di hapus!'
                ], 200);
            }            
        } catch (\Exception $e) {
            Log::error('Pesan Error: ' . $e->getMessage());
        }
    }
}
