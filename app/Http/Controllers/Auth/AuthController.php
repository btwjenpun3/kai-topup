<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.auth.index');
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]); 
        if($credentials) {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate(); 
                return redirect()->route('dashboard.index');                      
            } else {
                return redirect()->route('auth.index')->with('error', 'Email dan Password salah!');
            }            
        } else {
            return redirect()->route('auth.index')->with('error', 'Harap masukkan Email dan Password!');
        }        
    }

    public function register()
    {
        return view('pages.auth.register');
    }

    public function registerProcess(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|integer',
            'password' => 'required|confirmed|min:6'
        ], [
            'email.unique' => 'Email ini sudah tedaftar',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Password kamu tidak cocok! Harap masukkan password dengan benar'
        ]);
        if($validation) {
            User::create([
                'role_id' => 2,
                'kode_reseller' => 'fumola-' . Str::random(10),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password)
            ]);
            return redirect()->route('auth.index')->with('success', 'Akun kamu berhasil terdaftar. Silahkan Login untuk masuk ke dalam Member Realm');
        } else {
            return back()->with('error', 'Harap masukkan semua data kamu!');
        }
    }

    public function privacy()
    {
        return view('master.private.privacy-policy');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        $userFromGoogle = Socialite::driver('google')->user();
        $checkUser = User::where('email', $userFromGoogle->getEmail())->first();
        if($checkUser) {
            if($checkUser->email == $userFromGoogle->getEmail() && !isset($checkUser->google_id)) {
                return redirect()->route('auth.index')->with('error', 'Email ini sudah terdaftar tanpa Google! Silahkan login menggunakan form di bawah ini.');
            } else {
                Auth::login($checkUser);
                $request->session()->regenerate(); 
                return redirect()->route('dashboard.index'); 
            }                   
        } else {          
            $kodeReseller = 'fumola-' . Str::random(10);
            $createUser = User::create([
                'role_id' => 2,
                'kode_reseller' => $kodeReseller,
                'name' => $userFromGoogle->getName(),
                'email' => $userFromGoogle->getEmail(),
                'phone' => '62000000000',
                'google_id' => $userFromGoogle->getId(),                
                'password' => bcrypt($kodeReseller),
                'password_changed' => 0
            ]);
            if($createUser) {
                Auth::login($createUser);
                $request->session()->regenerate(); 
                return redirect()->route('dashboard.index'); 
            } else {
                return redirect()->route('auth.index')->with('error', 'Terdapat masalah saat Login ke Google. Silahkan coba lagi nanti.');
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 
        return redirect()->route('auth.index');
    }
}
