<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            line-height: 1.6; 
            color: #333; 
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            padding: 20px; 
        }
        .header { 
            background-color: #f39c12; 
            color: white; 
            padding: 20px; 
            text-align: center; 
            border-radius: 5px 5px 0 0; 
        }
        .content { 
            background-color: #f9f9f9; 
            padding: 20px; 
            border: 1px solid #ddd; 
        }
        .footer { 
            background-color: #333; 
            color: white; 
            padding: 10px; 
            text-align: center; 
            font-size: 12px; 
            border-radius: 0 0 5px 5px; 
        }
        .warning { 
            background-color: #fff3cd; 
            border-left: 4px solid #ffc107; 
            padding: 10px; 
            margin: 10px 0; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>⚠️ PERINGATAN: PEMINJAMAN TELAT</h2>
        </div>
        
        <div class="content">
            <p>Halo {{ $userName }},</p>
            
            <p>Kami ingin mengingatkan bahwa peminjaman barang Anda sudah melampaui tenggat waktu pengembalian.</p>
            
            <div class="warning">
                <strong>Detail Peminjaman:</strong><br>
                Barang: {{ $barangName }}<br>
                Tanggal Pinjam: {{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}<br>
                Tanggal Kembali (Rencana): {{ $peminjaman->tanggal_kembali->format('d-m-Y') }}<br>
                <strong>Hari Telat: {{ $daysLate }} hari</strong>
            </div>
            
            <p><strong>PERHATIAN:</strong> Jika peminjaman telat terus berlanjut, akun Anda akan <strong>TERKENA SUSPEND</strong> dan tidak bisa meminjam barang lagi selama periode tertentu.</p>
            
            <p>Segera kembalikan barang Anda untuk menghindari suspend akun. Terima kasih!</p>
            
            <p>Salam,<br>Tim SIPINJAM Fasilkom UNEJ</p>
        </div>
        
        <div class="footer">
            <p>&copy; 2025 SIPINJAM - Sistem Peminjaman Inventaris Fasilkom UNEJ</p>
        </div>
    </div>
</body>
</html>
