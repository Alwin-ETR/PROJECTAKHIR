<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // Form Laporan (filter)
    public function formLaporan()
    {
        // Ambil semua mahasiswa dari database
        $list_mahasiswa = \App\Models\User::where('role', 'mahasiswa')->orderBy('name')->get();
        return view('admin.peminjaman.laporan', compact('list_mahasiswa'));
    }

    // Download Laporan PDF
    public function downloadRiwayat(Request $request)
    {
        $query = Peminjaman::with(['user', 'barang']);

        // Filter tanggal
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }
        // Filter mahasiswa tertentu
        if ($request->mahasiswa_id) {
            $query->where('user_id', $request->mahasiswa_id);
        }
        // Status
        if ($request->status) {
            $query->where('status', $request->status);
        }
        // Terbaru 
        if ($request->terbaru == 1) {
            $query->orderBy('created_at', 'desc')->limit(10);
        }

        $riwayat = $query->orderBy('created_at', 'desc')->get();

        $data = [
            'title' => 'Laporan Riwayat Peminjaman Mahasiswa',
            'riwayat' => $riwayat,
            'periode' => $request->start_date && $request->end_date 
                ? Carbon::parse($request->start_date)->format('d/m/Y') . ' - ' . Carbon::parse($request->end_date)->format('d/m/Y')
                : 'Semua Periode',
            'generated_by' => auth()->user()->name,
            'generated_at' => now()->format('d/m/Y H:i:s')
        ];

        $pdf = Pdf::loadView('admin.peminjaman.laporan-riwayat-pdf', $data)
                  ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-riwayat-peminjaman-' . now()->format('Ymd-His') . '.pdf');
    }
}
