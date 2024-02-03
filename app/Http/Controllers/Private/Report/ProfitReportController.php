<?php

namespace App\Http\Controllers\Private\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class ProfitReportController extends Controller
{
    public function indexProfit()
    {
        return view('pages.private.report.profit.index');
    }

    public function generateProfit(Request $request)
    {
        try {
            $dateRange = $request->date;
            $explode = explode('-', $dateRange);
            $startDate = date('Y-m-d', strtotime($explode[0]));
            $endDate = date('Y-m-d', strtotime($explode[1]));
            $result = Invoice::with('harga')->whereBetween('created_at', [$startDate, $endDate])->where('status', 'PAID')->get();
            return response()->json(['data' => $result]);
        } catch (\Exception $e) {

        }
    }
}
