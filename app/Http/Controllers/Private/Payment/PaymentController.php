<?php

namespace App\Http\Controllers\Private\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Gate;

class PaymentController extends Controller
{
    public function index()
    {   
        if(Gate::allows('admin')) {     
            $data = Payment::get();
            return view('pages.private.payment.index', [
                'datas' => $data
            ]);
        } else {
            abort(404);
        }
    }

    public function show(Request $request)
    {
        try {            
            $data = Payment::where('id', $request->id)->first();
            return response()->json($data);
        } catch (\Exception $e) {

        }
    }

    public function update(Request $request)
    {
        try {            
            $validation = $request->validate([
                'status' => 'required|boolean'
            ]);
            if($validation) {
                $data = Payment::where('id', $request->id)->first();
                if($data) {
                    $data->update([
                        'admin_fee' => $request->admin_fee,
                        'admin_fee_fixed' => $request->admin_fee_fixed,
                        'status' => $request->status
                    ]);
                    return response()->json([
                        'success' => 'Payment' . $data->name . ' berhasil di update.'
                    ], 200);
                } else {
                    return response()->json([
                        'error' => 'Payment' . $data->name . ' gagal di update.'
                    ]);
                }
            }            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
