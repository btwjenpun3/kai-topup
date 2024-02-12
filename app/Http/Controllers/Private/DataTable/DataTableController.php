<?php

namespace App\Http\Controllers\Private\DataTable;

use App\Http\Controllers\Controller;
use DataTables;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DataTableController extends Controller
{
    public function invoiceWeb()
    {
        if(Gate::allows('admin')) {
            $data = Invoice::with(['harga', 'game', 'user.role'])->where('via', 'WEB')->get();
            return DataTables::of($data)->toJson();
        } else {
            abort(404);
        }
    }

    public function invoiceAdmin()
    {
        if(Gate::allows('admin')) {
            $data = Invoice::with(['harga', 'game', 'user.role'])->where('via', 'REALM')->get();
            return DataTables::of($data)->toJson();
        } else {
            abort(404);
        }
    }

    public function invoiceReseller()
    {
        if(Gate::allows('reseller')) {
            $data = Invoice::with(['harga', 'game', 'user.role'])->where('via', 'REALM')->where('realm_user_id', auth()->id())->get();
            return DataTables::of($data)->toJson();
        } else {
            abort(404);
        }
    }
}
