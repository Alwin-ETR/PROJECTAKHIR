<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        Barang::create([
            'kode_barang' => 'P-001',
            'nama' => 'Palu Presidium',
            'deskripsi' => 'Palu untuk persidangan',
            'stok' => 5,
            'status' => 'tersedia'
        ]);

        Barang::create([
            'kode_barang' => 'PRO-001',
            'nama' => 'Projector Epson',
            'deskripsi' => 'Projector untuk presentasi',
            'stok' => 3,
            'status' => 'tersedia'
        ]);

        Barang::create([
            'kode_barang' => 'RUANG-B1',
            'nama' => 'Ruang Kelas B1',
            'deskripsi' => 'Ruang kelas B1 Fasilkom',
            'stok' => 1,
            'status' => 'tersedia'
        ]);

        Barang::create([
            'kode_barang' => 'RUANG-LP',
            'nama' => 'Lab Pertanian Cerdas',
            'deskripsi' => 'Laboratorium IoT untuk praktikum',
            'stok' => 1,
            'status' => 'tersedia'
        ]);
    }
}