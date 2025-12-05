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
            background-color: #28a745; 
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
        .success { 
            background-color: #d4edda; 
            border-left: 4px solid #28a745; 
            padding: 15px; 
            margin: 15px 0; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>✅ SUSPEND ANDA SUDAH BERAKHIR</h2>
        </div>
        
        <div class="content">
            <p>Halo {{ $userName }},</p>
            
            <div class="success">
                <strong>SELAMAT!</strong> Periode suspend Anda telah berakhir dan akun Anda kembali aktif.
            </div>
            
            <h3>Status Akun:</h3>
            <p>✅ Akun Anda telah <strong>AKTIF KEMBALI</strong></p>
            <p>✅ Anda bisa meminjam barang seperti biasa</p>
            <p>✅ Anda bisa membuat request peminjaman baru</p>
            
            <h3>Pengingat Penting:</h3>
            <ul>
                <li>Selalu kembalikan barang tepat waktu sesuai tenggat waktu</li>
                <li>Jika akan terlambat, segera laporkan ke admin</li>
                <li>Jaga kondisi barang dengan baik</li>
                <li>Hindari peminjaman telat untuk mencegah suspend lagi</li>
            </ul>
            
            <p>Terima kasih atas kerja sama Anda. Semoga ke depannya Anda selalu mengembalikan barang tepat waktu!</p>
            
            <p>Salam,<br>Tim SIPINJAM Fasilkom UNEJ</p>
        </div>
        
        <div class="footer">
            <p>&copy; 2025 SIPINJAM - Sistem Peminjaman Inventaris Fasilkom UNEJ</p>
        </div>
    </div>
</body>
</html>
