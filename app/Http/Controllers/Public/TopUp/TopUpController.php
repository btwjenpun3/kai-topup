<?php

namespace App\Http\Controllers\Public\TopUp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Game;
use App\Models\Invoice;
use App\Models\Harga;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class TopUpController extends Controller
{
    public function index(Request $request)
    {
        $game = Game::where('slug', $request->slug)->firstOrFail();
        return view('pages.public.topup.index', [
            'game' => $game,
            'harga' => $game->harga
        ]);
    }

    public function process(Request $request)
    {        
        try {
            $validation = $request->validate([
                'price' => 'required',
                'itemName' => 'required',
                'userId' => 'required',
                'serverId' => 'required',
                'itemId' => 'required',
                'paymentType' => 'required',
                'paymentMethod' => 'required'
            ]);
            if($validation) {
                /**
                 * Validasi terlebih dahulu apakah itemId dan itemPrice cocok dengan Database
                 */
                $data = Harga::where('id', $request->itemId)->first();
                if($data) {
                    if($request->price == $data->harga_jual) {

                        /**
                         * Cek Pembayaran apa yang di gunakan. ini berguna untuk menentukan biaya Admin
                         */
                        if($request->paymentMethod == 'ID_SHOPEEPAY') {
                            $adminFee = $request->price * (4.5 / 100);
                            $total = round($request->price + $adminFee);
                        } elseif ($request->paymentMethod == 'ID_DANA') {
                            $adminFee = $request->price * (2 / 100);
                            $total = round($request->price + $adminFee);
                        } elseif ($request->paymentMethod == 'ID_OVO') {
                            $adminFee = $request->price * (4 / 100);
                            $total = round($request->price + $adminFee);
                        } elseif ($request->paymentMethod == 'ID_LINKAJA') {
                            $adminFee = $request->price * (4 / 100);
                            $total = round($request->price + $adminFee);
                        } elseif ($request->paymentMethod == 'ID_ASTRAPAY') {
                            $adminFee = $request->price * (2 / 100);
                            $total = round($request->price + $adminFee);
                        } elseif ($request->paymentMethod == 'QRIS') {
                            $adminFee = $request->price * (0.8 / 100);
                            $total = round($request->price + $adminFee);
                        }
                        /**
                         * Ini bagian untuk pembuatan nomor Invoice
                         */
                        $datePart = now()->format('Ymd');
                        $lastOrder = Invoice::orderby('id', 'desc')->first();
                        $sequenceNumber = $lastOrder ? sprintf('%08d', $lastOrder->id + 1) : '00000001';
                        $invoiceNumber = 'TRX' . $datePart . $sequenceNumber;

                        /**
                         * Setelah nomor invoice di buat, mari berlanjut ke pembuatan Expired_At
                         */
                        $currentTime = now();
                        $expiredTime = $currentTime->addDay(1);
                        $expiredAt = $expiredTime->format('Y-m-d\TH:i:s.u\Z');
                         /**
                         * Setelah nomor invoice di buat, mari berlanjut ke Request POST untuk membuat Invoice
                         */
                        if($request->paymentType == 'EWALLET') {
                            $response = Http::withHeaders([
                                'Content-Type' => 'application/json',
                                'Authorization' => 'Basic ' . base64_encode(env('XENDIT_SECRET_KEY') . ':'),
                            ])->post('https://api.xendit.co/ewallets/charges', [
                                'reference_id' => $invoiceNumber,
                                'currency' => 'IDR',
                                'amount' => $total,
                                'checkout_method' => 'ONE_TIME_PAYMENT',
                                'channel_code' => $request->paymentMethod,
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
                            if($request->paymentMethod == 'ID_SHOPEEPAY') {
                                $invoice_url = $response['actions']['mobile_deeplink_checkout_url'];
                            } elseif ($request->paymentMethod == 'ID_DANA') {
                                $invoice_url = $response['actions']['desktop_web_checkout_url'];
                            } elseif ($request->paymentMethod == 'ID_LINKAJA') {
                                $invoice_url = $response['actions']['mobile_web_checkout_url'];
                            } elseif ($request->paymentMethod == 'ID_ASTRAPAY') {
                                $invoice_url = $response['actions']['mobile_web_checkout_url'];
                            } 
    
                            $game = Game::where('slug', $request->slug)->first();
                            Invoice::create([
                                'game_id' => $game->id,
                                'harga_id' => $request->itemId,                    
                                'nomor_invoice' => $invoiceNumber,
                                'user_id' => $request->userId,
                                'server_id' => $request->serverId,
                                'xendit_invoice_id' => $response['id'],
                                'xendit_invoice_url' => $invoice_url,
                                'payment_type' => 'EWALLET',
                                'payment_method' => $response['channel_code'],
                                'total' => $total,
                                'status' => 'PENDING',                                
                                'expired_at' => $expiredAt,
                            ]); 
                            return response()->json(['redirect' => route('invoice.index', ['id' => $invoiceNumber])]);
                        } elseif($request->paymentType == 'QRIS') {
                            $response = Http::withHeaders([
                                'api-version' => '2022-07-31',
                                'Content-Type' => 'application/json',
                                'Authorization' => 'Basic ' . base64_encode(env('XENDIT_SECRET_KEY') . ':'),
                            ])->post('https://api.xendit.co/qr_codes', [
                                'reference_id' => $invoiceNumber,
                                'type' => 'DYNAMIC',
                                'currency' => 'IDR',
                                'amount' => $total,
                                'expires_at'=> $expiredAt
                            ]);
                            $game = Game::where('slug', $request->slug)->first();
                            Invoice::create([
                                'game_id' => $game->id,
                                'harga_id' => $request->itemId,                    
                                'nomor_invoice' => $invoiceNumber,
                                'user_id' => $request->userId,
                                'server_id' => $request->serverId,
                                'xendit_invoice_id' => $response['id'],
                                'xendit_qr_string' => $response['qr_string'],
                                'payment_type' => 'QRIS',
                                'payment_method' => 'QRIS',
                                'total' => $total,
                                'status' => 'PENDING',
                                'expired_at' => $expiredAt,
                            ]);
                            return response()->json(['redirect' => route('invoice.index', ['id' => $invoiceNumber])]);
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
            return response()->json(['unaccepted' => 'Payment sedang Offline, silahkan pilih metode pembayaran yang lain']);
        }
    }
}
