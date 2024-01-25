<?php

namespace App\Http\Controllers\Private\Testing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Harga;
use App\Models\Invoice;
use App\Models\Game;
use Illuminate\Support\Facades\Http;

class TestingController extends Controller
{
    public function index()
    {
        return view('pages.private.test.index');
    }

    public function testShopeePay()
    {        
        try {        
            $slug = 'mobile-legend';    
            $price = '21500';
            $itemName = 'Diamond 500';
            $userId = '123';
            $serverId = '123';
            $itemId = '1';
            $paymentType = 'EWALLET';
            $checkoutMethod = 'ONE_TIME_PAYMENT';
            $paymentMethod = 'ID_SHOPEEPAY';
                /**
                 * Validasi terlebih dahulu apakah itemId dan itemPrice cocok dengan Database
                 */
                $data = Harga::where('id', $itemId)->first();
                if($data) {                   

                        /**
                         * Cek Pembayaran apa yang di gunakan. ini berguna untuk menentukan biaya Admin
                         */
                        if($paymentMethod == 'ID_SHOPEEPAY') {
                            $adminFee = $price * (4.5 / 100);
                            $totalWithDecimal = $price + $adminFee;
                            $total = round($totalWithDecimal);
                        } elseif ($paymentMethod == 'ID_DANA') {
                            $adminFee = $price * (2 / 100);
                            $total = $price + $adminFee;
                        } elseif ($paymentMethod == 'ID_OVO') {
                            $adminFee = $price * (4 / 100);
                            $total = $price + $adminFee;
                        }
                        /**
                         * Ini bagian untuk pembuatan nomor Invoice
                         */
                        $datePart = now()->format('Ymd');
                        $lastOrder = Invoice::orderby('id', 'desc')->first();
                        $sequenceNumber = $lastOrder ? sprintf('%08d', $lastOrder->id + 1) : '00000001';
                        $invoiceNumber = 'TRX' . $datePart . $sequenceNumber;

                        /**
                         * Setelah nomor invoice di buat, mari berlanjut ke pengiriman Data ke XENDIT
                         */
                        if($paymentType == 'EWALLET') {
                            $response = Http::withHeaders([
                                'Content-Type' => 'application/json',
                                'Authorization' => 'Basic ' . base64_encode(env('XENDIT_SECRET_KEY') . ':'),
                            ])->post('https://api.xendit.co/ewallets/charges', [
                                'reference_id' => $invoiceNumber,
                                'currency' => 'IDR',                                
                                'amount' => $total,
                                'checkout_method' => $checkoutMethod,
                                'channel_code' => $paymentMethod,
                                'channel_properties' => [
                                    'success_redirect_url' => route('invoice.index', ['id' => $invoiceNumber]),
                                ],
                                'metadata' => [
                                    'branch_area' => 'PLUIT',
                                    'branch_city' => 'JAKARTA',
                                ],
                            ]);                          
                             
                            return view('pages.private.test.index', [
                                'response' => $response
                            ]);
                        } else {

                        }                                               
                    
                } else {
                    return response()->json([
                        'unaccepted' => 'Produk tidak ditemukan!'
                    ]);
                }          
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }
}
