@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header bg-success text-white">
        <h5>Unduh Laporan Riwayat Peminjaman</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.peminjaman.laporan.download') }}" target="_blank" class="row g-3">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" class="form-control" />
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">Tanggal Akhir</label>
                <input type="date" name="end_date" id="end_date" class="form-control" />
            </div>
            <div class="col-md-4">
                <label for="mahasiswa_id" class="form-label">Mahasiswa</label>
                <select name="mahasiswa_id" id="mahasiswa_id" class="form-select">
                    <option value="">Semua Mahasiswa</option>
                    @foreach($list_mahasiswa as $mhs)
                        <option value="{{ $mhs->id }}">{{ $mhs->name }} ({{ $mhs->nim }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label>Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="borrowed">Dipinjam</option>
                    <option value="returned">Dikembalikan</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
            <div class="col-12">
                <label>Terbaru Saja</label>
                <select name="terbaru" id="terbaru" class="form-select">
                    <option value="0">Semua Data</option>
                    <option value="1">Hanya 10 Terakhir</option>
                </select>
            </div>
            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-file-download"></i> Download Laporan PDF
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
