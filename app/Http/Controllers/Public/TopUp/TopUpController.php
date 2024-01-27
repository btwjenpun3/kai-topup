<?php

namespace App\Http\Controllers\Public\TopUp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Game;
use App\Models\Invoice;
use App\Models\Harga;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class TopUpController extends Controller
{
    public function index(Request $request)
    {
        $game = Game::where('slug', $request->slug)->firstOrFail();
        return view('pages.public.topup.index', [
            'game' => $game,
            'harga' => $game->harga,
            'ewallets' => Payment::where('status', 1)->where('payment_type', 'EWALLET')->get(),
            'qris' => Payment::where('status', 1)->where('payment_type', 'QRIS')->get(),
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
                        $payment = Payment::where('payment_method', $request->paymentMethod)->first();
                        $adminFee = $data->harga_jual * ($payment->admin_fee / 100);
                        $total = round($data->harga_jual + $adminFee);                        
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
    
                            $game = Game::where('slug', $request->slug)->first();
                            Invoice::create([
                                'game_id' => $game->id,
                                'harga_id' => $request->itemId, 
                                'payment_id' => $payment->id,                   
                                'nomor_invoice' => $invoiceNumber,
                                'user_id' => $request->userId,
                                'server_id' => $request->serverId,
                                'xendit_invoice_id' => $response['id'],
                                'xendit_invoice_url' => $invoice_url,
                                'total' => $total,
                                'status' => 'PENDING',                                
                                'expired_at' => $expiredAt,
                            ]); 
                            return response()->json(['redirect' => route('invoice.index', ['id' => $invoiceNumber])]);
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
                            $game = Game::where('slug', $request->slug)->first();
                            Invoice::create([
                                'game_id' => $game->id,
                                'harga_id' => $request->itemId,   
                                'payment_id' => $payment->id,                 
                                'nomor_invoice' => $invoiceNumber,
                                'user_id' => $request->userId,
                                'server_id' => $request->serverId,
                                'xendit_invoice_id' => $response['id'],
                                'xendit_qr_string' => $response['qr_string'],
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
