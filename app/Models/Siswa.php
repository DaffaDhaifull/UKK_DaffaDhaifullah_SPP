<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable
{
    use HasFactory;
    protected $table = 'siswa';
    protected $primaryKey = 'nisn';
    protected $fillable = ['nis','nama','id_kelas','alamat','no_tlp','id_spp'];

    public function spp(){
        return $this->belongsTo(Spp::class,'id_spp','id_spp');
    }
    public function kelas(){
        return $this->belongsTo(Kelas::class,'id_kelas','id_kelas');
    }
    public function pembayaran(){
        return $this->hasMany(Pembayaran::class,'nisn','nisn');
    }
}
