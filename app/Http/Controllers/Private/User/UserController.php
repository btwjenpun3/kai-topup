<?php

namespace App\Http\Controllers\Private\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('pages.private.user.index', [
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
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
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'phone' => $request->phone,
                ]);
                return redirect()->route('user.index')->with('success', 'User baru berhasil di tambah');
            }
        } catch (\Exception $e) {
            return redirect()->route('user.index')->withErrors($e->getMessage());
        }        
    }
}
