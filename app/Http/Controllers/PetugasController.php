<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index(){
        $petugas = Petugas::all();
        return view('data.petugas', compact('petugas'));
    }
    public function store(Request $request){
        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:petugas,username',
            'password' => 'required|string|min:6',
            'level' => 'required|in:admin,petugas'
        ]);

        Petugas::create([
            'nama_petugas'=> $request->nama,
            'username'=> $request->username,
            'password'=> Hash::make($request->password),
            'leve'=> $request->level,
        ]);

        return redirect()->route('petugas.index')->with('success','Data Bersahil ditambahkan');
    }

    public function show(string $id){
        $petugas = Petugas::find($id);
        return response()->json($petugas);
    }

    public function update(Request $request, string $id){
        $petugas = Petugas::find($id);
        $request->validate([
            'nama' => 'required',
            'username' => 'required|string|unique:petugas,username,' . $id.',id_petugas',
            'level' => 'required|in:admin,petugas',
        ]);

        if($request->password != ""){
            $pw = Hash::make($request->password);
        }else{
            $pw = $petugas->password;
        }

        Petugas::where('id_petugas',$id)->update([
            'nama_petugas' => $request->nama,
            'username' => $request->username,
            'password' => $pw,
            'level' => $request->level,
        ]);

        return redirect()->route('petugas.index')->with('success','Data berhasil di ubah');
    }

    public function destroy(string $id){
        $petugas = Petugas::find($id);
        $petugas->delete();
        return redirect()->route('petugas.index')->with('success','Data berhasil dihapus');
    }


}
