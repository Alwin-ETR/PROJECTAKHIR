<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\MahasiswaController as AdminMahasiswaController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Mahasiswa\DashboardController as MhsDashboardController;
use App\Http\Controllers\Mahasiswa\KatalogController;
use App\Http\Controllers\Mahasiswa\KeranjangController;
use App\Http\Controllers\Mahasiswa\PeminjamanController as MhsPeminjamanController;
use App\Http\Controllers\Mahasiswa\ProfileController as MhsProfileController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Public
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/loginproses', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/lupa-password', [AuthController::class, 'forgotPassword'])->name('password.request');
Route::post('/lupa-password', [AuthController::class, 'sendReset'])->name('password.email');

Route::get('/ketentuan', function () {
    return view('ketentuan');
})->name('ketentuan');

// Password reset routes (Laravel built-in)
// Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
// Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
// Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
// Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.store');

// Authenticated
Route::middleware(['auth'])->group(function () {

    // Admin
    Route::middleware(['admin'])->prefix('admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/barang', [BarangController::class, 'index'])->name('admin.barang.index');
        Route::get('/barang/create', [BarangController::class, 'create'])->name('admin.barang.create');
        Route::post('/barang', [BarangController::class, 'store'])->name('admin.barang.store');
        Route::get('/barang/{barang}/edit', [BarangController::class, 'edit'])->name('admin.barang.edit');
        Route::put('/barang/{barang}', [BarangController::class, 'update'])->name('admin.barang.update');
        Route::delete('/barang/{barang}', [BarangController::class, 'destroy'])->name('admin.barang.destroy');
 
        Route::get('/mahasiswa', [AdminMahasiswaController::class, 'index'])->name('admin.mahasiswa.index');
        Route::get('/mahasiswa/{user}/peminjaman', [AdminMahasiswaController::class, 'peminjaman'])->name('admin.mahasiswa.peminjaman');

        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('admin.peminjaman.index');
        Route::post('/peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('admin.peminjaman.approve');
        Route::post('/peminjaman/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('admin.peminjaman.reject');
        Route::post('/peminjaman/{peminjaman}/complete', [PeminjamanController::class, 'complete'])->name('admin.peminjaman.complete');
        Route::post('/peminjaman/{peminjaman}/verifikasi-kembali', [PeminjamanController::class, 'verifikasi_kembali'])->name('admin.peminjaman.verifikasi-kembali');

        Route::get('/peminjaman/laporan', [LaporanController::class, 'formLaporan'])->name('admin.peminjaman.laporan');
        Route::get('/peminjaman/laporan/download', [LaporanController::class, 'downloadRiwayat'])->name('admin.peminjaman.laporan.download');
    });

    // Mahasiswa
        Route::middleware(['auth', 'mahasiswa'])->prefix('mahasiswa')->group(function () {
        Route::get('/dashboard', [MhsDashboardController::class, 'index'])->name('mahasiswa.dashboard');

        Route::get('/katalog', [KatalogController::class, 'index'])->name('mahasiswa.katalog');
        Route::get('/barang/{id}', [KatalogController::class, 'show'])->name('mahasiswa.barang.show');
        Route::get('/search', [KatalogController::class, 'search'])->name('mahasiswa.search');

        Route::post('/cart/add/{id}', [KeranjangController::class, 'add'])->name('mahasiswa.cart.add');
        Route::put('/cart/update/{id}', [KeranjangController::class, 'update'])->name('mahasiswa.cart.update');
        Route::delete('/cart/remove/{id}', [KeranjangController::class, 'remove'])->name('mahasiswa.cart.remove');
        Route::delete('/cart/clear', [KeranjangController::class, 'clear'])->name('mahasiswa.cart.clear');

        Route::get('/pengajuan', [MhsPeminjamanController::class, 'showPengajuanForm'])->name('mahasiswa.pengajuan.form');
        Route::post('/peminjaman/submit', [MhsPeminjamanController::class, 'submit'])->name('mahasiswa.peminjaman.submit');
        Route::get('/riwayat', [MhsPeminjamanController::class, 'riwayat'])->name('mahasiswa.riwayat');
        Route::post('/peminjaman/{id}/return', [MhsPeminjamanController::class, 'confirmReturn'])->name('mahasiswa.peminjaman.return');
        Route::get('/peminjaman/{id}/bukti-pdf', [MhsPeminjamanController::class, 'downloadBuktiPDF'])->name('mahasiswa.peminjaman.bukti-pdf');

        Route::get('/profile', [MhsProfileController::class, 'index'])->name('mahasiswa.profile');
        Route::put('/profile', [MhsProfileController::class, 'update'])->name('mahasiswa.profile.update');
        Route::put('/profile/password', [MhsProfileController::class, 'updatePassword'])->name('mahasiswa.profile.update-password');
    });
});
