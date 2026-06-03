<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjam;

class PeminjamSeeder extends Seeder
{
    public function run(): void
    {
        Peminjam::create([
            'nama_peminjam' => 'Ahmad Fauzan',
            'kelas' => 'XI PPLG 1',
            'jurusan' => 'PPLG',
            'no_hp' => '081234567801',
        ]);

        Peminjam::create([
            'nama_peminjam' => 'Rizky Pratama',
            'kelas' => 'XI PPLG 2',
            'jurusan' => 'PPLG',
            'no_hp' => '081234567802',
        ]);

        Peminjam::create([
            'nama_peminjam' => 'Dinda Putri',
            'kelas' => 'XI PPLG 1',
            'jurusan' => 'PPLG',
            'no_hp' => '081234567803',
        ]);
    }
}
