<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;

class BerandaController extends Controller
{
    public function admin(){
        return view('beranda.admin');
    }
    public function petugas(){
        return view('beranda.petugas');
    }
    public function siswa(){
        return view('beranda.siswa');
    }
}
