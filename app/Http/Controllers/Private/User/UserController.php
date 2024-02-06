<?php

namespace App\Http\Controllers\Private\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        if(Gate::allows('admin')) { 
            $users = User::orderBy('id', 'asc')->paginate(10);
            return view('pages.private.user.index', [
                'users' => $users
            ]);
        } else {
            abort(404);
        }
    }

    public function show(Request $request)
    {
        if(Gate::allows('admin')) { 
            $user = User::find($request->id);
            return response()->json($user, 200);
        } else {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        if(Gate::allows('admin')) { 
            try {
                $validation = $request->validate([                    
                    'name' => 'required',
                    'email' => 'required',
                    'password' => 'required',
                    'phone' => 'required',
                    'role_id' => 'required'
                ]);
                if($validation) {
                    User::create([
                        'role_id' => $request->role_id,
                        'kode_reseller' => 'fumola-' . Str::random(10),
                        'name' => $request->name,
                        'email' => $request->email,
                        'saldo' => 0,
                        'password' => bcrypt($request->password),
                        'phone' => $request->phone,
                    ]);
                    return redirect()->route('user.index')->with('success', 'User baru berhasil di tambah');
                }
            } catch (\Exception $e) {
                return redirect()->route('user.index')->withErrors($e->getMessage());
            } 
        } else {
            abort(404);
        }       
    }

    public function tambahSaldo(Request $request)
    {
        if(Gate::allows('admin')) {
            try {
                $validation = $request->validate([
                    'saldo' => 'required|integer'
                ]);
                if($validation) {
                    $user = User::find($request->id);
                    $saldoSekarang = $user->saldo;
                    $saldoDiTambah = $request->saldo;
                    $saldoTotal = $saldoSekarang + $saldoDiTambah;
                    $user->update([
                        'saldo' => $saldoTotal
                    ]);
                    return response()->json([
                        'success' => 'Saldo berhasil di tambah'
                    ], 200);
                }                
            } catch (\Exception $e) {
                return response()->json([
                    'unaccepted' => 'Saldo gagal di tambah. Harap hubungi Admin!'
                ], 422);
            }
        } else {
            abort(404);
        }
    }
}
