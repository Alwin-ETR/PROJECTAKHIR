<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Peminjaman</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            font-family: 'Inter', Arial, sans-serif;
            color: #333;
            background: #fff;
            line-height: 1.6;
        }
        
        .container {
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            border-bottom: 4px solid #0d6efd;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 12px;
            color: #666;
        }
        
        .tanggal-cetak {
            text-align: right;
            margin-bottom: 20px;
            font-size: 12px;
            color: #666;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section-title {
            background: #0d6efd;
            color: white;
            padding: 10px 15px;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        table tr {
            border-bottom: 1px solid #ddd;
        }
        
        table td {
            padding: 10px;
            font-size: 13px;
        }
        
        table td:first-child {
            font-weight: 600;
            width: 35%;
            background: #f8f9fa;
            color: #333;
        }
        
        table td:last-child {
            color: #555;
        }
        
        .badge {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 12px;
        }
        
        .badge-success {
            background: #198754;
            color: white;
        }
        
        .badge-pending {
            background: #ffc107;
            color: black;
        }
        
        .badge-danger {
            background: #dc3545;
            color: white;
        }
        
        .badge-info {
            background: #0dcaf0;
            color: black;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 11px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>BUKTI PEMINJAMAN BARANG</h1>
            <p>Sistem Peminjaman Inventaris Fasilkom UNEJ</p>
        </div>

        <!-- Tanggal Cetak -->
        <div class="tanggal-cetak">
            Dicetak: {{ $tanggalCetak->format('d/m/Y H:i:s') }}
        </div>

        <!-- Data Mahasiswa -->
        <div class="section">
            <div class="section-title">DATA MAHASISWA</div>
            <table>
                <tr>
                    <td>Nama Mahasiswa</td>
                    <td>{{ $peminjaman->user->name }}</td>
                </tr>
                <tr>
                    <td>NIM</td>
                    <td>{{ $peminjaman->user->nim }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $peminjaman->user->email }}</td>
                </tr>
            </table>
        </div>

        <!-- Detail Barang -->
        <div class="section">
            <div class="section-title">DETAIL BARANG</div>
            <table>
                <tr>
                    <td>Nama Barang</td>
                    <td>{{ $peminjaman->barang->nama }}</td>
                </tr>
                <tr>
                    <td>Jumlah Dipinjam</td>
                    <td>{{ $peminjaman->jumlah }} {{ $peminjaman->barang->satuan ?? 'unit' }}</td>
                </tr>
            </table>
        </div>

        <!-- Jadwal Peminjaman -->
        <div class="section">
            <div class="section-title">JADWAL PEMINJAMAN</div>
            <table>
                <tr>
                    <td>Tanggal Mulai Pinjam</td>
                    <td>{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td>Tanggal Harus Dikembalikan</td>
                    <td>{{ $peminjaman->tanggal_kembali->format('d/m/Y') }}</td>
                </tr>
                @if($peminjaman->tanggal_pengembalian)
                <tr>
                    <td>Tanggal Pengembalian</td>
                    <td>{{ $peminjaman->tanggal_pengembalian->format('d/m/Y') }}</td>
                </tr>
                @endif
            </table>
        </div>

        <!-- Status Peminjaman -->
        <div class="section">
            <div class="section-title">STATUS PEMINJAMAN</div>
            <table>
                <tr>
                    <td>Status</td>
                    <td>
                        @php
                            $badgeClass = [
                                'pending' => 'badge-pending',
                                'disetujui' => 'badge-success',
                                'ditolak' => 'badge-danger',
                                'dikembalikan' => 'badge-info'
                            ][$peminjaman->status] ?? 'badge-pending';
                            
                            $statusText = [
                                'pending' => 'Menunggu Persetujuan',
                                'disetujui' => 'Disetujui',
                                'ditolak' => 'Ditolak',
                                'dikembalikan' => 'Sudah Dikembalikan'
                            ][$peminjaman->status] ?? 'Tidak Diketahui';
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                    </td>
                </tr>
                @if($peminjaman->alasan)
                <tr>
                    <td>Alasan Peminjaman</td>
                    <td>{{ $peminjaman->alasan }}</td>
                </tr>
                @endif
                @if($peminjaman->catatan_admin)
                <tr>
                    <td>Catatan Admin</td>
                    <td>{{ $peminjaman->catatan_admin }}</td>
                </tr>
                @endif
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2025 SIPINJAM - Fasilkom UNEJ</p>
        </div>
    </div>
</body>
</html>
