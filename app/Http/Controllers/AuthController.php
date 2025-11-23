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
        $siswa = Siswa::where('nis', $request->username)->first();

        if ($petugas && Hash::check($request->password, $petugas->password)) {
            $petugas->last_login = now();
            $petugas->save();

            Auth::guard('petugas')->login($petugas);
            $request->session()->regenerate();

            if ($petugas->level === 'admin') {
                return redirect()->route('beranda.admin');
            }

            return redirect()->route('beranda.petugas');
        }

        if ($siswa && Hash::check($request->password, $siswa->password)) {
            $siswa->last_login = now();
            $siswa->save();

            Auth::guard('siswa')->login($siswa);
            $request->session()->regenerate();

            return redirect()->route('beranda.siswa',Auth::guard('siswa')->user()->nisn);
        }

        return back()->withErrors(['message' => 'Username atau password salah']);
    }



    public function logout(Request $request){
        if (Auth::guard('petugas')->check()) {
            $petugas = Auth::guard('petugas')->user();
            $petugas->last_logout = now();
            $petugas->save();

            Auth::guard('petugas')->logout();
        }
        if (Auth::guard('siswa')->check()) {
            $siswa = Auth::guard('siswa')->user();
            $siswa->last_logout = now();
            $siswa->save();

            Auth::guard('siswa')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
