<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang; // pastikan model Barang sudah dibuat

class LandingController extends Controller
{
    public function index()
    {
        // Ambil data barang (misal inventaris yang tersedia)
        $barangList = Barang::where('status', 'tersedia')->get(); // atau bisa juga: all(), paginate(), dsb

        // Kirim ke landing.blade.php
        return view('landing', compact('barangList'));
    }
}
