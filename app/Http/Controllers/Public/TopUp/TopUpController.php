<?php

namespace App\Http\Controllers\Public\TopUp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Game;
use App\Models\Invoice;
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
                ])->post('https://api.xendit.co/v2/invoices', [
                    'external_id' => 'payment-link-example',
                    'amount' => $request->price,
                    'available_banks' => [
                        [
                            'bank_code'=> 'BCA',
                            'collection_type'=> 'POOL',
                            'transfer_amount'=> $request->price,
                            'bank_branch'=> 'Virtual Account',
                            'account_holder_name' => 'KAIA'
                        ]
                    ],
                    'items' => [
                        [
                            'name' => $request->itemName,
                            'quantity' => 1,
                            'price' => $request->price
                        ]
                    ],
                    'success_redirect_url' => route('invoice.index', ['id' => $invoiceNumber]),
                    'fees' => [
                        [
                            'type' => 'ADMIN',
                            'value' => 4000
                        ]
                    ]
                ]);
                $game = Game::where('slug', $request->slug)->first();
                Invoice::create([
                    'game_id' => $game->id,
                    'harga_id' => $request->itemId,                    
                    'nomor_invoice' => $invoiceNumber,
                    'user_id' => $request->userId,
                    'server_id' => $request->serverId,
                    'xendit_invoice_id' => $response['id'],
                    'xendit_invoice_url' => $response['invoice_url'],
                    'status' => 'PENDING'
                ]); 
                return response()->json(['redirect' => route('invoice.index', ['id' => $invoiceNumber])]);
            }                
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
