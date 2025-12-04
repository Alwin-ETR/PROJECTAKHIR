<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
        font-family: Arial, sans-serif;
        font-size: 11px;
        color: #000;
        margin: 28px;
        background: #fff;
        }

        h1 {
            text-align: center;
            margin-bottom: 2px;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .subtitle {
            text-align: center;
            font-size: 11px;
            margin-bottom: 18px;
        }

        .info-box {
            margin-bottom: 16px;
            padding: 8px 10px;
            border: 1px solid #000;
            border-radius: 0;
            font-size: 11px;
            background: #fff;
        }

        .info-box strong {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            box-sizing: border-box;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 4px;
            font-size: 10px;
            word-break: break-word;
        }

        th {
            text-align: center;
            font-weight: bold;
            background: #f2f2f2;
        }

        tr:nth-child(even) {
            background: #fafafa;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 2px;
            font-size: 9px;
            min-width: 60px;
            text-align: center;
            border: 1px solid #000;
            text-transform: uppercase;
            background: #fff;
            color: #000;
        }

        /* Semua status tampil hitam-putih saja */
        .badge-success,
        .badge-warning,
        .badge-danger,
        .badge-primary {
            background: #fff;
            color: #000;
        }

        .footer {
            margin-top: 22px;
            border-top: 1px solid #000;
            font-size: 9px;
            text-align: center;
            padding-top: 6px;
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
