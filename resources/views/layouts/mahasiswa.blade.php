@extends('layouts.app')

@section('title', 'Mahasiswa Dashboard')

@section('sidebar')
<div class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link {{ Request::is('mahasiswa/dashboard') ? 'active' : '' }}" 
           href="{{ route('mahasiswa.dashboard') }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::is('mahasiswa/barang*') ? 'active' : '' }}" 
           href="{{ route('mahasiswa.barang.index') }}">
            <i class="fas fa-box"></i> Daftar Barang
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::is('mahasiswa/peminjaman*') ? 'active' : '' }}" 
           href="{{ route('mahasiswa.peminjaman.index') }}">
            <i class="fas fa-clipboard-list"></i> Peminjaman Saya
        </a>
    </li>
</div>
@endsection