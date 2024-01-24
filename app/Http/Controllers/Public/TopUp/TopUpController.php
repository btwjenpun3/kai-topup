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
                'itemId' => 'required'
            ]);
            if($validation) {
                /**
                 * Validasi terlebih dahulu apakah itemId dan itemPrice cocok dengan Database
                 */
                $data = Harga::where('id', $request->itemId)->first();
                if($data) {
                    if($request->price == $data->harga_jual) {
                        /**
                         * Ini bagian untuk pembuata nomor Invoice
                         */
                        $datePart = now()->format('Ymd');
                        $lastOrder = Invoice::orderby('id', 'desc')->first();
                        $sequenceNumber = $lastOrder ? sprintf('%08d', $lastOrder->id + 1) : '00000001';
                        $invoiceNumber = 'TRX' . $datePart . $sequenceNumber;

                        /**
                         * Setelah nomor invoice di buat, mari berlanjut ke pengiriman Data ke XENDIT
                         */
                        $response = Http::withHeaders([
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Basic ' . base64_encode(env('XENDIT_SECRET_KEY') . ':'),
                        ])->post('https://api.xendit.co/ewallets/charges', [
                            'reference_id' => 'order-id-123',
                            'currency' => 'IDR',
                            'amount' => 25000,
                            'checkout_method' => 'ONE_TIME_PAYMENT',
                            'channel_code' => 'ID_SHOPEEPAY',
                            'channel_properties' => [
                                'success_redirect_url' => 'https://redirect.me/payment',
                            ],
                            'metadata' => [
                                'branch_area' => 'PLUIT',
                                'branch_city' => 'JAKARTA',
                            ],
                        ]);
                        $game = Game::where('slug', $request->slug)->first();
                        Invoice::create([
                            'game_id' => $game->id,
                            'harga_id' => $request->itemId,                    
                            'nomor_invoice' => $invoiceNumber,
                            'user_id' => $request->userId,
                            'server_id' => $request->serverId,
                            'xendit_invoice_id' => $response,
                            'xendit_invoice_url' => '123',
                            'status' => 'PENDING'
                        ]); 
                        // return response()->json(['redirect' => route('invoice.index', ['id' => $invoiceNumber])]);
                        return response()->json(['redirect' => $response]);
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
            return response()->json(['unaccepted' => $e->getMessage()]);
        }
    }
}
