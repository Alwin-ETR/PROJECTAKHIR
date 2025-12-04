<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang; 

class LandingController extends Controller
{
    public function index()
    {
        $barangList = Barang::where('status', 'tersedia')->get(); 
        return view('landing', compact('barangList'));
    }
}
