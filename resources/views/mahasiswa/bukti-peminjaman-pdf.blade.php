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
            font-family: Arial, sans-serif;
            color: #000;
            background: #fff;
            line-height: 1.5;
            font-size: 12px;
        }

        .container {
            padding: 32px;
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            padding-bottom: 16px;
            margin-bottom: 24px;
            border-bottom: 1px solid #000;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 11px;
        }

        .tanggal-cetak {
            text-align: right;
            margin-bottom: 16px;
            font-size: 11px;
        }

        .section {
            margin-bottom: 18px;
        }

        .section-title {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        table tr {
            border-bottom: 1px solid #ccc;
        }

        table td {
            padding: 6px 4px;
            vertical-align: top;
        }

        table td:first-child {
            width: 32%;
            font-weight: bold;
        }

        .badge {
            display: inline-block;
            padding: 3px 6px;
            border: 1px solid #000;
            border-radius: 2px;
            font-size: 10px;
            font-weight: normal;
            text-transform: uppercase;
        }

        /* Semua status hitam-putih saja */
        .badge-success,
        .badge-pending,
        .badge-danger,
        .badge-info {
            background: #fff;
            color: #000;
        }

        .footer {
            margin-top: 32px;
            text-align: center;
            font-size: 10px;
            border-top: 1px solid #000;
            padding-top: 8px;
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
            <p>&copy; 2025 SIPINJAM - Fakultas Ilmu Komputer Universitas Jember</p>
        </div>
    </div>
</body>
</html>
