<?php

namespace App\Http\Controllers\Private\Testing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Harga;
use App\Models\Invoice;
use App\Models\Payment;
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
            $itemId = '3';
            $paymentType = 'EWALLET';
            $checkoutMethod = 'ONE_TIME_PAYMENT';
            $paymentMethod = 'BCA';
                /**
                 * Validasi terlebih dahulu apakah itemId dan itemPrice cocok dengan Database
                 */
                $data = Harga::where('id', $itemId)->first();
                if($data) {                   

                    $payment = Payment::where('payment_method', $paymentMethod)->first();
                    if($payment->payment_type = 'EWALLET' || $payment->payment_type = 'QRIS') {
                        $adminFee = $data->harga_jual * ($payment->admin_fee / 100);
                        $total = round($data->harga_jual + $adminFee);
                    } elseif($payment->payment_type = 'VA') {
                        $adminFee = $payment->admin_fee_fixed;
                        $total = round($data->harga_jual + $adminFee);
                    }                     
                    $datePart = now()->format('Ymd');
                    $lastOrder = Invoice::orderby('id', 'desc')->first();
                    $sequenceNumber = $lastOrder ? sprintf('%08d', $lastOrder->id + 1) : '00000001';
                    $invoiceNumber = 'TRX' . $datePart . $sequenceNumber;
                    
                    $currentTime = now();
                    $expiredTime = $currentTime->addDay(1);
                    $expiredAt = $expiredTime->format('Y-m-d\TH:i:s.u\Z');
                     
                    if($paymentType == 'EWALLET') {
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
                        } 
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
