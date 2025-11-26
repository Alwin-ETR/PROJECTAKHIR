<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 28px;
        }
        h1 {
            text-align: center;
            margin-bottom: 0;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .subtitle {
            text-align: center;
            font-size: 13px;
            margin-bottom: 20px;
            color: #666;
        }
        .info-box {
            margin-bottom: 20px;
            padding: 10px;
            background: #f4f7fa;
            border-radius: 8px;
            font-size: 11px;
        }
        .info-box strong {
            color: #2e86de;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            box-sizing: border-box;
        }
        th, td {
            border: 1px solid #bfc9ca;
            padding: 8px 6px;
            font-size: 10px;
            word-break: break-word;
        }
        th {
            background: #667eea;
            color: #fff;
            text-align: center;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        tr:nth-child(even) { background: #f5f7fa; }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 7px;
            color: #fff;
            font-size: 9px;
            min-width: 65px;
            text-align: center;
            font-weight: 500;
        }
        .badge-success { background: #27ae60; }
        .badge-warning { background: #f39c12; }
        .badge-danger { background: #c0392b; }
        .badge-primary { background: #2980b9; }
        .footer {
            margin-top: 25px;
            border-top: 2px solid #eee;
            font-size: 10px;
            color: #95a5a6;
            text-align: center;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <div class="subtitle">Sistem Manajemen Peminjaman Inventaris Fakultas</div>
    <div class="info-box">
        <strong>Periode:</strong> {{ $periode }}<br>
        <strong>Tanggal cetak:</strong> {{ $generated_at }}
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Inventaris</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayat as $no => $pmj)
            <tr>
                <td style="text-align:center;">{{ $no + 1 }}</td>
                <td>{{ $pmj->user->name }}</td>
                <td style="text-align:center;">{{ $pmj->user->nim ?? '-' }}</td>
                <td>{{ $pmj->barang->nama }}</td>
                <td style="text-align:center;">{{ \Carbon\Carbon::parse($pmj->tanggal_pinjam)->format('d/m/Y') }}</td>
                <td style="text-align:center;">{{ \Carbon\Carbon::parse($pmj->tanggal_kembali)->format('d/m/Y') }}</td>
                <td style="text-align:center;">
                    @php
                        $bg = $pmj->status == 'disetujui' ? 'badge-success'
                             : ($pmj->status == 'pending' ? 'badge-warning'
                             : ($pmj->status == 'returned' ? 'badge-primary'
                             : 'badge-danger'));
                    @endphp
                    <span class="badge {{ $bg }}">{{ ucfirst($pmj->status) }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; color:#888; padding:24px;">
                    Tidak ada data peminjaman.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer">
        © {{ now()->year }} SIPINJAM - Fakultas Ilmu Komputer Universitas Jember
    </div>
</body>
</html>
