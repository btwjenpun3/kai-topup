<?php

namespace App\Http\Controllers\Private\Flashsale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Flashsale;
use App\Models\Harga;
use Illuminate\Support\Facades\Gate;

class FlashsaleController extends Controller
{
    public function index()
    {
        if(Gate::allows('admin')) {
            $hargas = Harga::all();
            $flashsales = Flashsale::all();
            return view('pages.private.flashsale.index', [
                'hargas' => $hargas,
                'flashsales' => $flashsales
            ]);
        } else {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validation = $request->validate([
                'harga_id' => 'required',
                'discount' => 'required|integer',
                'final_price' => 'required|integer',
                'profit' => 'required|integer',
                'stock' => 'required|integer'
            ]);
            if($validation) {
                Flashsale::create([
                    'harga_id' => $request->harga_id,
                    'discount' => $request->discount,
                    'final_price' => $request->final_price,
                    'profit' => $request->profit,
                    'stock' => $request->stock,
                    'status' => 1
                ]);
                return response()->json([
                    'success' => 'Flashsale berhasil di tambah'
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }        
    }

    public function storeExpired(Request $request)
    {
        try {
            $validation = $request->validate([
                'expired_at' => 'required'
            ]);
            if($validation) {
                Flashsale::query()->update([
                    'expired_at' => $request->expired_at
                ]);
                return response()->json([
                    'success' => 'Expired berhasil di set'
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Expired gagal di set'], 400);
        }
        
    }

    public function destroy(Request $request) 
    {
        try {
            Flashsale::where('id', $request->id)->delete();
            return response()->json([
                'success' => 'Flashsale berhasil di hapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Flashsale gagal di hapus'], 400);
        }
    }
}
