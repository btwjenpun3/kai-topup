<?php

namespace App\Http\Controllers\Public\TopUp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Game;
use App\Models\Invoice;
use App\Models\Harga;
use App\Models\Payment;
use App\Models\XenditEWallet;
use App\Models\XenditOutlet;
use App\Models\XenditQr;
use App\Models\XenditVa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class TopUpController extends Controller
{
    public function index(Request $request)
    {
        $now =  Carbon::now()->format('Y-m-d H:i:s');
        $game = Game::with('harga')->where('slug', $request->slug)->firstOrFail();
        $harga = $game->harga()->orderBy('kode_produk', 'asc')->get();
        if($game->slug == 'mobile-legend') {
            return view('pages.public.topup.mobile-legend', [     
                'now' => $now,       
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);
        } elseif($game->slug == 'free-fire') {
            return view('pages.public.topup.free-fire', [   
                'now' => $now,            
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);
        } elseif($game->slug == 'undawn') {
            return view('pages.public.topup.undawn', [   
                'now' => $now,            
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);
        }  elseif($game->slug == 'undawn-all-bind') {
            return view('pages.public.topup.undawn-all-bind', [   
                'now' => $now,            
                'game' => $game,
                'harga' => Harga::where('kode_produk', 'LIKE', 'UGRC%')->get(),
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);
        } elseif($game->slug == 'lifeafter') {
            return view('pages.public.topup.lifeafter', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);
        } elseif($game->slug == 'pln') {
            return view('pages.public.topup.pln', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);
        } elseif($game->slug == 'pubg') {
            return view('pages.public.topup.pubg', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);
        } elseif($game->slug == 'hago') {
            return view('pages.public.topup.hago', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);
        } elseif($game->slug == 'clash-of-clans') {
            return view('pages.public.topup.coc', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'valorant') {
            return view('pages.public.topup.valorant', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'bigo-live') {
            return view('pages.public.topup.bigo-live', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'honkai-star-rail') {
            return view('pages.public.topup.honkai-star-rail', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'genshin-impact') {
            return view('pages.public.topup.genshin-impact', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'hay-day') {
            return view('pages.public.topup.hay-day', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'sausage-man') {
            return view('pages.public.topup.sausage-man', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'league-of-legends-wild-rift') {
            return view('pages.public.topup.league-of-legend', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'ragnarok-origin') {
            return view('pages.public.topup.ragnarok-origin', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'call-of-duty-mobile') {
            return view('pages.public.topup.call-of-duty-mobile', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'lita') {
            return view('pages.public.topup.lita', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'metal-slug-awakening') {
            return view('pages.public.topup.metal-slug-awakening', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'ludo-club') {
            return view('pages.public.topup.ludo-club', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'dragon-raja-sea') {
            return view('pages.public.topup.dragon-raja-sea', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'zepeto') {
            return view('pages.public.topup.zepeto', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'tower-of-fantasy') {
            return view('pages.public.topup.tower-of-fantasy', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'love-nikki') {
            return view('pages.public.topup.love-nikki', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'eggy-party') {
            return view('pages.public.topup.eggy-party', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'stumble-guys') {
            return view('pages.public.topup.stumble-guys', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'telkomsel') {
            return view('pages.public.topup.pulsa.telkomsel', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'indosat') {
            return view('pages.public.topup.pulsa.indosat', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'axis') {
            return view('pages.public.topup.pulsa.axis', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'xl') {
            return view('pages.public.topup.pulsa.xl', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'tri') {
            return view('pages.public.topup.pulsa.tri', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'smartfren') {
            return view('pages.public.topup.pulsa.smartfren', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'razer-gold') {
            return view('pages.public.topup.voucher.razer-gold', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'unipin') {
            return view('pages.public.topup.voucher.unipin', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } elseif($game->slug == 'garena-shell') {
            return view('pages.public.topup.voucher.garena-shell', [
                'now' => $now,               
                'game' => $game,
                'harga' => $harga,
                'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
                'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
                'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
                'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
            ]);        
        } else {
            abort(404);
        }       
    }

    public function process(Request $request)
    {          
        try {
            $validation = $request->validate([
                'price' => 'required',
                'itemName' => 'required',
                'userId' => 'required',
                'userPhone' => 'required',
                'itemId' => 'required',
                'paymentType' => 'required',
                'paymentMethod' => 'required'
            ]);
            if($validation) {
                /**
                 * Validasi terlebih dahulu apakah itemId dan itemPrice cocok dengan Database
                 */
                $data = Harga::where('id', $request->itemId)->first();      
                
                /**
                 * Cek apakah produk Seller Digiflazz online atau tidak
                 */
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
                /**
                 * Cek saldo Digiflazz terlebih dahulu
                 */
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
                        'unaccepted' => 'Produk ini sedang Offline, silahkan pilih produk yang lain'
                    ], 200);
                }

                /**
                 * Cek apakah produk tersebut sedang Cut Off atau tidak
                 */
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

                $via = 'WEB';

                /**
                 * Cek Seller, ini berlaku jika customer_no butuh format khusus 
                 */  
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
                    
                } elseif ($data->game->brand == 'Tower of Fantasy') {
                    $customer_no = $request->userId . ',' . $request->serverId; 
                    
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

                /**
                 * GAS PROSES!!
                 */
                if($data) {
                    if($request->price == $data->harga_jual) {
                        $game = $data->game->where('slug', $request->slug)->first();
                        $payment = Payment::where('payment_method', $request->paymentMethod)->first();
                        /**
                         * Cek Pembayaran apa yang di gunakan. ini berguna untuk menentukan biaya Admin
                         */
                        if ($payment->payment_type == 'EWALLET' || $payment->payment_type == 'QRIS') {
                            $adminFee = $data->harga_jual * ($payment->admin_fee / 100);
                            $total = round($data->harga_jual + $adminFee);
                        } elseif ($payment->payment_type == 'VA') {
                            $adminFee = $payment->admin_fee_fixed;
                            $total = $data->harga_jual + $adminFee;
                        } elseif ($payment->payment_type == 'OUTLET') {
                            $total = $data->harga_jual;
                        }                        
                                                    
                        /**
                         * Ini bagian untuk pembuatan nomor Invoice
                         */
                        $datePart = now()->format('Ymd');
                        $lastOrder = Invoice::orderby('id', 'desc')->first();
                        $randNumber = rand(100,999);
                        $sequenceNumber = $lastOrder ? sprintf('%05d', $lastOrder->id + 1) : '00001';
                        $invoiceNumber = 'TRX' . $datePart . $randNumber . $sequenceNumber;

                        /**
                         * Setelah nomor invoice di buat, mari berlanjut ke pembuatan Expired_At
                         */
                        $currentTime = now();
                        $expiredTime = $currentTime->addHours(17);
                        $expiredAt = $expiredTime->format('Y-m-d\TH:i:s.u\Z');
                         /**
                         * Setelah nomor invoice di buat, mari berlanjut ke Request POST untuk membuat Invoice
                         */
                        if($payment->payment_type == 'EWALLET') {
                            $response = Http::withHeaders([
                                'Content-Type' => 'application/json',
                                'Authorization' => 'Basic ' . base64_encode(env('XENDIT_SECRET_KEY') . ':'),
                            ])->post('https://api.xendit.co/ewallets/charges', [
                                'reference_id' => $invoiceNumber,
                                'currency' => 'IDR',
                                'amount' => $total,
                                'checkout_method' => 'ONE_TIME_PAYMENT',
                                'channel_code' => $payment->payment_method,
                                'channel_properties' => [
                                    'success_redirect_url' => route('invoice.index', ['id' => $invoiceNumber]),
                                    'failure_redirect_url' => route('invoice.index', ['id' => $invoiceNumber]),
                                ],
                                'metadata' => [
                                    'branch_area' => 'PLUIT',
                                    'branch_city' => 'JAKARTA',
                                ],
                            ]);
                            /**
                             * Cek Methode pembayaran untuk di masukkan URL nya ke Invoice
                             */
                            if($payment->payment_method == 'ID_SHOPEEPAY') {
                                $invoice_url = $response['actions']['mobile_deeplink_checkout_url'];
                            } elseif ($payment->payment_method == 'ID_DANA') {
                                $invoice_url = $response['actions']['desktop_web_checkout_url'];
                            } elseif ($payment->payment_method == 'ID_LINKAJA') {
                                $invoice_url = $response['actions']['mobile_web_checkout_url'];
                            } elseif ($payment->payment_method == 'ID_ASTRAPAY') {
                                $invoice_url = $response['actions']['mobile_web_checkout_url'];
                            }   
                            $eWalletCreate = XenditEWallet::create([
                                'xendit_invoice_url' => $invoice_url
                            ]);
                            Invoice::create([                                                   
                                'nomor_invoice' => $invoiceNumber,                                
                                'user_id' => $request->userId,
                                'server_id' => $request->serverId,
                                'customer' => $customer_no,
                                'phone' => $request->userPhone,
                                'game_id' => $game->id,
                                'harga_id' => $data->id, 
                                'payment_id' => $payment->id,
                                'xendit_invoice_id' => $response['id'],
                                'xendit_e_wallet_id' => $eWalletCreate['id'],
                                'profit' => $data->profit,
                                'total' => $total,
                                'status' => 'PENDING',      
                                'via' => $via,                          
                                'expired_at' => $expiredAt,
                            ]);                                                       
                            return response()->json(['redirect' => route('invoice.index', ['id' => $invoiceNumber])], 200);
                        } elseif($payment->payment_type == 'QRIS') {
                            $response = Http::withHeaders([
                                'api-version' => '2022-07-31',
                                'Content-Type' => 'application/json',
                                'Authorization' => 'Basic ' . base64_encode(env('XENDIT_SECRET_KEY') . ':'),
                            ])->post('https://api.xendit.co/qr_codes', [
                                'reference_id' => $invoiceNumber,
                                'type' => 'DYNAMIC',
                                'currency' => 'IDR',
                                'amount' => $total,
                                'channel_code' => 'ID_DANA',
                                'expires_at'=> $expiredAt
                            ]);
                            $QrCreate = XenditQr::create([
                                'xendit_qr_string' => $response['qr_string']
                            ]);
                            Invoice::create([                                                   
                                'nomor_invoice' => $invoiceNumber,                                
                                'user_id' => $request->userId,
                                'server_id' => $request->serverId,
                                'customer' => $customer_no,
                                'phone' => $request->userPhone,
                                'game_id' => $game->id,
                                'harga_id' => $data->id, 
                                'payment_id' => $payment->id,
                                'xendit_invoice_id' => $response['id'],
                                'xendit_qr_id' => $QrCreate['id'],
                                'profit' => $data->profit,
                                'total' => $total,
                                'status' => 'PENDING',
                                'via' => $via,                                 
                                'expired_at' => $expiredAt,
                            ]);
                            return response()->json(['redirect' => route('invoice.index', ['id' => $invoiceNumber])], 200);
                        } elseif($payment->payment_type == 'VA') {
                            if($data->harga_jual >= 10000) {
                                $response = Http::withHeaders([
                                    'Content-Type' => 'application/json',
                                    'Authorization' => 'Basic ' . base64_encode(env('XENDIT_SECRET_KEY') . ':'),
                                ])->post('https://api.xendit.co/callback_virtual_accounts', [
                                    'external_id' => $invoiceNumber,
                                    'bank_code' => $payment->payment_method,
                                    'name' => 'Muhamad Helmi',
                                    'is_closed' => true,
                                    'expected_amount' => $total,
                                    'expiration_date' => $expiredAt
                                ]);                                
                                $VaCreate = XenditVa::create([
                                    'xendit_va_name' => $response['name'],
                                    'xendit_va_number' => $response['account_number']
                                ]);
                                Invoice::create([                                                   
                                    'nomor_invoice' => $invoiceNumber,                                
                                    'user_id' => $request->userId,
                                    'server_id' => $request->serverId,
                                    'customer' => $customer_no,
                                    'phone' => $request->userPhone,
                                    'game_id' => $game->id,
                                    'harga_id' => $data->id, 
                                    'payment_id' => $payment->id,
                                    'xendit_invoice_id' => $response['id'],
                                    'xendit_va_id' => $VaCreate['id'],
                                    'profit' => $data->profit,
                                    'total' => $total,
                                    'status' => 'PENDING', 
                                    'via' => $via,                                
                                    'expired_at' => $expiredAt,
                                ]);
                                return response()->json(['redirect' => route('invoice.index', ['id' => $invoiceNumber])], 200);
                            } else {
                                return response()->json([
                                    'unaccepted' => 'Minimal pembelian dengan Virtual Account adalah Rp. 10.000'
                                ]);
                            }                                                       
                        } else if($payment->payment_type == 'OUTLET') {
                            if($data->harga_jual >= 10000) {
                                $response = Http::withHeaders([
                                    'Content-Type' => 'application/json',
                                    'Authorization' => 'Basic ' . base64_encode(env('XENDIT_SECRET_KEY') . ':'),
                                ])->post('https://api.xendit.co/fixed_payment_code', [
                                    'external_id' => $invoiceNumber,
                                    'retail_outlet_name' => $payment->payment_method,
                                    'name' => 'Kai Top Up',
                                    'expected_amount' => $total,
                                    'expiration_date' => $expiredAt
                                ]); 
                                $OutletCreate = XenditOutlet::create([
                                    'prefix' => $response['prefix'],
                                    'name' => $response['name'],
                                    'payment_code' => $response['payment_code']
                                ]);
                                Invoice::create([                                                   
                                    'nomor_invoice' => $invoiceNumber,                                
                                    'user_id' => $request->userId,
                                    'server_id' => $request->serverId,
                                    'customer' => $customer_no,
                                    'phone' => $request->userPhone,
                                    'game_id' => $game->id,
                                    'harga_id' => $data->id, 
                                    'payment_id' => $payment->id,
                                    'xendit_invoice_id' => $response['id'],
                                    'xendit_outlet_id' => $OutletCreate['id'],
                                    'profit' => $data->profit,
                                    'total' => $total,
                                    'status' => 'PENDING', 
                                    'via' => $via,                                
                                    'expired_at' => $expiredAt,
                                ]);
                                return response()->json(['redirect' => route('invoice.index', ['id' => $invoiceNumber])], 200);
                            } else {
                                return response()->json([
                                    'unaccepted' => 'Minimal pembelian dengan Outlet adalah Rp. 10.000'
                                ]);
                            }                             
                        } else {
                            return response()->json([
                                'unaccepted' => 'Tipe pembayaran tidak ditemukan.'
                            ]);   
                        }                                                
                    } else {
                        return response()->json([
                            'unaccepted' => 'Produk dan harga tidak cocok!'
                        ]);
                    }
                } else {
                    return response()->json([
                        'unaccepted' => 'Produk tidak ditemukan!'
                    ]);
                }
            }                
        } catch (\Exception $e) {
            Log::channel('invoice')->error('Error occurred: ' . $e->getMessage());            
            return response()->json(['unaccepted' => 'Payment sedang Offline, silahkan pilih metode pembayaran yang lain']);
        }
    }

    public function cekNomorPln(Request $request)
    {
        try {
            $randomNumber = rand(100,200);
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://api.digiflazz.com/v1/transaction', [
                'username' => env('DIGIFLAZZ_USERNAME'),
                'buyer_sku_code' => 'PLNCNTP',
                'customer_no' => $request->id,
                'ref_id' => 'PLNNB' . $randomNumber,
                'sign' => md5(env('DIGIFLAZZ_USERNAME') . env('DIGIFLAZZ_SECRET_KEY') . 'PLNNB' .  $randomNumber)
            ]);
            if($response->successful()) {
                return response()->json($response->json());
            } else {
                Log::channel('invoice')->error('Error occurred: ' . $response);
                return response()->json($response->json());
            }
        } catch (\Exception $e) {
            Log::channel('invoice')->error('Error occurred: ' . $e->getMessage());            
            return response()->json(['unaccepted' => 'Payment sedang Offline, silahkan pilih metode pembayaran yang lain']);
        }        
    }
}
