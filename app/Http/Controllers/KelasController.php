<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function index(){
        $kelas = Kelas::all();
        return view('data.kelas',compact('kelas'));
    }

    public function store(Request $request){
        $request->validate([
            'kls' => 'required',
            'keahlian' => 'required',
        ]);
        Kelas::create([
            'nama_kelas' => $request->kls,
            'kompetensi_keahlian' => $request->keahlian,
        ]);

        return redirect()->route('kelas.index')->with('success','Data berhasil di simpan');
    }

    public function show($id){
        $kelas = Kelas::find($id);
        return response()->json($kelas);
    }

    public function update(Request $request, $id){
        $request->validate([
            'kls' => 'required',
            'keahlian' => 'required',
        ]);
        Kelas::where('id_kelas',$id)->update([
            'nama_kelas' => $request->kls,
            'kompetensi_keahlian' => $request->keahlian,
        ]);

        return redirect()->route('kelas.index')->with('success','Data berhasil di ubah.');
    }

    public function destroy($id){
        Kelas::destroy( $id );
        return redirect()->route('kelas.index')->with('success','Data berhasil di hapus');
    }
}
