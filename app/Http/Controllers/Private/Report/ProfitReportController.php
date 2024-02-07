<?php

namespace App\Http\Controllers\Private\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\Gate;

class ProfitReportController extends Controller
{
    public function indexProfit()
    {
        if(Gate::allows('admin')) { 
            return view('pages.private.report.profit.index');
        } else {
            abort(404);
        }
    }

    public function generateProfit(Request $request)
    {
        try {
            $dateRange = $request->date;
            $explode = explode(' - ', $dateRange);
            $startDate = date('Y-m-d H:i:s', strtotime($explode[0]));
            $endDate = date('Y-m-d H:i:s', strtotime($explode[1]));
            $result = Invoice::with(['harga', 'digiflazz', 'user.role'])->whereBetween('created_at', [$startDate, $endDate])->where('status', 'PAID')->orderBy('id', 'desc')->get();
            return response()->json(['data' => $result]);
        } catch (\Exception $e) {

        }
    }
}
