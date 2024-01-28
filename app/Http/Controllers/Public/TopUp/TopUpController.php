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
use App\Models\XenditQr;
use App\Models\XenditVa;
use Illuminate\Support\Facades\Log;
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
            'vas' => Payment::where('status', 1)->where('payment_type', 'VA')->get(),
            'outlets' => Payment::where('status', 1)->where('payment_type', 'OUTLET')->get()
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
                        $game = $data->game->where('slug', $request->slug)->first();
                        $payment = Payment::where('payment_method', $request->paymentMethod)->first();
                        /**
                         * Cek Pembayaran apa yang di gunakan. ini berguna untuk menentukan biaya Admin
                         */
                        if ($payment->payment_type == 'EWALLET' || $payment->payment_type == 'QRIS') {
                            $adminFee = $data->harga_jual * ($payment->admin_fee / 100);
                            $total = round($data->harga_jual + $adminFee);
                        } elseif ($payment->payment_type == 'VA' || $payment->payment_type == 'OUTLET') {
                            $adminFee = $payment->admin_fee_fixed;
                            $total = $data->harga_jual + $adminFee;
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
                                'game_id' => $game->id,
                                'harga_id' => $data->id, 
                                'payment_id' => $payment->id,
                                'xendit_invoice_id' => $response['id'],
                                'xendit_e_wallet_id' => $eWalletCreate['id'],
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
                            $QrCreate = XenditQr::create([
                                'xendit_qr_string' => $response['qr_string']
                            ]);
                            Invoice::create([                                                   
                                'nomor_invoice' => $invoiceNumber,                                
                                'user_id' => $request->userId,
                                'server_id' => $request->serverId,
                                'game_id' => $game->id,
                                'harga_id' => $data->id, 
                                'payment_id' => $payment->id,
                                'xendit_invoice_id' => $response['id'],
                                'xendit_qr_id' => $QrCreate['id'],
                                'total' => $total,
                                'status' => 'PENDING',                                
                                'expired_at' => $expiredAt,
                            ]);
                            return response()->json(['redirect' => route('invoice.index', ['id' => $invoiceNumber])]);
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
                                    'game_id' => $game->id,
                                    'harga_id' => $data->id, 
                                    'payment_id' => $payment->id,
                                    'xendit_invoice_id' => $response['id'],
                                    'xendit_va_id' => $VaCreate['id'],
                                    'total' => $total,
                                    'status' => 'PENDING',                                
                                    'expired_at' => $expiredAt,
                                ]);
                                return response()->json(['redirect' => route('invoice.index', ['id' => $invoiceNumber])]);
                            } else {
                                return response()->json([
                                    'unaccepted' => 'Minimal pembelian dengan Virtual Account adalah Rp. 10.000'
                                ]);
                            }                                                       
                        } else if($payment->payment_type == 'OUTLET') {
                            $response = Http::withHeaders([
                                'Content-Type' => 'application/json',
                                'Authorization' => 'Basic ' . base64_encode(env('XENDIT_SECRET_KEY') . ':'),
                            ])->post('https://api.xendit.co/fixed_payment_code', [
                                'external_id' => $invoiceNumber,
                                'retail_outlet_name' => $payment->payment_method,
                                'name' => 'Kai Top Up',
                                'expected_amount' => $total
                            ]); 
                            Invoice::create([
                                'game_id' => $game->id,
                                'harga_id' => $data->id,   
                                'payment_id' => $payment->id,                 
                                'nomor_invoice' => $invoiceNumber,
                                'user_id' => $request->userId,
                                'server_id' => $request->serverId,
                                'xendit_invoice_id' => $response['id'],
                                'total' => $total,
                                'status' => 'PENDING',
                                'expired_at' => $expiredAt,
                            ]);
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
}
