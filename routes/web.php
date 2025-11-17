<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Admin Routes dengan middleware admin
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // CRUD Barang
        Route::get('/barang', [AdminController::class, 'barangIndex'])->name('admin.barang.index');
        Route::get('/barang/create', [AdminController::class, 'barangCreate'])->name('admin.barang.create');
        Route::post('/barang', [AdminController::class, 'barangStore'])->name('admin.barang.store');
        Route::get('/barang/{barang}/edit', [AdminController::class, 'barangEdit'])->name('admin.barang.edit');
        Route::put('/barang/{barang}', [AdminController::class, 'barangUpdate'])->name('admin.barang.update');
        Route::delete('/barang/{barang}', [AdminController::class, 'barangDestroy'])->name('admin.barang.destroy');
        
        // Manajemen Mahasiswa
        Route::get('/mahasiswa', [AdminController::class, 'mahasiswaIndex'])->name('admin.mahasiswa.index');
        Route::get('/mahasiswa/{user}/peminjaman', [AdminController::class, 'mahasiswaPeminjaman'])->name('admin.mahasiswa.peminjaman');
        
        // Manajemen Peminjaman
        Route::get('/peminjaman', [AdminController::class, 'peminjamanIndex'])->name('admin.peminjaman.index');
        Route::post('/peminjaman/{peminjaman}/approve', [AdminController::class, 'approvePeminjaman'])->name('admin.peminjaman.approve');
        Route::post('/peminjaman/{peminjaman}/reject', [AdminController::class, 'rejectPeminjaman'])->name('admin.peminjaman.reject');
        Route::post('/peminjaman/{peminjaman}/complete', [AdminController::class, 'completePeminjaman'])->name('admin.peminjaman.complete');
    });
    
    // Mahasiswa Routes dengan middleware mahasiswa
    Route::middleware(['mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [MahasiswaController::class, 'profile'])->name('profile');
        Route::get('/barang/{id}', [MahasiswaController::class, 'showBarang'])->name('barang.show');
        Route::get('/search', [MahasiswaController::class, 'searchBarang'])->name('search');
        Route::post('/cart/add/{id}', [MahasiswaController::class, 'addToCart'])->name('cart.add');
        Route::put('/cart/update/{id}', [MahasiswaController::class, 'updateCart'])->name('cart.update');
        Route::delete('/cart/remove/{id}', [MahasiswaController::class, 'removeFromCart'])->name('cart.remove');
        Route::delete('/cart/clear', [MahasiswaController::class, 'clearCart'])->name('cart.clear');
        Route::get('/pengajuan', [MahasiswaController::class, 'showPengajuanForm'])->name('pengajuan.form');
        Route::post('/peminjaman/submit', [MahasiswaController::class, 'submitPeminjaman'])->name('peminjaman.submit');
        Route::get('/riwayat', [MahasiswaController::class, 'riwayat'])->name('riwayat');
    });
});