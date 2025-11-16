<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Kelas;
use App\Models\Petugas;
use App\Models\Siswa;
use App\Models\Spp;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();


        Kelas::create([
            'nama_kelas' => '12 A',
            'kompetensi_keahlian' => 'Rekayasa Perangkat Lunak',
        ]);

        Spp::create([
            'tahun' => '2025',
            'nominal' => '200000'
        ]);

        Siswa::create([
            'nisn' => '09081234',
            'nis' => '20240001',
            'nama' => 'siswa',
            'id_kelas' => '1',
            'alamat' => '-',
            'no_telepon' => '012345',
            'id_spp' => '1',
            'password' => Hash::make('password'),
        ]);

        Petugas::create([
            'username' => 'admin',
            'password' => Hash::make('password'),
            'nama_petugas' => 'TestAdmin',
            'level' => 'admin',
        ]);

        Petugas::create([
            'username' => 'petugas',
            'password' => Hash::make('password'),
            'nama_petugas' => 'TestPetugas',
            'level' => 'petugas',
        ]);
    }
}
