<?php

namespace App\Http\Controllers\Private\Recharge;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recharge;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RechargeController extends Controller
{
    public function index()
    {
        if(Gate::allows('admin')) { 
            return view('pages.private.recharge.index');
        }
    }

    public function indexResult(Request $request)
    {
        if(Gate::allows('admin')) { 
            $data = Recharge::where('id', $request->id)->first();
            return view('pages.private.recharge.result', [
                'data' => $data
            ]);
        }
    }

    public function proses(Request $request)
    {
        try {
            $validation = $request->validate([
                'nominal' => 'required|integer',
                'bank' => 'required',
                'nama' => 'required'
            ]);
            if($validation) {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->post('https://api.digiflazz.com/v1/deposit', [
                    'username' => env('DIGIFLAZZ_USERNAME'),
                    'amount' => $request->nominal,
                    'bank' => $request->bank,
                    'owner_name' => $request->nama,
                    'sign' => md5(env('DIGIFLAZZ_USERNAME') . env('DIGIFLAZZ_SECRET_KEY') . 'deposit')
                ]);
                if($response->successful()) {
                    $result = Recharge::create([
                        'user_id' => auth()->id(),
                        'nominal' => $response['data']['amount'],
                        'bank' => $request->bank,
                        'pemilik_rekening' => $request->nama,
                        'note' => $response['data']['notes'],
                        'status' => 1
                    ]);
                    return redirect()->route('recharge.index.result', ['id' => $result['id']]);
                } else {
                    Log::error('Pesan Error: ' . $response);
                    return redirect()->back()->with('error', 'Permintaan Deposit Gagal! Harap hubungi Admin! (' . $response['data']['message'] . ')');
                }                
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terdapat masalah pada sistem. Harap hubungi Admin!');
        }
    }
}
