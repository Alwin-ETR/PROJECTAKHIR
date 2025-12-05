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
            background-color: #dc3545; 
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
        .alert { 
            background-color: #f8d7da; 
            border-left: 4px solid #dc3545; 
            padding: 15px; 
            margin: 15px 0; 
        }
        .info-box { 
            background-color: #e7f3ff; 
            border-left: 4px solid #0066cc; 
            padding: 10px; 
            margin: 10px 0; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>🚫 AKUN ANDA TERKENA SUSPEND</h2>
        </div>
        
        <div class="content">
            <p>Halo {{ $userName }},</p>
            
            <div class="alert">
                <strong>NOTIFIKASI PENTING:</strong><br>
                Akun Anda telah terkena suspend dan tidak dapat melakukan peminjaman saat ini.
            </div>
            
            <h3>Alasan Suspend:</h3>
            <p>{{ $reason }}</p>
            
            <div class="info-box">
                <strong>Detail Suspend:</strong><br>
                Tanggal Suspend: {{ $suspension->suspended_at->format('d-m-Y H:i') }}<br>
                <strong>Suspend Berakhir: {{ $suspendedUntil->format('d-m-Y') }}</strong><br>
                Sisa Hari: <strong style="color: #dc3545;">{{ $daysRemaining }} hari</strong>
            </div>
            
            <h3>Apa yang Bisa Anda Lakukan?</h3>
            <ul>
                <li>✅ Anda masih bisa melihat katalog barang</li>
                <li>✅ Anda masih bisa melihat riwayat peminjaman</li>
                <li>❌ Anda <strong>TIDAK BISA</strong> meminjam barang baru</li>
                <li>❌ Anda <strong>TIDAK BISA</strong> membuat request peminjaman</li>
            </ul>
            
            <p>Setelah periode suspend berakhir, Anda dapat kembali meminjam barang seperti biasa. Kami akan mengirimkan email pemberitahuan saat suspend Anda sudah berakhir.</p>
            
            <p>Jika Anda merasa ini adalah kesalahan atau ingin membuat keberatan, silakan hubungi admin Fasilkom.</p>
            
            <p>Terima kasih atas pengertian Anda.<br>Tim SIPINJAM Fasilkom UNEJ</p>
        </div>
        
        <div class="footer">
            <p>&copy; 2025 SIPINJAM - Sistem Peminjaman Inventaris Fasilkom UNEJ</p>
        </div>
    </div>
</body>
</html>
