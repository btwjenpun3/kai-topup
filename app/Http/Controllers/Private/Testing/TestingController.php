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
            $itemId = '2';
            $paymentType = 'EWALLET';
            $checkoutMethod = 'ONE_TIME_PAYMENT';
            $paymentMethod = 'ID_ASTRAPAY';
                /**
                 * Validasi terlebih dahulu apakah itemId dan itemPrice cocok dengan Database
                 */
                $data = Harga::where('id', $itemId)->first();
                if($data) {                   

                    $payment = Payment::where('payment_method', $paymentMethod)->first();
                    $adminFee = $data->harga_jual * ($payment->admin_fee / 100);
                    $total = round($data->harga_jual + $adminFee);
                    // if ($request->paymentMethod == 'ID_SHOPEEPAY') {
                    //     $adminFee = $request->price * (4.5 / 100);
                    //     $total = round($request->price + $adminFee);
                    // } elseif ($request->paymentMethod == 'ID_DANA') {
                    //     $adminFee = $request->price * (2 / 100);
                    //     $total = round($request->price + $adminFee);
                    // } elseif ($request->paymentMethod == 'ID_LINKAJA') {
                    //     $adminFee = $request->price * (4 / 100);
                    //     $total = round($request->price + $adminFee);
                    // } elseif ($request->paymentMethod == 'ID_ASTRAPAY') {
                    //     $adminFee = $request->price * (2 / 100);
                    //     $total = round($request->price + $adminFee);
                    // } elseif ($request->paymentMethod == 'QRIS') {
                    //     $adminFee = $request->price * (0.8 / 100);
                    //     $total = round($request->price + $adminFee);
                    // }
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
                    if($paymentType == 'EWALLET') {
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
                        if($payment->method == 'ID_SHOPEEPAY') {
                            $invoice_url = $response['actions']['mobile_deeplink_checkout_url'];
                        } elseif ($payment->method == 'ID_DANA') {
                            $invoice_url = $response['actions']['desktop_web_checkout_url'];
                        } elseif ($payment->method == 'ID_LINKAJA') {
                            $invoice_url = $response['actions']['mobile_web_checkout_url'];
                        } elseif ($payment->method == 'ID_ASTRAPAY') {
                            $invoice_url = $response['actions']['mobile_web_checkout_url'];
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
