<?php

namespace App\Http\Controllers\Private\DataTable;

use App\Http\Controllers\Controller;
use DataTables;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DataTableController extends Controller
{
    public function invoiceAdmin()
    {
        if(Gate::allows('admin')) {
            $data = Invoice::with(['harga', 'game', 'user.role'])->where('via', 'REALM')->orderBy('id', 'desc')->get();
            return DataTables::of($data)->toJson();
        } else {
            abort(404);
        }
    }
}
