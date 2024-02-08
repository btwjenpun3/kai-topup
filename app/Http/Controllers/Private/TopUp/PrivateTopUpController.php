<?php

namespace App\Http\Controllers\Private\TopUp;

use App\Events\TopUpEvent;
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

        if ($game->slug == 'undawn-all-bind') {
            $produk = Harga::where('game_id', 3)->where('kode_produk', 'LIKE', 'UGRC%')->orderBy('kode_produk', 'asc')->get();
        } elseif ($game->slug == 'undawn') {
            $produk = Harga::where('game_id', $game->id)->where('kode_produk', 'NOT LIKE', 'UGRC%')->orderBy('kode_produk', 'asc')->get();
        } else {
            $produk = Harga::where('game_id', $game->id)->orderBy('kode_produk', 'asc')->get();
        }

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
                'userId' => 'required',
                'password' => 'required'
            ]);
            if($validation) {
                $data = Harga::where('kode_produk', $request->product)->first();
                if($data) {
                    $user = auth()->user();
                    if(Hash::check($request->password, $user->password)) {
                        if($user->role->name == 'reseller') {
                            if($user->saldo <= $data->harga_jual_reseller ) {
                                return response()->json([                          
                                    'unaccepted' => 'Saldo kamu kurang! Harap recharge saldo kamu lagi! (Error 506)'
                                ], 200);
                            }
                        }

                        $cekOffline = Http::withHeaders([
                            'Content-Type' => 'application/json',
                        ])->post('https://api.digiflazz.com/v1/price-list', [
                            'cmd' => 'prepaid',
                            'username' => env('DIGIFLAZZ_USERNAME'),
                            'code' => $data->kode_produk,
                            'sign' => md5(env('DIGIFLAZZ_USERNAME') . env('DIGIFLAZZ_SECRET_KEY') . 'pricelist')
                        ]);                        
                        if($cekOffline['data'][0]['seller_product_status'] == false) { 
                            $data->update([
                                'status' => 3
                            ]);
                            return response()->json([                          
                                'unaccepted' => 'Denom ini sedang Offline, silahkan pilih denom yang lain'
                            ], 200);
                        }

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
                                'unaccepted' => 'Terdapat error! Harap hubungi Admin! (Error 505)'
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

                        if ($data->seller_name == 'BANGJEFF' && $data->game->brand == 'LifeAfter Credits') {
                            $customer_no = $request->userId . ',' . $request->serverId;
        
                        } elseif ($data->game->brand == 'Honkai Star Rail') {
                            if($data->seller_name == 'HOPE') {
                                $customer_no = $request->userId . '|' . $request->serverId;
                            } elseif ($data->seller_name == 'VocaGame') {
                                if($request->serverId == 'os_asia') {
                                    $serverId = 'prod_official_asia';
                                } elseif($request->serverId == 'os_usa') {
                                    $serverId = 'prod_official_usa';
                                } elseif($request->serverId == 'os_euro') {
                                    $serverId = 'prod_official_eur';
                                } else {
                                    return response()->json([
                                        'unaccepted' => 'Produk ini dengan Server TW_HK_MO tidak support! Harap pilih denom yang lain'
                                    ]);
                                }
                                $customer_no = $request->userId . '|' . $serverId;
                            } elseif($data->seller_name == 'YinYangStoreid') {
                                $customer_no = $request->userId . '|' . $request->serverId;
                            } elseif($data->seller_name == 'LUQMANTRONIK') {
                                $customer_no = $request->userId . $request->serverId;
                            }                
                        } elseif($data->game->brand == 'Genshin Impact') {    
                            if($data->seller_name == 'HOPE') {
                                $customer_no = $request->userId . '|' . $request->serverId;
                            } elseif($data->seller_name == 'lapakgamingcom') {
                                if($request->serverId == 'os_asia') {
                                    $serverId = '001';
                                } elseif($request->serverId == 'os_usa') {
                                    $serverId = '002';
                                } elseif($request->serverId == 'os_euro') {
                                    $serverId = '003';
                                } elseif($request->serverId == 'os_cht') {
                                    $serverId = '004';
                                } else {
                                    return response()->json([
                                        'unaccepted' => 'Produk ini dengan Server TW_HK_MO tidak support! Harap pilih denom yang lain'
                                    ]);
                                }
                                $customer_no = $serverId . $request->userId;
                            }
                            
                        } elseif ($data->game->brand == 'Clash of Clans') {
                            $customer_no = '#' . $request->userId;
        
                        } elseif ($data->game->brand == 'Hay Day') {
                            $customer_no = '#' . $request->userId;
        
                        } elseif ($data->game->brand == 'League of Legends Wild Rift') {
                            $customer_no = $request->userId . '#' . $request->userId;
        
                        } elseif ($data->game->brand == 'Valorant') {
                            $customer_no = $request->userId . '#' . $request->serverId;   
                            
                        } elseif ($data->game->brand == 'Ragnarok Origin') {
                            if($data->seller_name == 'BANGJEFF') {
                                $customer_no = $request->userId . ',' . $request->userNickname . ',' . $request->serverId;
                            } else {
                                Log::error('Error occurred: Format customer_no dengan seller ' . $data->seller_name . ' belum di setting!');
                                        return response()->json([
                                            'unaccepted' => 'Produk ini sedang Offline. (Error 600)'
                                        ]);
                                return response()->json([
                                    'unaccepted' => 'Produk ini sedang Offline.'
                                ]);
                            }                   
        
                        } else {
                            $customer_no = $request->userId . $request->serverId;
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
                            'user_id' => $request->userId,
                            'server_id' => $request->serverId,
                            'customer' => $customer_no,
                            'phone' => $user->phone,
                            'realm_user_id' => auth()->id(),
                            'game_id' => $data->game->id,
                            'harga_id' => $data->id, 
                            'payment_id' => 99,
                            'profit' => $data->profit,
                            'total' => $data->harga_jual,
                            'status' => 'PENDING',      
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
                            Log::channel('invoice')->error('Error occurred: ' . $response);                       
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
                                'berhasil' => 'Invoice berhasil di buat dengan nomor Invoice ' . $invoiceNumber . '. Harap tunggu kami sedang memproses pembelian produk anda.'
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
                'unaccepted' => 'Terdapat error pada sistem! Harap hubungi Admin! (Error 500)'
            ]);
        }
    }
}
