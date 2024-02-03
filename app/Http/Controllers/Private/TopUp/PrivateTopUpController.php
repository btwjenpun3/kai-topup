<?php

namespace App\Http\Controllers\Private\TopUp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Harga;
use App\Models\Game;
use App\Models\Invoice;
use App\Models\Digiflazz;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PrivateTopUpController extends Controller
{
    public function index(Request $request)
    {
        $game = Game::where('slug', $request->slug)->first();
        $produk = Harga::where('game_id', $game->id)->orderBy('kode_produk', 'asc')->get();
        return view('pages.private.topup.index', [
            'game' => $game,
            'produk' => $produk
        ]);
    }

    public function process(Request $request) 
    {
        try {
            $validation = $request->validate([
                'product' => 'required',
                'userid' => 'required',
                'password' => 'required'
            ]);
            if($validation) {
                $data = Harga::where('kode_produk', $request->product)->first();
                if($data) {
                    $user = auth()->user();
                    if(Hash::check($request->password, $user->password)) {

                        $saldo = Http::withHeaders([
                            'Content-Type' => 'application/json',
                        ])->post('https://api.digiflazz.com/v1/cek-saldo', [
                            'cmd' => 'deposit',
                            'username' => env('DIGIFLAZZ_USERNAME'),
                            'sign' => md5(env('DIGIFLAZZ_USERNAME') . env('DIGIFLAZZ_SECRET_KEY') . 'depo')
                        ]);

                        if($saldo['data']['deposit'] <= $data->modal) {
                            Log::channel('digiflazz')->error('Saldo kurang! Kamu butuh Rp. ' . $data->modal . ' dan saldo kamu sisa Rp. ' . $saldo['data']['deposit']);
                            return response()->json([                          
                                'unaccepted' => 'Saldo kamu kurang!'
                            ], 200);
                        }

                        if(!($data->start_cut_off == $data->end_cut_off)) {
                            $waktuSekarang = Carbon::now();
                            $mulaiCutOff = Carbon::parse($data->start_cut_off);
                            $selesaiCutOff = Carbon::parse($data->end_cut_off)->addDay();
                            if ($waktuSekarang->between($mulaiCutOff, $selesaiCutOff)) {                        
                                return response()->json([
                                    'unaccepted' => 'Produk ini sedang Offline hingga pukul ' . $data->end_cut_off . ' WIB'
                                ]);
                            }
                        } 
        
                        $via = 'REALM';

                        if($data->seller_name == 'BANGJEFF' && $data->game->brand == 'LifeAfter Credits') {
                            $customer_no = $request->userid . ',' . $request->serverid;
                        } else {
                            $customer_no = $request->userid . $request->serverid;
                        }

                        $datePart = now()->format('Ymd');
                        $lastOrder = Invoice::orderby('id', 'desc')->first();
                        $randNumber = rand(100,999);
                        $sequenceNumber = $lastOrder ? sprintf('%05d', $lastOrder->id + 1) : '00001';
                        $invoiceNumber = 'TRX' . $datePart . $randNumber . $sequenceNumber;

                        $currentTime = now();
                        $expiredTime = $currentTime->addHours(17);
                        $expiredAt = $expiredTime->format('Y-m-d\TH:i:s.u\Z');


                        $createInvoice = Invoice::create([                                                   
                            'nomor_invoice' => $invoiceNumber,                                
                            'user_id' => $request->userid,
                            'server_id' => $request->serverid,
                            'customer' => $customer_no,
                            'phone' => $user->phone,
                            'game_id' => $data->game->id,
                            'harga_id' => $data->id, 
                            'payment_id' => 99,
                            'profit' => $data->profit,
                            'total' => $data->harga_jual,
                            'status' => 'PAID',      
                            'via' => $via,                          
                            'expired_at' => $expiredAt,
                        ]);
                        if($createInvoice) {
                            $response = Http::withHeaders([
                                'Content-Type' => 'application/json',
                            ])->post('https://api.digiflazz.com/v1/transaction', [
                                'username' => env('DIGIFLAZZ_USERNAME'),
                                'buyer_sku_code' => $data->kode_produk,
                                'customer_no' => $customer_no,
                                'ref_id' => $invoiceNumber,
                                'sign' => md5(env('DIGIFLAZZ_USERNAME') . env('DIGIFLAZZ_SECRET_KEY') . $invoiceNumber)
                            ]);                            
                            $digiflazz = Digiflazz::create([
                                'saldo_terakhir' => $response['data']['buyer_last_saldo'],
                                'saldo_terpotong' => $response['data']['price'],
                                'message' => $response['data']['message'],
                                'seller_telegram' => $response['data']['tele'],
                                'seller_whatsapp' => $response['data']['wa'],
                                'status' => $response['data']['status']
                            ]);   
                            $createInvoice->update([
                                'digiflazz_id' => $digiflazz->id
                            ]);                                                         
                            return response()->json([
                                'berhasil' => 'Produk berhasil di beli dengan nomor Invoice ' . $invoiceNumber
                            ],200);                            
                        } else {
                            return response()->json([
                                'unaccepted' => 'Terdapat kesalahan saat membuat Invoice'
                            ]);
                        }  
                    } else {
                        return response()->json([
                            'unaccepted' => 'Password kamu salah!'
                        ]);
                    }                    
                } else {
                    return response()->json([
                        'unaccepted' => 'Produk dan harga tidak cocok!'
                    ]);
                }              
            } return response()->json([
                'unaccepted' => 'Harap isi lengkap data kamu!'
            ]);
        } catch (\Exception $e) {
            Log::channel('invoice')->error('Error occurred: ' . $e->getMessage());  
            return response()->json([
                'unaccepted' => $e->getMessage()
            ]);
        }
    }
}
