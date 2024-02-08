<?php

namespace App\Http\Controllers\Private\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::where('id', auth()->id())->first();
        return view('pages.private.profile.index', [
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        try {
            $validation = $request->validate([
                'name' => 'required',
                'phone' => 'required|integer'
            ], [
                'name.required' => 'Nama harus diisi!',
                'phone.required' => 'Nomor telepon harus diisi!',
                'phone.integer' => 'Telepon harus berisi angka!'
            ]);
            if($validation) {
                User::where('id', auth()->id())->update([
                    'name' => $request->name,
                    'phone' => $request->phone
                ]);
                return redirect()->route('profile.index')->with('success', 'Data kamu berhasil di ubah');
            } else {
                return redirect()->route('profile.index')->with('error', 'Gagal merubah data. Harap hubungi Admin!');
            }          
        } catch (\Exception $e) {
            Log::error('Gagal Update Profile: ' . $e->getMessage());
            return redirect()->route('profile.index')->with('error', 'Gagal merubah data. Harap hubungi Admin!');
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $validation = $request->validate([
                'old_password' => 'required',
                'password' => 'required|confirmed|min:6'
            ], [
                'password.confirmed' => 'Password tidak cocok!',
                'password.min' => 'Panjang Password minimal 6 karakter!'
            ]);
            if($validation) {
                $user = auth()->user();
                if(Hash::check($request->old_password, $user->password)) {
                    User::where('id', auth()->id())->update([
                        'password' => $request->password
                    ]);
                    return redirect()->route('profile.index')->with('success', 'Password berhasil di ubah');
                } else {
                    return redirect()->route('profile.index')->with('error', 'Password Lama kamu salah!');
                }
            }
        } catch (\Exception $e) {
            Log::error('Gagal Update Profile: ' . $e->getMessage());
            return redirect()->route('profile.index')->with('error', $e->getMessage());
        }
    }
}
