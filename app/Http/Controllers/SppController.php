<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spp;

class SppController extends Controller
{
    public function index(){
        $spp = Spp::all();
        return view('data.spp',compact("spp"));
    }

    public function store(Request $request){
        $request->validate([
            'tahun' => 'required|unique:spp,tahun',
            'nominal' => 'required|integer',
        ]);
        Spp::create([
            'tahun' => $request->tahun,
            'nominal' => $request->nominal,
        ]);

        return redirect()->route('spp.index')->with('success','Data berhasil di simpan.');
    }

    public function show(string $id){
        $spp = Spp::find($id);
        return response()->json($spp);
    }

    public function update(Request $request,string $id){
        $request->validate([
            'tahun' => 'required|unique:spp,tahun,'.$id.',id_spp',
            'nominal' => 'required|integer',
        ]);
        Spp::where('id_spp',$id)->update([
            'tahun'=> $request->tahun,
            'nominal' => $request->nominal,
        ]);

        return redirect()->route('spp.index')->with('success','Data berhasil di ubah.');
    }

    public function destroy(string $id){
        Spp::destroy($id);
        return redirect()->route('spp.index')->with('success','Data berhasil di hapus.');
    }
}
