<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin(){
        return view('login');
    }
    public function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $petugas = Petugas::where('username', $request->username)->first();
        $siswa = Siswa::where('no_telepon', $request->username)->first();

        // === PETUGAS & ADMIN ===
        if ($petugas && Hash::check($request->password, $petugas->password)) {
            Auth::guard('petugas')->login($petugas);
            $request->session()->regenerate();

            if ($petugas->level === 'admin') {
                return redirect()->route('beranda.admin');
            }

            return redirect()->route('beranda.petugas');
        }

        // === SISWA ===
        if ($siswa && Hash::check($request->password, $siswa->password)) {
            Auth::guard('siswa')->login($siswa);
            $request->session()->regenerate();

            return redirect()->route('beranda.siswa');
        }

        return back()->withErrors(['message' => 'Username atau password salah']);
    }



    public function logout(Request $request){
        if (Auth::guard('petugas')->check()) {
            Auth::guard('petugas')->logout();
        }
        if (Auth::guard('siswa')->check()) {
            Auth::guard('siswa')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
