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
            $price = '16500';
            $itemName = 'Diamond 500';
            $userId = '123';
            $serverId = '123';
            $itemId = '1';
            $paymentType = 'EWALLET';
            $checkoutMethod = 'ONE_TIME_PAYMENT';
            $paymentMethod = 'ID_ASTRAPAY';
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
                        } elseif ($paymentMethod == 'ID_LINKAJA') {
                            $adminFee = $price * (4 / 100);
                            $total = round($price + $adminFee);
                        } elseif ($paymentMethod == 'ID_ASTRAPAY') {
                            $adminFee = $price * (2 / 100);
                            $total = round($price + $adminFee);
                        }

                        $currentTime = now();
                        $expiredTime = $currentTime->addDay(1);
                        $expiredAt = $expiredTime->format('Y-m-d\TH:i:s.u\Z');
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
