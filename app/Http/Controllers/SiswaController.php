<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Spp;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index(){
        $kelas = Kelas::all();
        $spp = Spp::all();
        $siswa = Siswa::orderBy("created_at","desc")->paginate(25);
        return view('data.siswa',compact('siswa','kelas','spp'));
    }

    public function store(Request $request){
        $request->validate([
            'nisn' => 'required|unique:siswa,nisn',
            'nis' => 'required|unique:siswa,nis',
            'nama' => 'required|string',
            'idk' => 'required',
            'alamat' => 'required',
            'tlp' => 'required|string|max:15',
            'password' => 'required|string|min:6',
            'ids' => 'required',
        ]);
        Siswa::create([
            'nisn' => $request->nisn,
            'nis' => $request->nis,
            'nama' => $request->nama,
            'id_kelas' => $request->idk,
            'alamat'=> $request->alamat,
            'no_telepon' => $request->tlp,
            'password' => Hash::make($request->password),
            'id_spp' => $request->ids,
        ]);

        return redirect()->route('siswa.index')->with('success','Data berhasil di simpan.');
    }

    public function show(string $id){
        $siswa = Siswa::where('nisn',$id)->first();
        return response()->json($siswa);
    }

    public function update(Request $request,string $id){
        $siswa = Siswa::findOrFail($id);
        $request->validate([
            'nisn' => 'required|unique:siswa,nisn,'.$id.',nisn',
            'nis' => 'required|unique:siswa,nis,'.$id.',nisn',
            'nama' => 'required|string',
            'idk' => 'required',
            'alamat' => 'required',
            'tlp' => 'required|string|max:15|unique:siswa,no_telepon,'.$id.',nisn',
            'ids' => 'required',
        ]);

        if($request->password != ""){
            $pw = Hash::make($request->password);
        }else{
            $pw = $siswa->password;
        }

        $siswa->update([
            'nisn' => $request->nisn,
            'nis' => $request->nis,
            'nama' => $request->nama,
            'id_kelas' => $request->idk,
            'alamat'=> $request->alamat,
            'no_telepon' => $request->tlp,
            'password' => $pw,
            'id_spp' => $request->ids,
        ]);

        return redirect()->route('siswa.index')->with('success','Data berhasil di ubah.');
    }

    public function destroy(string $id){
        Siswa::destroy($id);
        return redirect()->route('siswa.index')->with('success','Data berhasil di hapus.');
    }
}
