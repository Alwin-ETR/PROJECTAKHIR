// SweetAlert untuk notifikasi
function showAlert(type, title, message) {
    Swal.fire({
        icon: type,
        title: title,
        text: message,
        timer: 3000,
        showConfirmButton: false
    });
}

// AJAX untuk peminjaman barang
document.addEventListener('DOMContentLoaded', function() {
    // Session untuk keranjang peminjaman
    let keranjang = JSON.parse(sessionStorage.getItem('keranjang_peminjaman')) || [];
    
    // Tombol tambah ke keranjang
    const tambahKeranjangButtons = document.querySelectorAll('.tambah-keranjang');
    tambahKeranjangButtons.forEach(button => {
        button.addEventListener('click', function() {
            const barangId = this.dataset.barangId;
            const barangNama = this.dataset.barangNama;
            
            keranjang.push({
                id: barangId,
                nama: barangNama
            });
            
            sessionStorage.setItem('keranjang_peminjaman', JSON.stringify(keranjang));
            showAlert('success', 'Berhasil', 'Barang ditambahkan ke keranjang');
        });
    });
    
    // Notifikasi tenggat waktu
    function checkTenggatWaktu() {
        fetch('/api/peminjaman/tenggat')
            .then(response => response.json())
            .then(data => {
                if (data.overdue.length > 0) {
                    showAlert('warning', 'Peringatan', 
                        `Anda memiliki ${data.overdue.length} barang yang harus segera dikembalikan`);
                }
            });
    }
    
    // Panggil saat halaman dimuat
    checkTenggatWaktu();
});